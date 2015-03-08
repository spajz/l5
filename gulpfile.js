var gulp = require('gulp');
var elixir = require('laravel-elixir');
// gulp-util from elixir
var util = require('./node_modules/laravel-elixir/node_modules/gulp-util');

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

elixir.extend('copy2', function (src, output) {
    gulp.task('copy2', function () {
        var obj = gulp.src(src);
        output.forEach(function (value) {
            obj.pipe(gulp.dest(value));
        });
    });
    //this.registerWatcher("copy2", "**/*.php");
    return this.queueTask('copy2');
});

// Bootstrap
elixir(function (mix) {
    mix.less('app.less');

    mix.styles([
        adminConfig.assetsDir + 'css/added.css'
    ], adminConfig.cssOutput + '/added.css', './');

    mix.styles([
        adminConfig.cssOutput + '/app.css',
        adminConfig.bowerDir + '/font-awesome/css/font-awesome.css'
    ], null, './');

    mix.scripts([
        adminConfig.bowerDir + '/jquery-legacy/dist/jquery.min.js',
        adminConfig.bowerDir + '/bootstrap/dist/js/bootstrap.min.js'
    ], null, './');

    mix.version([
        adminConfig.cssOutput + '/all.css',
        adminConfig.jsOutput + '/all.js',
        adminConfig.cssOutput + '/added.css',
    ]);
});

elixir(function (mix) {
    mix.copy2([
            adminConfig.bowerDir + '/font-awesome/fonts/**/*',
            adminConfig.bowerDir + '/bootstrap/fonts/**/*'
        ], [adminBuildDir + '/fonts/', adminDir + '/fonts/']
    );
});

