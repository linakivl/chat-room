const gulp = require('gulp'),
    sass = require('gulp-sass'),
    prefixer = require('gulp-autoprefixer'),
    path = require('path'),
    browserSync = require('browser-sync').create(),
    babel = require('gulp-babel'),
    uglify = require('gulp-uglify'),
    plumber = require('gulp-plumber'),
    minify = require("gulp-babel-minify");
cleanCSS = require('gulp-clean-css');

gulp.task('styles', function() {
    gulp.src('source/scss/login.scss')
        .pipe(sass({
            indentedSyntax: false,
            outputStyle: 'expanded',
            indentType: 'tab',
            indentWidth: 1
        }).on('error', sass.logError))
        .pipe(prefixer())
        .pipe(cleanCSS({
            compatibility: 'ie8',
            inline: ['none']
        }))
        .pipe(gulp.dest('../public/css'))
        .pipe(browserSync.stream());
});

gulp.task('browserSync', function(){

    // find project name
    var dir = path.resolve(__dirname, '..'),
        n = dir.lastIndexOf('\\'),
        project_name = dir.substring(n + 1) + '/';

    // browserSync.init({
    //     proxy: "http://localhost/lina-livechat",
    //     files: [
    //         "../**/*.php",
    //     ]
    // });

});

//Watch task
gulp.task('default', ['styles', 'browserSync'], function() {
    gulp.watch('source/scss/**/*.scss', { interval: 500 }, ['styles']);
    gulp.watch('source/',  { interval: 500 }, ['browserSync']);
});
