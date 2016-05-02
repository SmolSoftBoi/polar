<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Title head asset.
 *
 * @package Polar\Views\Assets
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<title><?= $this->lang->line('brand') ?><?php if (isset($title)): ?> - <?= $title ?><?php endif; ?></title>