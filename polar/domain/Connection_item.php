<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Connection item.
 *
 * @package Polar\Domain\Items
 */
class Connection_item extends Item {

	/**
	 * @var int $connection_id Connection ID.
	 */
	public $connection_id;

	/**
	 * @var int $user_id User ID.
	 */
	public $user_id;

	/**
	 * @var DateTime $connection_timestamp Connection timestamp.
	 */
	public $connection_timestamp;

	/**
	 * @var User_item $user User.
	 */
	public $user;

	/**
	 * @var Quiz_item $quiz Quiz.
	 */
	public $quiz;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	public function jsonSerialize()
	{
		$object = $this->base_json_serialize();

		$object->connectionTimestamp = $this->connection_timestamp->format(DateTime::ATOM);

		return $object;
	}

	/**
	 * JSON deserialize.
	 *
	 * @param object $object Object.
	 */
	public function jsonDeserialize($object)
	{
		$object = $this->base_json_deserialize('Connection_item', $object);

		if (isset($object->connectionTimestamp))
		{
			$this->connection_timestamp = new DateTime($object->connectionTimestamp);
		}

		if (isset($object->quiz))
		{
			$quiz_item = new Quiz_item();

			$quiz_item->jsonDeserialize($object->quiz);

			$this->quiz = $quiz_item;
		}
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'connection_id'        => $this->connection_id,
			'user_id'              => $this->user_id,
			'connection_timestamp' => $this->connection_timestamp->getTimestamp()
		));
	}
}