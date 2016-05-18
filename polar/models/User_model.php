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
 * @property Email_model  $email_model  Email model.
 * @property Role_model   $role_model   Role model.
 * @property School_model $school_model School model.
 */
class User_model extends Item_model {

	/**
	 * User model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'domain_model',
			'email_model',
			'role_model',
			'school_model'
		));
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
		return $this->base_search('User_item', 'user_id', $user_params);
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
		return $this->base_get_item('users', 'user_id', 'User_item', $user_id);
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

		foreach ($user_item->roles as $index => $role_item)
		{
			$user_item->roles[$index] = $this->role_model->get_item_by_key($role_item->role_key);
		}

		$user_id = $this->base_set_item('users', 'user_id', 'user_id', $user_item);

		$email_ids = $this->email_model->set_items($user_item->emails);

		$this->db->where('user_id', $user_id)->where_not_in('email_id', $email_ids)->delete('user_emails');

		$user_emails = array();
		foreach ($email_ids as $email_id)
		{
			$user_emails[] = array(
				'user_id'  => $user_id,
				'email_id' => $email_id
			);
		}

		if ( ! empty($user_emails))
		{
			$this->db->insert_batch('user_emails', $user_emails);
		}

		$role_ids = array();

		foreach ($user_item->roles as $role)
		{
			$role_ids[] = $role->role_id;
		}

		$this->db->where('user_id', $user_id)->where_not_in('role_id', $role_ids)->delete('user_roles');

		$user_roles = array();
		foreach ($role_ids as $role_id)
		{
			$user_roles[] = array(
				'user_id' => $user_id,
				'role_id' => $role_id
			);
		}

		if ( ! empty($user_roles))
		{
			$this->db->insert_batch('user_roles', $user_roles);
		}

		$user_schools = array();
		foreach ($user_item->schools as $school_item)
		{
			$user_schools[] = array(
				'user_id'   => $user_id,
				'school_id' => $school_item->school_id
			);
		}

		if ( ! empty($user_schools))
		{
			$this->db->insert_batch('user_schools', $user_schools);
		}

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

		$this->base_build('users');

		$this->db->join('user_emails', 'users.user_id = user_emails.user_id', 'left')
		         ->join('emails', 'user_emails.email_id = emails.email_id', 'left')
		         ->join('user_roles', 'users.user_id = user_roles.user_id', 'left')
		         ->join('roles', 'user_roles.role_id = roles.role_id', 'left');

		$this->build_param($user_params, 'email', 'emails', 'email');
		$this->build_param($user_params, 'role_key', 'roles', 'role_key');
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
		if (is_null($user_item))
		{
			return $user_item;
		}

		$user_item = $this->base_generate(2, 'user_id', $user_item);

		$user_item->initials = strtoupper($user_item->first_name[0] . $user_item->last_name[0]);

		if ($this->level > 0)
		{
			$role_params = new Role_params();

			$role_params->user_id = $user_item->user_id;

			$this->role_model->level = $this->level;

			$user_item->roles = $this->role_model->search($role_params);

			$school_params = new School_params();

			$school_params->user_id = $user_item->user_id;

			$this->school_model->level = $this->level;

			$user_item->schools = $this->school_model->search($school_params);
		}

		return $user_item;
	}
}