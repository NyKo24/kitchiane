'use strict';
 
var gulp = require('gulp');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minify = require('gulp-minify-css');

var paths = {
	sass: ['./chat/scss/*.scss']
};


gulp.task('sass', function() {
    gulp.src(paths.scss)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./web/'))
        .pipe(gulp.dest('./chat/'))
});


gulp.task('minify', function () {
    gulp.src('./web/*.css')
        .pipe(minify({keepBreaks: true}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./web/'))
    ;
});


gulp.task('watch', function() {
  gulp.watch(paths.sass, ['sass']);
});