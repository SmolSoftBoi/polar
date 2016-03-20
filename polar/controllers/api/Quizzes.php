<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quizzes API controller.
 *
 * @package Polar\Controllers\API
 *
 * @property Quiz_model $quiz_model Quiz model.
 */
class Quizzes extends POLAR_Controller {

	/**
	 * Quizzes API constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('quiz_model');
	}

	/**
	 * Quizzes search.
	 */
	public function search()
	{
		$json = $this->input->raw_input_stream;

		$quiz_params = new Quiz_params();

		$quiz_params->jsonDeserialize($json);

		if ($quiz_params->school_ids === TRUE)
		{
			$quiz_params->school_ids = array();

			foreach ($_SESSION['schools'] as $school)
			{
				$quiz_params->school_ids[] = $school['school_id'];
			}
		}

		if ($quiz_params->user_id === TRUE)
		{
			$quiz_params->user_id = $_SESSION['user_id'];
		}

		$quiz_items = $this->quiz_model->search($quiz_params);

		$this->api_output($quiz_items);
	}

	/**
	 * GET quizzes.
	 */
	public function get_quizzes()
	{
		$this->api_authed($this->auth->authed_by_role('admin', FALSE));

		$quiz_items = $this->quiz_model->search();

		$this->api_output($quiz_items);
	}

	/**
	 * POST quizzes.
	 */
	public function post_schools()
	{
		$this->api_authed($this->auth->authed_by_role('admin', FALSE));

		$json = $this->input->raw_input_stream;

		$quiz_item = new School_item();

		$quiz_item->jsonDeserialize($json);

		$quiz_id = $this->quiz_model->set_item($quiz_item);

		$quiz_item = $this->quiz_model->get_item($quiz_id);

		$this->api_output($quiz_item);
	}
}