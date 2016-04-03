<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User item.
 *
 * @package Polar\Domain\Items
 */
class User_item extends Item {

	/**
	 * @var int $user_id User ID.
	 */
	public $user_id;

	/**
	 * @var string $first_name First name.
	 */
	public $first_name;

	/**
	 * @var string $last_name Last name.
	 */
	public $last_name;

	/**
	 * @var Email_item[] $emails Emails.
	 */
	public $emails = array();

	/**
	 * @var Role_item[] $roles Roles.
	 */
	public $roles = array();

	/**
	 * @var School_item[] $schools Schools.
	 */
	public $schools = array();

	/**
	 * @var string $password Password.
	 */
	public $password;

	/**
	 * @var string $password_hash Password hash.
	 */
	public $password_hash;

	/**
	 * @var string $initials Initials.
	 */
	public $initials;

	/**
	 * JSON serialize.
	 *
	 * return object Object.
	 */
	public function jsonSerialize()
	{
		$object = $this->base_json_serialize();

		unset($object->password);
		unset($object->passwordHash);

		return $object;
	}

	/**
	 * JSON deserialize.
	 *
	 * @param object $object Object.
	 */
	public function jsonDeserialize($object)
	{
		$object = $this->base_json_deserialize('User_item', $object);

		if (isset($object->emails))
		{
			foreach ($object->emails as $email)
			{
				$email_item = new Email_item();

				$email_item->jsonDeserialize($email);

				$this->emails[] = $email_item;
			}
		}

		if (isset($object->roles))
		{
			foreach ($object->roles as $role)
			{
				$role_item = new Role_item();

				$role_item->jsonDeserialize($role);

				$this->roles[] = $role_item;
			}
		}

		if (isset($object->schools))
		{
			foreach ($object->schools as $school)
			{
				$school_item = new Role_item();

				$school_item->jsonDeserialize($school);

				$this->schools[] = $school_item;
			}
		}
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'user_id'       => $this->user_id,
			'first_name'    => $this->first_name,
			'last_name'     => $this->last_name,
			'password_hash' => $this->password_hash
		));
	}
}