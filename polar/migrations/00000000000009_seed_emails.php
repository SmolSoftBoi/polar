<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed emails migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_emails extends CI_Migration {

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
			$faker = Faker\Factory::create('en_GB');

			$faker->addProvider(new Faker\Provider\en_GB\School($faker));
			$faker->addProvider(new Faker\Provider\School($faker));

			$user_emails = array();

			$this->db->trans_complete();

			$user_emails = array();

			$this->db->trans_start();

			$users = $this->db->get('users')->result();

			foreach ($users as $user)
			{
				$email = array(
					'email'    => $faker->unique()->schoolEmail,
					'verified' => $faker->boolean(80)
				);
				$this->db->insert('emails', $email);

				$email_id = $this->db->insert_id();

				$user_emails[] = array(
					'user_id'  => $user->user_id,
					'email_id' => $email_id
				);
			}

			$this->db->insert_batch('user_emails', $user_emails);

			$this->db->trans_complete();
		}
	}

	/**
	 * Migrate down.
	 */
	public function down()
	{
	}
}