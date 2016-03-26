<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * 404 not found error.
 *
 * @package Polar\Views\Errors\HTML
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container error">

			<h1><?= $heading ?></h1>
			<p><?= $message ?></p>

		</div>
	</div>
</div>