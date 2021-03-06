'use strict';

// !! IMPORTANT
// find node_modules/ -name '*.info' -type f -delete

// including plugins
var gulp = require('gulp'),
    concat = require("gulp-concat"),
    minifyCss = require("gulp-minify-css"),
    uglify = require("gulp-uglify"),
    watch = require('gulp-watch'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer');

//  sourcemaps = require('gulp-sourcemaps')


// task
/*gulp.task('js', function () {
 gulp.src(getPaths('forAll', 'js')) // path to your files
 .pipe(concat('forAll.min.js'))
 .pipe(uglify())
 .pipe(gulp.dest(bu + 'build/js'));
 });*/

gulp.task('watch', function () {
    gulp.watch('../../**/*.scss', ['scss']);
});

// Путь от этого файла к публичной дирктории
var customCss = '../../public/css/style.scss'; // Base url

gulp.task('scss', function () {
    return gulp.src([customCss])
        .pipe(sass().on('error', sass.logError))
        // .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(minifyCss())
        .pipe(gulp.dest('../../public/css'));
});

// task
gulp.task('css', function () {
    gulp.src(getPaths('forAll', 'css')) // path to your file
        .pipe(concat('forAll.min.css'))
        // .pipe(minifyCss())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(bu + 'build/css'));
});

//      bu + 'js/*.js',
//      bu + 'js/*/*.js',

gulp.task('default', ['watch']);