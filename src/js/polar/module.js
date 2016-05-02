/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/*global angular */
angular.module('polar', ['ngAnimate', 'ngMessages']);

/*global require */
require('./run.js');
require('./controllers/admin/schools.js');
require('./controllers/auth.js');
require('./controllers/quiz.js');
require('./controllers/quizForm.js');
require('./controllers/welcome.js');
require('./directives/domain.js');
require('./directives/highchartsColumn.js');
require('./directives/integer.js');
require('./directives/match.js');
require('./directives/quizCode.js');
require('./directives/unique.js');
require('./directives/trianglify.js');
require('./factories/connectionModel.js');
require('./factories/questionModel.js');
require('./factories/quizModel.js');
require('./factories/schoolModel.js');
require('./factories/url.js');
require('./values/answerItem.js');
require('./values/answerParams.js');
require('./values/domainItem.js');
require('./values/domainParams.js');
require('./values/connectionItem.js');
require('./values/connectionParams.js');
require('./values/emailItem.js');
require('./values/emailParams.js');
require('./values/mediaItem.js');
require('./values/questionItem.js');
require('./values/questionParams.js');
require('./values/questionResponseItem.js');
require('./values/questionResponseParams.js');
require('./values/questionTypeItem.js');
require('./values/quizItem.js');
require('./values/quizParams.js');
require('./values/roleParams.js');
require('./values/schoolItem.js');
require('./values/schoolParams.js');
require('./values/userItem.js');
require('./values/userParams.js');