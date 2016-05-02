<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Media item.
 *
 * @package Polar\Domain\Items
 */
class Media_item extends Item {

	/**
	 * @var int $media_id Media ID.
	 */
	public $media_id;

	/**
	 * @var string $media_url Media URL.
	 */
	public $media_url;

	/**
	 * @var string $media_url_lg Media URL large.
	 */
	public $media_url_lg;

	/**
	 * @var string $media_url_md Media URL medium.
	 */
	public $media_url_md;

	/**
	 * @var string $media_url_sm Media URL small.
	 */
	public $media_url_sm;

	/**
	 * @var string $media_url_xs Media URL extra-small.
	 */
	public $media_url_xs;

	/**
	 * @var bool $image Image.
	 */
	public $image;

	/**
	 * Database set.
	 */
	public function db_set()
	{
		$this->db->set(array(
			'media_id'     => $this->media_id,
			'media_url'    => $this->media_url,
			'media_url_lg' => $this->media_url_lg,
			'media_url_md' => $this->media_url_md,
			'media_url_sm' => $this->media_url_sm,
			'media_url_xs' => $this->media_url_xs,
			'image'        => $this->image
		));
	}
}