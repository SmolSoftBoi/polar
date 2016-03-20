<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email item.
 *
 * @package Polar\Domain\Items
 */
class Email_item extends Item {

	/**
	 * @var int $email_id Email ID.
	 */
	public $email_id;

	/**
	 * @var string $email Email.
	 */
	public $email;

	/**
	 * @var bool $verified Verified.
	 */
	public $verified = FALSE;

	/**
	 * @var User_item $user User item.
	 */
	public $user;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	public function jsonSerialize()
	{
		$object = new stdClass();

		$object->emailId = $this->email_id;
		$object->email = $this->email;
		$object->verified = $this->verified;
		$object->user = $this->user;

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

		if (isset($object->emailId))
		{
			$this->email_id = $object->emailId;
		}

		if (isset($object->email))
		{
			$this->email = $object->email;
		}

		if (isset($object->verified))
		{
			$this->verified = $object->verified;
		}

		if (isset($object->user))
		{
			$user_item = new User_item();

			$user_item->jsonDeserialize($object->user);

			$this->user = $user_item;
		}
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'email_id' => $this->email_id,
			'email'    => $this->email,
			'verified' => $this->verified
		));
	}
}