<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Connections API controller.
 *
 * @package Polar\Controllers\API
 *
 * @property Connection_model $connection_model Connection model.
 */
class Connections extends POLAR_Controller {

	/**
	 * Connections API constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('connection_model');
	}

	/**
	 * Connections search.
	 */
	public function search()
	{
		try
		{
			$connection_items = $this->base_api_search('Connection_params', 'connection_model');

			$this->api_output($connection_items);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * GET connections.
	 */
	public function get_connections()
	{
		try
		{
			$connection_items = $this->base_api_gets('connection_model');

			$this->api_output($connection_items);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * GET connection.
	 *
	 * @param int $connection_id Connection ID.
	 */
	public function get_connection($connection_id)
	{
		try
		{
			$connection_item = $this->base_api_get('connection_model', $connection_id);

			$this->api_output($connection_item);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}

	/**
	 * POST connections.
	 */
	public function post_connections()
	{
		try
		{
			$connection_item = $this->base_api_set('Connection_item', 'connection_model');

			$this->api_output($connection_item);
		} catch (Exception $exception)
		{
			$this->api_status(HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
		}
	}
}