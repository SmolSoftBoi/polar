<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Answer item.
 *
 * @package Polar\Domain\Items
 */
class Answer_item extends Item {

	/**
	 * @var int $answer_id Answer ID.
	 */
	public $answer_id;

	/**
	 * @var int $question_id Question ID.
	 */
	public $question_id;

	/**
	 * @var string $answer Answer.
	 */
	public $answer;

	/**
	 * @var int $score Score.
	 */
	public $score;

	public function jsonSerialize()
	{
		$object = $this->base_json_serialize();

		unset($object->score);

		return $object;
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'domain_id' => $this->domain_id,
			'domain'    => $this->domain
		));
	}
}