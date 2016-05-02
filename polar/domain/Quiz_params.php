<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quiz parameters.
 *
 * @package Polar\Domain\Params
 */
class Quiz_params extends Params {

	/**
	 * @var string $code Code.
	 */
	public $code;

	/**
	 * @var int $connection_id Connection ID.
	 */
	public $connection_id;

	/**
	 * @var string $quiz_slug Quiz slug.
	 */
	public $quiz_slug;

	/**
	 * @var int $school_id School ID.
	 */
	public $school_id;

	/**
	 * @var int[] $school_ids School IDs.
	 */
	public $school_ids = array();

	/**
	 * @var int $user_id User ID.
	 */
	public $user_id;

	/**
	 * @var DateTime $min_launch_timestamp Minimum launch timestamp.
	 */
	public $min_launch_timestamp;
}