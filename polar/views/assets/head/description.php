<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Description head asset.
 *
 * @package Polar\Views\Assets
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?><?php if (isset($description)): ?>
	<meta name="description" content="<?= $description ?>">
<?php endif; ?>