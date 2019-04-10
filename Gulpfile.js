// Dependencies
const gulp = require('gulp');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sourcemaps = require('gulp-sourcemaps');
const sassGlob = require('gulp-sass-glob');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const babel = require('gulp-babel');
const browserSync = require('browser-sync').create();

// Some config data for our tasks
const config = {
  styles: {
    sass: 'assets/sass/style.scss',
    srcDir: 'assets/sass',
    dest: 'assets/css'
  },
  scripts: {
    js: './assets/js/**/*.js',
    dest: './assets/js'
  },
  browserSync: {
    active: false,
    localURL: 'mylocalsite.local'
  }
};

function styles() {
  return gulp.src(config.styles.sass)
    .pipe(sourcemaps.init()) // Sourcemaps need to init before compilation
    .pipe(sassGlob()) // Allow for globbed @import statements in SCSS
    .pipe(sass()) // Compile
    .on('error', sass.logError) // Error reporting
    .pipe(postcss([
      autoprefixer(), // Autoprefix resulting CSS
      cssnano() // Minify
    ]))
    .pipe(rename({ // Rename to .min.css
      suffix: '.min'
    }))
    .pipe(sourcemaps.write()) // Write the sourcemap files
    .pipe(gulp.dest(config.styles.dest)) // Drop the resulting CSS file in the specified dir
    .pipe(browserSync.stream());
}

function scripts() {
  return gulp.src(config.scripts.js)
    .pipe(sourcemaps.init())
    .pipe(babel({
      presets: ['@babel/preset-env']
    }))
    .pipe(concat('pledges.js')) // Concatenate
    .pipe(uglify()) // Minify + compress
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(config.scripts.dest))
    .pipe(browserSync.stream());
}

// Injects changes into browser
function browserSyncTask() {
  if (config.browserSync.active) {
    browserSync.init({
      proxy: config.browserSync.localURL
    });
  }
}

// Reloads browsers that are using browsersync
function browserSyncReload(done) {
  browserSync.reload();
  done();
}

// Watch directories, and run specific tasks on file changes
function watch() {
  gulp.watch(config.styles.srcDir, styles);
  gulp.watch(config.scripts.js, scripts);
  
  // Reload browsersync when PHP files change, if active
  if (config.browserSync.active) {
    gulp.watch('./**/*.php', browserSyncReload);
  }
}

// export tasks
exports.styles = styles;
exports.scripts = scripts;
exports.watch = watch;

// What happens when we run gulp?
gulp.task('default',
  gulp.series(
    gulp.parallel(styles, scripts), // First run these tasks asynchronously
    gulp.parallel(watch, browserSyncTask) // Then start watching files and browsersyncing
  )
);