<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Storage configuraiton.
 *
 * @package Polar\Config
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$config['cdn_url'] = '';
$config['cdn_path'] = 'content';

$active_group = 'default';

$storage['default'] = array(
	'base_url' => '',
	'path'     => FCPATH . 'content',
	'driver'   => 'file',
	'key'      => '',
	'secret'   => '',
	'region'   => ''
);