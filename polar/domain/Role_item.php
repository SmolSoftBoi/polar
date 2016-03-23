<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Role item.
 *
 * @package Polar\Domain\Items
 */
class Role_item extends Item {

	/**
	 * @var int $role_id Role ID.
	 */
	public $role_id;

	/**
	 * @var string $role_key Role key.
	 */
	public $role_key;

	/**
	 * @var string $role_name Role name.
	 */
	public $role_name;

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'role_id'   => $this->role_id,
			'role_key'  => $this->role_key,
			'role_name' => $this->role_name
		));
	}
}