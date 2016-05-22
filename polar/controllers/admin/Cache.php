<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cache admin controller.
 *
 * @package Polar\Controllers\Admin
 */
class Cache extends POLAR_Controller {

	/**
	 * Cache constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->auth->authed_by_role('admin');

		$data['nav'] = 'cache';
		$this->load->vars($data);
	}

	/**
	 * Clean.
	 */
	public function clean()
	{
		$this->cache->clean();

		redirect('admin');
	}
}