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
		$quiz_items = $this->base_api_search('Quiz_params', 'quiz_model');

		$this->api_output($quiz_items);
	}

	/**
	 * GET quizzes.
	 */
	public function get_quizzes()
	{
		$quiz_items = $this->base_api_gets('quiz_model');

		$this->api_output($quiz_items);
	}

	/**
	 * GET quiz.
	 *
	 * @param int $quiz_id Quiz ID.
	 */
	public function get_quiz($quiz_id)
	{
		$quiz_item = $this->base_api_get('quiz_model', $quiz_id);

		$this->api_output($quiz_item);
	}

	/**
	 * GET quiz by slug.
	 *
	 * @param string $quiz_slug Quiz slug.
	 */
	public function get_quiz_by_slug($quiz_slug)
	{
		$quiz_item = $this->base_api_get('quiz_model', $quiz_slug, 'get_item_by_slug');

		$this->api_output($quiz_item);
	}

	/**
	 * POST quizzes.
	 */
	public function post_quizzes()
	{
		$quiz_item = $this->base_api_set('quiz_item', 'quiz_model');

		$this->api_output($quiz_item);
	}
}