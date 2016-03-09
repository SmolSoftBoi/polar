<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Navigation bar asset.
 *
 * @package Polar\Views\Assets
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav class="navbar navbar-main main navbar-fixed-top navbar-light bg-faded">

	<!-- Brand -->
	<a class="navbar-brand" href="<?= site_url() ?>">
		<?= $this->lang->line('brand') ?><?php if (ENVIRONMENT !== 'production'): ?>
			<span class="label label-primary"><?= $this->lang->line(ENVIRONMENT . '_environment') ?></span>
		<?php endif; ?>
	</a>

	<!-- User -->
	<ul class="nav navbar-nav pull-xs-right">
		<?php if (isset($_SESSION['authed'])) if ($_SESSION['authed']): ?>

			<!-- User -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
				   aria-expanded="false">
					<span class="first-name"><?= $_SESSION['first_name'] ?></span>
					<span class="last-name"><?= $_SESSION['last_name'] ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right">

					<!-- Account -->
					<a class="dropdown-item" href="<?= site_url('account') ?>">
						<?= $this->lang->line('account_button') ?>
					</a>

					<div class="dropdown-divider"></div>

					<!-- Sign out -->
					<a class="dropdown-item" href="<?= site_url('auth/signout') ?>">
						<?= $this->lang->line('sign_out_button') ?>
					</a>

				</div>
			</li>

		<?php endif ?>
	</ul>

</nav>