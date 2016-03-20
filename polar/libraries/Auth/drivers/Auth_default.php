<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Default Authentication driver.
 *
 * @package Polar\Libraries\Auth\Drivers
 *
 * @property User_model $user_model User model.
 */
class Auth_default extends Auth_driver {

	/**
	 * @var User_item $valid_user_item Valid user item.
	 */
	private $valid_user_item;

	/**
	 * Default authentication driver constructor.
	 *
	 * @param array $params Parameters.
	 */
	public function __construct($params = array())
	{
		parent::__construct($params);
		$this->CI->load->model(array('email_model', 'user_model'));
	}

	/**
	 * Sign in.
	 *
	 * @param User_item $user_item User item credentials.
	 * @param bool      $remember  Remember.
	 */
	public function sign_in($user_item, $remember = FALSE)
	{
		$valid = $this->validate($user_item);

		if ($valid)
		{
			$this->auth($this->userdata($this->valid_user_item));
		}
	}

	/**
	 * Sign in by user ID.
	 *
	 * @param int  $user_id  User ID.
	 * @param bool $remember Remember.
	 */
	public function sign_in_by_user_id($user_id, $remember = FALSE)
	{
		$user_item = $this->CI->user_model->get_item($user_id);

		$this->auth($this->userdata($user_item));
	}

	/**
	 * Validate.
	 *
	 * @param User_item $user_item User item.
	 *
	 * @return bool Valid.
	 */
	public function validate($user_item)
	{
		$email_params = New Email_params();

		foreach ($user_item->emails as $email_item)
		{
			$email_params->emails[] = $email_item->email;
		}

		$email_items = $this->CI->email_model->search($email_params);

		foreach ($email_items as $email_item)
		{
			if (password_verify($user_item->password, $email_item->user->password_hash))
			{
				if (password_needs_rehash($email_item->user->password_hash, PASSWORD_DEFAULT))
				{
					$this->user_model->set_user($email_item->user);
				}

				$this->valid_user_item = $email_item->user;

				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Userdata.
	 *
	 * @param User_item $user_item User item.
	 *
	 * @return array Userdata.
	 */
	private function userdata($user_item)
	{
		$userdata = array(
			'user_id'    => $user_item->user_id,
			'first_name' => $user_item->first_name,
			'last_name'  => $user_item->last_name,
			'roles'      => array(),
			'schools'    => array()
		);

		foreach ($user_item->roles as $role)
		{
			$userdata['roles'][] = $role->role_key;
		}

		foreach ($user_item->schools as $school)
		{
			$userdata['schools'][] = array(
				'school_id' => $school->school_id
			);
		}

		return $userdata;
	}
}