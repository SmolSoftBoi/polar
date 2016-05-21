<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email parameters.
 *
 * @package Polar\Domain\Params
 */
class Email_params extends Params {

	/**
	 * @var string $domain Domain.
	 */
	public $domain;

	/**
	 * @var string $email Email.
	 */
	public $email;

	/**
	 * @var string[] $emails Emails.
	 */
	public $emails = array();
}