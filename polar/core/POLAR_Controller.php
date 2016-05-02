<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Polar controller.
 *
 * @package Polar
 *
 * @property CI_Config          $config          CodeIgniter configuration.
 * @property CI_Form_validation $form_validation CodeIgniter form validation.
 * @property CI_Loader          $load            CodeIgniter loader.
 * @property CI_Migration       $migration       CodeIgniter migration.
 * @property CI_Output          $output          CodeIgniter output.
 * @property POLAR_Input        $input           Input.
 * @property Auth               $auth            Authentication.
 * @property Template           $template        Template.
 */
class POLAR_Controller extends CI_Controller {

	/**
	 * Polar controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(SHOW_PROFILER);

		$this->migration->current();

		$data['brand_color'] = $this->config->item('brand_color');

		$this->load->vars($data);
	}

	/**
	 * Base API search.
	 *
	 * @param string $params_class  Parameters class.
	 * @param string $model_class   Model class.
	 * @param string $search_method Search method.
	 *
	 * @return Item[] Items.
	 */
	protected function base_api_search($params_class, $model_class, $search_method = 'search')
	{
		$json = $this->input->raw_input_stream;

		$params = new $params_class();

		$params->jsonDeserialize($json);

		$items = $this->$model_class->$search_method($params);

		return $items;
	}

	/**
	 * Base API gets.
	 *
	 * @param string $model_class   Model class.
	 * @param string $search_method Search method.
	 *
	 * @return Item[] Items.
	 */
	protected function base_api_gets($model_class, $search_method = 'search')
	{
		$items = $this->$model_class->$search_method();

		return $items;
	}

	/**
	 * Base API get.
	 *
	 * @param string $model_class     Model class.
	 * @param int    $id              ID.
	 * @param string $get_item_method Get item method.
	 *
	 * @return Item Item.
	 */
	protected function base_api_get($model_class, $id, $get_item_method = 'get_item')
	{
		$item = $this->$model_class->$get_item_method($id);

		return $item;
	}

	/**
	 * Base API set.
	 *
	 * @param string $item_class      Item class.
	 * @param string $model_class     Model class.
	 * @param string $set_item_method Set item method.
	 * @param string $get_item_method Get item method.
	 *
	 * @return Item Item.
	 */
	protected function base_api_set($item_class, $model_class, $set_item_method = 'set_item', $get_item_method = 'get_item')
	{
		$json = $this->input->raw_input_stream;

		$item = new $item_class();

		$item->jsonDeserialize($json);

		$id = $this->$model_class->$set_item_method($item);

		$this->$model_class->level = 0;

		$item = $this->$model_class->$get_item_method($id);

		return $item;
	}

	/**
	 * API authenticated.
	 *
	 * @param bool $authed Authenticated.
	 */
	protected function api_authed($authed)
	{
		if ( ! $authed)
		{
			$this->output->set_status_header(HTTP_UNAUTHORISED)->_display();

			exit;
		}
	}

	/**
	 * API status.
	 *
	 * @param int    $code HTTP status code.
	 * @param string $text Message.
	 */
	protected function api_status($code, $text = '')
	{
		$this->output->enable_profiler(FALSE);

		$this->output->set_status_header($code, $text)->_display();

		exit;
	}

	/**
	 * API output.
	 *
	 * @param mixed $data Output data.
	 */
	protected function api_output($data)
	{
		$this->output->enable_profiler(FALSE);

		$this->output->set_content_type('json')->set_output(json_encode($data));
	}
}