<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quiz parameters.
 *
 * @package Polar\Domain\Params
 */
class Quiz_params extends Params {

	/**
	 * @var int $school_id School ID.
	 */
	public $school_id;

	/**
	 * @var int[]|bool $school_ids School IDs.
	 */
	public $school_ids = array();

	/**
	 * @var bool|int $user_id User ID.
	 */
	public $user_id;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	public function jsonSerialize()
	{
		$object = new stdClass();

		$object->schoolId = $this->school_id;
		$object->schoolIds = $this->school_ids;
		$object->userId = $this->user_id;

		return $object;
	}

	/**
	 * JSON deserialize.
	 *
	 * @param object $object
	 */
	public function jsonDeserialize($object)
	{
		$object = json_decode($object);

		if (isset($object->schoolId))
		{
			$this->school_id = $object->schoolId;
		}

		if (isset($object->schoolIds))
		{
			$this->school_ids = $object->schoolIds;
		}

		if (isset($object->userId))
		{
			$this->user_id = $object->userId;
		}
	}
}