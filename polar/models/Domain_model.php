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
 *
 * @property Email_model $email_model Email model.
 */
class Domain_model extends Item_model {

	/**
	 * Domain model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('email_model');
	}

	/**
	 * Search.
	 *
	 * @param Domain_params|null $domain_params
	 *
	 * @return Domain_item[] Domain items.
	 */
	public function search($domain_params = NULL)
	{
		return $this->base_search('Domain_item', 'domain_id', $domain_params);
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
		return $this->base_get_item('domains', 'domain_id', 'Domain_item', $domain_id);
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
		$domain_id = $this->base_set_item('domains', 'domain_id', 'domain_id', $domain_item);

		$school_params = new School_params();
		$school_params->domain = $domain_item->domain;
		$school_items = $this->school_model->search($school_params);

		if (count($school_items) > 0)
		{
			$email_params = new Email_params();
			$email_params->domain = $domain_item->domain;
			$email_items = $this->email_model->search($email_params);

			$user_schools = array();
			foreach ($email_items as $email_item)
			{
				if ( ! isset($email_item->user->schools[reset($school_items)->school_id]))
				{
					$user_schools[] = array(
						'user_id' => $email_item->user->user_id,
						'school_id' => reset($school_items)->school_id
					);
				}
			}

			if ( ! empty($user_schools))
			{
				$this->db->insert_batch('user_schools', $user_schools);
			}
		}

		return $domain_id;
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

		$this->base_build('domains');

		$this->build_param($domain_params, 'domain', 'domains', 'domain');
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
		if (is_null($domain_item))
		{
			return $domain_item;
		}

		return $this->base_generate(1, 'domain_id', $domain_item);
	}
}