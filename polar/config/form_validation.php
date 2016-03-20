<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Form validation configuration.
 *
 * @package Polar\Config
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authentication.
 */
$config['auth/signup'] = array(
	array(
		'field' => 'firstName',
		'label' => 'lang:first_name_label',
		'rules' => 'required|trim|max_length[255]'
	),
	array(
		'field' => 'lastName',
		'label' => 'lang:last_name_label',
		'rules' => 'required|trim|max_length[255]'
	),
	array(
		'field' => 'email',
		'label' => 'lang:email_label',
		'rules' => 'required|trim|valid_email|is_unique[emails.email]|max_length[255]'
	),
	array(
		'field' => 'password',
		'label' => 'lang:password_label',
		'rules' => 'required'
	),
	array(
		'field' => 'passwordConfirm',
		'label' => 'lang:password_confirm_label',
		'rules' => 'required|matches[password]'
	)
);
$config['auth/signin'] = array(
	array(
		'field' => 'email',
		'label' => 'lang:email_label',
		'rules' => 'required|trim|valid_email|max_length[255]'
	),
	array(
		'field' => 'password',
		'label' => 'lang:password_label',
		'rules' => 'required'
	)
);

/**
 * Domain.
 */
$config['domain'] = array(
	array(
		'field' => 'domain',
		'label' => 'lang:domain_label',
		'rules' => 'required|trim|valid_domain|max_length[255]'
	)
);

/**
 * School.
 */
$config['school'] = array(
	array(
		'field' => 'schoolName',
		'label' => 'lang:school_name_label',
		'rules' => 'required|trim|is_unique[schools.school_name]|max_length[255]'
	)
);

/**
 * Admin.
 */
$config['admin/setup/user'] = $config['auth/signup'];
$config['admin/school'] = array_merge($config['school'], $config['domain']);