<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * School model.
 *
 * @package Polar\Models
 */
class School_model extends Item_model {

	/**
	 * Search.
	 *
	 * @param School_params|null $school_params School parameters.
	 *
	 * @return School_item[] School items.
	 */
	public function search($school_params = NULL)
	{
		$this->build($school_params);

		$school_items = $this->db->get()->result('school_item');

		foreach ($school_items as $key => $school_item)
		{
			$school_items[$key] = $this->generate($school_item);
		}

		return $school_items;
	}

	/**
	 * Get school items.
	 *
	 * @param int[] $school_ids School IDs.
	 *
	 * @return School_item[] School items.
	 */
	public function get_items($school_ids)
	{
		$school_items = array();

		foreach ($school_ids as $school_id)
		{
			$school_items[$school_id] = $this->get_item($school_id);
		}

		return $school_items;
	}

	/**
	 * Get school item.
	 *
	 * @param int $school_id School ID.
	 *
	 * @return School_item School item.
	 */
	public function get_item($school_id)
	{
		$this->build();

		$school_item = $this->db->where('schools.school_id', $school_id)->get()->row(0, 'school_item');

		return $this->generate($school_item);
	}

	/**
	 * Set school items.
	 *
	 * @param School_item[] $school_items School items.
	 *
	 * @return int[] School IDs.
	 */
	public function set_items($school_items)
	{
		$school_ids = array();

		foreach ($school_items as $school_item)
		{
			$school_ids[] = $this->set_item($school_item);
		}

		return $school_ids;
	}

	/**
	 * Set school item.
	 *
	 * @param School_item $school_item School item.
	 *
	 * @return int School ID.
	 */
	public function set_item($school_item)
	{
		$school_item->db_set();

		if ( ! isset($school_item->school_id) || $school_item->school_id === 0)
		{
			$this->db->insert('schools');
		}
		else
		{
			$this->db->where('school_id', $school_item->school_id)->update('schools');
		}

		return $this->db->insert_id();
	}

	/**
	 * Build.
	 *
	 * @param School_params|null $school_params School parameters.
	 */
	protected function build($school_params = NULL)
	{
		if (is_null($school_params))
		{
			$school_params = new School_params();
		}

		$this->db->select('schools.*')->from('schools');

		if (isset($school_params->school_name))
		{
			$this->db->where('schools.school_name', $school_params->school_name);
		}
	}

	/**
	 * Generate.
	 *
	 * @param School_item $school_item School item.
	 *
	 * @return School_item School item.
	 */
	protected function generate($school_item)
	{
		return $school_item;
	}
}