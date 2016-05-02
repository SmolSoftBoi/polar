<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Answer item.
 *
 * @package Polar\Domain\Items
 */
class Answer_item extends Item {

	/**
	 * @var int $answer_id Answer ID.
	 */
	public $answer_id;

	/**
	 * @var int $question_id Question ID.
	 */
	public $question_id;

	/**
	 * @var string $answer Answer.
	 */
	public $answer;

	/**
	 * @var int $score Score.
	 */
	public $score;

	/**
	 * @var int $user_id User ID.
	 */
	public $user_id;

	/**
	 * @var Question_item $question Question.
	 */
	public $question;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	public function jsonSerialize()
	{
		$object = $this->base_json_serialize();

		if (isset($_SESSION['user']))
		{
			$user_item = new User_item();

			$user_item->jsonDeserialize($_SESSION['user']);

			if ($this->user_id !== $user_item->user_id)
			{
				unset($object->score);
			}
		}
		else
		{
			unset($object->score);
		}

		return $object;
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'answer_id'   => $this->answer_id,
			'question_id' => $this->question_id,
			'answer'      => $this->answer,
			'score'       => $this->score
		));
	}
}