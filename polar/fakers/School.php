<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

namespace Faker\Provider;

defined('BASEPATH') OR exit('No direct script access allowed');

class School extends \Faker\Provider\Base {
	protected $schoolFormats = array(
		'{{country}} {{schoolSuffix}}',
		'{{schoolPrefix}} Central {{country}}',
		'{{schoolPrefix}} {{country}}',
		'The {{schoolPrefix}} {{country}}'
	);

	protected $schoolPrefixes = array(
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

	protected $schoolSuffixes = array(
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

	protected $schoolEmailFormats = array(
		'{{schoolId}}@{{schoolDomain}}',
		'{{schoolUserName}}@{{schoolDomain}}'
	);

	protected $schoolTlds = array(
		'ac.uk',
		'edu.kw'
	);

	public function school()
	{
		$format = $this->generator->randomElement($this->schoolFormats);

		return $this->generator->parse($format);
	}

	public function schoolPrefix()
	{
		return $this->generator->randomElement($this->schoolPrefixes);
	}

	public function schoolSuffix()
	{
		return $this->generator->randomElement($this->schoolSuffixes);
	}

	public function schoolId()
	{
		$id = $this->generator->numberBetween(1);

		return str_pad($id, 10, '0', STR_PAD_LEFT);
	}

	public function schoolEmail()
	{
		$format = $this->generator->randomElement($this->schoolEmailFormats);

		return $this->generator->parse($format);
	}

	public function schoolDomain()
	{
		$domain = $this->generator->parse('{{country}}.{{schoolTld}}');

		return str_replace(' ', '', strtolower($domain));
	}

	public function schoolUserName()
	{
		$firstName = strtolower($this->generator->firstName);
		$lastName = strtolower($this->generator->lastName);

		if ($this->generator->boolean(20))
		{
			$firstName = substr($firstName, 0, 1);
		}

		if ($this->generator->boolean(20))
		{
			$lastName = substr($lastName, 0, 1);
		}

		return $firstName . '.' . $lastName;
	}

	public function schoolTld()
	{
		return $this->generator->randomElement($this->schoolTlds);
	}
}