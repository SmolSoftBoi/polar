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
		$school_items = $this->school_model->search();

		$this->api_output($school_items);
	}

	/**
	 * GET schools.
	 */
	public function get_schools()
	{
		$school_items = $this->school_model->search();

		$this->api_output($school_items);
	}

	/**
	 * POST schools.
	 */
	public function post_schools()
	{
		$json = $this->input->raw_input_stream;

		$school_item = new School_item();

		$school_item->jsonDeserialize($json);

		$school_id = $this->school_model->set_item($school_item);

		$school_item = $this->school_model->get_item($school_id);

		$this->api_output($school_item);
	}
}