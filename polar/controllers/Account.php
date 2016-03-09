<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Account controller.
 *
 * @package Polar\Controllers
 */
class Account extends POLAR_Controller {

	/**
	 * Account constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->auth->authed();
	}

	/**
	 * Index.
	 */
	public function index()
	{
		$this->template->view('default', 'account');
	}
}