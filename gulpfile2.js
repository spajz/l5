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
var watch = require('gulp-watch');

// Gulp copy vars
var copyNo = 1;
var copyTasks = [];
var customTasksBefore = [];
var customTasksAfter = [];
var themeSufix = '';

// Gulp console parameters --module module_name
var production = false;
var productionSufix = '';
var moduleUpper = '';
var moduleLower = '';
var theme = 'default';
var allowedModules = ['Front'];
var allowedThemes = ['default', 'demo'];

// Data vars
var cssArray = [];
var cssArrayLocal = [];
var scriptsArray = [];
var scriptsArrayLocal = [];
var lessArray = [];

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

if (typeof util.env.pro !== 'undefined') {
    production = util.env.pro;
    productionSufix = '.pro';
}

/*
 |--------------------------------------------------------------------------
 | Functions
 |--------------------------------------------------------------------------
 */

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

/*
 |--------------------------------------------------------------------------
 | Config
 |--------------------------------------------------------------------------
 */

var adminConfig = {
    assetsDir: 'app/Modules/Admin/assets/',
    baseOutput: 'public/assets/admin/',
    baseOutputUrl: 'assets/admin/',
    cssOutput: 'public/assets/admin/css/',
    jsOutput: 'public/assets/admin/js/',
    bowerDir: 'bower_components/'
}

var moduleConfig = {
    assetsDir: 'app/Modules/' + moduleUpper + '/assets/',
    baseOutput: 'public/assets/' + moduleLower + '/',
    baseOutputUrl: 'assets/' + moduleLower + '/',
    cssOutput: 'public/assets/' + moduleLower + '/css/',
    jsOutput: 'public/assets/' + moduleLower + '/js/',
    bowerDir: 'bower_components/'
}

var config = setConfig();

/*
 |--------------------------------------------------------------------------
 | Admin
 |--------------------------------------------------------------------------
 */

