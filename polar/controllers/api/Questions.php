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
		try
		{
			$question_items = $this->base_api_search('Question_params', 'question_model');

			$this->api_output($question_items);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * GET questions.
	 */
	public function get_questions()
	{
		try
		{
			$question_items = $this->base_api_gets('question_model');

			$this->api_output($question_items);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * GET question.
	 *
	 * @param int $question_id Question ID.
	 */
	public function get_question($question_id)
	{
		try
		{
			$question_item = $this->base_api_get('question_model', $question_id);

			$this->api_output($question_item);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * POST questions.
	 */
	public function post_questions()
	{
		try
		{
			$question_item = $this->base_api_set('Question_item', 'question_model');

			$this->api_output($question_item);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * Question responses search.
	 */
	public function responses_search()
	{
		try
		{
			$question_response_items = $this->base_api_search('Question_response_params', 'question_model', 'search_responses');

			$this->api_output($question_response_items);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * GET question responses.
	 */
	public function get_question_responses()
	{
		try
		{
			$question_response_items = $this->base_api_gets('question_model', 'search_responses');

			$this->api_output($question_response_items);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * GET question response.
	 *
	 * @param int $question_response_id Question response ID.
	 */
	public function get_question_response($question_response_id)
	{
		try
		{
			$question_response_item = $this->base_api_get('question_model', $question_response_id, 'get_response_item');

			$this->api_output($question_response_item);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * POST question responses.
	 */
	public function post_question_responses()
	{
		try
		{
			$question_response_item = $this->base_api_set('Question_response_item', 'question_model', 'set_response_item', 'get_response_item');

			$this->api_output($question_response_item);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}
}