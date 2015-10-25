var gulp = require('gulp'),
        connect = require('gulp-connect'),
        gutil = require('gulp-util'),
        sass = require('gulp-sass');

/**
 * Info
 */
gulp.task('default', ['develop'], function () {
    gutil.log("\nAvailable tasks found in gulpfile");
});

/**
 * SASS compilation
 */
gulp.task('styles', function () {
    gulp.src('./scss/style.scss')
            .pipe(sass({
                includePaths: ['./js/lib/foundation/scss'],
                outputStyle: 'compressed'
            })
            .on('error', sass.logError))
            .pipe(gulp.dest('./'));
});

/**
 * SASS live compilation
 */
gulp.task('watch-styles', function () {
    gulp.watch('./scss/*.scss', ['styles']);
});

/**
 * Webserver
 */
gulp.task('webserver', function () {
    connect.server();
});

/**
 * Webserver with reload
 * https://www.npmjs.com/package/gulp-connect
 */
gulp.task('webserver-live', function () {
    connect.server({
        port: 10000
    });
});

/**
 * 
 */
gulp.task('develop', ['styles', 'webserver-live', 'watch-styles']);
