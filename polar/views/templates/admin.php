<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Admin template.
 *
 * @package Polar\Views\Templates
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en" ng-app="polar">

<head>
	<?php $this->template->asset('head') ?>
</head>

<body trianglify="{
	seed: 'polar',
	variance: 1,
	x_colors: ['<?= $brand_color ?>', '<?= $brand_color ?>'],
	y_colors: ['#fff', '<?= $brand_color ?>']
}">
<?php $this->template->asset('body/head') ?>

<?php $this->template->asset('navbar') ?>
<div class="container-fluid">
	<div class="admin">
		<div class="sidebar">
			<div class="sidebar-wrapper">
				<?php $this->template->asset('admin/navbar') ?>
			</div>
		</div>
		<div class="content">

			<?php if (isset($body)): ?><?= $body ?><?php endif; ?>

		</div>
	</div>
</div>

<?php $this->template->asset('body/foot') ?>
</body>

</html>