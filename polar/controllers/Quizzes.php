<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quizzes controller.
 */
class Quizzes extends POLAR_Controller {

	/**
	 * Quizzes constructor.
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
		$this->template->view('default', 'welcome_message');
	}

	public function create()
	{
		$this->template->view('default', 'quizzes/form');
	}

	/**
	 * Quiz slug.
	 *
	 * @param string $slug Slug.
	 */
	public function quiz()
	{
		$this->template->view('default', 'quizzes/quiz');
	}
}