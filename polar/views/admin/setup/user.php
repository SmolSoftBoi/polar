<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * User setup admin view.
 *
 * @package Polar\Views
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="site-wrapper">
	<div class="site-wrapper-inner">

		<!-- User setup -->
		<?= form_open('admin/setup', array(
			'class' => 'form-setup',
			'name'  => 'setupUser'
		)) ?>
		<h1><?= $this->lang->line('setup_heading') ?></h1>
		<h2><?= $this->lang->line('admin_account_heading') ?></h2>

		<!-- First name -->
		<div class="form-group" ng-class="{
		         'has-success': setupUser.firstName.$dirty && setupUser.firstName.$valid,
		         'has-danger': setupUser.firstName.$dirty && setupUser.firstName.$invalid
		}">
			<label for="firstName"><?= $this->lang->line('first_name_label') ?></label>
			<input type="text" class="form-control" name="firstName"
			       placeholder="<?= $this->lang->line('first_name_placeholder') ?>" ng-model="user.firstName"
			       ng-maxlength="255" required autofocus>
			<div class="alert" ng-messages="setupUser.firstName.$error"
			     ng-show="setupUser.firstName.$dirty && setupUser.firstName.$invalid">
				<span ng-message="required"><?= $this->lang->line('first_name_required_message') ?></span>
				<span ng-message="maxlength"><?= $this->lang->line('first_name_maxlength_message') ?></span>
			</div>
		</div>

		<!-- last name -->
		<div class="form-group" ng-class="{
		         'has-success': setupUser.lastName.$dirty && setupUser.lastName.$valid,
		         'has-danger': setupUser.lastName.$dirty && setupUser.lastName.$invalid
		}">
			<label for="lastName"><?= $this->lang->line('last_name_label') ?></label>
			<input type="text" class="form-control" name="lastName"
			       placeholder="<?= $this->lang->line('last_name_placeholder') ?>" ng-model="user.lastName"
			       ng-maxlength="255" required>
			<div class="alert" ng-messages="setupUser.lastName.$error"
			     ng-show="setupUser.lastName.$dirty && setupUser.lastName.$invalid">
				<span ng-message="required"><?= $this->lang->line('last_name_required_message') ?></span>
				<span ng-message="maxlength"><?= $this->lang->line('last_name_maxlength_message') ?></span>
			</div>
		</div>

		<!-- Email -->
		<div class="form-group" ng-class="{
		         'has-success': setupUser.email.$dirty && setupUser.email.$valid,
		         'has-danger': setupUser.email.$dirty && setupUser.email.$invalid
		}">
			<label for="email"><?= $this->lang->line('email_label') ?></label>
			<input type="email" class="form-control" name="email"
			       placeholder="<?= $this->lang->line('email_placeholder') ?>" ng-model="user.email" ng-maxlength="255"
			       ng-unique="email" required>
			<div class="alert" ng-messages="setupUser.email.$error"
			     ng-show="setupUser.email.$dirty && setupUser.email.$invalid">
				<span ng-message="required"><?= $this->lang->line('email_required_message') ?></span>
				<span ng-message="email"><?= $this->lang->line('email_valid_message') ?></span>
				<span ng-message="unique"><?= $this->lang->line('email_unique_message') ?></span>
				<span ng-message="maxlength"><?= $this->lang->line('email_maxlength_message') ?></span>
			</div>
		</div>

		<!-- Password -->
		<div class="form-group" ng-class="{
		         'has-success': setupUser.password.$dirty && setupUser.password.$valid,
		         'has-danger': setupUser.password.$dirty && setupUser.password.$invalid
		}">
			<label for="password"><?= $this->lang->line('password_label') ?></label>
			<input type="password" class="form-control" name="password"
			       placeholder="<?= $this->lang->line('password_placeholder') ?>" ng-model="user.password" required>
			<div class="alert" ng-messages="setupUser.password.$error"
			     ng-show="setupUser.password.$dirty && setupUser.password.$invalid">
				<span ng-message="required"><?= $this->lang->line('password_required_message') ?></span>
			</div>
		</div>

		<!-- Confirm password -->
		<div class="form-group" ng-class="{
		         'has-success': setupUser.passwordConfirm.$dirty && setupUser.passwordConfirm.$valid,
		         'has-danger': setupUser.passwordConfirm.$dirty && setupUser.passwordConfirm.$invalid
		}">
			<label for="passwordConfirm"><?= $this->lang->line('confirm_password_label') ?></label>
			<input type="password" class="form-control" name="passwordConfirm"
			       placeholder="<?= $this->lang->line('confirm_password_placeholder') ?>" ng-class="{
			           'form-control-last': setupUser.passwordConfirm.$pristine || setupUser.passwordConfirm.$valid
			       }" ng-model="user.passwordConfirm" ng-match="setupUser.password" required>
			<div class="alert" ng-messages="setupUser.passwordConfirm.$error"
			     ng-show="setupUser.passwordConfirm.$dirty && setupUser.passwordConfirm.$invalid">
				<span ng-message="required"><?= $this->lang->line('confirm_password_required_message') ?></span>
				<span ng-message="match"><?= $this->lang->line('confirm_password_match_message') ?></span>
			</div>
		</div>

		<button type="submit" class="btn-primary" ng-disabled="setupUser.$invalid">
			<?= $this->lang->line('setup_admin_account_button') ?>
		</button>
		<?= form_close() ?>

	</div>
</div>