<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Create tables migration.
 *
 * @package Polar\Migrations
 *
 * @property CI_DB_query_builder $db      CodeIgniter database quiery builder.
 * @property CI_DB_forge         $dbforge CodeIgniter database forge.
 * @property CI_Loader           $load    CodeIgniter loader.
 */
class Migration_Create_tables extends CI_Migration {

	/**
	 * Create tables migration constructor.
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

		// Create domains
		$this->dbforge->add_field(array(
			'domain_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'domain'    => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'unique'     => TRUE
			)
		));
		$this->dbforge->add_key('domain_id', TRUE);
		$this->dbforge->create_table('domains', TRUE);

		// Create emails
		$this->dbforge->add_field(array(
			'email_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'email'    => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'unique'     => TRUE
			),
			'verified' => array(
				'type'    => 'BOOLEAN',
				'default' => FALSE
			)
		));
		$this->dbforge->add_key('email_id', TRUE);
		$this->dbforge->create_table('emails', TRUE);

		// Create email verifications
		$this->dbforge->add_field(array(
			'email_verification_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'email_id'              => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE,
				'unique'   => TRUE
			),
			'verification_code'     => array(
				'type'       => 'VARCHAR',
				'constraint' => 36,
				'unique'     => TRUE
			)
		));
		$this->dbforge->add_key('email_verification_id', TRUE);
		$this->dbforge->add_foreign_key('email_id', 'emails', 'email_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('email_verifications', TRUE);

		// Create roles
		$this->dbforge->add_field(array(
			'role_id'   => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'role_key'  => array(
				'type'       => 'VARCHAR',
				'constraint' => 14,
				'unique'     => TRUE
			),
			'role_name' => array(
				'type'       => 'VARCHAR',
				'constraint' => 15,
				'unique'     => TRUE
			)
		));
		$this->dbforge->add_key('role_id', TRUE);
		$this->dbforge->create_table('roles', TRUE);

		// Create users
		$this->dbforge->add_field(array(
			'user_id'       => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'first_name'    => array(
				'type'       => 'VARCHAR',
				'constraint' => 255
			),
			'last_name'     => array(
				'type'       => 'VARCHAR',
				'constraint' => 255
			),
			'password_hash' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255
			)
		));
		$this->dbforge->add_key('user_id', TRUE);
		$this->dbforge->create_table('users', TRUE);

		// Create user emails
		$this->dbforge->add_field(array(
			'user_email_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'user_id'       => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'email_id'      => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE,
				'unique'   => TRUE
			)
		));
		$this->dbforge->add_key('user_email_id', TRUE);
		$this->dbforge->add_foreign_key('user_id', 'users', 'user_id');
		$this->dbforge->add_foreign_key('email_id', 'emails', 'email_id');
		$this->dbforge->create_table('user_emails', TRUE);

		// Create user roles
		$this->dbforge->add_field(array(
			'user_role_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'user_id'      => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'role_id'      => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('user_role_id', TRUE);
		$this->dbforge->add_foreign_key('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
		$this->dbforge->add_foreign_key('role_id', 'roles', 'role_id', 'CASCADE', 'RESTRICT');
		$this->dbforge->create_table('user_roles', TRUE);

		// Create schools
		$this->dbforge->add_field(array(
			'school_id'   => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'school_name' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'unique'     => TRUE
			)
		));
		$this->dbforge->add_key('school_id', TRUE);
		$this->dbforge->create_table('schools', TRUE);

		// Create school domains
		$this->dbforge->add_field(array(
			'school_domain_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'school_id'        => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'domain_id'        => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE,
				'unique'   => TRUE
			)
		));
		$this->dbforge->add_key('school_domain_id', TRUE);
		$this->dbforge->add_foreign_key('school_id', 'schools', 'school_id', 'CASCADE', 'CASCADE');
		$this->dbforge->add_foreign_key('domain_id', 'domains', 'domain_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('school_domains', TRUE);

		// Create user schools
		$this->dbforge->add_field(array(
			'user_school_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'user_id'        => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'school_id'      => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('user_school_id', TRUE);
		$this->dbforge->add_foreign_key('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
		$this->dbforge->add_foreign_key('school_id', 'schools', 'school_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('user_schools', TRUE);

		// Create quizzes
		$this->dbforge->add_field(array(
			'quiz_id'          => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'question_id'      => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE,
				'null'     => TRUE
			),
			'user_id'          => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'quiz_name'        => array(
				'type'       => 'VARCHAR',
				'constraint' => 255
			),
			'quiz_slug'        => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'unique'     => TRUE
			),
			'description'      => array(
				'type' => 'TEXT',
				'NULL' => TRUE
			),
			'code'             => array(
				'type'       => 'VARCHAR',
				'constraint' => 4,
				'null'       => TRUE,
				'unique'     => TRUE
			),
			'launch_timestamp' => array(
				'type'       => 'integer',
				'constraint' => 10,
				'null'       => TRUE
			),
			'live'             => array(
				'type'    => 'BOOLEAN',
				'default' => FALSE
			)
		));
		$this->dbforge->add_key('quiz_id', TRUE);
		$this->dbforge->add_foreign_key('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('quizzes', TRUE);

		// Create question types
		$this->dbforge->add_field(array(
			'question_type_id'   => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'question_type_key'  => array(
				'type'       => 'VARCHAR',
				'constraint' => 17,
				'unique'     => TRUE
			),
			'question_type_name' => array(
				'type'       => 'VARCHAR',
				'constraint' => 18,
				'unique'     => TRUE
			)
		));
		$this->dbforge->add_key('question_type_id', TRUE);
		$this->dbforge->create_table('question_types', TRUE);

		// Create questions
		$this->dbforge->add_field(array(
			'question_id'      => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'question_type_id' => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'quiz_id'          => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'question'         => array(
				'type'       => 'VARCHAR',
				'constraint' => 255
			),
			'time_limit'       => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE,
				'null'     => TRUE
			)
		));
		$this->dbforge->add_key('question_id', TRUE);
		$this->dbforge->add_foreign_key('question_type_id', 'question_types', 'question_type_id', 'CASCADE', 'RESTRICT');
		$this->dbforge->add_foreign_key('quiz_id', 'quizzes', 'quiz_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('questions', TRUE);

		// Create answers
		$this->dbforge->add_field(array(
			'answer_id'   => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'question_id' => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'answer'      => array(
				'type'       => 'VARCHAR',
				'constraint' => 255
			),
			'score'       => array(
				'type'    => 'INTEGER',
				'default' => 0
			)
		));
		$this->dbforge->add_key('answer_id', TRUE);
		$this->dbforge->add_foreign_key('question_id', 'questions', 'question_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('answers', TRUE);

		// Create question responses
		$this->dbforge->add_field(array(
			'question_response_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'answer_id'            => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'user_id'              => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('question_response_id', TRUE);
		$this->dbforge->add_foreign_key('answer_id', 'answers', 'answer_id', 'CASCADE', 'CASCADE');
		$this->dbforge->add_foreign_key('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('question_responses', TRUE);

		// Create media
		$this->dbforge->add_field(array(
			'media_id'     => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'media_url'    => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'unique'     => TRUE
			),
			'media_url_lg' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => TRUE,
				'unique'     => TRUE
			),
			'media_url_md' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => TRUE,
				'unique'     => TRUE
			),
			'media_url_sm' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => TRUE,
				'unique'     => TRUE
			),
			'media_url_xs' => array(
				'type'       => ' VARCHAR',
				'constraint' => 255,
				'null'       => TRUE,
				'unique'     => TRUE
			),
			'image'        => array(
				'type' => 'BOOLEAN'
			)
		));
		$this->dbforge->add_key('media_id', TRUE);
		$this->dbforge->create_table('media', TRUE);

		// Create question media
		$this->dbforge->add_field(array(
			'question_media_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'question_id'       => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'media_id'          => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('question_media_id', TRUE);
		$this->dbforge->add_foreign_key('question_id', 'questions', 'question_id', 'CASCADE', 'CASCADE');
		$this->dbforge->add_foreign_key('media_id', 'media', 'media_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('question_media', TRUE);

		// Create connections
		$this->dbforge->add_field(array(
			'connection_id'        => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'user_id'              => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'connection_timestamp' => array(
				'type'       => 'INTEGER',
				'constraint' => 10
			)
		));
		$this->dbforge->add_key('connection_id', TRUE);
		$this->dbforge->add_foreign_key('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('connections', TRUE);

		// Create quiz connections
		$this->dbforge->add_field(array(
			'quiz_connection_id' => array(
				'type'           => 'INTEGER',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'quiz_id'            => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			),
			'connection_id'      => array(
				'type'     => 'INTEGER',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('quiz_connection_id', TRUE);
		$this->dbforge->add_foreign_key('quiz_id', 'quizzes', 'quiz_id', 'CASCADE', 'CASCADE');
		$this->dbforge->add_foreign_key('connection_id', 'connections', 'connection_id', 'CASCADE', 'CASCADE');
		$this->dbforge->create_table('quiz_connections', TRUE);

		// Add quiz foreign key
		$this->dbforge->add_foreign_key_to_table('quizzes', 'question_id', 'questions', 'question_id', 'CASCADE', 'SET NULL');

		$this->db->trans_complete();
	}

	/**
	 * Migrate down.
	 */
	public function down()
	{
		$this->db->trans_start();

		// Drop quiz connections
		$this->dbforge->drop_table('quiz_connections', TRUE);

		// Drop connections
		$this->dbforge->drop_table('connections', TRUE);

		// Drop question media
		$this->dbforge->drop_table('question_media', TRUE);

		// Drop media
		$this->dbforge->drop_table('media', TRUE);

		// Drop question responses
		$this->dbforge->drop_table('question_responses', TRUE);

		// Drop answers
		$this->dbforge->drop_table('answers', TRUE);

		// Drop questions
		$this->dbforge->drop_table('questions', TRUE);

		// Drop question types
		$this->dbforge->drop_table('question_types', TRUE);

		// Drop quizzes
		$this->dbforge->drop_table('quizzes', TRUE);

		// Drop user schools
		$this->dbforge->drop_table('user_schools', TRUE);

		// Drop school domains
		$this->dbforge->drop_table('school_domains', TRUE);

		// Drop schools
		$this->dbforge->drop_table('schools', TRUE);

		// Drop user roles
		$this->dbforge->drop_table('user_roles', TRUE);

		// Drop user emails
		$this->dbforge->drop_table('user_emails', TRUE);

		// Drop users
		$this->dbforge->drop_table('users', TRUE);

		// Drop roles
		$this->dbforge->drop_table('roles', TRUE);

		// Drop email verifications
		$this->dbforge->drop_table('email_verifications', TRUE);

		// Drop emails
		$this->dbforge->drop_table('emails', TRUE);

		// Drop domains
		$this->dbforge->drop_table('domains', TRUE);

		$this->db->trans_complete();
	}
}