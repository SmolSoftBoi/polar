<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Question response item.
 *
 * @package Polar\Domain\Items
 */
class Question_response_item extends Item {

	/**
	 * @var int $question_response_id Question response ID.
	 */
	public $question_response_id;

	/**
	 * @var int $answer_id Answer ID.
	 */
	public $answer_id;

	/**
	 * @var int $user_id User ID.
	 */
	public $user_id;

	/**
	 * @var Answer_item $answer Answer.
	 */
	public $answer;

	public function jsonSerialize()
	{
		$object = $this->base_json_serialize();

		if (isset($this->answer)) {
			$object->score = $this->answer->score;
		}

		return $object;
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'question_response_id'          => $this->question_response_id,
			'answer_id'        => $this->answer_id,
			'user_id'        => $this->user_id
		));
	}
}