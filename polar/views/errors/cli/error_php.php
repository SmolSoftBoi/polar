<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * PHP command line interface error.
 *
 * @package Polar\Views\Errors\CLI
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>

A PHP Error was encountered:

	Severity:    <?= $severity ?>
	Message:     <?= $message ?>
	Filename:    <?= $filepath ?>
	Line Number: <?= $line ?>

	<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
		Backtrace:

		<?php foreach (debug_backtrace() as $error): if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
			File:     <?= $error['file'] ?>
			Line:     <?= $error['line'] ?>
			Function: <?= $error['function'] ?>

		<?php endif; endforeach; ?>

	<?php endif; ?>
