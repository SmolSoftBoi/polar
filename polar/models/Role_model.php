<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Role model.
 *
 * @package Polar\Models
 */
class Role_model extends Item_model {

	/**
	 * Search.
	 *
	 * @param Role_params|null $role_params Role parameters.
	 *
	 * @return Role_item[] Role items.
	 */
	public function search($role_params = NULL)
	{
		return $this->base_search('Role_item', 'role_id', $role_params);
	}

	/**
	 * Get role item.
	 *
	 * @param  int $role_id Role ID.
	 *
	 * @return Role_item Role item.
	 */
	public function get_item($role_id)
	{
		return $this->base_get_item('roles', 'role_id', 'Role_item', $role_id);
	}

	/**
	 * Set role item.
	 *
	 * @param Role_item $role_item Role item.
	 *
	 * @return int Role ID.
	 */
	public function set_item($role_item)
	{
		return $this->base_set_item('roles', 'role_id', 'role_id', $role_item);
	}

	/**
	 * Build.
	 *
	 * @param Role_params|null $role_params Role parameters.
	 */
	protected function build($role_params = NULL)
	{
		$this->base_build('roles');

		$this->db->join('user_roles', 'roles.role_id = user_roles.role_id', 'left');

		$this->build_param($role_params, 'user_id', 'user_roles', 'user_id');
	}

	/**
	 * Generate.
	 *
	 * @param Role_item $role_item Role item.
	 *
	 * @return Role_item Role item.
	 */
	protected function generate($role_item)
	{
		if (is_null($role_item))
		{
			return $role_item;
		}

		return $this->base_generate(1, 'role_id', $role_item);
	}

	/**
	 * Get role items by keys.
	 *
	 * @param string[] $role_keys Role keys.
	 *
	 * @return Role_item[] Role items.
	 */
	public function get_items_by_keys($role_keys)
	{
		$role_items = array();

		foreach ($role_keys as $role_key)
		{
			$role_items[$role_key] = $this->get_item_by_key($role_key);
		}

		return $role_items;
	}

	/**
	 * Get role item by key.
	 *
	 * @param string $role_key Role key.
	 *
	 * @return Role_item Role item.
	 */
	public function get_item_by_key($role_key)
	{
		return $this->base_get_item('roles', 'role_key', 'Role_item', $role_key);
	}
}