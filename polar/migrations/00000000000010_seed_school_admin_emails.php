<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed school admin emails migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_school_admin_emails extends CI_Migration {

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

			$this->db->trans_start();

			$school_admin_users = $this->db->join('user_roles', 'users.user_id = user_roles.user_id')
			                               ->join('roles', 'user_roles.role_id = roles.role_id')
			                               ->where('roles.role_key', 'schooladmin')
			                               ->get('users')
			                               ->result();

			foreach ($school_admin_users as $school_admin_user)
			{
				$emails_count = $faker->numberBetween(0, 1);
				for ($j = 0; $j < $emails_count; $j++)
				{
					$email = array(
						'email'    => $faker->unique()->schoolEmail,
						'verified' => $faker->boolean(80)
					);
					$this->db->insert('emails', $email);

					$email_id = $this->db->insert_id();

					$user_emails[] = array(
						'user_id'  => $school_admin_user->user_id,
						'email_id' => $email_id
					);
				}
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