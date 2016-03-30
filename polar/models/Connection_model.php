<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Connection model.
 *
 * @package Polar\Models
 */
class Connection_model extends Item_model {

	/**
	 * Search.
	 *
	 * @param Connection_params|null $connection_params Connection parameters.
	 *
	 * @return Connection_item[] Connection items.
	 */
	public function search($connection_params = NULL)
	{
		return $this->base_search('connection_item', 'connection_id', $connection_params);
	}

	/**
	 * Get connection item.
	 *
	 * @param  int $connection_id Connection ID.
	 *
	 * @return Connection_item Connection item.
	 */
	public function get_item($connection_id)
	{
		return $this->base_get_item('connections', 'connection_id', 'connection_item', $connection_id);
	}

	/**
	 * Set connection item.
	 *
	 * @param Connection_item $connection_item Connection item.
	 *
	 * @return int Connection ID.
	 */
	public function set_item($connection_item)
	{
		return $this->base_set_item('connections', 'connection_id', 'connection_id', 'connection_item', $connection_item);
	}

	/**
	 * Build.
	 *
	 * @param Connection_params|null $connection_params Connection parameters.
	 */
	protected function build($connection_params = NULL)
	{
		if (is_null($connection_params))
		{
			$connection_params = new Connection_params();
		}

		$this->base_build('connections');

		$this->db->join('quiz_connections', 'connections.connection_id = quiz_connections.connection_id');

		$this->build_param($connection_params, 'quiz_id', 'quiz_connections', 'quiz_id');
	}

	/**
	 * Generate.
	 *
	 * @param Connection_item $connection_item Connection item.
	 *
	 * @return Connection_item Connection item.
	 */
	protected function generate($connection_item)
	{
		$connection_item = $this->base_generate(2, 'connection_id', $connection_item);

		$connection_item->user_id = intval($connection_item->user_id);
		$connection_item->connection_timestamp = new DateTime($connection_item->connection_timestamp);

		return $connection_item;
	}
}