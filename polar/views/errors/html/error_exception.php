<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Exception error.
 *
 * @package Polar\Views\Errors\HTML
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card card-inverse card-danger" xmlns="http://www.w3.org/1999/html">
	<h1 class="card-header">An uncaught Exception was encountered</h1>
	<div class="card-block">
		<dl class="dl-horizontal">

			<!-- Type -->
			<dt>Type:</dt>
			<dd><?= get_class($exception) ?></dd>

			<!-- Message -->
			<dt>Message:</dt>
			<dd><?= $message ?></dd>

			<!-- Filename -->
			<dt>Filename:</dt>
			<dd><?= $exception->getFile() ?></dd>

			<!-- Line number -->
			<dt>Line Number:</dt>
			<dd><?= $exception->getLine() ?></dd>

			<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
				<!-- Backtrace -->
				<dt>Backtrace:</dt>
				<dd>
					<?php foreach ($exception->getTrace() as $error):
						?><?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
						<dl class="dl-horizontal">

							<!-- Type -->
							<dt>Type:</dt>
							<dd><?= $error['file'] ?></dd>

							<!-- Line -->
							<dt>Line:</dt>
							<dd><?= $error['line'] ?></dd>

							<!-- Function -->
							<dt>Function:</dt>
							<dd><?= $error['function'] ?></dd>

						</dl>
					<?php endif; ?><?php endforeach; ?>
				</dd>
			<?php endif; ?>

		</dl>
	</div>
</div>