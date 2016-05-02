<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Schools admin view.
 *
 * @package Polar\Views
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Schools admin controller -->
<div ng-controller="adminSchools">

	<h1 class="page-header"><?= $this->lang->line('schools_heading') ?></h1>
	<div class="btn-toolbar" role="toolbar">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#schoolModal"
		        ng-click="add($event)"><?= $this->lang->line('add_school_button') ?></button>
	</div>
	<div class="card card-faded">
		<div class="table-responsive">
			<table class="table table-hover table-sm">
				<thead>
				<tr>
					<th>#</th>
					<th><?= $this->lang->line('school_name_heading') ?></th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="school in schools">
					<th>{{school.schoolId}}</th>
					<td>{{school.schoolName}}</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- School modal -->
	<div class="modal modal-admin fade" id="schoolModal" tabindex="-1" role="dialog" aria-labelledby="schoolModalLabel"
	     aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="schoolModalLabel">{{modal.title}}</h4>
				</div>
				<div class="modal-body">
					<form name="adminSchool">

						<!-- School name -->
						<label for="schoolName"><?= $this->lang->line('school_name_label') ?></label>
						<input type="text" class="form-control" name="schoolName"
						       placeholder="<?= $this->lang->line('school_name_placeholder') ?>"
						       ng-model="school.schoolName" ng-maxlength="255" ng-unique="schoolName" required>

						<!-- Domain -->
						<label for="domain"><?= $this->lang->line('domain_label') ?></label>
						<input type="text" class="form-control" name="domain"
						       placeholder="<?= $this->lang->line('domain_placeholder') ?>"
						       ng-model="school.domains[0].domain" ng-maxlength="255" ng-unique="domain" required
						       ng-domain>

					</form>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" ng-disabled="adminSchool.$invalid" ng-click="save()">
						<?= $this->lang->line('save_button') ?>
					</button>
				</div>
			</div>
		</div>
	</div>

</div>