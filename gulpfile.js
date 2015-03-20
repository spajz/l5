var gulp = require('gulp');
var elixir = require('laravel-elixir');
// gulp-util from elixir
var util = require('./node_modules/laravel-elixir/node_modules/gulp-util');
var runSequence = require('./node_modules/laravel-elixir/node_modules/run-sequence');

var inProduction = elixir.config.production;

/**
 * Overwrites obj1's values with obj2's and adds obj2's if non existent in obj1
 * @param obj1
 * @param obj2
 * @returns obj3 a new object based on obj1 and obj2
 */
function objMerge(obj1, obj2) {
    var obj3 = {};
    for (var attrname in obj1) {
        obj3[attrname] = obj1[attrname];
    }
    for (var attrname in obj2) {
        obj3[attrname] = obj2[attrname];
    }
    return obj3;
}

// gulp --param some_value
// console.log(util.env.param);

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

var adminConfig = {
    srcDir: 'app',
    assetsDir: 'resources/admin/',
    cssOutput: 'public/assets/admin/css',
    jsOutput: 'public/assets/admin/js',
    bowerDir: 'bower_components'
}

elixir.config = objMerge(elixir.config, adminConfig);

var bowerDir = elixir.config.bowerDir;
var adminDir = 'public/assets/admin';
var adminBuildDir = 'public/build/assets/admin';
var copyNo = 1;
var copyTasks = [];

elixir.extend('gulper', function () {
    gulp.task('gulper', function (callback) {
        runSequence(copyTasks,
            callback);
    });
    return this.queueTask('gulper');
});

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

// Multiple copy
function multiCopy(src, output) {
    src = typeof src == 'string' ? [src] : src;
    output = typeof output == 'string' ? [output] : output;
    elixir(function (mix) {
        src.forEach(function (srcItem) {
            output.forEach(function (outputItem) {
                mix.copy(srcItem, outputItem);
            });
        });
    });
}


// Bootstrap
elixir(function (mix) {
    mix.less('app.less')

        .styles([
            adminConfig.assetsDir + 'css/added.css'
        ], adminConfig.cssOutput + '/added.css', './')

        .styles([
            //adminConfig.cssOutput + '/app.css',
            adminConfig.bowerDir + '/font-awesome/css/font-awesome.css',
            adminConfig.assetsDir + '/vendor/css/dataTables.bootstrap.css',
            adminConfig.assetsDir + '/vendor/css/datatables.responsive.css',
            adminConfig.bowerDir + '/metisMenu/dist/metisMenu.min.css',
            adminConfig.bowerDir + '/select2/select2.css',
            adminConfig.bowerDir + '/select2-bootstrap-css/select2-bootstrap.css',
            adminConfig.bowerDir + '/fancybox/source/jquery.fancybox.css',

        ], null, './')

        .scripts([
            adminConfig.assetsDir + 'js/added.js'
        ], adminConfig.jsOutput + '/added.js', './')

        .scripts([
            adminConfig.bowerDir + '/jquery-legacy/dist/jquery.min.js',
            adminConfig.bowerDir + '/bootstrap/dist/js/bootstrap.min.js',
            adminConfig.bowerDir + '/datatables/media/js/jquery.dataTables.min.js',
            adminConfig.assetsDir + '/vendor/js/dataTables.bootstrap.js',
            adminConfig.assetsDir + '/vendor/js/datatables.responsive.js',
            adminConfig.bowerDir + '/metisMenu/dist/metisMenu.min.js',
            adminConfig.bowerDir + '/jquery-pjax/jquery.pjax.js',
            adminConfig.bowerDir + '/bootbox/bootbox.js',
            adminConfig.bowerDir + '/select2/select2.js',
            adminConfig.bowerDir + '/fancybox/source/jquery.fancybox.pack.js',

        ], null, './')

        .version([
            adminConfig.cssOutput + '/all.css',
            adminConfig.jsOutput + '/all.js',
            adminConfig.cssOutput + '/added.css',
            adminConfig.jsOutput + '/added.js',
        ]);
});

