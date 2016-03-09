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
		$this->load->model(array('user_model'));
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
		$this->build($email_params);

		$email_items = $this->db->get()->result('email_item');

		foreach ($email_items as $key => $email_item)
		{
			$email_items[$key] = $this->generate($email_item);
		}

		return $email_items;
	}

	/**
	 * Get email items.
	 *
	 * @param int[] $email_ids Email IDs.
	 *
	 * @return Email_item[] Email items.
	 */
	public function get_items($email_ids)
	{
		$email_items = array();

		foreach ($email_ids as $email_id)
		{
			$email_items[$email_id] = $this->get_item($email_id);
		}

		return $email_items;
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
		$this->build();

		$email_item = $this->db->where('emails.email_id', $email_id)->get()->row(0, 'email_item');

		return $this->generate($email_item);
	}

	/**
	 * Set email items.
	 *
	 * @param Email_item[] $email_items Email items.
	 *
	 * @return int[] Email IDs.
	 */
	public function set_items($email_items)
	{
		$email_ids = array();

		foreach ($email_items as $email_item)
		{
			$email_ids[] = $this->set_item($email_item);
		}

		return $email_ids;
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
		$email_item->db_set();

		if ( ! isset($email_item->email_id) || $email_item->email_id === 0)
		{
			$this->db->insert('emails');
		}
		else
		{
			$this->db->where('email_id', $email_item->email_id)->update('emails');
		}

		return $this->db->insert_id();
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

		$this->db->select('emails.*')->from('emails');

		if (isset($email_params->email))
		{
			$this->db->where('emails.email', $email_params->email);
		}

		if ( ! empty($email_params->emails))
		{
			foreach ($email_params->emails as $email)
			{
				$this->db->where('emails.email', $email);
			}
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
		$user_params = new User_params();

		$user_params->email = $email_item->email;

		$user_items = $this->user_model->search($user_params);

		if (count($user_items) > 0)
		{
			$email_item->user = $user_items[0];
		}

		return $email_item;
	}
}