<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Userdata API controller.
 *
 * @package Polar\Controllers\API
 */
class Userdata extends POLAR_Controller {

	/**
	 * GET userdata.
	 */
	public function get()
	{
		$output = new stdClass();

		$output->polar = new stdClass();

		$output->polar->brandColor = $this->config->item('brand_color');

		if ($this->auth->authed(FALSE))
		{
			$output->user = json_decode($_SESSION['user']);
		}

		$this->api_output($output);
	}
}