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
var sass = require('gulp-sass'),
    watch = require('gulp-watch'),
    prefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    sourcemaps = require('gulp-sourcemaps'),
    rigger = require('gulp-rigger'),
    cssmin = require('gulp-minify-css'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    rimraf = require('rimraf'),
    browserSync = require("browser-sync"),
    reload = browserSync.reload;


var path = {
    build: { //Тут мы укажем куда складывать готовые после сборки файлы
        js: 'web/js/',
        css: 'web/css/',
        img: 'web/img/',
        fonts: 'web/fonts/'
    },
    src: { //Пути откуда брать исходники
        js: 'src/EatingBundle/Resources/public/main.js',//В стилях и скриптах нам понадобятся только main файлы
        style: 'src/EatingBundle/Resources/public/style.scss',
        img: 'src/EatingBundle/Repository/public/img/**/*.*', //Синтаксис img/**/*.* означает - взять все файлы всех расширений из папки и из вложенных каталогов
        fonts: 'src/EatingBundle/Repository/public/fonts/**/*.*'
    },
    watch: { //Тут мы укажем, за изменением каких файлов мы хотим наблюдать
        js: 'src/EatingBundle/Repository/public/**/*.js',
        style: 'src/EatingBundle/Repository/public/**/*.scss',
        img: 'src/EatingBundle/Repository/public/img/**/*.*',
        fonts: 'src/EatingBundle/Repository/public/fonts/**/*.*'
    },
    clean: './build'
};

gulp.task('sass', function(){
    return gulp.src('src/EatingBundle/Resources/public/style.scss')
        .pipe(sass()) // Using gulp-sass
        .pipe(gulp.dest('web/css'))
});

gulp.task('watch', function(){
    gulp.watch('src/EatingBundle/Resources/public/style.scss', ['sass']);
    // Other watchers
});

gulp.task('js:build', function () {
    gulp.src(path.src.js) //Найдем наш main файл
        .pipe(rigger()) //Прогоним через rigger
        .pipe(sourcemaps.init()) //Инициализируем sourcemap
        .pipe(uglify()) //Сожмем наш js
        .pipe(sourcemaps.write()) //Пропишем карты
        .pipe(gulp.dest(path.build.js)) //Выплюнем готовый файл в build
        .pipe(reload({stream: true})); //И перезагрузим сервер
});

gulp.task('style:build', function () {
    gulp.src(path.src.style) //Выберем наш main.scss
        .pipe(sourcemaps.init()) //То же самое что и с js
        .pipe(sass()) //Скомпилируем
        .pipe(prefixer()) //Добавим вендорные префиксы
        .pipe(cssmin()) //Сожмем
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.build.css)) //И в build
        .pipe(reload({stream: true}));
});

gulp.task('image:build', function () {
    gulp.src(path.src.img) //Выберем наши картинки
        .pipe(imagemin({ //Сожмем их
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()],
            interlaced: true
        }))
        .pipe(gulp.dest(path.build.img)) //И бросим в build
        .pipe(reload({stream: true}));
});

gulp.task('fonts:build', function() {
    gulp.src(path.src.fonts)
        .pipe(gulp.dest(path.build.fonts))
});

gulp.task('build', [
    'js:build',
    'style:build',
    'fonts:build',
    'image:build'
]);

gulp.task('watch', function(){
    watch([path.watch.style], function(event, cb) {
        gulp.start('style:build');
    });
    watch([path.watch.js], function(event, cb) {
        gulp.start('js:build');
    });
    watch([path.watch.img], function(event, cb) {
        gulp.start('image:build');
    });
    watch([path.watch.fonts], function(event, cb) {
        gulp.start('fonts:build');
    });
});

gulp.task('clean', function (cb) {
    rimraf(path.clean, cb);
});
