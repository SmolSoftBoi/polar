<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed answers migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_answers extends CI_Migration {

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
			set_time_limit(30);
		}
	}

	/**
	 * Migrate up.
	 */
	public function up()
	{
		if ($this->seed)
		{
			$faker = Faker\Factory::create('en_GB');

			$faker->addProvider(new Faker\Provider\Quiz($faker));

			$scores = range(10, 100, 10);

			$this->db->trans_start();

			$questions = $this->db->get('questions')->result();

			$this->db->trans_complete();

			foreach ($questions as $question)
			{
				$answers = array();

				$this->db->trans_start();

				$answers_count = $faker->numberBetween(2, 4);

				$correct_answer = $faker->numberBetween(0, $answers_count - 1);

				for ($i = 0; $i < $answers_count; $i++)
				{
					$answer = array(
						'question_id' => $question->question_id,
						'answer'      => $faker->quizAnswer,
						'score'       => 0
					);

					if ($i === $correct_answer)
					{
						$answer['score'] = $faker->randomElement($scores);
					}

					$answers[] = $answer;
				}

				$this->db->insert_batch('answers', $answers);

				$this->db->trans_complete();
			}
		}
	}

	/**
	 * Migrate down.
	 */
	public function down()
	{
	}
}