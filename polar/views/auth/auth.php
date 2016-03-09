<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Authentication view.
 *
 * @package Polar\Views
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Authentication controller -->
<div class="site-wrapper" ng-controller="auth">
	<div class="site-wrapper-inner">

		<div class="row">

			<!-- Sign in -->
			<?= form_open('sign/in', array(
				'class' => 'form-auth',
				'name'  => 'authSignIn'
			)) ?>
			<h1><?= $this->lang->line('sign_in_heading') ?></h1>

			<!-- Email -->
			<div class="form-group" name="email" ng-class="{
			         'has-success': authSignIn.email.$dirty && authSignIn.email.$valid,
		             'has-danger': authSignIn.email.$dirty && authSignIn.email.$invalid
			}">
				<label for="email"><?= $this->lang->line('email_label') ?></label>
				<input type="email" class="form-control" name="email"
				       placeholder="<?= $this->lang->line('email_placeholder') ?>" ng-model="user.emails[0].email"
				       ng-maxlength="46" required autofocus>
				<div class="alert" ng-messages="authSignIn.email.$error" ng-show="authSignIn.email.$dirty && authSignIn
				     .email.$invalid">
					<span ng-message="required"><?= $this->lang->line('email_required_message') ?></span>
					<span ng-message="email"><?= $this->lang->line('email_valid_message') ?></span>
					<span ng-message="maxlength"><?= $this->lang->line('email_maxlength_message') ?></span>
				</div>
			</div>

			<!-- Password -->
			<div class="form-group form-group-last" ng-class="{
			         'has-success': authSignIn.password.$dirty && authSignIn.password.$valid,
		             'has-danger': authSignIn.password.$dirty && authSignIn.password.$invalid
			}">
				<label for="password"><?= $this->lang->line('password_label') ?></label>
				<input type="password" name="password" class="form-control" ng-class="{
			               'form-control-last': authSignIn.password.$pristine || authSignIn.password
			               .$valid
			           }" ng-model="user.password" placeholder="<?= $this->lang->line('password_placeholder') ?>"
				       ng-model="user.password" required>
				<div class="alert" ng-messages="authSignIn.password.$error" ng-show="authSignIn.password.$dirty && authSignIn
				     .password.$invalid">
					<span ng-message="required"><?= $this->lang->line('password_required_message') ?></span>
				</div>
			</div>

			<!-- Remember -->
			<div class="checkbox">
				<label class="c-input c-checkbox"><input type="checkbox" name="remember" ng-model="user.remember"><span
						class="c-indicator"></span> <?= $this->lang->line('remember_me_checkbox_label') ?>
				</label>
			</div>

			<button type="submit" class="btn-primary"
			        ng-disabled="authSignIn.$invalid"><?= $this->lang->line('sign_in_button') ?></button>
			<?= form_close() ?>

			<!-- Sign up -->
			<?= form_open('sign/up', array(
				'class' => 'form-auth',
				'name'  => 'authSignUp
				'
			)) ?>
			<h1><?= $this->lang->line('sign_up_heading') ?></h1>

			<!-- First name -->
			<div class="form-group" ng-class="{
		             'has-success': authSignUp.firstName.$dirty && authSignUp.firstName.$valid,
		             'has-danger': authSignUp.firstName.$dirty && authSignUp.firstName.$invalid
			}">
				<label for="firstName"><?= $this->lang->line('first_name_label') ?></label>
				<input type="text" class="form-control" name="firstName"
				       placeholder="<?= $this->lang->line('first_name_placeholder') ?>" ng-model="user.firstName"
				       ng-maxlength="10" required autofocus>
				<div class="alert" ng-messages="authSignUp.firstName.$error"
				     ng-show="authSignUp.firstName.$dirty && authSignUp.firstName.$invalid">
					<span ng-message="required"><?= $this->lang->line('first_name_required_message') ?></span>
					<span ng-message="maxlength"><?= $this->lang->line('first_name_maxlength_message') ?></span>
				</div>
			</div>

			<!-- Last name -->
			<div class="form-group" ng-class="{
		             'has-success': authSignUp.lastName.$dirty && authSignUp.lastName.$valid,
		             'has-danger': authSignUp.lastName.$dirty && authSignUp.lastName.$invalid
			}">
				<label for="lastName"><?= $this->lang->line('last_name_label') ?></label>
				<input type="text" class="form-control" name="lastName"
				       placeholder="<?= $this->lang->line('last_name_placeholder') ?>" ng-model="user.lastName"
				       ng-maxlength="10" required>
				<div class="alert" ng-messages="authSignUp.lastName.$error"
				     ng-show="authSignUp.lastName.$dirty && authSignUp.lastName.$invalid">
					<span ng-message="required"><?= $this->lang->line('last_name_required_message') ?></span>
					<span ng-message="maxlength"><?= $this->lang->line('last_name_maxlength_message') ?></span>
				</div>
			</div>

			<!-- Email -->
			<div class="form-group" ng-class="{
			         'has-success': authSignUp.email.$dirty && authSignUp.email.$valid,
		             'has-danger': authSignUp.email.$dirty && authSignUp.email.$invalid
			}">
				<label for="email"><?= $this->lang->line('email_label') ?></label>
				<input type="email" class="form-control" name="email"
				       placeholder="<?= $this->lang->line('email_placeholder') ?>" ng-model="user.emails[0].email"
				       ng-maxlength="46" ng-unique="email" required>
				<div class="alert" ng-messages="authSignUp.email.$error"
				     ng-show="authSignUp.email.$dirty && authSignUp.email.$invalid">
					<span ng-message="required"><?= $this->lang->line('email_required_message') ?></span>
					<span ng-message="email"><?= $this->lang->line('email_valid_message') ?></span>
					<span ng-message="unique"><?= $this->lang->line('email_unique_message') ?></span>
					<span ng-message="maxlength"><?= $this->lang->line('email_maxlength_message') ?></span>
				</div>
			</div>

			<!-- Password -->
			<div class="form-group" ng-class="{
			         'has-success': authSignUp.password.$dirty && authSignUp.password.$valid,
		             'has-danger': authSignUp.password.$dirty && authSignUp.password.$invalid
			}">
				<label for="password"><?= $this->lang->line('password_label') ?></label>
				<input type="password" class="form-control" name="password"
				       placeholder="<?= $this->lang->line('password_placeholder') ?>" ng-model="user.password" required>
				<div class="alert" ng-messages="authSignUp.password.$error" ng-show="authSignUp.password.$dirty && authSignUp.password
				     .$invalid">
					<span ng-message="required"><?= $this->lang->line('password_required_message') ?></span>
				</div>
			</div>

			<!-- Confirm password -->
			<div class="form-group" ng-class="{
			         'has-success': authSignUp.passwordConfirm.$dirty && authSignUp.passwordConfirm.$valid,
		             'has-danger': authSignUp.passwordConfirm.$dirty && authSignUp.passwordConfirm.$invalid
			}">
				<label for="passwordConfirm"><?= $this->lang->line('confirm_password_label') ?></label>
				<input type="password" class="form-control" name="passwordConfirm"
				       placeholder="<?= $this->lang->line('confirm_password_placeholder') ?>" ng-class="{
			               'form-control-last': authSignUp.passwordConfirm.$pristine || authSignUp.passwordConfirm.$valid
			           }" ng-model="user.passwordConfirm" ng-match="authSignUp.password" required>
			</div>

			<button type="submit" class="btn-primary"
			        ng-disabled="authSignUp.$invalid"><?= $this->lang->line('sign_up_button') ?></button>
			<?= form_close() ?>

		</div>

	</div>
</div>