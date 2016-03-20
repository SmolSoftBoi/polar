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
 */
class Quiz_model extends Item_model {

	/**
	 * Search.
	 *
	 * @param Quiz_params|null $quiz_params Quiz parameters.
	 *
	 * @return Quiz_item[] Quiz items.
	 */
	public function search($quiz_params = NULL)
	{
		$this->build($quiz_params);

		$quiz_items = $this->db->get()->result('quiz_item');

		foreach ($quiz_items as $key => $quiz_item)
		{
			$quiz_items[$key] = $this->generate($quiz_item);
		}

		return $quiz_items;
	}

	/**
	 * Get quiz items.
	 *
	 * @param  int[] $quiz_ids Quiz IDs.
	 *
	 * @return Quiz_item[] Quiz items.
	 */
	public function get_items($quiz_ids)
	{
		$quiz_items = array();

		foreach ($quiz_ids as $quiz_id)
		{
			$quiz_items[$quiz_id] = $this->get_item($quiz_id);
		}

		return $quiz_items;
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
		$this->build();

		return $this->db->where('quizzes.quiz_id', $quiz_id)->get()->row(0, 'quiz_item');
	}

	/**
	 * Set quiz items.
	 *
	 * @param Quiz_item[] $quiz_items Quiz items.
	 *
	 * @return int[] Quiz IDs.
	 */
	public function set_items($quiz_items)
	{
		$quiz_ids = array();

		foreach ($quiz_items as $quiz_item)
		{
			$quiz_ids[] = $this->set_item($quiz_item);
		}

		return $quiz_ids;
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
		$quiz_item->db_set();

		if ( ! isset($quiz_item->quiz_id) || $quiz_item->quiz_id === 0)
		{
			$this->db->insert('quizzes');
		}
		else
		{
			$this->db->where('quiz_id', $quiz_item->quiz_id)->update('quizzes');
		}

		return $this->db->insert_id();
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

		$this->db->select('quizzes.*')
		         ->from('quizzes')
		         ->join('user_schools', 'quizzes.user_id = user_schools.user_id')
		         ->join('schools', 'user_schools.school_id = schools.school_id');

		if (isset($quiz_params->school_id))
		{
			$this->db->where('quizzes.user_id', $quiz_params->user_id);
		}

		if (isset($quiz_params->user_id))
		{
			$this->db->where('quizzes.user_id', $quiz_params->user_id);
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
		return $quiz_item;
	}
}