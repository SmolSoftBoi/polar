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