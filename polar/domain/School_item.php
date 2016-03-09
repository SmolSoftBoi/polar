<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * School item.
 *
 * @package Polar\Domain\Items
 */
class School_item extends Item {

	/**
	 * @var int $school_id School ID.
	 */
	public $school_id;

	/**
	 * @var string $school_name School name.
	 */
	public $school_name;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	function jsonSerialize()
	{
		$object = new stdClass();

		$object->schoolId = $this->school_id;
		$object->schoolName = $this->school_name;

		return $object;
	}

	/**
	 * JSON deserialize.
	 *
	 * @param object $object Object.
	 */
	public function jsonDeserialize($object)
	{
		if (isset($object->schoolId))
		{
			$this->school_id = $object->schoolId;
		}

		if (isset($object->schoolName))
		{
			$this->school_name = $object->schoolName;
		}
	}

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'school_id'   => $this->school_id,
			'school_name' => $this->school_name
		));
	}
}