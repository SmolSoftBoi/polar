<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email item.
 *
 * @package Polar\Domain\Items
 */
class Domain_item extends Item {

	/**
	 * @var int $domain_id Domain ID.
	 */
	public $domain_id;

	/**
	 * @var string $domain Email.
	 */
	public $domain;

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	public function jsonSerialize()
	{
		$object = new stdClass();

		$object->domainId = $this->domain_id;
		$object->domain = $this->domain;

		return $object;
	}

	/**
	 * JSON deserialize.
	 *
	 * @param object $object
	 */
	public function jsonDeserialize($object)
	{
		if (isset($object->domainId))
		{
			$this->domain_id = $object->domainId;
		}

		if (isset($object->domain))
		{
			$this->domain = $object->domain;
		}
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