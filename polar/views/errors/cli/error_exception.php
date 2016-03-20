<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Exception command line interface error.
 *
 * @package Polar\Views\Errors\CLI
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>

An uncaught Exception was encountered:

Type:        <?= get_class($exception) ?>
Message:     <?= $message ?>
Filename:    <?= $exception->getFile() ?>
Line Number: <?= $exception->getLine() ?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
	Backtrace:

	<?php foreach ($exception->getTrace() as $error):
		if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
			File:     <?= $error['file'] ?>
			Line:     <?= $error['line'] ?>
			Function: <?= $error['function'] ?>

		<?php endif; endforeach; ?>

<?php endif; ?>
