<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Events configuration.
 *
 * @package Polar\Config
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$event['Auth']['pre_authed_by_role'] = array(
	'class'    => 'Auth_events',
	'function' => 'pre_authed_by_role',
	'filepath' => 'events/Auth_events.php'
);