<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Keywords head asset.
 *
 * @package Polar\Views\Assets
 */

defined('BASEPATH')
OR exit('No direct script access allowed'); ?><?php if (isset($keywords)): ?><?php if (is_array($keywords)): ?>
	<meta name="keywords" content="<?= implode(', ', $keywords) ?>">
<?php else: ?>
	<meta name="keywords" content="<?= $keywords ?>">
<?php endif; ?><?php endif; ?>