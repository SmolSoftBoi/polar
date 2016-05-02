<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

namespace Faker\Provider\en_GB;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * School faker.
 *
 * @package Polar\Fakers
 */
class School extends \Faker\Provider\Base {
	protected $schoolFormats = array(
		'Central {{city}} {{schoolSuffix}}',
		'{{city}} City {{schoolSuffix}}',
		'{{city}} {{schoolSuffix}}',
		'{{city}} South {{schoolSuffix}}',
		'{{schoolPrefix}} Central {{city}}',
		'{{schoolPrefix}} Central {{state}}',
		'{{schoolPrefix}} East {{city}}',
		'{{schoolPrefix}} East {{state}}',
		'{{schoolPrefix}} {{city}}',
		'{{schoolPrefix}} {{state}}',
		'Central {{state}} {{schoolSuffix}}',
		'{{state}} {{schoolSuffix}}',
		'{{state}} South {{schoolSuffix}}'
	);

	protected $schoolPrefixes = array(
		'Acadamy of',
		'University College',
		'University College of',
		'University of'
	);

	protected $schoolSuffixes = array(
		'College',
		'Institute',
		'School',
		'University',
		'University College'
	);

	protected $schoolTlds = array('ac.uk');
}