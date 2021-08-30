const wordpress_config = require( '@wordpress/scripts/config/webpack.config.js' );

// Add include paths to SASS loader.
sass_loader_include_paths:
for ( const rule of wordpress_config.module.rules ) {
	if ( ! Array.isArray( rule.use ) ) {
		continue;
	}

	for ( const use of rule.use ) {
		if ( Object.prototype.toString.call( use ) !== '[object Object]' ) {
			continue;
		}

		if ( use.loader.includes( 'sass-loader' ) ) {
			use.options.sassOptions = {
				includePaths: [
					'resources/sass/'
				]
			};

			break sass_loader_include_paths;
		}
	}
}

module.exports = wordpress_config;
