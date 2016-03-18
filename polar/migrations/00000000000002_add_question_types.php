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
class Migration_Add_question_types extends CI_Migration {

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

		// Insert question types
		$question_types = array(
			array(
				'question_type_key'  => 'multiplechoice',
				'question_type_name' => 'Multiple-Choice'
			)
		);
		$this->db->insert_batch('question_types', $question_types);

		$this->db->trans_complete();
	}

	/**
	 * Migrate down.
	 */
	public function down()
	{
		$this->db->trans_start();

		// Delete roles
		$this->db->where_in('question_type_key', array('multiplechoice'));
		$this->db->delete('questions');

		$this->db->trans_complete();
	}
}