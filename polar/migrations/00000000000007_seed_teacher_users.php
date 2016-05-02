<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed teacher users migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_teacher_users extends CI_Migration {

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

			$password = $this->config->item('migration_seed_password');

			if (is_null($password))
			{
				$password = $faker->password;
			}

			$password_hash = password_hash($password, PASSWORD_DEFAULT);

			$this->db->trans_start();

			$teacher_role = $this->db->where('role_key', 'teacher')->get('roles')->row();

			$school_admin_user_schools = $this->db->join('user_roles', 'user_schools.user_id = user_roles.user_id')
			                                      ->join('roles', 'user_roles.role_id = roles.role_id')
			                                      ->where('roles.role_key', 'schooladmin')
			                                      ->get('user_schools')
			                                      ->result();

			$this->db->trans_complete();

			foreach ($school_admin_user_schools as $school_admin_user_school)
			{
				$user_roles = array();
				$user_schools = array();

				$this->db->trans_start();

				$users_count = $faker->numberBetween(1 * $magnitude, 8 * $magnitude);
				for ($i = 0; $i < $users_count; $i++)
				{
					$user = array(
						'first_name'    => $faker->firstName,
						'last_name'     => $faker->lastName,
						'password_hash' => $password_hash
					);
					$this->db->insert('users', $user);

					$user_id = $this->db->insert_id();

					$user_roles[] = array(
						'user_id' => $user_id,
						'role_id' => $teacher_role->role_id
					);

					$user_schools[] = array(
						'user_id'   => $user_id,
						'school_id' => $school_admin_user_school->school_id
					);
				}

				$this->db->insert_batch('user_roles', $user_roles);
				$this->db->insert_batch('user_schools', $user_schools);

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