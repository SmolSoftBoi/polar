<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Question item.
 *
 * @package Polar\Domain\Items
 */
class Question_item extends Item {

	/**
	 * @var int $question_id Question ID.
	 */
	public $question_id;

	/**
	 * @var int $question_type_id Question type ID.
	 */
	public $question_type_id;

	/**
	 * @var int $quiz_id Quiz ID.
	 */
	public $quiz_id;

	/**
	 * @var string $question Question.
	 */
	public $question;

	/**
	 * @var int $time_limit Time limit.
	 */
	public $time_limit;

	/**
	 * @var Question_response_item[] $responses Responses.
	 */
	public $responses = array();

	/**
	 * @var Answer_item[] $answers Answers
	 */
	public $answers = array();

	/**
	 * JSON deserialize.
	 *
	 * @param object $object Object.
	 */
	public function jsonDeserialize($object)
	{
		$object = $this->base_json_deserialize('Question_item', $object);

		if (isset($object->answers))
		{
			foreach ($object->answers as $answer)
			{
				$answer_item = new Answer_item();

				$answer_item->jsonDeserialize($answer);

				$this->answers[] = $answer_item;
			}
		}
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'question_id'      => $this->question_id,
			'question_type_id' => $this->question_type_id,
			'quiz_id'          => $this->quiz_id,
			'question'         => $this->question,
			'time_limit'       => $this->time_limit
		));
	}
}