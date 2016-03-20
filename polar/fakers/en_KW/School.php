<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

namespace Faker\Provider\en_KW;

defined('BASEPATH') OR exit('No direct script access allowed');

class School extends \Faker\Provider\Base {
	protected $schoolFormats = array(
		'{{city}} {{schoolSuffix}}',
		'{{state}} {{schoolSuffix}}',
		'{{schoolPrefix}} {{city}}',
		'{{schoolPrefix}} {{state}}'
	);

	protected $schoolPrefixes = array(
		'College of'
	);

	protected $schoolSuffixes = array(
		'College',
		'University'
	);

	protected $schoolTlds = array('edu.kw');
}