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
	 * School model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('domain_model');
	}

	/**
	 * Search.
	 *
	 * @param School_params|null $school_params School parameters.
	 *
	 * @return School_item[] School items.
	 */
	public function search($school_params = NULL)
	{
		return $this->base_search('School_item', 'school_id', $school_params);
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
		return $this->base_get_item('schools', 'school_id', 'School_item', $school_id);
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
		$school_id = $this->base_set_item('schools', 'school_id', 'school_id', $school_item);

		$domain_ids = $this->domain_model->set_items($school_item->domains);

		$this->db->where('school_id', $school_id)->where_not_in('domain_id', $domain_ids)->delete('school_domains');

		$school_domains = array();
		foreach ($domain_ids as $domain_id)
		{
			$school_domains[] = array(
				'school_id'  => $school_id,
				'domain_id' => $domain_id
			);
		}

		if ( ! empty($school_domains))
		{
			$this->db->insert_batch('school_domains', $school_domains);
		}

		return $school_id;
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

		$this->db->join('school_domains', 'schools.school_id = school_domains.school_id', 'left');
		$this->db->join('domains', 'school_domains.domain_id = domains.domain_id', 'left');
		$this->db->join('user_schools', 'schools.school_id = user_schools.school_id', 'left');

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
		if (is_null($school_item))
		{
			return $school_item;
		}

		return $this->base_generate(1, 'school_id', $school_item);
	}
}