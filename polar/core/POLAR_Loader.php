<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Polar loader.
 *
 * @package Polar
 */
class POLAR_Loader extends CI_Loader {

	/**
	 * @var CI_Controller $CI CodeIgniter instance.
	 */
	protected $CI;

	public function __construct()
	{
		parent::__construct();

		$this->CI =& get_instance();
	}

	/**
	 * Load the database forge class.
	 *
	 * @param    object $db     Database object.
	 * @param    bool   $return Whether to return the database forge class object or not.
	 *
	 * @return    object Database forge class object.
	 */
	public function dbforge($db = NULL, $return = FALSE)
	{
		if ( ! is_object($db) OR ! ($db instanceof CI_DB))
		{
			class_exists('CI_DB', FALSE) OR $this->database();
			$db =& $this->CI->db;
		}

		$subclass_prefix = config_item('subclass_prefix');

		require_once BASEPATH . 'database/DB_forge.php';
		require_once BASEPATH . 'database/drivers/' . $db->dbdriver . '/' . $db->dbdriver . '_forge.php';

		$driver_path = APPPATH . 'database/drivers/' . $db->dbdriver . '/' . $db->dbdriver . '_forge.php';

		if (file_exists($driver_path))
		{
			require_once $driver_path;
		}

		if ( ! empty($db->subdriver))
		{
			$driver_path = BASEPATH . 'database/drivers/' . $db->dbdriver . '/subdrivers/' . $db->dbdriver . '_'
			               . $db->subdriver . '_forge.php';

			if (file_exists($driver_path))
			{
				require_once $driver_path;

				$class = 'CI_DB_' . $db->dbdriver . '_' . $db->subdriver . '_forge';

				$driver_path = APPPATH . 'database/drivers/' . $db->dbdriver . '/subdrivers/' . $subclass_prefix
				               . $db->dbdriver . '_' . $db->subdriver . '_forge.php';

				if (file_exists($driver_path))
				{
					require_once $driver_path;

					$driver_class = $subclass_prefix . 'DB_' . $db->dbdriver . '_' . $db->subdriver . '_forge';

					if (class_exists($driver_class))
					{
						$class = $driver_class;
					}
				}
			}
		}
		else
		{
			$class = 'CI_DB_' . $db->dbdriver . '_forge';

			$driver_class = $subclass_prefix . 'DB_' . $db->dbdriver . '_forge';

			if (class_exists($driver_class))
			{
				$class = $driver_class;
			}
		}

		if ($return === TRUE)
		{
			return new $class($db);
		}

		$this->CI->dbforge = new $class($db);

		return $this;
	}
}