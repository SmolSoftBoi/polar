<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User parameters.
 *
 * @package Polar\Domain\Params
 */
class User_params extends Params {

	/**
	 * @var string $email Email.
	 */
	public $email;

	/**
	 * @var string $role_key Role key.
	 */
	public $role_key;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	public function jsonSerialize()
	{
		$object = new stdClass();

		$object->email = $this->email;
		$object->roleKey = $this->role_key;

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

		if (isset($object->email))
		{
			$this->email = $object->email;
		}

		if (isset($object->roleKey))
		{
			$this->role_key = $object->roleKey;
		}
	}
}