multiCopy([
    adminConfig.bowerDir + '/font-awesome/fonts',
    adminConfig.bowerDir + '/bootstrap/fonts',
], [
    adminBuildDir + '/fonts/',
    adminDir + '/fonts/'
]);

gulpCopy(
    [
        adminConfig.bowerDir + '/select2/select2.png',
        adminConfig.bowerDir + '/select2/select2x2.png',
    ],
    [adminBuildDir + '/css/', adminDir + '/css/']
);

gulpCopy(
    [adminConfig.bowerDir + '/fancybox/source/*.{gif,png}'],
    [adminBuildDir + '/css/', adminDir + '/css/']
);

gulpCopy(
    [adminConfig.bowerDir + '/fancybox/source/*.{gif,png}'],
    [adminBuildDir + '/css/', adminDir + '/css/']
);

elixir(function (mix) {
    mix.gulper()
});

//elixir(function (mix) {
//    mix.copy2([
//            adminConfig.bowerDir + '/select2/select2.png',
//            adminConfig.bowerDir + '/select2/select2x2.png',
//        ], [adminBuildDir + '/css/', adminDir + '/css/']
//    )
//});

//elixir.extend('copy2', function (src, output) {
//    gulp.task('copy2', function () {
//        var obj = gulp.src(src);
//        output.forEach(function (value) {
//            obj.pipe(gulp.dest(value));
//        });
//    });
//    //this.registerWatcher("copy2", "**/*");
//    return this.queueTask('copy2');
//});

//elixir(function (mix) {
//    mix.copy2([
//            adminConfig.bowerDir + '/fancybox/source/*.{gif,png}'
//        ], [adminBuildDir + '/css/', adminDir + '/css/']
//    )
//});

//elixir(function (mix) {
//    mix.copy(
//        adminConfig.bowerDir + '/font-awesome/fonts',
//        adminDir + '/fonts/'
//    ).copy(
//        adminConfig.bowerDir + '/font-awesome/fonts',
//        adminBuildDir + '/fonts/'
//    ).copy(
//        adminConfig.bowerDir + '/bootstrap/fonts',
//        adminDir + '/fonts/'
//    ).copy(
//        adminConfig.bowerDir + '/bootstrap/fonts',
//        adminBuildDir + '/fonts/'
//    );
//});


// Datatables images
//multiCopy([
//    adminConfig.bowerDir + '/datatables/media/images'
//], [
//    adminBuildDir + '/images/',
//    adminDir + '/images/'
//]);

//multiCopy(adminConfig.bowerDir + '/bootstrap/fonts', [
//    adminBuildDir + '/fonts/',
//    adminDir + '/fonts/'
//]);

//elixir(function (mix) {
//
//    mix.copy2([
//            adminConfig.bowerDir + '/font-awesome/fonts/**/*',
//            adminConfig.bowerDir + '/bootstrap/fonts/**/*'
//        ], [adminBuildDir + '/fonts/', adminDir + '/fonts/']
//    ).copy2([
//            adminConfig.bowerDir + '/datatables/media/images/**/*',
//            gitRepoDir + '/Plugins/integration/bootstrap/3/images/**/*'
//        ], [adminBuildDir + '/images/', adminDir + '/images/']
//    );
//
//
//});
//
//elixir(function (mix) {
//    mix.copy2([
//            adminConfig.bowerDir + '/datatables/media/images/**/*.png',
//            gitRepoDir + '/Plugins/integration/bootstrap/3/images/**/*.png'
//        ], [adminBuildDir + '/images/', adminDir + '/images/']
//    );
//
//
//});

//gulp.task('adminCopy', function () {
//    gulp.src(adminConfig.bowerDir + '/font-awesome/fonts/**/*')
//        .pipe(gulp.dest(adminBuildDir + '/fonts/'));
//});
//
//gulp.task('admin', function (callback) {
//    runSequence('default',
//        'adminCopy',
//        callback);
//});