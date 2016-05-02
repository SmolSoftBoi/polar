<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Item interface.
 *
 * @package Polar\Domain\Items
 */
interface Item_interface extends JsonSerializable {

	/**
	 * Specify data which should be deserialized from JSON.
	 *
	 * @param object $object Data which can be deserialized.
	 */
	public function jsonDeserialize($object);

	/**
	 * Database set.
	 */
	public function db_set();
}