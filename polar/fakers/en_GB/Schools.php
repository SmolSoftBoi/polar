<?php

namespace Faker\Provider\en_GB;

defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends \Faker\Provider\Base
{
	protected static $schoolFormats = array(
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

	protected static $schoolPrefixes = array(
		'Acadamy of',
		'University College',
		'University College of',
		'University of'
	);

	protected static $schoolSuffixes = array(
		'College',
		'Institute',
		'School',
		'University',
		'University College'
	);

	protected static $schoolTlds = array('ac.uk');
}