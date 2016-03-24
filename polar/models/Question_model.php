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
 */
class Question_model extends Item_model {

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
		return $this->base_set_item('questions', 'question_id', 'question_id', 'question_item', $question_item);
	}

	/**
	 * Build.
	 *
	 * @param Question_params|null $question_params $question parameters.
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
	 * @param Quiz_item $quiz_item Quiz item.
	 *
	 * @return Quiz_item Quiz item.
	 */
	protected function generate($quiz_item)
	{
		return $this->base_generate('quiz_id', $quiz_item);
	}
}