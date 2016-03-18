<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Add roles migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class Migration_Add_roles extends CI_Migration {

	/**
	 * Add roles migration constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Migrate up.
	 */
	public function up()
	{
		$this->db->trans_start();

		// Insert roles
		$roles = array(
			array(
				'role_name' => 'Admin',
				'role_key'  => 'admin'
			),
			array(
				'role_name' => 'School Admin',
				'role_key'  => 'schooladmin',
			),
			array(
				'role_name' => 'Teacher',
				'role_key'  => 'teacher'
			),
			array(
				'role_name' => 'Student',
				'role_key'  => 'student'
			)
		);
		$this->db->insert_batch('roles', $roles);

		$this->db->trans_complete();
	}

	/**
	 * Migrate down.
	 */
	public function down()
	{
		$this->db->trans_start();

		// Delete roles
		$this->db->where_in('role_key', array(
			'admin',
			'schooladmin',
			'teacher',
			'student'
		));
		$this->db->delete('roles');

		$this->db->trans_complete();
	}
}