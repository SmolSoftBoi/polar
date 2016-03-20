<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Role item.
 *
 * @package Polar\Domain\Items
 */
class Role_item extends Item {

	/**
	 * @var int $role_id Role ID.
	 */
	public $role_id;

	/**
	 * @var string $role_key Role key.
	 */
	public $role_key;

	/**
	 * @var string $role_name Role name.
	 */
	public $role_name;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	function jsonSerialize()
	{
		$object = new stdClass();

		$object->roleId = $this->role_id;
		$object->roleKey = $this->role_key;
		$object->roleName = $this->role_name;

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

		if (isset($object->roleId))
		{
			$this->role_id = $object->roleId;
		}

		if (isset($object->roleKey))
		{
			$this->role_key = $object->roleKey;
		}

		if (isset($object->roleName))
		{
			$this->role_name = $object->roleName;
		}
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'role_id'   => $this->role_id,
			'role_key'  => $this->role_key,
			'role_name' => $this->role_name
		));
	}
}