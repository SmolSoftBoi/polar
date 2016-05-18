<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Schools API controller.
 *
 * @package Polar\Controllers\API
 *
 * @property School_model $school_model School model.
 */
class Schools extends POLAR_Controller {

	/**
	 * Schools API constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('school_model');
	}

	/**
	 * Schools search.
	 */
	public function search()
	{
		try
		{
			$school_items = $this->school_model->search();

			$this->api_output($school_items);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * GET schools.
	 */
	public function get_schools()
	{
		try
		{
			$school_items = $this->school_model->search();

			$this->api_output($school_items);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * POST schools.
	 */
	public function post_schools()
	{
		try
		{
			$school_item = $this->base_api_set('School_item', 'school_model');

			$this->api_output($school_item);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}
}