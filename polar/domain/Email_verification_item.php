<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email verification item.
 *
 * @package Polar\Domain\Items
 */
class Email_verification_item extends Item {

	/**
	 * @var int $email_verification_id Email verification ID.
	 */
	public $email_verification_id;

	/**
	 * @var int $email_id Email ID.
	 */
	public $email_id;

	/**
	 * @var string $verification_code Verification code.
	 */
	public $verification_code;

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'email_verification_id' => $this->email_verification_id,
			'email_id'              => $this->email_id,
			'verification_code'     => $this->verification_code
		));
	}
}