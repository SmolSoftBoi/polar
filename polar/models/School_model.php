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
		return $this->base_search('school_item', 'school_id', $school_params);
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
		return $this->base_get_item('schools', 'school_id', 'school_item', $school_id);
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
		$this->base_set_item('schools', 'school_id', 'school_id', $school_item);
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

		$this->base_build('schools');

		$this->db->join('user_schools', 'schools.school_id = user_schools.school_id');

		$this->build_param($school_params, 'school_name', 'schools', 'school_name');
		$this->build_param($school_params, 'user_id', 'user_schools', 'user_id');
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
		return $this->base_generate('school_id', $school_item);
	}
}