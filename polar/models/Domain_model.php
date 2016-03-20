<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Domain model.
 *
 * @package Polar\Models
 */
class Domain_model extends Item_model {

	/**
	 * Search.
	 *
	 * @param Domain_params|null $domain_params
	 *
	 * @return Domain_item[] Domain items.
	 */
	public function search($domain_params = NULL)
	{
		$this->build($domain_params);

		$domain_items = $this->db->get()->result('domain_item');

		foreach ($domain_items as $key => $domain_item)
		{
			$domain_items[$key] = $this->generate($domain_item);
		}

		return $domain_items;
	}

	/**
	 * Get domain items.
	 *
	 * @param int[] $domain_ids Domain IDs.
	 *
	 * @return Domain_item[] Domain items.
	 */
	public function get_items($domain_ids)
	{
		$domain_items = array();

		foreach ($domain_ids as $domain_id)
		{
			$domain_items[$domain_id] = $this->get_item($domain_id);
		}

		return $domain_items;
	}

	/**
	 * Get domain item.
	 *
	 * @param int $domain_id Domain ID.
	 *
	 * @return Domain_item Domain item.
	 */
	public function get_item($domain_id)
	{
		$this->build();

		$domain_item = $this->db->where('domains.domain_id', $domain_id)->get()->row(0, 'domain_item');

		return $this->generate($domain_item);
	}

	/**
	 * Set domain items.
	 *
	 * @param Domain_item[] $domain_items Domain items.
	 *
	 * @return int[] Domain IDs.
	 */
	public function set_items($domain_items)
	{
		$domain_ids = array();

		foreach ($domain_items as $domain_item)
		{
			$domain_ids[] = $this->set_item($domain_item);
		}

		return $domain_ids;
	}

	/**
	 * Set domain item.
	 *
	 * @param Domain_item $domain_item Domain item.
	 *
	 * @return int Domain ID.
	 */
	public function set_item($domain_item)
	{
		$domain_item->db_set();

		if ( ! isset($domain_item->domain_id) || $domain_item->domain_id === 0)
		{
			$this->db->insert('domains');
		}
		else
		{
			$this->db->where('domain_id', $domain_item->domain_id)->update('domains');
		}

		return $this->db->insert_id();
	}

	/**
	 * Build.
	 *
	 * @param Domain_params|null $domain_params Domain parameters.
	 */
	protected function build($domain_params = NULL)
	{
		if (is_null($domain_params))
		{
			$domain_params = new Domain_params();
		}

		$this->db->select('domains.*')->from('domains');

		if (isset($domain_params->domain))
		{
			$this->db->where('domains.domain', $domain_params->domain);
		}
	}

	/**
	 * Generate.
	 *
	 * @param Domain_item $domain_item Domain item.
	 *
	 * @return Domain_item Domain item.
	 */
	protected function generate($domain_item)
	{
		return $domain_item;
	}
}