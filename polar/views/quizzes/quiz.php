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
<div id="quiz" class="site-wrapper" ng-controller="quiz">
	<div class="site-wrapper-inner">
		<div class="cover-container quiz">

			<progress class="progress-load" value="100" max="100" ng-hide="quiz">
				<?= $this->lang->line('quiz_progress') ?>
			</progress>

			<!-- Quiz -->
			<div class="quiz ng-hide" ng-show="quiz && questionId === 0" ng-cloak>
				<h1>{{quiz.quizName}}</h1>
				<p>{{quiz.description}}</p>
				<div class="connections">
					<div class="connection" ng-repeat="connection in connections">
						{{connection.user.initials}}
					</div>
				</div>
				<p>
					<a href="#" class="btn btn-start" role="button" ng-click="start()"
					   ng-show="quiz.live === false || role === 'teacher'">
						<?= $this->lang->line('start_quiz_button') ?>
					</a>
				</p>
			</div>

			<!-- Questions -->
			<div class="question ng-hide" ng-repeat="question in quiz.questions"
			     ng-show="question.questionId === questionId" ng-cloak>
				<h2>{{question.question}}</h2>
				<highcharts-column class="chart" categories="{{question.categories}}" series="{{question.series}}"
				                   ng-show="role === 'teacher'">
					<progress class="progress-load" value="100" max="100">
						<?= $this->lang->line('question_chart_progress') ?>
					</progress>
				</highcharts-column>
				<div class="answers" ng-show="role === 'student'">
					<div class="answer answer-{{question.answersCount}}" ng-class="{
						'correct': answer.correct === true,
						'incorrect': answer.correct === false
					}" ng-repeat="answer in question.answers">
						<a href="#" class="btn" role="button" ng-click="answerQuestion($event, answer)">
							{{answer.answer}}
						</a>
					</div>
				</div>
				<p>
					<a href="#" class="btn btn-show" role="button" ng-click="showCorrectAnswer(question)"
					   ng-show="role === 'teacher'">
						<?= $this->lang->line('show_correct_answer_button') ?>
					</a>
					<a href="#" class="btn btn-next" role="button" ng-click="nextQuestion(question.questionId)"
					   ng-show="question.questionId !== lastQuestionId
					   && ((quiz.live === false && question.answered === true)
				       || (role === 'teacher'))">
						<?= $this->lang->line('next_question_button') ?>
					</a>
					<a href="#" class="btn btn-next" role="button" ng-click="nextQuestion(question.questionId)"
					   ng-show="question.questionId === lastQuestionId
					   && (question.answered === true || role === 'teacher')">
						<?= $this->lang->line('show_results_button') ?>
					</a>
				</p>
			</div>

			<!-- Results -->
			<div class="score ng-hide" ng-show="questionId === -1" ng-cloak>
				<h2 ng-show="role === 'student'">{{score}}</h2>
				<div ng-repeat="question in quiz.questions">
					<h3>{{question.question}}</h3>
					<p ng-repeat="answer in question.answers" ng-class="{
					       'correct': answer.correct || answer.score > 0
					   }" ng-show="answer.correct || answer.score > 0">{{answer.answer}}</p>
				</div>
			</div>

		</div>
	</div>
</div>