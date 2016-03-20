<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Form API controller.
 *
 * @package Polar\Controllers\API
 *
 * @property Email_model  $email_model  Email model.
 * @property School_model $school_model School model.
 */
class Form extends POLAR_Controller {

	/**
	 * Form API constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('domain_model', 'email_model', 'school_model'));
	}

	/**
	 * GET Unique.
	 */
	public function get_unique()
	{
		$control = $this->input->get('control', TRUE);
		$value = $this->input->get('value', TRUE);

		if (is_null($control) || is_null($value))
		{
			$this->api_status(HTTP_BAD_REQUEST);
		}

		switch (strtolower($control))
		{
			case 'domain':
				$unique = $this->unique_domain($value);
				break;
			case 'email':
				$unique = $this->unique_email($value);
				break;
			case 'schoolname':
				$unique = $this->unique_school_name($value);
				break;
			default:
				$this->api_status(HTTP_NOT_FOUND);
		}

		$output = new stdClass();

		$output->unique = $unique;

		$this->api_output($output);
	}

	/**
	 * Unique domain.
	 *
	 * @param string $value Domain value.
	 *
	 * @return bool Unique.
	 */
	private function unique_domain($value)
	{
		$domain_params = new Domain_params();

		$domain_params->domain = $value;

		$count = $this->domain_model->count($domain_params);

		if ($count === 0)
		{
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Unique email.
	 *
	 * @param string $value Email value.
	 *
	 * @return bool Unique.
	 */
	private function unique_email($value)
	{
		$email_params = new Email_params();

		$email_params->email = $value;

		$count = $this->email_model->count($email_params);

		if ($count === 0)
		{
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Unique school name.
	 *
	 * @param string $value School name value.
	 *
	 * @return bool Unique.
	 */
	private function unique_school_name($value)
	{
		$school_params = new School_params();

		$school_params->school_name = $value;

		$count = $this->school_model->count($school_params);

		if ($count === 0)
		{
			return TRUE;
		}

		return FALSE;
	}
}