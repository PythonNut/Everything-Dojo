/**
 * Gulpfile.js
 */

/* jshint node:true */

"use strict";

// Gulp plugins
var gulp    = require("gulp"),
    gutil   = require("gulp-util"),
    changed = require("gulp-changed"),
    rename  = require("gulp-rename"),
    jshint  = require("gulp-jshint"),
    uglify  = require("gulp-uglify"),
    csslint = require("gulp-csslint"),
    minify  = require("gulp-minify-css");

// Lint

// JS
gulp.task("lint-js", function () {
  return gulp.src(gulp.env.src || "src/js/*.js")
    .pipe(jshint())
    .pipe(jshint.reporter("default"));
});

// CSS
gulp.task("lint-css", function () {
  return gulp.src(gulp.env.src || "src/css/*.css")
    .pipe(csslint(".csslintrc"))
    .pipe(csslint.reporter());
});

// Build

// Scripts
gulp.task("scripts", ["lint-js"], function () {
  return gulp.src("src/js/*.js")
    .pipe(rename({suffix: ".min"}))
    .pipe(gulp.env.type === "production" ? changed(uglify()) : gutil.noop())
    .pipe(gulp.dest("js/"));
});

// Styles
gulp.task("styles", ["lint-css"], function () {
  return gulp.src("src/css/*.css")
    .pipe(rename({suffix: ".min"}))
    .pipe(gulp.env.type === "production" ? changed(minify()) : gutil.noop())
    .pipe(gulp.dest("css/"));
});

// Default task
gulp.task("default", function () {
  gulp.start("scripts", "styles");
});

// Watch files
gulp.task("watch", function () {
  gulp.watch("src/css/*.css", "styles");
  gulp.watch("src/js/*.js", "scripts");
});
