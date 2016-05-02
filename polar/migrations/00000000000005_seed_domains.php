<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed domains migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_domains extends CI_Migration {

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

			$school_domains = array();

			$this->db->trans_start();

			$schools = $this->db->get('schools')->result();

			foreach ($schools as $school)
			{
				$domains_count = $faker->numberBetween(1, 2 * $magnitude);
				for ($i = 0; $i < $domains_count; $i++)
				{
					$domain = array(
						'domain' => $faker->unique()->schoolDomain
					);
					$this->db->insert('domains', $domain);

					$domain_id = $this->db->insert_id();

					$school_domains[] = array(
						'school_id' => $school->school_id,
						'domain_id' => $domain_id
					);
				}
			}

			$this->db->insert_batch('school_domains', $school_domains);

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