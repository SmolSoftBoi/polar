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
 *
 * @property Quiz_model $quiz_model Quiz model.
 * @property User_model $user_model User model.
 */
class Connection_model extends Item_model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('quiz_model', 'user_model'));

		$this->clean();
	}

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
		if ( ! isset($connection_item->connection_id) || $connection_item->connection_id === 0)
		{
			$connection_params = new Connection_params();

			$connection_params->user_id = $connection_item->user_id;

			$connection_items = $this->search($connection_params);

			if (count($connection_items) > 0)
			{
				$connection_item->connection_id = reset($connection_items)->connection_id;
			}
		}

		$connection_item->connection_timestamp = new DateTime();

		$connection_id = $this->base_set_item('connections', 'connection_id', 'connection_id', $connection_item);

		if (isset($connection_item->quiz))
		{
			$quiz_connection = array(
				'quiz_id'       => $connection_item->quiz->quiz_id,
				'connection_id' => $connection_id
			);

			$this->db->insert('quiz_connections', $quiz_connection);
		}

		return $connection_id;
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

		$this->db->join('quiz_connections', 'connections.connection_id = quiz_connections.connection_id', 'left');

		$this->build_param($connection_params, 'quiz_id', 'quiz_connections', 'quiz_id');
		$this->build_param($connection_params, 'user_id', 'connections', 'user_id');
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
		if (is_null($connection_item))
		{
			return $connection_item;
		}

		$connection_item = $this->base_generate(2, 'connection_id', $connection_item);

		$connection_item->user_id = intval($connection_item->user_id);

		$timestamp = new DateTime();

		$timestamp->setTimestamp($connection_item->connection_timestamp);

		$connection_item->connection_timestamp = $timestamp;

		if ($this->level > 0)
		{
			$this->user_model->level = $this->level;

			$connection_item->user = $this->user_model->get_item($connection_item->user_id);

			$quiz_params = new Quiz_params();

			$quiz_params->connection_id = $connection_item->connection_id;

			$this->quiz_model->level = $this->level;

			$quiz_connections = $this->quiz_model->search($quiz_params);

			if (count($quiz_connections) > 0)
			{
				$connection_item->quiz = reset($quiz_connections);
			}
		}

		return $connection_item;
	}

	/**
	 * Clean.
	 */
	private function clean()
	{
		$timestamp = new DateTime();

		$timestamp->sub(new DateInterval('PT30S'));

		$this->db->where('connection_timestamp <', $timestamp->getTimestamp())->delete('connections');
	}
}