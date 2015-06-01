// Require
var gulp = require('gulp');
var rev = require('gulp-rev');
var minifyCSS = require('gulp-minify-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var revDel = require('rev-del');
//var minifyHTML = require('gulp-minify-html');
var rename = require('gulp-rename');
var runSequence = require('run-sequence');
var less = require('gulp-less');
var sourcemaps = require('gulp-sourcemaps');
var urlAdjuster = require('gulp-css-url-adjuster');
var util = require('gulp-util');

// Gulp copy vars
var copyNo = 1;
var copyTasks = [];

// Gulp console parameters --module module_name
var production = false;
var moduleUpper = '';
var moduleLower = '';
var theme = 'default';
var allowedModules = ['Front'];
var allowedThemes = ['default', 'demo'];

if (typeof util.env.module !== 'undefined') {
    if (allowedModules.indexOf(util.env.module) >= 0) {
        moduleUpper = util.env.module;
        moduleLower = moduleUpper.toString().toLowerCase();
    } else {
        throw 'The module does not exist.';
    }
}

if (typeof util.env.theme !== 'undefined') {
    if (allowedThemes.indexOf(util.env.theme) >= 0) {
        theme = util.env.theme;
    } else {
        throw 'The theme does not exist.';
    }
}

if (typeof util.env.production !== 'undefined') {
    production = util.env.production;
}

// Functions
function setConfig() {
    if (moduleUpper && moduleUpper != 'Admin') {
        return moduleConfig;
    } else {
        return adminConfig;
    }
}

// Gulp copy
function gulpCopy(src, output) {
    src = typeof src == 'string' ? [src] : src;
    output = typeof output == 'string' ? [output] : output;

    var currentTask = 'copyTask' + copyNo;
    copyNo++;
    copyTasks.push(currentTask);

    gulp.task(currentTask, function () {
        var obj = gulp.src(src);
        output.forEach(function (value) {
            obj.pipe(gulp.dest(value));
        });
    })
}

var adminConfig = {
    assetsDir: 'app/Modules/Admin/assets/',
    baseOutput: 'public/assets/admin/',
    cssOutput: 'public/assets/admin/css/',
    jsOutput: 'public/assets/admin/js/',
    bowerDir: 'bower_components/'
}

var moduleConfig = {
    assetsDir: 'app/Modules/' + moduleUpper + '/assets/',
    baseOutput: 'public/assets/' + moduleLower + '/',
    cssOutput: 'public/assets/' + moduleLower + '/css/',
    jsOutput: 'public/assets/' + moduleLower + '/js/',
    bowerDir: 'bower_components/'
}

var config = setConfig();

gulp.task('gulpCopyProcess', function (callback) {
    if (typeof copyTasks !== 'undefined' && copyTasks.length > 0) {
        runSequence(copyTasks,
            callback);
    }
});

gulpCopy(
    ['./bower_components/magnific-popup/dist/jquery.magnific-popup.min.js'],
    ['./js/vendor/',]
);


/*
 |--------------------------------------------------------------------------
 | Admin
 |--------------------------------------------------------------------------
 */

if (!moduleLower) {

    var cssArray = [
        //config.cssOutput + 'app.css',
        config.bowerDir + 'bootstrapxl/BootstrapXL.css',
        config.bowerDir + 'font-awesome/css/font-awesome.css',
        config.assetsDir + 'vendor/css/dataTables.bootstrap.css',
        config.assetsDir + 'vendor/css/datatables.responsive.css',
        config.bowerDir + 'metisMenu/dist/metisMenu.min.css',
        config.bowerDir + 'select2/select2.css',
        config.bowerDir + 'select2-bootstrap-css/select2-bootstrap.css',
        config.bowerDir + 'fancybox/source/jquery.fancybox.css',
        config.bowerDir + 'jquery-ui/themes/base/jquery-ui.min.css',
        config.bowerDir + 'Jcrop/css/Jcrop.min.css',

        config.assetsDir + 'css/added.css',
    ];

    var scriptsArray = [
        config.bowerDir + 'jquery-legacy/dist/jquery.min.js',
        config.bowerDir + 'bootstrap/dist/js/bootstrap.min.js',
        config.bowerDir + 'datatables/media/js/jquery.dataTables.min.js',
        config.assetsDir + 'vendor/js/dataTables.bootstrap.js',
        config.assetsDir + 'vendor/js/datatables.responsive.js',
        config.bowerDir + 'metisMenu/dist/metisMenu.min.js',
        config.bowerDir + 'jquery-pjax/jquery.pjax.js',
        config.bowerDir + 'bootbox/bootbox.js',
        config.bowerDir + 'select2/select2.js',
        config.bowerDir + 'fancybox/source/jquery.fancybox.pack.js',
        config.bowerDir + 'jquery-ui/jquery-ui.min.js',
        config.bowerDir + 'underscore/underscore-min.js',
        config.bowerDir + 'Jcrop/js/Jcrop.min.js',

        config.assetsDir + 'js/added.js',
    ];

    var lessSource = config.assetsDir + 'less/app.less';

    gulp.task('run', function (callback) {
        runSequence(
            //'less',
            'css',
            'scripts',
          //  'gulpCopyProcess',
            callback);
    });

    //// Main admin mix
    //elixir(function (mix) {
    //    mix.less('app.less')
    //
    //        .scripts([
    //            adminConfig.assetsDir + 'js/added.js'
    //        ], adminConfig.jsOutput + '/added.js', './')
    //
    //        .scripts([
    //            adminConfig.bowerDir + '/jquery-legacy/dist/jquery.min.js',
    //            adminConfig.bowerDir + '/bootstrap/dist/js/bootstrap.min.js',
    //            adminConfig.bowerDir + '/datatables/media/js/jquery.dataTables.min.js',
    //            adminConfig.assetsDir + 'vendor/js/dataTables.bootstrap.js',
    //            adminConfig.assetsDir + 'vendor/js/datatables.responsive.js',
    //            adminConfig.bowerDir + '/metisMenu/dist/metisMenu.min.js',
    //            adminConfig.bowerDir + '/jquery-pjax/jquery.pjax.js',
    //            adminConfig.bowerDir + '/bootbox/bootbox.js',
    //            adminConfig.bowerDir + '/select2/select2.js',
    //            adminConfig.bowerDir + '/fancybox/source/jquery.fancybox.pack.js',
    //            adminConfig.bowerDir + '/jquery-ui/jquery-ui.min.js',
    //            adminConfig.bowerDir + '/underscore/underscore-min.js',
    //            adminConfig.bowerDir + '/Jcrop/js/Jcrop.min.js',
    //        ], null, './')
    //
    //        .styles([
    //            adminConfig.assetsDir + 'css/added.css'
    //        ], adminConfig.cssOutput + '/added.css', './')
    //
    //        .styles([
    //            //adminConfig.cssOutput + '/app.css',
    //            adminConfig.bowerDir + '/bootstrapxl/BootstrapXL.css',
    //            adminConfig.bowerDir + '/font-awesome/css/font-awesome.css',
    //            adminConfig.assetsDir + 'vendor/css/dataTables.bootstrap.css',
    //            adminConfig.assetsDir + 'vendor/css/datatables.responsive.css',
    //            adminConfig.bowerDir + '/metisMenu/dist/metisMenu.min.css',
    //            adminConfig.bowerDir + '/select2/select2.css',
    //            adminConfig.bowerDir + '/select2-bootstrap-css/select2-bootstrap.css',
    //            adminConfig.bowerDir + '/fancybox/source/jquery.fancybox.css',
    //            adminConfig.bowerDir + '/jquery-ui/themes/base/jquery-ui.min.css',
    //            adminConfig.bowerDir + '/Jcrop/css/Jcrop.min.css',
    //        ], null, './')
    //
    //        .version([
    //            adminConfig.cssOutput + '/all.css',
    //            adminConfig.cssOutput + '/added.css',
    //            adminConfig.jsOutput + '/added.js',
    //            adminConfig.jsOutput + '/all.js',
    //        ], adminBuildBase);
    //});
    //
    gulpCopy(
        [
            config.bowerDir + 'font-awesome/fonts/**/*',
            config.bowerDir + 'bootstrap/fonts/**/*',
        ],
        [config.baseOutput + 'fonts/']
    );

    gulpCopy(
        [
            config.bowerDir + 'select2/select2.png',
            config.bowerDir + 'select2/select2x2.png',
            config.bowerDir + 'select2/select2-spinner.gif',
        ],
        [config.baseOutput + 'css/']
    );

    gulpCopy(
        [config.bowerDir + 'fancybox/source/*.{gif,png}'],
        [config.baseOutput + 'css/']
    );

    gulpCopy(
        [config.assetsDir + 'images/**/*'],
        [config.baseOutput + 'images/']
    );

    gulpCopy(
        [config.bowerDir + 'jquery-ui/themes/base/images/**/*'],
        [config.baseOutput + 'images/']
    );

    gulpCopy(
        [
            config.bowerDir + 'ckeditor/**/*',
            '!' + config.bowerDir + 'ckeditor/samples{,/**}',
        ],
        [config.baseOutput + 'vendor/ckeditor']
    );

    gulpCopy(
        [config.bowerDir + 'Jcrop/css/Jcrop.gif'],
        [config.baseOutput + 'css/']
    );
}// -- End admin


gulp.task('scripts', function () {
    var out = gulp.src(scriptsArray)
        .pipe(concat('assets/admin/js/all.js'));

    if (production) out = out.pipe(uglify());

    out.pipe(rev())
        .pipe(gulp.dest('public'))

        .pipe(rev.manifest('public/rev/rev-manifest.json', {merge: true}))

        .pipe(revDel({dest: ''}))
        .pipe(gulp.dest(''));

    return out;
});

gulp.task('css', function () {
    var out = gulp.src(cssArray)
        .pipe(concat('assets/admin/css/all.css'));

    if (production) out = out.pipe(minifyCSS());

    out.pipe(rev())
        .pipe(gulp.dest('public'))

        .pipe(rev.manifest('public/rev/rev-manifest.json', {merge: true}))

        .pipe(revDel({dest: ''}))
        .pipe(gulp.dest(''));

    return out;
});

gulp.task('less', function () {
    var out = gulp.src(lessSource)
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(config.cssOutput));

    return out;
});