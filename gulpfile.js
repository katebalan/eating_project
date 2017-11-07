'use strict';

/**
 * Initialization
 * @type {Gulp|*|exports|module.exports}
 */
// var gulp = require('gulp'),
//     plugins = require('gulp-load-plugins')(),
//     mains = require('main-bower-files'),
//     kss = require('kss'),
//     auto_prefixer = require('autoprefixer'),
//     argv = require('yargs').argv,
//     browserify = require('browserify'),
//     vinyl_source = require('vinyl-source-stream'),
//     vinyl_buffer = require('vinyl-buffer'),
//     rename = require('gulp-rename'),
//     rev = require('gulp-rev'),
//     del = require('del');

var gulp = require('gulp');
// Requires the gulp-sass plugin
var sass = require('gulp-sass');


gulp.task('hello', function() {
    console.log('Hello Zelhviuvoirjvoijl');
});

gulp.task('sass', function(){
    return gulp.src('src/EatingBundle/Resources/public/style.scss')
        .pipe(sass()) // Using gulp-sass
        .pipe(gulp.dest('web/css'))
});

gulp.task('watch', function(){
    gulp.watch('src/EatingBundle/Resources/public/style.scss', ['sass']);
    // Other watchers
});
// var paths = {
//     scripts: ['client/js/**/*.coffee', '!client/external/**/*.coffee'],
//     images: 'client/img/**/*'
// };
//
// // Not all tasks need to use streams
// // A gulpfile is just another node program and you can use any package available on npm
// gulp.task('clean', function() {
//     // You can use multiple globbing patterns as you would with `gulp.src`
//     return del(['build']);
// });
//
// gulp.task('scripts', ['clean'], function() {
//     // Minify and copy all JavaScript (except vendor scripts)
//     // with sourcemaps all the way down
//     return gulp.src(paths.scripts)
//         .pipe(sourcemaps.init())
//         .pipe(coffee())
//         .pipe(uglify())
//         .pipe(concat('all.min.js'))
//         .pipe(sourcemaps.write())
//         .pipe(gulp.dest('build/js'));
// });
//
// // Copy all static images
// gulp.task('images', ['clean'], function() {
//     return gulp.src(paths.images)
//     // Pass in options to the task
//         .pipe(imagemin({optimizationLevel: 5}))
//         .pipe(gulp.dest('build/img'));
// });
//
// // Rerun the task when a file changes
// gulp.task('watch', function() {
//     gulp.watch(paths.scripts, ['scripts']);
//     gulp.watch(paths.images, ['images']);
// });
//
// // The default task (called when you run `gulp` from cli)
// gulp.task('default', ['watch', 'scripts', 'images']);
