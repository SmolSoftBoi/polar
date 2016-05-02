<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quiz item.
 *
 * @package Polar\Domain\Items
 */
class Quiz_item extends Item {

	/**
	 * @var int $quiz_id Quiz ID.
	 */
	public $quiz_id;

	/**
	 * @var int $question_id Question ID.
	 */
	public $question_id;

	/**
	 * @var int $user_id User ID.
	 */
	public $user_id;

	/**
	 * @var string $quiz_name Quiz name.
	 */
	public $quiz_name;

	/**
	 * @var string $quiz_slug Quiz slug.
	 */
	public $quiz_slug;

	/**
	 * @var string $description Description.
	 */
	public $description;

	/**
	 * @var string $code Code.
	 */
	public $code;

	/**
	 * @var DateTime $launch_timestamp Launch timestamp.
	 */
	public $launch_timestamp;

	/**
	 * @var bool $live Live.
	 */
	public $live;

	/**
	 * @var int $score Score.
	 */
	public $score;

	/**
	 * @var Question_item[] $questions Questions.
	 */
	public $questions = array();

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	public function jsonSerialize()
	{
		$object = $this->base_json_serialize();

		$object->launchTimestamp = $this->launch_timestamp->format(DateTime::ATOM);

		if ($this->launch_timestamp->getTimestamp() === 0)
		{
			$object->launchTimestamp = NULL;
		}

		return $object;
	}

	/**
	 * JSON deserialize.
	 *
	 * @param object $object Object.
	 */
	public function jsonDeserialize($object)
	{
		$object = $this->base_json_deserialize('Quiz_item', $object);

		if (isset($object->launchTimestamp))
		{
			$this->launch_timestamp = new DateTime($object->launchTimestamp);
		}

		if (isset($object->questions))
		{
			foreach ($object->questions as $question)
			{
				$question_item = new Question_item();

				$question_item->jsonDeserialize($question);

				$this->questions[] = $question_item;
			}
		}
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'quiz_id'     => $this->quiz_id,
			'question_id' => $this->question_id,
			'user_id'     => $this->user_id,
			'quiz_name'   => $this->quiz_name,
			'quiz_slug'   => $this->quiz_slug,
			'description' => $this->description,
			'code'        => $this->code,
			'live'        => $this->live
		));

		if (is_null($this->launch_timestamp))
		{
			$this->db->set('launch_timestamp', $this->launch_timestamp);
		}
		else
		{
			$this->db->set('launch_timestamp', $this->launch_timestamp->getTimestamp());
		}
	}
}