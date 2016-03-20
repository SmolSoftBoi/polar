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
	 * @var string $user_id User ID.
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
	 * @var string $launch_timestamp Launch timestamp.
	 */
	public $launch_timestamp;

	/**
	 * @var bool $live Live.
	 */
	public $live;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	function jsonSerialize()
	{
		$object = new stdClass();

		$object->quizId = $this->quiz_id;
		$object->quizName = $this->quiz_name;
		$object->quizSlug = $this->quiz_slug;
		$object->description = $this->description;

		return $object;
	}

	/**
	 * JSON deserialize.
	 *
	 * @param object $object Object.
	 */
	public function jsonDeserialize($object)
	{
		$object = json_decode($object);

		if (isset($object->quizId))
		{
			$this->quiz_id = $object->quizId;
		}
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'quiz_id' => $this->quiz_id
		));
	}
}