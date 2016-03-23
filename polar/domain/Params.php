<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Parameters.
 *
 * @package Polar\Domain\Params
 */
abstract class Params extends POLAR_Model implements Params_interface {

	/**
	 * JSON serialize.
	 *
	 * @return object Object.
	 */
	public function jsonSerialize()
	{
		return $this->base_json_serialize();
	}

	/**
	 * JSON deserialize.
	 *
	 * @param object $object Object.
	 */
	public function jsonDeserialize($object)
	{
		$this->base_json_deserialize('Question_params', $object);
	}

	/**
	 * Base JSON serialize.
	 *
	 * @return object Object.
	 */
	protected function base_json_serialize()
	{
		$object = new stdClass();

		foreach ($this as $param => $value)
		{
			$params = explode('_', $param);

			foreach ($params as $key => $param)
			{
				$params[$key] = ucfirst($param);
			}

			$param = lcfirst(implode('', $params));

			$object->$param = $value;
		}

		return $object;
	}

	/**
	 * Base JSON deserialize.
	 *
	 * @param string $param_class Parameter class.
	 * @param object $object
	 *
	 * @return object Object.
	 */
	protected function base_json_deserialize($param_class, $object)
	{
		$object = json_decode($object);

		foreach ($object as $param => $value)
		{
			$param = ltrim(preg_replace('/[A-Z]/', '_$0', $param), '_');

			if (property_exists(__CLASS__, $param))
			{
				$this->$param = $value;
			}
		}

		return $object;
	}
}