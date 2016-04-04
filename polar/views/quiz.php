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
				<a href="#" class="btn btn-start" role="button" ng-click="start()">
					<?= $this->lang->line('start_quiz_button') ?>
				</a>
			</div>

			<!-- Questions -->
			<div class="question ng-hide" ng-repeat="question in quiz.questions"
			     ng-show="question.questionId === questionId" ng-cloak>
				<h2>{{question.question}}</h2>
				<div class="answers">
					<div class="answer answer-{{question.answersCount}}" ng-class="{
						'correct': answer.correct === true,
						'incorrect': answer.correct === false
					}" ng-repeat="answer in question.answers">
						<a href="#" class="btn" role="button" ng-click="answerQuestion($event, answer)">
							{{answer.answer}}
						</a>
					</div>
				</div>
				<a href="#" class="btn btn-next ng-hide" role="button" ng-click="nextQuestion(question.questionId)"
				   ng-show="question.answered === true">
					<?= $this->lang->line('next_question_button') ?>
				</a>
			</div>

			<!-- Results -->
			<div class="score ng-hide" ng-show="questionId === -1" ng-cloak>
				<h2>{{score}}</h2>
			</div>

		</div>
	</div>
</div>