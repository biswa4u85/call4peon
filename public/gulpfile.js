// Load plugins
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    less = require('gulp-less'),
    merge = require('merge-stream'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano = require('gulp-cssnano'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    watch = require('gulp-watch');
    del = require('del'),
    duration = require('gulp-duration');
    
    
    

// Styles
gulp.task('styles', function() {
    
    // Convert LESS to CSS
    gulp.src('front/assets/**/*.less')
        .pipe(less())
        .pipe(gulp.dest('front/assets'));
    
    // Convert SESS and SASS to CSS
    gulp.src(['front/assets/**/*.scss','front/assets/**/*.sass'])
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(gulp.dest('front/assets'));

    
    return gulp.src(['front/assets/css/bootstrap.css','front/assets/css/style.css','front/assets/css/menu.css','front/assets/css/color/color.css','front/assets/css/responsive.css','front/assets/css/font-awesome.css'])
       // .pipe(concat('main.css'))
       .pipe(concat({ path: 'main.css', stat: { mode: 0666 }}))
        .pipe(autoprefixer('last 2 version'))
        .pipe(duration('rebuilding files'))
        .pipe(gulp.dest('front/dist/css'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(cssnano())
        .pipe(gulp.dest('front/dist/css'))
        .pipe(notify({ message: 'Styles task complete' }));
});

// Scripts
gulp.task('scripts', function() {
   return gulp.src('front/assets/js/**/*.js')
    .pipe(concat('main.js'))
    .pipe(duration('rebuilding files'))
    .pipe(gulp.dest('front/dist/js'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('front/dist/js'))
    .pipe(notify({ message: 'Scripts task complete' }));
});

// Images
gulp.task('images', function() {
  return gulp.src('front/assets/images/**/*')
    .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
    .pipe(gulp.dest('front/dist/images'))
    .pipe(notify({ message: 'Images task complete' }));
});

// Clean
gulp.task('clean', function() {
  return del(['front/dist/css', 'front/dist/js', 'front/dist/images']);
});

// Default task
gulp.task('default', ['clean'], function() {
  gulp.start('styles', 'scripts', 'images');
});

// Watch
gulp.task('watch', function() {

  // Watch .scss files
  gulp.watch(['front/assets/**/*.less','front/assets/**/*.scss','front/assets/**/*.sass','front/assets/**/*.css'], ['styles']);

  // Watch .js files
  gulp.watch('front/assets/js/**/*.js', ['scripts']);

  // Watch image files
    gulp.watch('front/assets/images/**/*', ['images']);

  // Create LiveReload server
  livereload.listen();

  // Watch any files in dist/, reload on change
  gulp.watch(['front/dist/**']).on('change', livereload.changed);

});
