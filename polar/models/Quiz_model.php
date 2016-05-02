<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quiz model.
 *
 * @package Polar\Models
 *
 * @property Question_model $question_model Question model.
 */
class Quiz_model extends Item_model {

	/**
	 * User model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('question_model');
	}

	/**
	 * Search.
	 *
	 * @param Quiz_params|null $quiz_params Quiz parameters.
	 *
	 * @return Quiz_item[] Quiz items.
	 */
	public function search($quiz_params = NULL)
	{
		return $this->base_search('quiz_item', 'quiz_id', $quiz_params);
	}

	/**
	 * Get quiz item.
	 *
	 * @param  int $quiz_id Quiz ID.
	 *
	 * @return Quiz_item Quiz item.
	 */
	public function get_item($quiz_id)
	{
		return $this->base_get_item('quizzes', 'quiz_id', 'quiz_item', $quiz_id);
	}

	/**
	 * Set quiz item.
	 *
	 * @param Quiz_item $quiz_item Quiz item.
	 *
	 * @return int Quiz ID.
	 */
	public function set_item($quiz_item)
	{
		if (empty($quiz_item->quiz_slug))
		{
			$quiz_slug = url_title($quiz_item->quiz_name, '-', TRUE);

			$quiz_item->quiz_slug = $quiz_slug;

			$quiz_item_by_slug = $this->get_item_by_slug($quiz_item->quiz_slug);

			if ( ! is_null($quiz_item_by_slug))
			{
				$i = 1;
				while ( ! is_null($quiz_item_by_slug))
				{
					$quiz_item->quiz_slug = $quiz_slug . $i;

					$quiz_item_by_slug = $this->get_item_by_slug($quiz_item->quiz_slug);

					$i++;
				}
			}
		}

		if (is_null($quiz_item->live))
		{
			$quiz_item->live = FALSE;
		}

		$quiz_id = $this->base_set_item('quizzes', 'quiz_id', 'quiz_id', $quiz_item);

		if (isset($quiz_item->questions))
		{
			foreach ($quiz_item->questions as $question_item)
			{
				if (empty($question_item->quiz_id))
				{
					$question_item->quiz_id = $quiz_id;
				}

				$this->question_model->set_item($question_item);
			}
		}

		return $quiz_id;
	}

	/**
	 * Build.
	 *
	 * @param Quiz_params|null $quiz_params Quiz parameters.
	 */
	protected function build($quiz_params = NULL)
	{
		if (is_null($quiz_params))
		{
			$quiz_params = new Quiz_params();
		}

		$this->base_build('quizzes');

		$this->db->join('quiz_connections', 'quizzes.quiz_id = quiz_connections.quiz_id', 'left')
		         ->join('connections', 'quiz_connections.connection_id = connections.connection_id', 'left')
		         ->join('user_schools', 'quizzes.user_id = user_schools.user_id', 'left')
		         ->join('schools', 'user_schools.school_id = schools.school_id', 'left');

		$this->build_param($quiz_params, 'code', 'quizzes', 'code');
		$this->build_param($quiz_params, 'connection_id', 'quiz_connections', 'connection_id');
		$this->build_param($quiz_params, 'quiz_slug', 'quizzes', 'quiz_slug');
		$this->build_param($quiz_params, 'school_id', 'schools', 'school_id');
		$this->build_param($quiz_params, 'school_ids', 'schools', 'school_id');
		$this->build_param($quiz_params, 'user_id', 'quizzes', 'user_id');

		if (isset($quiz_params->min_launch_timestamp))
		{
			if ( ! empty($quiz_params->min_launch_timestamp))
			{
				$timestamp = new DateTime($quiz_params->min_launch_timestamp);

				$this->db->group_start()
				         ->where('quizzes.launch_timestamp', NULL)
				         ->or_where('quizzes.launch_timestamp >=', $timestamp->getTimestamp())
				         ->group_end();
			}
		}

		if (isset($quiz_params->connection_id))
		{
			if ( ! empty($quiz_params->connection_id))
			{
				$this->db->order_by('connections.connection_timestamp', 'DESC');
			}
		}
	}

	/**
	 * Generate.
	 *
	 * @param Quiz_item $quiz_item Quiz item.
	 *
	 * @return Quiz_item Quiz item.
	 */
	protected function generate($quiz_item)
	{
		if (is_null($quiz_item))
		{
			return $quiz_item;
		}

		$quiz_item = $this->base_generate(3, 'quiz_id', $quiz_item);

		$quiz_item->question_id = intval($quiz_item->question_id);
		$quiz_item->user_id = intval($quiz_item->user_id);
		$quiz_item->live = boolval($quiz_item->live);

		$timestamp = new DateTime();

		$timestamp->setTimestamp($quiz_item->launch_timestamp);

		$quiz_item->launch_timestamp = $timestamp;

		if ($this->level < 2)
		{
			$this->level = 2;
		}

		$question_params = new Question_params();

		$question_params->quiz_id = $quiz_item->quiz_id;

		$this->question_model->level = $this->level;

		$quiz_item->questions = $this->question_model->search($question_params);

		$quiz_item->score = 0;

		foreach ($quiz_item->questions as $question_item)
		{
			foreach ($question_item->answers as $answer_item)
			{
				$quiz_item->score += $answer_item->score;
			}
		}

		return $quiz_item;
	}

	/**
	 * Get quiz items by slug.
	 *
	 * @param string[] $quiz_slugs Quiz slugs.
	 *
	 * @return Quiz_item[] Quiz items.
	 */
	public function get_items_by_slug($quiz_slugs)
	{
		$quiz_items = array();

		foreach ($quiz_slugs as $quiz_slug)
		{
			$quiz_items[$quiz_slug] = $this->get_item_by_slug($quiz_slug);
		}

		return $quiz_items;
	}

	/**
	 * Get quiz item by slug.
	 *
	 * @param string $quiz_slug Quiz slug.
	 *
	 * @return Quiz_item Quiz item.
	 */
	public function get_item_by_slug($quiz_slug)
	{
		return $this->base_get_item('quizzes', 'quiz_slug', 'quiz_item', $quiz_slug);
	}
}