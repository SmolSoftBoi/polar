<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authentication events.
 */
class Auth_events {

	/**
	 * @var CI_Controller CodeIgniter instance.
	 */
	protected $CI;

	/**
	 * Authentication events constructor.
	 */
	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->model('user_model');
	}

	/**
	 * Pre-authicated by role.
	 *
	 * @param array $roles Roles.
	 */
	public function pre_authed_by_role($roles)
	{
		switch (strtolower($roles))
		{
			case ROLE_KEY_ADMIN:
				$user_params = new User_params();

				$user_params->role_key = ROLE_KEY_ADMIN;

				$admin_count = $this->CI->user_model->count($user_params);

				if ($admin_count === 0)
				{
					redirect('admin/setup');
				}
				break;
		}
	}
}