<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Welcome message view.
 *
 * @package Polar\Views
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="site-wrapper" ng-controller="welcome">
	<div class="site-wrapper-inner">
		<div class="cover-container">

			<div class="row-quiz-code">
				<div class="col-quiz-code">
					<form name="quizCode">
						<div class="input-group">
							<input type="text" name="code"
							       placeholder="<?= $this->lang->line('quiz_code_placeholder') ?>" required
							       ng-model="quiz.code" ng-minlength="4" ng-maxlength="4" ng-integer ng-quiz-code>
							<span class="input-group-btn">
								<button type="submit" ng-disabled="quizCode.$invalid" ng-click="go()">
									<?= $this->lang->line('go_button') ?>
								</button>
							</span>
						</div>
					</form>
				</div>
			</div>

			<progress class="progress progress-striped progress-animated" value="100" max="100" ng-hide="quizzes">
				<?= $this->lang->line('quizzes_progress') ?>
			</progress>

			<div class="row-quizzes">
				<div class="card-columns" ng-show="quizzes" ng-cloak>
					<div class="card card-quiz" ng-repeat="quiz in quizzes">
						<h1 class="card-header">{{quiz.quizName}}</h1>
						<div class="card-block">
							<p class="card-text">{{quiz.description}}</p>
							<a href="#" ng-href="<?= site_url('quizzes') ?>/{{quiz.quizSlug}}" class="btn"
							   role="button">Start Quiz</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>