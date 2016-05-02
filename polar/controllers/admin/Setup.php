<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Setup admin controller.
 *
 * @package Polar\Controllers\Admin
 *
 * @property User_model $user_model User model.
 */
class Setup extends POLAR_Controller {

	/**
	 * Setup constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('form_validation');
	}

	/**
	 * Index.
	 */
	public function index()
	{
		$user_params = new User_params();

		$user_params->role_key = ROLE_KEY_ADMIN;

		$admin_count = $this->user_model->count($user_params);

		if ($admin_count === 0)
		{
			$this->user();
		}
		else
		{
			redirect('admin');
		}
	}

	/**
	 * User.
	 */
	private function user()
	{
		if ($this->form_validation->run('admin/setup/user') === FALSE)
		{
			$this->template->view('default', 'admin/setup/user');
		}
		else
		{
			$user_item = new User_item();
			$email_item = new Email_item();
			$role_item = new Role_item();

			$user_item->first_name = $this->input->post('firstName', TRUE);
			$user_item->last_name = $this->input->post('lastName', TRUE);
			$user_item->password = $this->input->post('password', TRUE);

			$email_item->email = $this->input->post('email', TRUE);
			$user_item->emails[] = $email_item;

			$role_item->role_key = ROLE_KEY_ADMIN;
			$user_item->roles[] = $role_item;

			$user_id = $this->user_model->set_item($user_item);

			$this->auth->sign_in_by_user_id($user_id);

			redirect('admin');
		}
	}
}