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
	 * @var Domain_item[] $domains Domains.
	 */
	public $domains = array();

	/**
	 * JSON deserialize.
	 *
	 * @param object $object Object.
	 */
	public function jsonDeserialize($object)
	{
		$object = $this->base_json_deserialize('School_item', $object);

		if (isset($object->domains))
		{
			foreach ($object->domains as $domain)
			{
				$domain_item = new Domain_item();
				$domain_item->jsonDeserialize($domain);
				$this->domains[] = $domain_item;
			}
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