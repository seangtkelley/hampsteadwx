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
    'jquery'              : './bower_components/jquery/',
    'bootstrap'           : './bower_components/bootstrap-sass-official/assets/',
    'select2'             : './bower_components/select2/dist/',
    'jqueryFileUpload'    : './bower_components/jquery-file-upload/',
    'jqueryUI'            : './bower_components/jquery-ui/',
    'chartjs'             : './bower_components/Chart.js/'
};

elixir(function(mix) {
	//mix.less('app.less');

  // compile scss files from resources/assets/sass
  mix.sass("main.scss", 'public/css/main.css', {includePaths: [paths.bootstrap + 'stylesheets/']});
  mix.sass("raw.scss", 'public/css/raw.css', {includePaths: [paths.bootstrap + 'stylesheets/']});

  // add more if need be
  //mix.sass("<filename>.scss", 'public/css/', {includePaths: [paths.bootstrap + 'stylesheets/']});

  // create the addons css
  mix.copy([
    paths.jqueryFileUpload + 'css/jquery.fileupload.css',
    paths.select2 + 'css/select2.css'
  ], 'resources/assets/css');
  mix.styles([
    'jquery.fileupload.css',
    'select2.css'
  ], 'public/css/addons.css');

  // copy over bootstrap fonts
  mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts');

  // combine bootstrap and jquery scripts into public/js/app.js
  mix.scripts([
    paths.jquery + "dist/jquery.js",
    paths.jqueryUI + "jquery-ui.js",
    paths.bootstrap + "javascripts/bootstrap.js",
    paths.jqueryFileUpload + 'js/jquery.iframe-transport.js',
    paths.jqueryFileUpload + 'js/jquery.fileupload.js',
    paths.jqueryFileUpload + 'js/jquery.fileupload-ui.js',
    paths.jqueryFileUpload + 'js/jquery.fileupload-jquery-ui.js',
    paths.jqueryFileUpload + 'js/jquery.fileupload-process.js',
    paths.jqueryFileUpload + 'js/jquery.fileupload-image.js',
    paths.jqueryFileUpload + 'js/jquery.fileupload-audio.js',
    paths.jqueryFileUpload + 'js/jquery.fileupload-video.js',
    paths.jqueryFileUpload + 'js/jquery.fileupload-validate.js',
    paths.select2 + 'js/select2.full.js',
    paths.chartjs + 'Chart.js'
  ], 'public/js/app.js', './');
});
