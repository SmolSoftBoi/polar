<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User model.
 *
 * @package Polar\Models
 *
 * @property Email_model $email_model Email model.
 * @property Role_model  $role_model  Role model.
 */
class User_model extends Item_model {

	/**
	 * User model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'email_model',
			'role_model'
		));
	}

	/**
	 * Count.
	 *
	 * @param User_params $user_params User parameters.
	 *
	 * @return int Count.
	 */
	public function count($user_params = NULL)
	{
		$this->build($user_params);

		return $this->db->count_all_results();
	}

	/**
	 * Search.
	 *
	 * @param User_params|null $user_params User parameters.
	 *
	 * @return User_item[] User items.
	 */
	public function search($user_params = NULL)
	{
		$this->build($user_params);

		$user_items = $this->db->get()->result('user_item');

		foreach ($user_items as $key => $user_item)
		{
			$user_items[$key] = $this->generate($user_item);
		}

		return $user_items;
	}

	/**
	 * Get user items.
	 *
	 * @param int[] $user_ids User IDs.
	 *
	 * @return User_item[] User items.
	 */
	public function get_items($user_ids)
	{
		$user_items = array();

		foreach ($user_ids as $user_id)
		{
			$user_items[$user_id] = $this->get_item($user_id);
		}

		return $user_items;
	}

	/**
	 * Get user item.
	 *
	 * @param int $user_id User ID.
	 *
	 * @return User_item User item.
	 */
	public function get_item($user_id)
	{
		$this->build();

		return $this->db->where('users.user_id', $user_id)->get()->row(0, 'user_item');
	}

	/**
	 * Set user items.
	 *
	 * @param User_item[] $user_items User items.
	 *
	 * @return int[] User IDs.
	 */
	public function set_items($user_items)
	{
		$user_ids = array();

		foreach ($user_items as $user_item)
		{
			$user_ids[] = $this->set_item($user_item);
		}

		return $user_ids;
	}

	/**
	 * Set user item.
	 *
	 * @param User_item $user_item User item.
	 *
	 * @return int User ID.
	 */
	public function set_item($user_item)
	{
		if (isset($user_item->password))
		{
			if (isset($user_item->password_hash))
			{
				if (password_needs_rehash($user_item->password_hash, PASSWORD_DEFAULT))
				{
					$user_item->password_hash = password_hash($user_item->password, PASSWORD_DEFAULT);
				}
			}
			else
			{
				$user_item->password_hash = password_hash($user_item->password, PASSWORD_DEFAULT);
			}
		}

		foreach ($user_item->roles as $index => $role)
		{
			$user_item->roles[$index] = $this->role_model->get_item_by_key($role->role_key);
		}

		$user_item->db_set();

		if ( ! isset($user_item->user_id) || $user_item->user_id === 0)
		{
			$this->db->insert('users');
		}
		else
		{
			$this->db->where('user_id', $user_item->user_id)->update('users');
		}

		$user_id = $this->db->insert_id();

		$email_ids = $this->email_model->set_items($user_item->emails);

		$this->db->where('user_id', $user_id)->where_not_in('email_id', $email_ids)->delete('user_emails');

		$email_data = array();

		foreach ($email_ids as $email_id)
		{
			$email_data[] = array(
				'user_id'  => $user_id,
				'email_id' => $email_id
			);
		}

		$this->db->insert_batch('user_emails', $email_data);

		$role_ids = array();

		foreach ($user_item->roles as $role)
		{
			$role_ids[] = $role->role_id;
		}

		$this->db->where('user_id', $user_id)->where_not_in('role_id', $role_ids)->delete('user_roles');

		$role_data = array();

		foreach ($role_ids as $role_id)
		{
			$role_data[] = array(
				'user_id' => $user_id,
				'role_id' => $role_id
			);
		}

		$this->db->insert_batch('user_roles', $role_data);

		return $user_id;
	}

	/**
	 * Build.
	 *
	 * @param User_params|null $user_params User parameters.
	 */
	protected function build($user_params = NULL)
	{
		if (is_null($user_params))
		{
			$user_params = new User_params();
		}

		$this->db->select('users.*')
		         ->join('user_emails', 'users.user_id = user_emails.user_id')
		         ->join('emails', 'user_emails.email_id = emails.email_id')
		         ->join('user_roles', 'users.user_id = user_roles.user_id')
		         ->join('roles', 'user_roles.role_id = roles.role_id');

		if (isset($user_params->email))
		{
			$this->db->where('emails.email', $user_params->email);
		}

		if (isset($user_params->role_key))
		{
			$this->db->where('roles.role_key', $user_params->role_key);
		}

		$this->db->from('users');
	}

	/**
	 * Generate.
	 *
	 * @param User_item $user_item User item.
	 *
	 * @return User_item User item.
	 */
	protected function generate($user_item)
	{
		$role_params = new Role_params();

		$role_params->user_id = $user_item->user_id;

		$role_items = $this->role_model->search($role_params);

		$user_item->roles = $role_items;

		return $user_item;
	}
}