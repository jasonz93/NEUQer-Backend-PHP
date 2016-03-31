var elixir = require('laravel-elixir');
require('laravel-elixir-ng-annotate');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var jsDeps = [
    '../dep/angular/angular.min.js',
    '../dep/angular-ui-router/release/angular-ui-router.min.js',
    '../dep/angular-resource/angular-resource.min.js',
    '../dep/angular-animate/angular-animate.min.js',
    '../dep/angular-aria/angular-aria.min.js',
    '../dep/angular-messages/angular-messages.min.js',
    '../dep/angular-material/angular-material.min.js'
];

var cssDeps = [
    '../dep/angular-material/angular-material.min.css'
];

var appScripts = [
    'wx3rd/app/**/*.modules.js',
    'wx3rd/app/**/*.js'
];

elixir(function(mix) {
    mix.scripts(jsDeps, 'public/js/dep.js');
    mix.styles(cssDeps, 'public/css/dep.css');
    mix.annotate(appScripts, 'public/js/wx3rd-annotated.js');
    mix.scripts('../../../public/js/wx3rd-annotated.js', 'public/js/wx3rd.min.js');
});
