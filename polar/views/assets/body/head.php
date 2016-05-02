<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Head body asset.
 *
 * @package Polar\Views\Assets
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<noscript>
	<div class="cover-no-script">
		<div class="site-wrapper">
			<div class="site-wrapper-inner">
				<div class="cover-container">

					<h1><?= $this->lang->line('javascript_required_heading') ?></h1>
					<p><?= $this->lang->line('javascript_required_message') ?></p>

				</div>
			</div>
		</div>
	</div>
</noscript>
<div class="cover-cloak ng-cloak">
	<div class="site-wrapper">
		<div class="site-wrapper-inner">
			<div class="cover-container">

				<progress class="progress progress-striped progress-animated" value="100" max="100"></progress>

			</div>
		</div>
	</div>
</div>