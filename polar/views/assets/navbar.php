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
<nav class="navbar-main ng-cloak">

	<?php if (isset($_SESSION['authed'])): if ($_SESSION['authed']): ?><?php if (in_array('teacher', $_SESSION['roles'])): ?>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">&#9776;</button>
	<?php endif; ?><?php endif; endif; ?>

	<!-- Brand -->
	<a class="navbar-brand" href="<?= site_url() ?>">
		<?= $this->lang->line('brand') ?><?php if (ENVIRONMENT !== 'production'): ?>
			<span class="label label-primary"><?= $this->lang->line(ENVIRONMENT . '_environment') ?></span>
		<?php endif; ?>
	</a>

	<!-- User -->
	<ul class="nav navbar-nav pull-xs-right">
		<?php if (isset($_SESSION['authed'])): if ($_SESSION['authed']): ?>

			<!-- User -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
				   aria-expanded="false">
					<span class="first-name">{{user.firstName}}</span>
					<span class="last-name">{{user.lastName}}</span>
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

		<?php endif; endif; ?>
	</ul>

</nav>
<div class="collapse collapse-navbar" id="navbar">
	<nav class="nav nav-inline">
		<a class="nav-link active" href="<?= site_url('quizzes/create') ?>">
			<?= $this->lang->line('create_quiz_button') ?>
		</a>
	</nav>
</div>