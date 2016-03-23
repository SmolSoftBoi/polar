<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Question parameters.
 *
 * @package Polar\Domain\Params
 */
class Question_params extends Params {

	/**
	 * @var int $quiz_id Quiz ID.
	 */
	public $quiz_id;

	/**
	 * @var int $user_id User ID.
	 */
	public $user_id;
}