if (!moduleLower) {

    lessArray = [config.assetsDir + 'less/app.less'];

    cssArray = [
        config.cssOutput + 'app.css',
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
        //config.assetsDir + 'css/added.css',
    ]

    if (production) cssArray.push(config.assetsDir + 'css/added.css');

    cssArrayLocal = [config.assetsDir + 'css/added.css'];

    scriptsArray = [
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
        //config.assetsDir + 'js/added.js',
    ];

    if (production) scriptsArray.push(config.assetsDir + 'js/added.js');

    scriptsArrayLocal = [config.assetsDir + 'js/added.js'];

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


/*
 |--------------------------------------------------------------------------
 | Module
 |--------------------------------------------------------------------------
 */

if (moduleLower) {

    if (theme == 'default') {

        customTasksBefore = ['customTask01', 'customTask02'];

        gulp.task('customTask01', function () {
            gulp.src(config.assetsDir + 'fonts/Code-Pro-LC.css')
                .pipe(urlAdjuster({
                    prepend: '../fonts/'
                }))
                .pipe(gulp.dest(config.assetsDir + 'css'));
        });

        gulp.task('customTask02', function () {
            gulp.src(config.assetsDir + 'fonts/Code-Pro-Bold-LC.css')
                .pipe(urlAdjuster({
                    prepend: '../fonts/'
                }))
                .pipe(gulp.dest(config.assetsDir + 'css'));
        });

        lessArray = [config.assetsDir + 'less/app.less'];

        cssArray = [
            //config.cssOutput + 'app.css',
            //config.bowerDir + 'bootstrapxl/BootstrapXL.css',
            config.bowerDir + 'font-awesome/css/font-awesome.css',
            config.assetsDir + 'css/code-pro-bold-lc.css',
            config.assetsDir + 'css/code-pro-lc.css',
            config.bowerDir + 'owl.carousel/dist/assets/owl.carousel.min.css',
            config.bowerDir + 'metisMenu/dist/metisMenu.min.css',
        ]

        if (production) cssArray.push(config.assetsDir + 'css/added.css');

        cssArrayLocal = [config.assetsDir + 'css/added.css'];

        scriptsArray = [
            config.bowerDir + 'jquery-legacy/dist/jquery.min.js',
            config.bowerDir + 'bootstrap/dist/js/bootstrap.min.js',
            config.bowerDir + 'owl.carousel/dist/owl.carousel.min.js',
            config.bowerDir + 'matchHeight/jquery.matchHeight-min.js',
        ];

        if (production) scriptsArray.push(config.assetsDir + 'js/added.js');

        scriptsArrayLocal = [config.assetsDir + 'js/added.js'];

        gulpCopy(
            [config.assetsDir + '/fonts/*.{eot,ttf,woff,woff2,svg,otf}'],
            [config.baseOutput + 'fonts/']
        );

        gulpCopy(
            [config.assetsDir + 'images/**/*'],
            [config.baseOutput + 'images/']
        );
    }

    if (theme == 'demo') {

        themeSufix = '.demo';

        lessArray = [config.assetsDir + 'less/app.demo.less'];

        cssArray = [
            //config.cssOutput + 'app.demo.css',
            config.bowerDir + 'bootstrapxl/BootstrapXL.css',
            config.bowerDir + 'font-awesome/css/font-awesome.css',
            config.bowerDir + 'owl.carousel/dist/assets/owl.carousel.min.css',
            config.bowerDir + 'metisMenu/dist/metisMenu.min.css',
        ]

        if (production) cssArray.push(config.assetsDir + 'css/added.demo.css');

        cssArrayLocal = [config.assetsDir + 'css/added.demo.css'];

        scriptsArray = [
            config.bowerDir + 'jquery-legacy/dist/jquery.min.js',
            config.bowerDir + 'bootstrap/dist/js/bootstrap.min.js',
            config.bowerDir + 'owl.carousel/dist/owl.carousel.min.js',
            config.bowerDir + 'matchHeight/jquery.matchHeight-min.js',
            config.bowerDir + 'isInViewport/lib/isInViewport.min.js',
        ];

        if (production) scriptsArray.push(config.assetsDir + 'js/added.demo.js');

        scriptsArrayLocal = [config.assetsDir + 'js/added.demo.js'];

        gulpCopy(
            [config.assetsDir + 'fonts/*.{eot,ttf,woff,woff2,svg,otf}'],
            [config.baseOutput + 'fonts/']
        );

        gulpCopy(
            [config.assetsDir + 'images/**/*'],
            [config.baseOutput + 'images/']
        );

    }


}// -- End module

/*
 |--------------------------------------------------------------------------
 | Tasks
 |--------------------------------------------------------------------------
 */

gulp.task('gulpCopyProcess', function (callback) {
    if (typeof copyTasks !== 'undefined' && copyTasks.length > 0) {
        runSequence(copyTasks,
            callback);
    } else {
        return gulp.src('');
    }
});

gulp.task('customTasksBefore', function (callback) {
    if (typeof customTasksBefore !== 'undefined' && customTasksBefore.length > 0) {
        runSequence(customTasksBefore,
            callback);
    } else {
        return gulp.src('');
    }
});

gulp.task('customTasksAfter', function (callback) {
    if (typeof customTasksAfter !== 'undefined' && customTasksAfter.length > 0) {
        runSequence(customTasksAfter,
            callback);
    } else {
        return gulp.src('');
    }
});

gulp.task('scripts', function () {
    var out = gulp.src(scriptsArray)
        .pipe(concat(config.baseOutputUrl + 'js/all' + themeSufix + productionSufix + '.js'));
    if (production) out = out.pipe(uglify());
    out
        .pipe(rev())
        .pipe(gulp.dest('public'))
        .pipe(rev.manifest(config.baseOutput + 'rev-manifest.json', {merge: true}))
        .pipe(revDel({
            oldManifest: config.baseOutput + 'rev-manifest.json',
            dest: 'public'
        }))
        .pipe(gulp.dest(''));
    return out;
});

gulp.task('scriptsLocal', function () {
    var out = gulp.src(scriptsArrayLocal)
        .pipe(concat(config.baseOutputUrl + 'js/added' + themeSufix + '.js'))
        .pipe(rev())
        .pipe(gulp.dest('public'))
        .pipe(rev.manifest(config.baseOutput + 'rev-manifest.json', {merge: true}))
        .pipe(revDel({
            oldManifest: config.baseOutput + 'rev-manifest.json',
            dest: 'public'
        }))
        .pipe(gulp.dest(''));
    return out;
});

gulp.task('css', function () {
    var out = gulp.src(cssArray)
        .pipe(concat(config.baseOutputUrl + 'css/all' + themeSufix + productionSufix + '.css'));
    if (production) out = out.pipe(minifyCSS());
    out
        .pipe(rev())
        .pipe(gulp.dest('public'))
        .pipe(rev.manifest(config.baseOutput + 'rev-manifest.json', {merge: true}))
        .pipe(revDel({
            oldManifest: config.baseOutput + 'rev-manifest.json',
            dest: 'public'
        }))
        .pipe(gulp.dest(''));
    return out;
});

gulp.task('cssLocal', function () {
    var out = gulp.src(cssArrayLocal)
        .pipe(concat(config.baseOutputUrl + 'css/added' + themeSufix + '.css'))
        .pipe(rev())
        .pipe(gulp.dest('public'))
        .pipe(rev.manifest(config.baseOutput + 'rev-manifest.json', {merge: true}))
        .pipe(revDel({
            oldManifest: config.baseOutput + 'rev-manifest.json',
            dest: 'public'
        }))
        .pipe(gulp.dest(''));
    return out;
});

gulp.task('less', function () {
    var out = gulp.src(lessArray)
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(concat({path: config.baseOutputUrl + 'css/app' + themeSufix + '.css', cwd: ''}))
        .pipe(sourcemaps.write('.', {includeContent:false, sourceRoot:''}))

        .pipe(rev())
        .pipe(gulp.dest('public'))
        .pipe(rev.manifest(config.baseOutput + 'rev-manifest.json', {
            merge: true
        }))
        .pipe(revDel({
            oldManifest: config.baseOutput + 'rev-manifest.json',
            dest: 'public'
        }))
        .pipe(gulp.dest(''));
    return out;
});

gulp.task('watch', function () {
    gulp.watch(cssArrayLocal, ['cssLocal']);
    gulp.watch(scriptsArrayLocal, ['scriptsLocal']);
});

gulp.task('run2', ['styles', 'scripts', 'scriptsLocal', 'cssLocal', 'gulpCopyProcess']);
//gulp.task('run', ['less', 'scripts', 'cssLocal', 'css', 'gulpCopyProcess']);

gulp.task('run', function (callback) {
    runSequence(
        'customTasksBefore',
        'less',
        'css',
        'scripts',
        'scriptsLocal',
        'cssLocal',
        'gulpCopyProcess',
        'customTasksAfter',
        callback);
});