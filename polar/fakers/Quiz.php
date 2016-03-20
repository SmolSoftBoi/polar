<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

namespace Faker\Provider;

defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends \Faker\Provider\Base {
	public function quizName()
	{
		$name = $this->generator->sentence($this->generator->numberBetween(2, 8));
		$name = rtrim($name, '.');

		return $name;
	}

	public function quizDescription()
	{
		return $this->generator->paragraph($this->generator->numberBetween(2, 8));
	}

	public function quizQuestion()
	{
		$question = $this->generator->sentence($this->generator->numberBetween(2, 8));
		$question = rtrim($question, '.') + '?';

		return $question;
	}

	public function quizAnswer()
	{
		$answer = $this->generator->sentence($this->generator->numberBetween(1, 8));
		$answer = rtrim($answer, '.');

		return $answer;
	}
}