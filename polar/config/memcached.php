<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Memcached configuration
 *
 * @package Polar\Config
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Memcached settings
| -------------------------------------------------------------------------
| Your Memcached servers can be specified below.
|
|	See: http://codeigniter.com/user_guide/libraries/caching.html#memcached
|
*/
$config = array(
	'default' => array(
		'hostname' => '127.0.0.1',
		'port'     => '11211',
		'weight'   => '1',
	),
);
