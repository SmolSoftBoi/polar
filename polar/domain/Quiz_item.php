<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quiz item.
 *
 * @package Polar\Domain\Items
 */
class Quiz_item extends Item {

	/**
	 * @var int $quiz_id Quiz ID.
	 */
	public $quiz_id;

	/**
	 * @var string $user_id User ID.
	 */
	public $user_id;

	/**
	 * @var string $quiz_name Quiz name.
	 */
	public $quiz_name;

	/**
	 * @var string $quiz_slug Quiz slug.
	 */
	public $quiz_slug;

	/**
	 * @var string $description Description.
	 */
	public $description;

	/**
	 * @var string $code Code.
	 */
	public $code;

	/**
	 * @var string $launch_timestamp Launch timestamp.
	 */
	public $launch_timestamp;

	/**
	 * @var bool $live Live.
	 */
	public $live;

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'quiz_id' => $this->quiz_id,
			'quiz_name' => $this->quiz_name,
			'quiz_slug' => $this->quiz_slug,
			'description' => $this->description,
			'code' => $this->code,
			'launch_timestamp' => $this->launch_timestamp
		));
	}
}