<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authentication controller.
 *
 * @property School_model $school_model School model.
 * @property User_model   $user_model   User model.
 */
class Sign extends POLAR_Controller {

	/**
	 * Authentication constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('school_model', 'user_model'));
		$this->load->library('form_validation');
	}

	/**
	 * Index.
	 */
	public function index()
	{
		$this->template->view('default', 'auth/auth');
	}

	/**
	 * Sign in.
	 */
	public function in()
	{
		if ($this->form_validation->run('auth/signin') === FALSE)
		{
			redirect($this->auth->config['uri']);
		}
		else
		{
			$user_item = new User_item();
			$email_item = new Email_item();

			$user_item->password = $this->input->post('password', TRUE);

			$email_item->email = $this->input->post('email', TRUE);
			$user_item->emails[] = $email_item;

			$this->auth->sign_in($user_item, $this->input->post('remember', TRUE));

			redirect($this->auth->get_uri());
		}
	}

	/**
	 * Sign out.
	 */
	public function out()
	{
		$this->auth->sign_out();

		redirect($this->auth->config['uri']);
	}

	/**
	 * Sign up.
	 */
	public function up()
	{
		if ($this->form_validation->run('auth/signup') === FALSE)
		{
			redirect($this->auth->config['uri']);
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

			$role_item->role_key = ROLE_KEY_STUDENT;
			$user_item->roles[] = $role_item;

			$school_params = new School_params();
			$school_params->domain = substr($email_item->email, strpos($email_item->email, "@") + 1);
			$user_item->schools = $this->school_model->search($school_params);

			$user_id = $this->user_model->set_item($user_item);

			$this->auth->sign_in_by_user_id($user_id);

			redirect($this->auth->get_uri());
		}
	}
}