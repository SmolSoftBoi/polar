<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Questions API controller.
 *
 * @package Polar\Controllers\API
 *
 * @property Question_model $question_model Question model.
 */
class Questions extends POLAR_Controller {

	/**
	 * Questions API constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('question_model');
	}

	/**
	 * Questions search.
	 */
	public function search()
	{
		$json = $this->input->raw_input_stream;

		$question_params = new Question_params();

		$question_params->jsonDeserialize($json);

		$question_items = $this->question_model->search($question_params);

		$this->api_output($question_items);
	}

	/**
	 * GET questions.
	 */
	public function get_questions()
	{
		$question_items = $this->question_model->search();

		$this->api_output($question_items);
	}

	/**
	 * POST questions.
	 */
	public function post_questions()
	{
		$json = $this->input->raw_input_stream;

		$question_item = new Question_item();

		$question_item->jsonDeserialize($json);

		$question_id = $this->question_model->set_item($question_item);

		$question_item = $this->question_model->get_item($question_id);

		$this->api_output($question_item);
	}

	/**
	 * Question responses search.
	 */
	public function responses_search()
	{
		$json = $this->input->raw_input_stream;

		$question_response_params = new Question_response_params();

		$question_response_params->jsonDeserialize($json);

		$question_response_items = $this->question_model->search_responses($question_response_params);

		$this->api_output($question_response_items);
	}

	/**
	 * GET question responses.
	 */
	public function get_question_responses()
	{
		$question_response_items = $this->question_model->search_responses();

		$this->api_output($question_response_items);
	}

	/**
	 * POST question responses.
	 */
	public function post_question_responses()
	{
		$json = $this->input->raw_input_stream;

		$question_response_item = new Question_response_item();

		$question_response_item->jsonDeserialize($json);

		$question_response_id = $this->question_model->set_response_item($question_response_item);

		$question_response_item = $this->question_model->get_response_item($question_response_id);

		$this->api_output($question_response_item);
	}
}