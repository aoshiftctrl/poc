var gulp   = require('gulp'),
    sass   = require('gulp-sass'),
    rename = require('gulp-rename'),
    prefix = require('gulp-autoprefixer'),
    cssmin = require('gulp-cssmin'),
    jshint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    addsrc = require('gulp-add-src'),
    watch  = require('gulp-watch');

var dir = require('gulp-concat-filenames');
var dirOptions = {
  root: '/Users/vist/Sites/scapp',
  prepend: '+--',
  append: '',
  newline: '\n'
};

gulp.task('lsDir', function(){
  gulp.src('./**/*.*')
      .pipe(dir('map.txt', dirOptions))
      .pipe(gulp.dest('./map'));
});

gulp.task('sass', function(){
  gulp.src('./app/css/ui.sass')
      .pipe(sass())
      .pipe(prefix())
      .pipe(cssmin())
      .pipe(rename({suffix: '.min'}))
      .pipe(gulp.dest('./app/css/'));
});

gulp.task('js', function(){
  gulp.src('./app/js/app.js')
      .pipe(jshint())
      .pipe(addsrc('./app/js/helper/*.js'))
      .pipe(concat('./app.min.js'))
      .pipe(uglify())
      .pipe(gulp.dest('./app/js/'));
});

gulp.task('watch', function(){
  gulp.watch('./app/css/**/*.sass', ['sass']);
  gulp.watch('./app/js/**/*.js', ['js']);
  //gulp.watch('./**/*.*', ['lsDir']);
});

gulp.task('default', ['watch']);
