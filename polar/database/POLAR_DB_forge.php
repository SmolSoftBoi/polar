<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Polar database forge.
 *
 * @package Polar
 */
class POLAR_DB_forge extends CI_DB_forge {

	/**
	 * @var array $foreign_keys Foreign keys.
	 */
	public $foreign_keys = array();

	/**
	 * Add foreign key.
	 *
	 * @param string $key
	 * @param string $reference_table
	 * @param string $reference_column
	 * @param string $on_update
	 * @param string $on_delete
	 *
	 * @return POLAR_DB_forge Polar database forge.
	 */
	public function add_foreign_key($key, $reference_table, $reference_column, $on_update = 'NO ACTION', $on_delete = 'NO ACTION')
	{
		$foreign_key = array(
			'key'              => $key,
			'reference_table'  => $reference_table,
			'reference_column' => $reference_column
		);

		if ( ! empty($on_update))
		{
			$on_update = 'NO ACTION';
		}

		if ( ! empty($on_delete))
		{
			$on_delete = 'NO ACTION';
		}

		$foreign_key['on_update'] = strtoupper($on_update);
		$foreign_key['on_delete'] = strtoupper($on_delete);

		$this->foreign_keys[] = $foreign_key;

		return $this;
	}

	/**
	 * Create table.
	 *
	 * @param    string $table         Table name.
	 * @param    bool   $if_not_exists Whether to add `IF NOT EXISTS` condition.
	 * @param    array  $attributes    Associative array of table attributes.
	 *
	 * @return    mixed
	 */
	protected function _create_table($table, $if_not_exists, $attributes)
	{
		if ($if_not_exists === TRUE && $this->_create_table_if === FALSE)
		{
			if ($this->db->table_exists($table))
			{
				return TRUE;
			}
			else
			{
				$if_not_exists = FALSE;
			}
		}

		$sql = ($if_not_exists) ? sprintf($this->_create_table_if, $this->db->escape_identifiers($table))
			: 'CREATE TABLE';

		$columns = $this->_process_fields(TRUE);
		for ($i = 0, $c = count($columns); $i < $c; $i++)
		{
			$columns[$i] = ($columns[$i]['_literal'] !== FALSE) ? PHP_EOL . $columns[$i]['_literal']
				: PHP_EOL . $this->_process_column($columns[$i]);
		}

		$columns = implode(',', $columns) . $this->_process_primary_keys($table) . $this->_process_foreign_keys($table);

		// Are indexes created from within the `CREATE TABLE` statement?
		if ($this->_create_table_keys === TRUE)
		{
			$columns .= $this->_process_indexes($table);
		}

		// `_create_table` will usually have the following format: %s %s (%s\n)
		$sql = sprintf($this->_create_table
		               . '%s', $sql, $this->db->escape_identifiers($table), $columns, $this->_create_table_attr($attributes));

		return $sql;
	}

	/**
	 * Process foreign keys.
	 *
	 * @param string $table Table name.
	 *
	 * @return string SQL.
	 */
	protected function _process_foreign_keys($table)
	{
		$sql = '';

		foreach ($this->foreign_keys as $foreign_key)
		{
			$sql .= ',' . PHP_EOL . "\t" . 'CONSTRAINT '
			        . $this->db->escape_identifiers('fk__' . $table . '__' . $foreign_key['reference_table'])
			        . ' FOREIGN KEY (' . $this->db->escape_identifiers($foreign_key['key']) . ') REFERENCES '
			        . $this->db->escape_identifiers($foreign_key['reference_table'])
			        . ' (' . $this->db->escape_identifiers($foreign_key['reference_column']) . ')';
		}

		return $sql;
	}

	/**
	 * Reset.
	 *
	 * Resets table creation variables.
	 */
	protected function _reset()
	{
		$this->fields = $this->keys = $this->primary_keys = $this->foreign_keys = array();
	}
}