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
	 * @var string $domain Domain.
	 */
	public $domain;

	/**
	 * @var string $school_name School name.
	 */
	public $school_name;

	/**
	 * @var int $user_id User ID.
	 */
	public $user_id;
}