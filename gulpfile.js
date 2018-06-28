var gulp          = require('gulp'),
    sass          = require('gulp-sass'),
    sourcemaps    = require('gulp-sourcemaps'),
    autoprefixer  = require('gulp-autoprefixer'),
    rename        = require('gulp-rename'),
    concat        = require('gulp-concat'),
    uglify        = require('gulp-uglify'),
    zip           = require('gulp-zip');

folder = {
  src_js: 'src/js/', // folder.src_js
  src_sass: 'src/sass/', // folder.src_sass
  build: 'themes/match/' // folder.build
}

gulp.task('styles', function () {
  return gulp.src(folder.src_sass+'style.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({
    errLogToConsole: true,
    outputStyle: 'expanded' // compiles SASS to CSS
  }))
  .pipe(autoprefixer({
    browsers: [
      'last 2 versions',
      '> 5%',
      'Firefox ESR'
    ]
  }))
  .pipe(rename('style.css')) // not yet minified at this point, just compiled [optional]
  .pipe(gulp.dest(folder.src_sass)) // tells task which directory to output compiled CSS [optional]
  .pipe(sass({
    errLogToConsole: true,
    outputStyle: 'compressed' // minifies style.min.css
  }))
  .pipe(sourcemaps.write('/', { // write style.min.css.map to same directory as style.min.css
    includeContent: false,
    sourceRoot: '../../'+folder.src_sass // relative to minified output location
  }))
  //.pipe(rename('style.css')) // not yet minified at this point, just compiled [optional]
  .pipe(gulp.dest(folder.build)) // tells task which directory to output minified CSS
});

gulp.task('editor-styles', function () {
  return gulp.src(folder.src_sass+'editor-styles.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({
    errLogToConsole: true,
    outputStyle: 'expanded' // compiles SASS to CSS
  }))
  .pipe(autoprefixer({
    browsers: [
      'last 2 versions',
      '> 5%',
      'Firefox ESR'
    ]
  }))
  .pipe(rename('editor-style.min.css')) // not yet minified at this point, just compiled [optional]
  .pipe(gulp.dest(folder.src_sass)) // tells task which directory to output compiled CSS [optional]
  .pipe(sass({
    errLogToConsole: true,
    outputStyle: 'compressed' // minifies style.min.css
  }))
  .pipe(sourcemaps.write('/', { // write style.min.css.map to same directory as style.min.css
    includeContent: false,
    sourceRoot: '../../'+folder.src_sass // relative to minified output location
  }))
  //.pipe(rename('style.css')) // not yet minified at this point, just compiled [optional]
  .pipe(gulp.dest(folder.build+'css/')) // tells task which directory to output minified CSS
});

gulp.task('scripts', function(){
  return gulp.src([
      folder.src_js+'main.js',
    ])
  .pipe(concat('scripts.min.js')) // concatenates the JS files listed above into one file called scripts.min.js
  .pipe(uglify()) // minifies scripts.min.js
  .pipe(gulp.dest(folder.build+'js/')) // tells task which directory to outputs uglified (minified) scripts.min.js
});

gulp.task('scripts_libs', function(){
  return gulp.src([
      folder.src_js+'hover-intent.js',
      folder.src_js+'superfish.js',
      folder.src_js+'slicknav.js',
      folder.src_js+'fitvids.js',
      folder.src_js+'custom.js'
    ])
  .pipe(concat('libs.min.js')) // concatenates the JS files listed above into one file called scripts.min.js
  .pipe(uglify()) // minifies scripts.min.js
  .pipe(gulp.dest(folder.build+'js/')) // tells task which directory to outputs uglified (minified) scripts.min.js
});

gulp.task('zip', function(){
  var today = new Date,
    dd = today.getDate(),
    mm = today.getMonth() + 1,
    yyyy = today.getFullYear(),
    epoch = today.getTime();
    dd < 10 && (dd = "0" + dd); // Ex: 6 becomes 06
    mm < 10 && (mm = "0" + mm); // Ex: 6 becomes 06
    today = yyyy + "-" + mm + "-" + dd + "_" + epoch; // Ex: 2017-06-12_1497284127823
  return gulp.src([
    folder.build+'**', // include all the files in the "match" directory
    '!**/*.bak', // exclude all files with the "bak" extension
    '!**/*.zip' // exclude all files with the "zip" extension
  ], {base: './themes/'}) // put everything inside the "match" directory
  .pipe(zip('Match-Theme_2.x.x_'+today+'.zip')) // Ex: Match-Theme_2.x.x_2017-06-12_1497284127823.zip
  .pipe(gulp.dest('themes'))
});

gulp.task('default', ['styles', 'editor-styles', 'scripts', 'scripts_libs'], function() {  // include array of tasks to run them upon initial running of 'gulp' in the terminal
  gulp.watch(folder.src_sass+'**/*.scss', ['styles', 'editor-styles']); // Watch the sass files for changes
  // gulp.watch('src/js/main.js', ['scripts']); // Watch the main.js file for changes (global JS file)
  // gulp.watch('src/js/page-*.js', ['scripts_pages']); // Watch page specific JS files for changes
  // gulp.watch('src/js/template-*.min.js', ['scripts_templates']); // Watch template specific JS files for changes
  gulp.watch(folder.src_js+'*.js', ['scripts', 'scripts_libs']); // Watch the main.js file for changes (global JS file)
});