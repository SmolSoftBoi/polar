<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed quizzes migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_quizzes extends CI_Migration {

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

			$this->db->trans_start();

			$teacher_users = $this->db->join('user_roles', 'users.user_id = user_roles.user_id')
			                          ->join('roles', 'user_roles.role_id = roles.role_id')
			                          ->where('roles.role_key', 'teacher')
			                          ->get('users')
			                          ->result();

			$this->db->trans_complete();

			foreach ($teacher_users as $teacher_user)
			{
				$quizzes = array();

				$this->db->trans_start();

				$quizzes_count = $faker->numberBetween(0, 8 * $magnitude);
				for ($i = 0; $i < $quizzes_count; $i++)
				{
					$quiz = array(
						'user_id'          => $teacher_user->user_id,
						'quiz_name'        => $faker->quizName,
						'quiz_slug'        => $faker->unique()->slug,
						'description'      => $faker->quizDescription,
						'live'             => $faker->boolean(),
						'code'             => NULL,
						'launch_timestamp' => NULL
					);

					if ($faker->boolean())
					{
						$quiz['code'] = $faker->unique()->randomNumber(4);
						$quiz['launch_timestamp'] = $faker->dateTimeBetween('now', '1 year')->getTimestamp();
					}

					$quizzes[] = $quiz;
				}

				if ( ! empty($quizzes))
				{
					$this->db->insert_batch('quizzes', $quizzes);
				}

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