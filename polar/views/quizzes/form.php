<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Quiz view.
 *
 * @package Polar\Views
 */

defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="quiz" class="site-wrapper" ng-controller="quizForm">
	<div class="site-wrapper-inner">
		<div class="cover-container">

			<form name="createQuiz">
				<h1><?= $this->lang->line('create_quiz_heading') ?></h1>

				<!-- Quiz name -->
				<div class="form-group row">
					<label for="quizName" class="form-control-label">
						<?= $this->lang->line('quiz_name_label') ?>
					</label>
					<div class="col">
						<input type="text" class="form-control" name="quizName"
						       placeholder="<?= $this->lang->line('quiz_name_placeholder') ?>" ng-model="quiz.quizName"
						       ng-maxlength="255" required autofocus>
					</div>
				</div>

				<!-- Description -->
				<div class="form-group row">
					<label for="description" class="form-control-label">
						<?= $this->lang->line('description_label') ?>
					</label>
					<div class="col">
						<textarea class="form-control" name="description" rows="2"
						          placeholder="<?= $this->lang->line('description_placeholder') ?>"
						          ng-model="quiz.description"></textarea>
					</div>
				</div>

				<!-- Launch date & time -->
				<div class="form-group row">
					<label for="launch_timestamp" class="form-control-label">
						<?= $this->lang->line('launch_timestamp_label') ?>
					</label>
					<div class="col">
						<div class="row">
							<div class="col-sm-6">
								<input type="datetime" class="form-control" name="launchTimestamp"
								       placeholder="<?= $this->lang->line('launch_timestamp_placeholder') ?>" required>
							</div>
							<div class="col-sm-6">
								<div class="checkbox">
									<label class="c-input c-checkbox"><input type="checkbox" name="live"
									                                         ng-model="user.remember">
										<span
											class="c-indicator"></span> <?= $this->lang->line('live_checkbox_label') ?>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<hr/>

				<!-- Questions -->
				<div ng-repeat="(questionId, question) in quiz.questions" x>
					<h2>Question {{questionId + 1}}</h2>

					<!-- Question -->
					<div class="form-group row">
						<label for="question[]" class="form-control-label">
							<?= $this->lang->line('question_label') ?>
						</label>
						<div class="col">
							<input type="text" class="form-control" name="question[]"
							       placeholder="<?= $this->lang->line('question_placeholder') ?>"
							       ng-model="question.question" ng-maxlength="255" required>
						</div>
					</div>

					<!-- Media -->
					<!--<div class="form-group row">
						<label for="media[]" class="form-control-label">
							<?= $this->lang->line('media_label') ?>
						</label>
						<div class="col">
							<input type="file" class="form-control-file" ng-model="question.media">
						</div>
					</div>-->

					<!-- Answers -->
					<div class="form-group row">
						<label class="form-control-label">
							<?= $this->lang->line('answers_label') ?>
						</label>
						<div class="col">
							<div class="row">
								<div class="col-sm-9">
									<?= $this->lang->line('answer_label') ?>
								</div>
								<div class="col-sm-2">
									<?= $this->lang->line('score_label') ?>
								</div>
							</div>
							<div class="row" ng-repeat="(answerId, answer) in question.answers">
								<div class="col-sm-9">
									<input type="text" class="form-control" name="answer[][]"
									       placeholder="<?= $this->lang->line('answer_placeholder') ?>"
									       ng-model="answer.answer" ng-maxlength="255" required>
								</div>
								<div class="col-sm-2">
									<input type="number" step="10" class="form-control" name="score[][]"
									       placeholder="<?= $this->lang->line('score_placeholder') ?>"
									       ng-model="answer.score" required>
								</div>
								<div class="col-sm-1">
									<button type="button" class="btn btn-remove btn-block"
									        ng-click="removeAnswer(question, answerId)"
									        ng-show="question.answers.length > 2">
										<i class="icon icon-minus" aria-hidden="true"
										   title="<?= $this->lang->line('remove_answer_button') ?>"></i>
										<span class="sr-only">
											<?= $this->lang->line('remove_answer_button') ?>
										</span>
									</button>
								</div>
							</div>
							<p ng-hide="question.answers.length >= 4">
								<button type="button" class="btn btn-add btn-sm" ng-click="addAnswer(question)">
									<?= $this->lang->line('add_answer_button') ?>
								</button>
							</p>
						</div>
					</div>

					<div class="form-group row" ng-show="quiz.questions.length > 1">
						<div class="col col-offset">
							<p>
								<button type="button" class="btn btn-remove btn-sm"
								        ng-click="removeQuestion(questionId)">
									<?= $this->lang->line('remove_question_button') ?>
								</button>
							</p>
						</div>
					</div>

					<hr/>

				</div>

				<div class="form-group row">
					<div class="col col-offset">
						<p>
							<button type="button" class="btn btn-add btn-sm" ng-click="addQuestion()">
								<?= $this->lang->line('add_question_button') ?>
							</button>
						</p>
						<p>
							<button type="submit" class="btn btn-primary" ng-click="setQuiz()">
								<?= $this->lang->line('create_quiz_button') ?>
							</button>
						</p>
					</div>
				</div>

			</form>

		</div>
	</div>
</div>