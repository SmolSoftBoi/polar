<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard admin controller.
 *
 * @package Polar\Controllers\Admin
 */
class Dashboard extends POLAR_Controller {

	/**
	 * Dashboard constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->auth->authed_by_role('admin');

		$data['nav'] = 'dashboard';
		$this->load->vars($data);
	}

	/**
	 * Index.
	 */
	public function index()
	{
		$this->template->view('admin', 'admin/dashboard');
	}
}