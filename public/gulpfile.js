'use strict';

// sass compile
var gulp = require('gulp');
var prettify = require('gulp-prettify');
var minifyCss = require("gulp-minify-css");
var rename = require("gulp-rename");
var uglify = require("gulp-uglify");
var gutil = require('gulp-util');

var babel = require('gulp-babel');

var concat = require('gulp-concat');

//*** CSS & JS minify task
gulp.task('minify', function () {
    // css minify
    gulp.src([
        './layout/css/bootstrap.css',
        './layout/css/sb-admin.css',
        './layout/font-awesome/css/font-awesome.css',
        './vendor/alertifyjs/css/alertify.css',
        './css/jquery-ui.css',
        './vendor/select2-4.0.3/dist/css/select2.css',
        './vendor/jtable.2.4.0/themes/metro/darkgray/jtable.css',
        './vendor/datetimepicker/css/bootstrap-datetimepicker-standalone.css',
        './bootstrap-toggle/bootstrap-toggle.min.css',
        './bower_components/bootstrap-offcanvas/dist/css/bootstrap.offcanvas.css',
        './css/utilities.css',
        './css/custom.css',
        './jquery-loadingModal/css/jquery.loadingModal.css',

        // do and summary activity
        './simplePagination.js/simplePagination.css',

        './bower_components/bootstrap-fileinput/css/fileinput.min.css',

        './vendor/jstree/css/themes/default/style.css',

        './vendor/jplist/jplist.core.min.css',

        './vendor/DataTables-1.10.14/extensions/Responsive/css/responsive.bootstrap.min.css',
        './vendor/DataTables-1.10.14/extensions/Responsive/css/responsive.dataTables.css',
        './vendor/DataTables-1.10.14/extensions/RowReorder/css/rowReorder.bootstrap.css',
        './vendor/DataTables-1.10.14/extensions/RowReorder/css/rowReorder.bootstrap.min.css',

        // './css/jqupload/blueimp-gallery.min.css',
        // './vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload.css',
        // './vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui.css',
        // './vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-noscript.css',
        // './vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui-noscript.css',
    ])
        .pipe(minifyCss())
        //.pipe(uglify())
        .pipe(concat('bundle.css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('./dist/css/'));


    //js minify
    gulp.src([
        './layout/js/jquery.js',
        './jquery-loadingModal/js/jquery.loadingModal.min.js',
        './js/jquery-ui.min.js',
        './vendor/alertifyjs/alertify.min.js',
        './vendor/select2-4.0.3/dist/js/select2.full.min.js',
        './layout/js/bootstrap.min.js',
        './vendor/momentjs/moment-with-locales.js',
        './vendor/momentjs/locale/es.js',
        './vendor/datetimepicker/bootstrap/js/transition.js',
        './vendor/datetimepicker/bootstrap/js/collapse.js',
        './vendor/datetimepicker/js/bootstrap-datetimepicker.min.js',
        './vendor/jtable.2.4.0/jquery.jtable.min.js',
        './bootstrap-toggle/bootstrap-toggle.min.js',
        './bower_components/bootstrap-offcanvas/dist/js/bootstrap.offcanvas.min.js',

        // do and summary activity
        './simplePagination.js/jquery.simplePagination.js',

        './bower_components/bootstrap-fileinput/js/fileinput.min.js',
        './bower_components/bootstrap-fileinput/js/locales/es.js',
        './bower_components/bootstrap-fileinput/themes/fa/theme.min.js',

        './vendor/jQuery-File-Upload-9.18.0/js/vendor/jquery.ui.widget.js',
        './js/jqupload/tmpl.min.js',
        './js/jqupload/load-image.all.min.js',
        './js/jqupload/canvas-to-blob.min.js',
        './js/jqupload/jquery.blueimp-gallery.min.js',
        './vendor/jQuery-File-Upload-9.18.0/js/jquery.iframe-transport.js',
        './vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload.js',
        './vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-process.js',
        './vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-image.js',
        './vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-audio.js',
        './vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-video.js',
        './vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-validate.js',
        './vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-ui.js',
        './vendor/jQuery-File-Upload-9.18.0/js/main.js',

        './vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js',
        './vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js',

        './vendor/DataTables-1.10.14/extensions/Responsive/js/dataTables.responsive.min.js',
        './vendor/DataTables-1.10.14/extensions/RowReorder/js/dataTables.rowReorder.min.js',
        './vendor/DataTables-1.10.14/extensions/Responsive/js/responsive.bootstrap.js',

        './vendor/jstree/js/jstree.min.js',

        './vendor/jplist/jplist.core.min.js',
        //'./vendor/jplist/jplist.sort-bundle.min.js',
        './vendor/jplist/jplist.bootstrap-sort-dropdown.min.js',
        // './layout/js/app.js',
    ])
        /*.pipe(babel({
            presets: ['env','es2015']
        }))*/
        .pipe(uglify())
            .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(rename({suffix: '.min'}))
        .pipe(concat('bundle.min.js'))
        .pipe(gulp.dest('./dist/js'));
});
