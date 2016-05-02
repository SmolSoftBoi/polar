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
	 * @var int $response_level Response level.
	 */
	public $response_level = 0;

	/**
	 * @var int $type_level Type level.
	 */
	public $type_level = 0;

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
		if (empty($question_item->question_type_id))
		{
			$question_type_item = $this->get_type_item_by_key('multiplechoice');

			$question_item->question_type_id = $question_type_item->question_type_id;
		}

		$question_id = $this->base_set_item('questions', 'question_id', 'question_id', $question_item);

		if (isset($question_item->answers))
		{
			foreach ($question_item->answers as $answer_item)
			{
				if (empty($answer_item->question_id))
				{
					$answer_item->question_id = $question_id;
				}

				$this->answer_model->set_item($answer_item);
			}
		}

		return $question_id;
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

		$this->db->join('answers', 'questions.question_id = answers.question_id', 'left');
		$this->db->join('quizzes', 'questions.quiz_id = quizzes.quiz_id', 'left');

		$this->build_param($question_params, 'answer_id', 'answers', 'answer_id');
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
		if (is_null($question_item))
		{
			return $question_item;
		}

		$question_item = $this->base_generate(2, 'question_id', $question_item);

		$question_item->question_type_id = intval($question_item->question_type_id);
		$question_item->quiz_id = intval($question_item->quiz_id);
		$question_item->time_limit = intval($question_item->time_limit);

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
	 * @return int Question response ID.
	 */
	public function set_response_item($question_response_item)
	{
		$question_params = new Question_params();

		$question_params->answer_id = $question_response_item->answer_id;

		$question_items = $this->search($question_params);

		$question_response_params = new Question_response_params();

		$question_response_params->question_id = reset($question_items)->question_id;

		$question_response_items = $this->search_responses($question_response_params);

		if (count($question_response_items) > 0)
		{
			$question_response_item->question_response_id = reset($question_response_items)->question_response_id;
		}

		return $this->base_set_item('question_responses', 'question_response_id', 'question_response_id', $question_response_item);
	}

	/**
	 * Search types.
	 *
	 * @param Question_type_params|null $question_type_params Question type parameters.
	 *
	 * @return Question_type_item[] Question type items.
	 */
	public function search_types($question_type_params = NULL)
	{
		return $this->base_search('question_type_item', 'question_type_id', $question_type_params, 'build_type', 'generate_type');
	}

	/**
	 * Get question types.
	 *
	 * @param int[] $question_type_ids Question type IDs.
	 *
	 * @return Question_type_item[] Question type items.
	 */
	public function get_type_items($question_type_ids)
	{
		$question_types_items = array();

		foreach ($question_type_ids as $question_type_id)
		{
			$question_types_items[$question_type_id] = $this->get_type_item($question_type_id);
		}

		return $question_types_items;
	}

	/**
	 * Get question type item.
	 *
	 * @param int $question_type_id Question type ID.
	 *
	 * @return Question_type_item Question type item.
	 */
	public function get_type_item($question_type_id)
	{
		return $this->base_get_item('question_types', 'question_type_id', 'question_type_item', $question_type_id, 'build_type', 'generate_type');
	}

	/**
	 * Set question type items.
	 *
	 * @param Question_type_item[] $question_type_items Question type items.
	 *
	 * @return int[] Question type IDs.
	 */
	public function set_type_items($question_type_items)
	{
		$question_type_ids = array();

		foreach ($question_type_items as $question_type_item)
		{
			$question_type_ids[] = $this->set_type_item($question_type_item);
		}

		return $question_type_ids;
	}

	/**
	 * Set question type item.
	 *
	 * @param Question_type_item $question_type_item Question type item.
	 *
	 * @return int Question type ID.
	 */
	public function set_type_item($question_type_item)
	{
		return $this->base_set_item('question_types', 'question_type_id', 'question_type_id', $question_type_item);
	}

	/**
	 * Get question type items by key.
	 *
	 * @param string[] $question_type_keys Question type keys.
	 *
	 * @return Question_type_item[] Question type items.
	 */
	public function get_type_items_by_key($question_type_keys)
	{
		$question_type_items = array();

		foreach ($question_type_keys as $question_type_key)
		{
			$question_type_items[$question_type_key] = $this->get_type_item_by_key($question_type_key);
		}

		return $question_type_items;
	}

	/**
	 * Get question type item by key.
	 *
	 * @param string $question_type_key Question type key.
	 *
	 * @return Question_type_item Question type item.
	 */
	public function get_type_item_by_key($question_type_key)
	{
		return $this->base_get_item('question_types', 'question_type_key', 'question_type_item', $question_type_key, 'build_type', 'generate_type');
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

		$this->db->select_sum('answers.score', 'score')
		         ->join('answers', 'question_responses.answer_id = answers.answer_id', 'left')
		         ->join('questions', 'answers.question_id = questions.question_id', 'left')
		         ->group_by('question_responses.question_response_id');

		$this->build_param($question_response_params, 'question_id', 'questions', 'question_id');
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
		if (is_null($question_response_item))
		{
			return $question_response_item;
		}

		$question_response_item = $this->base_generate(4, 'question_response_id', $question_response_item, 'response_level');

		$question_response_item->answer_id = intval($question_response_item->answer_id);
		$question_response_item->user_id = intval($question_response_item->user_id);
		$question_response_item->score = intval($question_response_item->score);

		if ($this->response_level < 3)
		{
			$this->response_level = 3;
		}

		$this->answer_model->level = $this->response_level;

		$question_response_item->answer = $this->answer_model->get_item($question_response_item->answer_id);

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

	/**
	 * Build type.
	 *
	 * @param Question_type_params|null $question_type_params Question type parameters.
	 */
	protected function build_type($question_type_params = NULL)
	{
		if (is_null($question_type_params))
		{
			$question_type_params = new Question_type_params();
		}

		$this->base_build('question_types');
	}

	/**
	 * Generate type.
	 *
	 * @param Question_type_item $question_type_item Question type item.
	 *
	 * @return Question_type_item Question type item.
	 */
	protected function generate_type($question_type_item)
	{
		if (is_null($question_type_item))
		{
			return $question_type_item;
		}

		return $this->base_generate(1, 'question_type_id', $question_type_item, 'type_level');
	}
}