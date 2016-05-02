<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Question type item.
 *
 * @package Polar\Domain\Items
 */
class Question_type_item extends Item {

	/**
	 * @var int $question_type_id Question type ID.
	 */
	public $question_type_id;

	/**
	 * @var string $question_type_key Question type key.
	 */
	public $question_type_key;

	/**
	 * @var string $question_type_name Question type name.
	 */
	public $question_type_name;

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'question_type_id'   => $this->question_type_id,
			'question_type_key'  => $this->question_type_key,
			'question_type_name' => $this->question_type_name
		));
	}
}