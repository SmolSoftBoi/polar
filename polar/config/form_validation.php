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
		'label' => 'First Name',
		'rules' => 'required|trim|max_length[10]'
	),
	array(
		'field' => 'lastName',
		'label' => 'Last Name',
		'rules' => 'required|trim|max_length[10]'
	),
	array(
		'field' => 'email',
		'label' => 'Email',
		'rules' => 'required|trim|valid_email|is_unique[emails.email]|max_length[46]'
	),
	array(
		'field' => 'password',
		'label' => 'Password',
		'rules' => 'required'
	),
	array(
		'field' => 'passwordConfirm',
		'label' => 'Confirm Password',
		'rules' => 'required|matches[password]'
	)
);
$config['auth/signin'] = array(
	array(
		'field' => 'email',
		'label' => 'Email',
		'rules' => 'required|trim|valid_email|max_length[46]'
	),
	array(
		'field' => 'password',
		'label' => 'Password',
		'rules' => 'required'
	)
);

/**
 * Admin.
 */
$config['admin/setup/user'] = $config['auth/signup'];