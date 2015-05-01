var gulp = require('gulp');
var elixir = require('laravel-elixir');
// gulp-util from elixir
var util = require('./node_modules/laravel-elixir/node_modules/gulp-util');
var runSequence = require('./node_modules/laravel-elixir/node_modules/run-sequence');
var inProduction = elixir.config.production;


// gulp --module module_name
var moduleUpper = '';
var moduleLower = '';
var allowedModules = ['Front'];

if (typeof util.env.module !== 'undefined') {
    if(allowedModules.indexOf(util.env.module) >= 0){
        moduleUpper = util.env.module;
        moduleLower = moduleUpper.toString().toLowerCase();
    } else {
        throw 'The module does not exist.';
    }
}

var copyNo = 1;
var copyTasks = [];

/*
 |--------------------------------------------------------------------------
 | Functions
 |--------------------------------------------------------------------------
 */

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

// Gulper
elixir.extend('gulper', function () {

    gulp.task('gulper', function (callback) {
        if (copyTasks.length > 0) {
            runSequence(copyTasks,
                callback);
        }
    });

    return this.queueTask('gulper');
});


/*
 |--------------------------------------------------------------------------
 | Admin
 |--------------------------------------------------------------------------
 */

if (!moduleLower) {
    var adminConfig = {
        srcDir: 'app',
        //assetsDir: 'resources/admin/',
        assetsDir: 'app/Modules/Admin/assets/',
        cssOutput: 'public/assets/admin/css',
        jsOutput: 'public/assets/admin/js',
        bowerDir: 'bower_components'
    }

    elixir.config = objMerge(elixir.config, adminConfig);

    var adminDir = 'public/assets/admin';
    var adminBuildDir = 'public/build/assets/admin';


    // Main admin mix
    elixir(function (mix) {
        mix.less('app.less')

            .styles([
                adminConfig.assetsDir + 'css/added.css'
            ], adminConfig.cssOutput + '/added.css', './')

            .styles([
                //adminConfig.cssOutput + '/app.css',
                adminConfig.bowerDir + '/font-awesome/css/font-awesome.css',
                adminConfig.assetsDir + 'vendor/css/dataTables.bootstrap.css',
                adminConfig.assetsDir + 'vendor/css/datatables.responsive.css',
                adminConfig.bowerDir + '/metisMenu/dist/metisMenu.min.css',
                adminConfig.bowerDir + '/select2/select2.css',
                adminConfig.bowerDir + '/select2-bootstrap-css/select2-bootstrap.css',
                adminConfig.bowerDir + '/fancybox/source/jquery.fancybox.css',
                adminConfig.bowerDir + '/jquery-ui/themes/base/jquery-ui.min.css',
                adminConfig.bowerDir + '/Jcrop/css/jquery.Jcrop.css',
            ], null, './')

            .scripts([
                adminConfig.assetsDir + 'js/added.js'
            ], adminConfig.jsOutput + '/added.js', './')

            .scripts([
                adminConfig.bowerDir + '/jquery-legacy/dist/jquery.min.js',
                adminConfig.bowerDir + '/bootstrap/dist/js/bootstrap.min.js',
                adminConfig.bowerDir + '/datatables/media/js/jquery.dataTables.min.js',
                adminConfig.assetsDir + 'vendor/js/dataTables.bootstrap.js',
                adminConfig.assetsDir + 'vendor/js/datatables.responsive.js',
                adminConfig.bowerDir + '/metisMenu/dist/metisMenu.min.js',
                adminConfig.bowerDir + '/jquery-pjax/jquery.pjax.js',
                adminConfig.bowerDir + '/bootbox/bootbox.js',
                adminConfig.bowerDir + '/select2/select2.js',
                adminConfig.bowerDir + '/fancybox/source/jquery.fancybox.pack.js',
                adminConfig.bowerDir + '/jquery-ui/jquery-ui.min.js',
                adminConfig.bowerDir + '/underscore/underscore-min.js',
                adminConfig.bowerDir + '/Jcrop/js/jquery.Jcrop.min.js',
            ], null, './')

            .version([
                adminConfig.cssOutput + '/all.css',
                adminConfig.jsOutput + '/all.js',
                adminConfig.cssOutput + '/added.css',
                adminConfig.jsOutput + '/added.js',
            ]);
    });

    multiCopy(
        [
            adminConfig.bowerDir + '/font-awesome/fonts',
            adminConfig.bowerDir + '/bootstrap/fonts',
        ],
        [adminBuildDir + '/fonts/', adminDir + '/fonts/']
    );

    gulpCopy(
        [
            adminConfig.bowerDir + '/select2/select2.png',
            adminConfig.bowerDir + '/select2/select2x2.png',
            adminConfig.bowerDir + '/select2/select2-spinner.gif',
        ],
        [adminBuildDir + '/css/', adminDir + '/css/']
    );

    gulpCopy(
        [adminConfig.bowerDir + '/fancybox/source/*.{gif,png}'],
        [adminBuildDir + '/css/', adminDir + '/css/']
    );

    gulpCopy(
        [adminConfig.assetsDir + 'images/**/*'],
        [adminBuildDir + '/images/', adminDir + '/images/']
    );

    gulpCopy(
        [adminConfig.bowerDir + '/jquery-ui/themes/base/images/**/*'],
        [adminBuildDir + '/images/', adminDir + '/images/']
    );

    gulpCopy(
        [
            adminConfig.bowerDir + '/ckeditor/**/*',
            '!' + adminConfig.bowerDir + '/ckeditor/samples{,/**}',
        ],
        [adminDir + '/vendor/ckeditor']
    );

    gulpCopy(
        [adminConfig.bowerDir + '/Jcrop/css/Jcrop.gif'],
        [adminBuildDir + '/css/', adminDir + '/css/']
    );
}


/*
 |--------------------------------------------------------------------------
 | Module
 |--------------------------------------------------------------------------
 */

if (moduleLower) {

    var moduleConfig = {
        srcDir: 'app',
        //assetsDir: 'resources/admin/',
        assetsDir: 'app/Modules/' + moduleUpper + '/assets/',
        cssOutput: 'public/assets/' + moduleLower + '/css',
        jsOutput: 'public/assets/' + moduleLower + '/js',
        bowerDir: 'bower_components'
    }

    elixir.config = objMerge(elixir.config, moduleConfig);

    var moduleDir = 'public/assets/' + moduleLower;
    var moduleBuildDir = 'public/build/assets/' + moduleLower;

    // Main admin mix
    elixir(function (mix) {
        mix.less('app.less')

            .styles([
                moduleConfig.bowerDir + '/font-awesome/css/font-awesome.css'
            ], null, './')

    });

}

elixir(function (mix) {
    mix.gulper();
});



