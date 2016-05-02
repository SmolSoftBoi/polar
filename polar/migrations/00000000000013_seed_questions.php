<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed questions migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_questions extends CI_Migration {

	/**
	 * @var bool $seed Seed.
	 */
	private $seed = FALSE;

	/**
	 * Add roles migration constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('fakers');

		$this->config->load('migration');

		$this->seed = $this->config->item('migration_seed');

		if (is_null($this->seed))
		{
			$this->seed = FALSE;
		}
	}

	/**
	 * Migrate up.
	 */
	public function up()
	{
		if ($this->seed)
		{
			$magnitude = $this->config->item('migration_seed_magnitude');

			if (is_null($magnitude))
			{
				$magnitude = 1;
			}

			$max_execution_time = ini_get('max_execution_time');

			set_time_limit($max_execution_time * $magnitude);

			$faker = Faker\Factory::create('en_GB');

			$faker->addProvider(new Faker\Provider\Quiz($faker));

			$time_limits = range(30, 120, 30);

			$this->db->trans_start();

			$multiple_choice_question_type = $this->db->where('question_type_key', 'multiplechoice')
			                                          ->get('question_types')
			                                          ->row();

			$quizzes = $this->db->get('quizzes')->result();

			$this->db->trans_complete();

			foreach ($quizzes as $quiz)
			{
				$questions = array();

				$this->db->trans_start();

				$questions_count = $faker->numberBetween(2, 8 * $magnitude);
				for ($i = 0; $i < $questions_count; $i++)
				{
					$questions[] = array(
						'question_type_id' => $multiple_choice_question_type->question_type_id,
						'quiz_id'          => $quiz->quiz_id,
						'question'         => $faker->quizQuestion,
						'time_limit'       => $faker->randomElement($time_limits)
					);
				}

				$this->db->insert_batch('questions', $questions);

				$this->db->trans_complete();
			}

			set_time_limit($max_execution_time);
		}
	}

	/**
	 * Migrate down.
	 */
	public function down()
	{
	}
}