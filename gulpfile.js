/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/*global require */
var gulp         = require('gulp');
var autoPrefixer = require('gulp-autoprefixer');
var browserify   = require('gulp-browserify');
var clean        = require('gulp-clean-dest');
var copy         = require('gulp-copy');
var cssComb      = require('gulp-csscomb');
var cssNano      = require('gulp-cssnano');
var merge        = require('gulp-merge');
var rename       = require('gulp-rename');
var sass         = require('gulp-sass');

var config = {
    contentPath: 'content/',
    nodeModulesPage: 'node_modules/',
    srcPath: 'src/'
};

gulp.task('content:angularAnimate', function () {
    'use strict';

    return gulp.src(['**/*.js', '**/*.map'], {
        cwd: config.nodeModulesPage + 'angular-animate/'
    }).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content:angularMessages', function () {
    'use strict';

    return gulp.src(['**/*.js', '**/*.map'], {
        cwd: config.nodeModulesPage + 'angular-messages/'
    }).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content:angular', ['content:angularAnimate', 'content:angularMessages'], function () {
    'use strict';

    return gulp.src(['**/*.js', '**/*.map'], {
        cwd: config.nodeModulesPage + 'angular/'
    }).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content:jquery', function () {
    'use strict';

    return gulp.src('**/**', {
        cwd: config.nodeModulesPage + 'jquery/dist/'
    }).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content:bootstrap', ['content:jquery'], function () {
    'use strict';

    return gulp.src('js/**', {
        cwd: config.nodeModulesPage + 'bootstrap/dist/'
    }).pipe(copy(config.contentPath));
});

gulp.task('content:trianglify', function () {
    'use strict';

    return gulp.src('**/**', {
        cwd: config.nodeModulesPage + 'trianglify/dist/'
    }).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content', ['content:angular', 'content:bootstrap', 'content:jquery', 'content:trianglify']);

gulp.task('scripts', ['content'], function () {
    'use strict';

    return gulp.src(config.srcPath + 'js/polar.js')
        .pipe(browserify())
        .pipe(gulp.dest(config.contentPath + 'js/'));
});

gulp.task('styles', function () {
    'use strict';

    return gulp.src(config.srcPath + 'scss/polar.scss')
        .pipe(cssComb())
        .pipe(sass())
        .pipe(autoPrefixer())
        .pipe(gulp.dest(config.contentPath + 'css/'))
        .pipe(cssNano())
        .pipe(rename({
            extname: '.min.css'
        }))
        .pipe(gulp.dest(config.contentPath + 'css/'));
});

gulp.task('build', ['scripts', 'styles']);

gulp.task('default', ['build']);