var gulp         = require('gulp'),
    autoPrefixer = require('gulp-autoprefixer'),
    browserify   = require('gulp-browserify'),
    clean        = require('gulp-clean-dest'),
    copy         = require('gulp-copy'),
    combCSS      = require('gulp-csscomb'),
    cssnano      = require('gulp-cssnano'),
    merge        = require('gulp-merge'),
    rename       = require('gulp-rename'),
    sass         = require('gulp-sass');

var config = {
	contentPath: 'content/'
};

gulp.task('content:angularAnimate', function () {
	return gulp.src(['**/*.js', '**/*.map'], {
		cwd: 'node_modules/angular-animate/'
	}).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content:angularMessages', function () {
	return gulp.src(['**/*.js', '**/*.map'], {
		cwd: 'node_modules/angular-messages/'
	}).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content:angular', ['content:angularAnimate', 'content:angularMessages'], function () {
	return gulp.src(['**/*.js', '**/*.map'], {
		cwd: 'node_modules/angular/'
	}).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content:jquery', function () {
	return gulp.src('**/**', {
		cwd: 'node_modules/jquery/dist/'
	}).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content:bootstrap', ['content:jquery'], function () {
	return gulp.src('js/**', {
		cwd: 'node_modules/bootstrap/dist/'
	}).pipe(copy(config.contentPath));
});

gulp.task('content:trianglify', function () {
	return gulp.src('**/**', {
		cwd: 'node_modules/trianglify/dist/'
	}).pipe(copy(config.contentPath + 'js/'));
});

gulp.task('content', ['content:angular', 'content:bootstrap', 'content:jquery', 'content:trianglify']);

gulp.task('scripts', ['content'], function () {
	return gulp.src('src/js/polar.js')
		.pipe(browserify())
		.pipe(gulp.dest(config.contentPath + 'js/'));
});

gulp.task('styles', function () {
	return gulp.src('src/scss/polar.scss')
		.pipe(combCSS())
		.pipe(sass())
		.pipe(autoPrefixer())
		.pipe(gulp.dest(config.contentPath + 'css/'))
		.pipe(cssnano())
		.pipe(rename({
			extname: '.min.css'
		}))
		.pipe(gulp.dest(config.contentPath + 'css/'));
});

gulp.task('build', ['scripts', 'styles']);

gulp.task('default', ['build']);