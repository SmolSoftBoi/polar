<?php

namespace Faker\Provider;

defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends \Faker\Provider\Base
{
	protected static $schoolFormats = array(
		'{{country}} {{schoolSuffix}}',
		'{{schoolPrefix}} Central {{country}}'.
		'{{schoolPrefix}} {{country}}',
		'The{{schoolPrefix}} {{country}}'
	);

	protected static $schoolPrefixes = array(
		'Acadamy',
		'Acadamy of',
		'College of',
		'Community School of',
		'Cooperative School',
		'International Community School of',
		'International School',
		'International School of',
		'International Secondary School',
		'National University of',
		'School Foundation of',
		'School',
		'School of',
		'United World College',
		'United World College of'
	);

	protected static $schoolSuffixes = array(
		'Acadamy',
		'Alliance International School',
		'College',
		'College School',
		'Community School',
		'Comprehensive School',
		'Cooperative School',
		'Grammar School',
		'High School',
		'Institute',
		'International Acadamy',
		'International College',
		'International Community School',
		'International High School',
		'International School',
		'International School and College',
		'International Secondary School',
		'School',
		'School & College',
		'School Foundation',
		'Secondary College',
		'Secondary School',
		'United World College'
	);

	protected static $schoolTlds = array(
		'ac.uk',
		'edu.kw'
	);

	public static function school()
	{
		$format = $this->generator->randomElement($this->schoolFormats);

		return $this->generator->parse($format);
	}

	public static function schoolPrefix()
	{
		return $this->generator->randomElement($this->schoolPrefixes);
	}

	public static function schoolSuffix()
	{
		return $this->generator->randomElement($this->schoolSuffixes);
	}

	public static function schoolId()
	{
		return $this->numberBetween(1);
	}

	public static function schoolDomain()
	{
		$domain = strtolower($this->generator->randomElement($this->schools));
		$tld = $this->generator->randomElement($this->schoolTlds);

		return $domain + '.' + $tld;
	}

	public static function schoolUserName()
	{
		$userName = '';

		switch($this->generator->randomElement(array('id', 'name')))
		{
			case 'id':
				$prefix = $this->generator->randomLetter;
				$id = $this->schoolId;
				$userName = $prefix + $id;
				break;
			case 'name':
				$firstName = strtolower($this->generator->firstName);
				$lastName = strtolower($this->generator->lastName);
				$userName = $firstName + '.' + $lastName;
				break;
		}
	}
}