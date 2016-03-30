<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Question model.
 *
 * @package Polar\Models
 *
 * @property Answer_model $answer_model Answer model.
 */
class Question_model extends Item_model {

	/**
	 * User model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('answer_model');
	}

	/**
	 * Search.
	 *
	 * @param Question_params|null $question_params Question parameters.
	 *
	 * @return Question_item[] Question items.
	 */
	public function search($question_params = NULL)
	{
		return $this->base_search('question_item', 'question_id', $question_params);
	}

	/**
	 * Get question item.
	 *
	 * @param  int $question_id Question ID.
	 *
	 * @return Question_item Question item.
	 */
	public function get_item($question_id)
	{
		return $this->base_get_item('questions', 'question_id', 'question_item', $question_id);
	}

	/**
	 * Set question item.
	 *
	 * @param Question_item $question_item Question item.
	 *
	 * @return int Question ID.
	 */
	public function set_item($question_item)
	{
		return $this->base_set_item('questions', 'question_id', 'question_id', $question_item);
	}

	/**
	 * Build.
	 *
	 * @param Question_params|null $question_params Question parameters.
	 */
	protected function build($question_params = NULL)
	{
		if (is_null($question_params))
		{
			$question_params = new Question_params();
		}

		$this->base_build('questions');

		$this->db->join('quizzes', 'questions.quiz_id = quizzes.quiz_id');

		$this->build_param($question_params, 'quiz_id', 'quizzes', 'quiz_id');
		$this->build_param($question_params, 'user_id', 'quizzes', 'user_id');
	}

	/**
	 * Generate.
	 *
	 * @param Question_item $question_item Question item.
	 *
	 * @return Question_item Question item.
	 */
	protected function generate($question_item)
	{
		$question_item = $this->base_generate(2, 'question_id', $question_item);

		if ($this->level > 0)
		{
			$answer_params = new Answer_params();

			$answer_params->question_id = $question_item->question_id;

			$this->answer_model->level = $this->level;

			$question_item->answers = $this->answer_model->search($answer_params);
		}

		return $question_item;
	}

	/**
	 * Search responses.
	 *
	 * @param Question_response_params|null $question_response_params Question response parameters.
	 *
	 * @return Question_response_item[] Question response items.
	 */
	public function search_responses($question_response_params = NULL)
	{
		return $this->base_search('question_response_item', 'question_response_id', $question_response_params, 'build_response', 'generate_response');
	}

	/**
	 * Get question response items.
	 *
	 * @param int[] $question_response_ids Question response IDs.
	 *
	 * @return Question_response_item[] Question response items.
	 */
	public function get_response_items($question_response_ids)
	{
		$question_response_items = array();

		foreach ($question_response_ids as $question_response_id)
		{
			$question_response_items[$question_response_id] = $this->get_response_item($question_response_id);
		}

		return $question_response_items;
	}

	/**
	 * Get question response item.
	 *
	 * @param int $question_response_id Question response ID.
	 *
	 * @return Question_response_item Question response item.
	 */
	public function get_response_item($question_response_id)
	{
		return $this->base_get_item('question_responses', 'question_response_id', 'question_response_item', $question_response_id, 'build_response', 'generate_response');
	}

	/**
	 * Set question response items.
	 *
	 * @param Question_response_item[] $question_response_items Question response items.
	 *
	 * @return int[] Question response IDs.
	 */
	public function set_response_items($question_response_items)
	{
		$question_response_ids = array();

		foreach ($question_response_items as $question_response_item)
		{
			$question_response_ids[] = $this->set_response_item($question_response_item);
		}

		return $question_response_ids;
	}

	/**
	 * Set question response item.
	 *
	 * @param Question_response_item $question_response_item Question response item.
	 *
	 * @return int Question response item.
	 */
	public function set_response_item($question_response_item)
	{
		return $this->base_set_item('question_responses', 'question_response_id', 'question_response_id', $question_response_item);
	}

	/**
	 * Build response.
	 *
	 * @param Question_response_params|null $question_response_params Question response parameters.
	 */
	protected function build_response($question_response_params = NULL)
	{
		if (is_null($question_response_params))
		{
			$question_response_params = new Question_response_params();
		}

		$this->base_build('question_responses');
	}

	/**
	 * Generate response.
	 *
	 * @param Question_response_item $question_response_item Question response item.
	 *
	 * @return Question_response_item Question response item.
	 */
	protected function generate_response($question_response_item)
	{
		$question_response_item = $this->base_generate(4, 'question_response_id', $question_response_item);

		$question_response_item->answer_id = intval($question_response_item->answer_id);
		$question_response_item->user_id = intval($question_response_item->user_id);

		if ($this->level < 3)
		{
			$this->level = 3;
		}

		$this->answer_model->level = $this->level;

		$question_response_item->answer = $this->answer_model->get_item($question_response_item->answer_id);

		$question_response_item->score = $question_response_item->answer->score;

		foreach ($question_response_item->answer->question->answers as $answer_item)
		{
			if ($answer_item->score > 0)
			{
				$question_response_item->correct_answer_id = $answer_item->answer_id;

				break;
			}
		}

		return $question_response_item;
	}
}