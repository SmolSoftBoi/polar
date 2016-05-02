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

gulp.task('scripts', function () {
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