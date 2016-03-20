<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * School parameters.
 *
 * @package Polar\Domain\Params
 */
class School_params extends Params {

	/**
	 * @var string $school_name School name.
	 */
	public $school_name;

	/**
	 * @var int $user_id User ID.
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

		$object->schoolName = $this->school_name;
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

		if (isset($object->schoolName))
		{
			$this->school_name = $object->schoolName;
		}

		if (isset($object->userId))
		{
			$this->user_id = $object->userId;
		}
	}
}