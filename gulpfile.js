process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');

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

elixir.config.sourcemaps = false;

var paths = {
    'jquery': './bower_components/jquery/',
    'bootstrap': './bower_components/bootstrap-sass-official/assets/'
};

elixir(function(mix) {
	//mix.less('app.less');

    // compile scss files from resources/assets/sass
	mix.sass("main.scss", 'public/css/', {includePaths: [paths.bootstrap + 'stylesheets/']});

    // add more if need be
    //mix.sass("<filename>.scss", 'public/css/', {includePaths: [paths.bootstrap + 'stylesheets/']});

    // copy over bootstrap fonts
    mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts');

    // combine bootstrap and jquery scripts into public/js/app.js
    mix.scripts([
	    paths.jquery + "dist/jquery.js",
	    paths.bootstrap + "javascripts/bootstrap.js"
	], 'public/js/app.js', './');
});
