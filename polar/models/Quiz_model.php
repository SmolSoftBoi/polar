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
 *          @property Question_model $question_model Question model.
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
		return $this->base_set_item('quizzes', 'quiz_id', 'quiz_id', $quiz_item);
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

		$this->db->join('user_schools', 'quizzes.user_id = user_schools.user_id')
		         ->join('schools', 'user_schools.school_id = schools.school_id');

		$this->build_param($quiz_params, 'code', 'quizzes', 'code');
		$this->build_param($quiz_params, 'quiz_slug', 'quizzes', 'quiz_slug');
		$this->build_param($quiz_params, 'school_id', 'schools', 'school_id');
		$this->build_param($quiz_params, 'school_ids', 'schools', 'school_id');
		$this->build_param($quiz_params, 'user_id', 'quizzes', 'user_id');
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
		$quiz_item = $this->base_generate('quiz_id', $quiz_item);

		$question_params = new Question_params();

		$question_params->quiz_id = $quiz_item->quiz_id;

		$question_items = $this->question_model->search($question_params);

		$quiz_item->questions = $question_items;

		return $quiz_item;
	}
}