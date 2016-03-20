<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Role parameters.
 *
 * @package Polar\Domain\Params
 */
class Role_params extends Params {

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

		if (isset($object->userId))
		{
			$this->user_id = $object->userId;
		}
	}
}