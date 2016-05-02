<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seed email verifications migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Seed_email_verifications extends CI_Migration {

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

			$email_verifications = array();

			$this->db->trans_start();

			$emails = $this->db->where('verified', FALSE)->get('emails')->result();

			foreach ($emails as $email)
			{
				$email_verifications[] = array(
					'email_id'          => $email->email_id,
					'verification_code' => $faker->unique()->md5
				);
			}

			if ( ! empty($email_verifications))
			{
				$this->db->insert_batch('email_verifications', $email_verifications);
			}

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