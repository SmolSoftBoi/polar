<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Domain item.
 *
 * @package Polar\Domain\Items
 */
class Domain_item extends Item {

	/**
	 * @var int $domain_id Domain ID.
	 */
	public $domain_id;

	/**
	 * @var string $domain Domain.
	 */
	public $domain;

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