<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Errors controller.
 *
 * @package Polar\Controllers
 */
class Errors extends POLAR_Controller {

	/**
	 * 404 not found.
	 */
	public function notfound()
	{
		$data['heading'] = '404 Page Not Found';
		$data['message'] = 'The page you requested was not found.';

		$this->load->vars($data);

		$this->template->view('default', 'errors/html/error_404');
	}
}