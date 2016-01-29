/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Include required node packages
var gulp = require('gulp'),
    browser = require('browser-sync'),
    connect = require('gulp-connect'),
    jshint = require('gulp-jshint'),
    notify = require('gulp-notify'),
    PORT = 8888;

// Sophisticated server/browser. Start a server with LiveReload to preview the site in
gulp.task('server', ['jshint'], function () {
    browser.init({
        server: './', port: PORT
    });
});

//Simple webserver
gulp.task('webserver', ['jshint'], function () {
    connect.server({
        port: PORT
    });
});

var jsHintFail = function () {
    console.log(arguments);
    notify({
        title: 'JSHint',
        message: 'Failed'
    });
};

//Validate JS
gulp.task('jshint', function () {
    return gulp.src(['./lis/src/**/*.js'])
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(jshint.reporter('fail'))
        .on('fail', jsHintFail);
});

// Validate JS syntax and run the server
gulp.task('default', ['server'], function () {
    gulp.watch(['./lis/src/**/*.js'], ['jshint']);
});
