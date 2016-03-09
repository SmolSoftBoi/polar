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
		$this->build($role_params);

		$role_items = $this->db->get()->result('role_item');

		foreach ($role_items as $key => $role_item)
		{
			$role_items[$key] = $this->generate($role_item);
		}

		return $role_items;
	}

	/**
	 * Get role items.
	 *
	 * @param  int[] $role_ids Role IDs.
	 *
	 * @return Role_item[] Role items.
	 */
	public function get_items($role_ids)
	{
		$role_items = array();

		foreach ($role_ids as $role_id)
		{
			$role_items[$role_id] = $this->get_item($role_id);
		}

		return $role_items;
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
		$this->build();

		return $this->db->where('roles.role_id', $role_id)->get()->row(0, 'role_item');
	}

	/**
	 * Set role items.
	 *
	 * @param Role_item[] $role_items Role items.
	 *
	 * @return int[] Role IDs.
	 */
	public function set_items($role_items)
	{
		$role_ids = array();

		foreach ($role_items as $role_item)
		{
			$role_ids[] = $this->set_item($role_item);
		}

		return $role_ids;
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
		$role_item->db_set();

		if ( ! isset($role_item->role_id) || $role_item->role_id === 0)
		{
			$this->db->insert('roles');
		}
		else
		{
			$this->db->where('role_id', $role_item->role_id)->update('roles');
		}

		return $this->db->insert_id();
	}

	/**
	 * Build.
	 *
	 * @param Role_params|null $role_params Role parameters.
	 */
	protected function build($role_params = NULL)
	{
		$this->db->select('roles.*')->from('roles');
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
		return $role_item;
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
	 * @return Role_item
	 */
	public function get_item_by_key($role_key)
	{
		$this->build();

		return $this->db->where('roles.role_key', $role_key)->get()->row(0, 'role_item');
	}
}