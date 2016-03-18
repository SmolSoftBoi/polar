<?php

namespace Faker\Provider;

defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends \Faker\Provider\Base
{
	public static function quizName()
	{
		$name = $this->generator->sentance($this->generator->numberBetween(2, 8));
		$name = rtrim($name, '.');

		return $name;
	}

	public static function quizQuestion()
	{
		$question = $this->generator->sentance($this->generator->numberBetween(2, 8));
		$question = rtrim($question, '.') + '?';

		return $question;
	}

	public static function quizAnswer()
	{
		$answer = $this->generator->sentance($this->generator->numberBetween(1, 8));
		$answer = rtrim($answer, '.');

		return $answer;
	}
}