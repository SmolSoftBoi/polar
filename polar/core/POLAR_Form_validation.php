<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Polar form validation.
 *
 * @package Polar
 */
class POLAR_Form_validation extends CI_Form_validation {

	/**
	 * Valid domain.
	 *
	 * @param string $domain Domain.
	 *
	 * @return bool Valid.
	 */
	public function valid_domain($domain)
	{
		if (function_exists('idn_to_ascii'))
		{
			$domain = idn_to_ascii($domain);

			return (bool)preg_match(DOMAIN_REGEXP, $domain);
		}
	}
}