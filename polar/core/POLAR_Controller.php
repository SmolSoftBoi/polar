<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Polar controller.
 *
 * @package Polar
 *
 * @property CI_Config          $config          CodeIgniter configuration.
 * @property CI_Form_validation $form_validation CodeIgniter form validation.
 * @property CI_Loader          $load            CodeIgniter loader.
 * @property CI_Migration       $migration       CodeIgniter migration.
 * @property CI_Output          $output          CodeIgniter output.
 * @property POLAR_Input        $input           Input.
 * @property Auth               $auth            Authentication.
 * @property Template           $template        Template.
 */
class POLAR_Controller extends CI_Controller {

	/**
	 * Polar controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(SHOW_PROFILER);

		$this->migration->current();

		$data['brand_color'] = $this->config->item('brand_color');
		$this->load->vars($data);
	}

	/**
	 * API authenticated.
	 *
	 * @param bool $authed Authenticated.
	 */
	protected function api_authed($authed)
	{
		if ( ! $authed)
		{
			$this->output->set_status_header(HTTP_UNAUTHORISED)->_display();

			exit();
		}
	}

	/**
	 * API status.
	 *
	 * @param int    $code HTTP status code.
	 * @param string $text Message.
	 */
	protected function api_status($code, $text = '')
	{
		$this->output->set_status_header($code, $text)->_display();

		exit();
	}

	/**
	 * API output.
	 *
	 * @param mixed $data Output data.
	 */
	protected function api_output($data)
	{
		$this->output->set_content_type('json')->set_output(json_encode($data));
	}
}