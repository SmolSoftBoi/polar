<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Answer model.
 *
 * @package Polar\Models
 *
 * @property Question_model $question_model Question model.
 */
class Answer_model extends Item_model {

	/**
	 * Email model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('question_model');
	}

	/**
	 * Search.
	 *
	 * @param Answer_params|null $answer_params Answer parameters.
	 *
	 * @return Answer_item[] Answer items.
	 */
	public function search($answer_params = NULL)
	{
		return $this->base_search('answer_item', 'answer_id', $answer_params);
	}

	/**
	 * Get answer item.
	 *
	 * @param  int $answer_id Answer ID.
	 *
	 * @return Answer_item Answer item.
	 */
	public function get_item($answer_id)
	{
		return $this->base_get_item('answers', 'answer_id', 'answer_item', $answer_id);
	}

	/**
	 * Set answer item.
	 *
	 * @param Answer_item $answer_item Answer item.
	 *
	 * @return int Answer ID.
	 */
	public function set_item($answer_item)
	{
		return $this->base_set_item('answers', 'answer_id', 'answer_id', 'answer_item', $answer_item);
	}

	/**
	 * Build.
	 *
	 * @param Answer_params|null $answer_params Answer parameters.
	 */
	protected function build($answer_params = NULL)
	{
		if (is_null($answer_params))
		{
			$answer_params = new Answer_params();
		}

		$this->base_build('answers');

		$this->build_param($answer_params, 'question_id', 'answers', 'question_id');
	}

	/**
	 * Generate.
	 *
	 * @param Answer_item $answer_item Answer item.
	 *
	 * @return Answer_item Answer item.
	 */
	protected function generate($answer_item)
	{
		$answer_item = $this->base_generate(1, 'answer_id', $answer_item);

		$answer_item->question_id = intval($answer_item->question_id);
		$answer_item->score = intval($answer_item->score);

		if ($this->level > 0)
		{
			$this->question_model->level = $this->level;

			$answer_item->question = $this->question_model->get_item($answer_item->question_id);
		}

		return $answer_item;
	}
}