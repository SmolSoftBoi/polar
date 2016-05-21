<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email model.
 *
 * @package Polar\Models
 *
 * @property User_model $user_model User model.
 */
class Email_model extends Item_model {

	/**
	 * Email model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	/**
	 * Search.
	 *
	 * @param Email_params|null $email_params
	 *
	 * @return Email_item[] Email items.
	 */
	public function search($email_params = NULL)
	{
		return $this->base_search('Email_item', 'email_id', $email_params);
	}

	/**
	 * Get email item.
	 *
	 * @param int $email_id Email ID.
	 *
	 * @return Email_item Email item.
	 */
	public function get_item($email_id)
	{
		return $this->base_get_item('emails', 'email_id', 'Email_item', $email_id);
	}

	/**
	 * Set email item.
	 *
	 * @param Email_item $email_item Email item.
	 *
	 * @return int Email ID.
	 */
	public function set_item($email_item)
	{
		return $this->base_set_item('emails', 'email_id', 'email_id', $email_item);
	}

	/**
	 * Build.
	 *
	 * @param Email_params|null $email_params Email parameters.
	 */
	protected function build($email_params = NULL)
	{
		if (is_null($email_params))
		{
			$email_params = new Email_params();
		}

		$this->base_build('emails');

		$this->build_param($email_params, 'email', 'emails', 'email');
		$this->build_param($email_params, 'emails', 'emails', 'email');

		if ( ! empty($email_params->domain))
		{
			$this->db->like('emails.email', '@' . $email_params->domain, 'before');
		}
	}

	/**
	 * Generate.
	 *
	 * @param Email_item $email_item Email item.
	 *
	 * @return Email_item Email item.
	 */
	protected function generate($email_item)
	{
		if (is_null($email_item))
		{
			return $email_item;
		}

		$email_item = $this->base_generate(2, 'email_id', $email_item);

		$email_item->verified = boolval($email_item->verified);

		if ($this->level > 0)
		{
			$user_params = new User_params();

			$user_params->email = $email_item->email;

			$this->user_model->level = $this->level;

			$user_items = $this->user_model->search($user_params);

			if (count($user_items) > 0)
			{
				$email_item->user = reset($user_items);
			}
		}

		return $email_item;
	}
}