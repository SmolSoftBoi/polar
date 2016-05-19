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
		$this->load->driver('cache', array(
			'adapter' => 'file'
		));
	}
}

/**
 * Core item model.
 *
 * @package Polar
 */
abstract class Item_model extends POLAR_Model implements Item_model_interface {

	/**
	 * @var int $level Level.
	 */
	public $level = 0;

	/**
	 * Count.
	 *
	 * @param Params|null $params Parameters.
	 *
	 * @return int
	 */
	public function count($params = NULL)
	{
		$cache_id = $cache_id = get_class($this) . '_count';

		if ( ! $count = $this->cache->get($cache_id) || is_null($params))
		{
			$this->build($params);

			$count = $this->db->count_all_results();

			if (is_null($params))
			{
				$this->cache->save($count, $cache_id);
			}
		}

		if (is_string($count))
		{
			$count = intval($count);
		}

		return $count;
	}

	/**
	 * Get items.
	 *
	 * @param int[] $ids IDs.
	 *
	 * @return Item[] Items.
	 */
	public function get_items($ids)
	{
		$items = array();

		$level = $this->level;

		foreach ($ids as $id)
		{
			$this->level = $level;

			$items[$id] = $this->get_item($id);
		}

		return $items;
	}

	/**
	 * Set items.
	 *
	 * @param Item[] $items Items.
	 *
	 * @return int[] IDs.
	 */
	public function set_items($items)
	{
		$ids = array();

		foreach ($items as $item)
		{
			$ids[] = $this->set_item($item);
		}

		return $ids;
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
	 * @param Item $item Item.
	 *
	 * @return Item Item.
	 */
	abstract protected function generate($item);

	/**
	 * Base search.
	 *
	 * @param string      $item_class       Item class.
	 * @param string      $item_id_property Item ID property.
	 * @param Params|null $params           Parameters.
	 * @param string      $build_method     Build method.
	 * @param string      $generate_method  Generate method.
	 *
	 * @return Item[] Items.
	 */
	protected function base_search($item_class, $item_id_property, $params = NULL, $build_method = 'build', $generate_method = 'generate')
	{
		$this->$build_method($params);

		$search_items = $this->db->get()->result($item_class);

		$items = array();

		$level = $this->level;

		foreach ($search_items as $item)
		{
			$this->level = $level;

			$item = $this->$generate_method($item);

			$items[$item->$item_id_property] = $item;
		}

		return $items;
	}

	/**
	 * Base get item.
	 *
	 * @param string $table           Table.
	 * @param string $id_field        ID field.
	 * @param string $item_class      Item class.
	 * @param int    $id              ID.
	 * @param string $build_method    Build method.
	 * @param string $generate_method Generate method.
	 *
	 * @return Item Item.
	 */
	protected function base_get_item($table, $id_field, $item_class, $id, $build_method = 'build', $generate_method = 'generate')
	{
		$cache_id = get_class($this) . $table . '_' . $id_field . '_' . $id;

		if ($item = $this->cache->get($cache_id))
		{
			$item = deserialize($item);
		}
		else
		{
			$this->$build_method();

			$item = $this->db->where($table . '.' . $id_field, $id)->get()->row(0, $item_class);

			$this->cache->save(serialize($item), $cache_id);
		}

		return $this->$generate_method($item);
	}

	/**
	 * Base set item.
	 *
	 * @param string $table            Table.
	 * @param string $id_field         ID field.
	 * @param string $item_id_property Item ID property.
	 * @param Item   $item             Item
	 *
	 * @return int ID.
	 */
	protected function base_set_item($table, $id_field, $item_id_property, $item)
	{
		$this->cache->delete(get_class($this) . '_count');
		$this->cache->delete(get_class($this) . $table . '_' . $id_field . '_' . $item->$item_id_property);

		$item->db_set();

		if ( ! isset($item->$item_id_property) || $item->$item_id_property === 0)
		{
			$this->db->insert($table);

			return $this->db->insert_id();
		}
		else
		{
			$this->db->where($id_field, $item->$item_id_property)->update($table);

			$field_data = $this->db->field_data($table);

			foreach ($field_data as $field_data)
			{
				if (boolval($field_data->primary_key))
				{
					$field_name = $field_data->name;

					return $item->$field_name;
				}
			}
		}
	}

	/**
	 * Base build.
	 *
	 * @param string $table Table.
	 */
	protected function base_build($table)
	{
		$this->db->select($table . '.*')->from($table);
	}

	/**
	 * Base generate.
	 *
	 * @param int    $level            Level.
	 * @param string $item_id_property Item ID property.
	 * @param Item   $item             Item.
	 * @param string $level_property   Response level property.
	 *
	 * @return Item Item.
	 */
	protected function base_generate($level, $item_id_property, $item, $level_property = 'level')
	{
		if ($this->$level_property === 0)
		{
			$this->$level_property = $level;
		}

		$this->$level_property--;

		$item->$item_id_property = intval($item->$item_id_property, 10);

		return $item;
	}

	/**
	 * Build parameter.
	 *
	 * @param Params $params         Parameters.
	 * @param string $param_property Parameter property.
	 * @param string $table          Table.
	 * @param string $field          Field.
	 */
	protected function build_param($params, $param_property, $table, $field)
	{
		if (isset($params->$param_property))
		{
			if ( ! empty($params->$param_property))
			{
				if (is_array($params->$param_property))
				{
					$this->db->where_in($table . '.' . $field, $params->$param_property);
				}
				else
				{
					$this->db->where($table . '.' . $field, $params->$param_property);
				}
			}
		}
	}
}