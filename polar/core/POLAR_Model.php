<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Item model interface.
 *
 * @package Polar
 */
interface Item_model_interface {

	/**
	 * Count.
	 *
	 * @param Params|null $params Parameters.
	 *
	 * @return Item[] Items.
	 */
	public function count($params = NULL);

	/**
	 * Search.
	 *
	 * @param Params|null $params Parameters.
	 *
	 * @return Item[] Items.
	 */
	public function search($params = NULL);

	/**
	 * Get items.
	 *
	 * @param int[] $ids IDs.
	 *
	 * @return Item[] Items.
	 */
	public function get_items($ids);

	/**
	 * Get item.
	 *
	 * @param int $id ID.
	 *
	 * @return Item Item.
	 */
	public function get_item($id);

	/**
	 * Set items.
	 *
	 * @param Item[] $items Items.
	 *
	 * @return int[] IDs.
	 */
	public function set_items($items);

	/**
	 * Set item.
	 *
	 * @param Item $item Item.
	 *
	 * @return int ID.
	 */
	public function set_item($item);
}

/**
 * Polar model.
 *
 * @package Polar
 *
 * @property CI_DB_query_builder $db   CodeIgniter database query builder.
 * @property CI_Loader           $load CodeIgniter loader.
 */
class POLAR_Model extends CI_Model {

	/**
	 * Polar model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
}

/**
 * Core item model.
 *
 * @package Polar
 */
abstract class Item_model extends POLAR_Model implements Item_model_interface {

	/**
	 * Count.
	 *
	 * @param Params|null $params Parameters.
	 *
	 * @return int
	 */
	public function count($params = NULL)
	{
		$this->build($params);

		return $this->db->count_all_results();
	}

	/**
	 * Build select, joins, and from.
	 *
	 * @param Params|null $params Parameters.
	 */
	abstract protected function build($params = NULL);

	/**
	 * Generate item.
	 *
	 * @param $item
	 *
	 * @return mixed
	 */
	abstract protected function generate($item);
}