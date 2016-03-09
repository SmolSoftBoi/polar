<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Navbar admin asset.
 *
 * @package Polar\Views\Assets
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<ul class="nav nav-sidebar">

	<!-- Dashboard -->
	<li class="nav-item">
		<a class="nav-link <?php if (isset($nav)): if ($nav === 'dashboard'): ?>active<?php endif; endif; ?>" href="<?= site_url('admin') ?>">Dashboard</a>
	</li>

	<!-- Schools -->
	<li class="nav-item">
		<a class="nav-link <?php if (isset($nav)): if ($nav === 'schools'): ?>active<?php endif; endif; ?>" href="<?= site_url('admin/schools') ?>">Schools</a>
	</li>
</ul>