<?php

namespace Faker\Provider\en_KW;

defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends \Faker\Provider\Base
{
	protected static $schoolFormats = array(
		'{{city}} {{schoolSuffix}}',
		'{{state}} {{schoolSuffix}}',
		'{{schoolPrefix}} {{city}}',
		'{{schoolPrefix}} {{state}}'
	);

	protected static $schoolPrefixes = array(
		'College of'
	);

	protected static $schoolSuffixes = array(
		'College',
		'University'
	);

	protected static $schoolTlds = array('edu.kw');
}