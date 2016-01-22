var elixir = require('laravel-elixir');

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

elixir.config.sourcemaps = false;

elixir(function(mix) {

	//-------------------------------------------------------------
	// COPY RESOURCES
	//-------------------------------------------------------------

		// // foundation and it's dependencies

		// mix.copy('bower_components/jquery/dist/jquery.min.js', 'resources/assets/js/jquery.min.js'); // jquery

		// mix.copy('bower_components/what-input/what-input.min.js', 'resources/assets/js/what-input.min.js'); // what-input

		// mix.copy('bower_components/foundation-sites/dist/foundation.min.js', 'resources/assets/js/foundation.min.js');
		// mix.copy('bower_components/foundation-sites/scss', 'resources/assets/sass/foundation-sites');

		// // angular js

		// mix.copy('bower_components/angular/angular.min.js', 'resources/assets/js/angular.min.js');

		// // motion ui
		mix.copy('bower_components/motion-ui/dist/motion-ui.min.css', 'resources/assets/css/motion-ui.min.css');
		mix.copy('bower_components/motion-ui/dist/motion-ui.min.js', 'resources/assets/js/motion-ui.min.js');
		mix.copy('bower_components/motion-ui/src', 'resources/assets/sass/motion-ui');


	//-------------------------------------------------------------
	// COMPILE SASS & COFFEE
	//-------------------------------------------------------------

		// compile sass

	    mix.rubySass('foundation-sites.scss', 'resources/assets/css', null);
	    mix.rubySass('app.scss', 'resources/assets/css', null);

	    // compile coffee

	    mix.coffee('finder.coffee', 'resources/assets/js', null);
	    mix.coffee('issues.coffee', 'resources/assets/js', null);
	    mix.coffee('helpers.coffee', 'resources/assets/js', null);
	    mix.coffee('config.coffee', 'resources/assets/js', null);


    //-------------------------------------------------------------
    // COMBINE STYLES & JS
    //-------------------------------------------------------------

    	// seldom styles & scripts


	    // combine styles

	    mix.styles([
	    	'foundation-sites.css',
	    	'motion-ui.min.css',
	    	'app.css'
		], 'public/css/base.css');

		// combine scripts

		mix.scripts([
			'jquery.min.js',
	    	'what-input.min.js',
			'foundation.min.js',
			'motion-ui.min.js',
			'angular.min.js',
			'helpers.js',
			'config.js',
			'finder.js',
			'issues.js'
		], 'public/js/base.js');
});
