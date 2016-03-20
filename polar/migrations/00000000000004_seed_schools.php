<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed schools migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_schools extends CI_Migration {

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

			$faker->addProvider(new Faker\Provider\en_GB\School($faker));
			$faker->addProvider(new Faker\Provider\School($faker));

			$schools = array();

			$this->db->trans_start();

			$schools_count = $faker->numberBetween(2 * $magnitude, 8 * $magnitude);
			for ($i = 0; $i < $schools_count; $i++)
			{
				$schools[] = array(
					'school_name' => $faker->unique()->school
				);
			}

			$this->db->insert_batch('schools', $schools);

			$this->db->trans_complete();

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