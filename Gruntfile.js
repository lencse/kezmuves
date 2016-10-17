module.exports = function(grunt) {

    var sassOptions = {
        sassDir: 'readable-theme/sass',
        javascriptsDir: 'readable-theme/scripts',
        outputStyle: 'nested',
        relativeAssets: true,
        importPath: 'readable-theme/bower_components',
        debugInfo: false
    };

	if (process.env.VAGRANT_BOX) {
		sassOptions.cacheDir =  '../'.repeat((__dirname.match(/\//g) || []).length) + 'tmp/sass';
	}

	// Auto-load the neede grunt tasks
	// require('load-grunt-tasks')(grunt);
	require('load-grunt-tasks')(grunt, {pattern: ['grunt-*', 'assemble']});

	// Project configuration
	grunt.initConfig({

		// Run predefined tasks whenever watched file patterns are added, changed or deleted
		watch: {
			options: {
				livereload: true,
				spawn:      false
			},

			// Watch .hbs (html) files
			assemble: {
				files: ['readable-theme/assemble/{,*/}*.hbs'],
				tasks: ['newer:assemble:dev'],
			},

			// autoprefix the files
			autoprefixer: {
				files: ['readable-theme/stylesheets/*.css'],
				tasks: ['autoprefixer:dev'],
			},

			// watch other files
			other: {
				files: [
					'readable-theme/scripts/{,*/}*.js'
				]
			}
		},

		// Assemble convert .hbs to .html
		// https://github.com/assemble/assemble/
		assemble: {
			options: {
				assets:   'assets',
				plugins:  [],
				partials: ['readable-theme/assemble/includes/*.hbs'],
				data:     'db.yml'
			},
			dev: {
				files: [{
					expand: true,
					cwd:    'readable-theme/assemble',
					src:    ['*.hbs'],
					dest:   'readable-theme/'
				}]
			},
			build: {
				options: {
					data:        ['buildData.yml'],
					production:  true,
					postprocess: require('pretty')
				},
				files: [{
					expand: true,
					cwd:    'readable-theme/assemble',
					src:    ['*.hbs'],
					dest:   'web/readable-theme/'
				}]
			}
		},

		// Compass convert .scss to .css
		// https://github.com/gruntjs/grunt-contrib-compass
		compass: {
			options: sassOptions,
			dev: {
				options: {
					imagesDir:      'readable-theme/images',
					cssDir:         'readable-theme/stylesheets',
					environment:    'development',
					noLineComments: false,
					watch:          true
				},
				files: [{
					expand: true,
					cwd:    'readable-theme/sass/',
					src:    '{,*/}*.scss',
					dest:   'readable-theme/stylesheets',
					ext:    '.css'
				}]
			},
			build: {
				options: {
					imagesDir:      'web/readable-theme/images',
					cssDir:         'web/readable-theme/stylesheets',
					environment:    'production',
					noLineComments: true,
					watch:          false
				},
				files: [{
					expand: true,
					cwd:    'readable-theme/sass/',
					src:    '{,*/}*.scss',
					dest:   'web/readable-theme/stylesheets',
					ext:    '.css'
				}]
			}
		},

		// Parse CSS and add vendor-prefixed CSS properties using the Can I Use database. Based on Autoprefixer.
		// https://github.com/nDmitry/grunt-autoprefixer
		autoprefixer: {
			dev: {
				files: [{
					expand: true,
					cwd:    'readable-theme/stylesheets/',
					src:    '*.css',
					dest:   'readable-theme/stylesheets'
				}]
			},
			build: {
				files: [{
					expand: true,
					cwd:    'web/readable-theme/stylesheets/',
					src:    '*.css',
					dest:   'web/readable-theme/stylesheets'
				}]
			}
		},

		// Minify PNG, JPG and GIF images
		// https://github.com/gruntjs/grunt-contrib-imagemin
		imagemin: {
			options: {
				progressive: true,
			},
			build: {
				files: [{
					expand: true,
					cwd:    'web/readable-theme/images',
					src:    ['**/*.{png,gif,jpg,jpeg}'],
					dest:   'web/readable-theme/images'
				}]
			}
		},

		// requireJS optimizer
		// https://github.com/gruntjs/grunt-contrib-requirejs
		requirejs: {
			build: {
				// Options: https://github.com/jrburke/r.js/blob/master/build/example.build.js
				options: {
					baseUrl:                 'readable-theme/scripts',
					mainConfigFile:          'readable-theme/scripts/main.js',
					optimize:                'uglify2',
					preserveLicenseComments: false,
					useStrict:               true,
					wrap:                    true,
					name:                    '../bower_components/almond/almond',
					include:                 'main',
					out:                     'web/readable-theme/js/main.js'
				}
			}
		},

		// https://github.com/yeoman/grunt-usemin
		useminPrepare: {
			html: 'web/readable-theme/index.html',
			options: {
				dest: 'web/readable-theme'
			}
		},
		usemin: {
			html: ['web/readable-theme/{,*/}*.html'],
			css:  ['web/readable-theme/stylesheets/{,*/}*.css']
		},

		// rename the files based on the content
		// https://github.com/cbas/grunt-rev
		//rev: {
		//	files: {
		//		src: ['web/readable-theme/stylesheets/*.css']
		//	}
		//},

		// concurrent
		// https://github.com/sindresorhus/grunt-concurrent
		concurrent: {
			dev: ['compass:dev', 'watch']
		},

		// clean the build dir
		// https://github.com/gruntjs/grunt-contrib-clean
		clean: {
			beforebuild: ['web/readable-theme'],
			afterBuild:  ['.tmp']
		},

		// copy some files not handled by other tasks
		// https://github.com/gruntjs/grunt-contrib-copy
		copy: {
			build: {
				files: [{
					expand: true,
					cwd:    'readable-theme/bower_components',
					src:    ['sass-bootstrap/fonts/*'],
					dest:   'web/readable-theme/bower_components'
				},
				{
					expand: true,
					cwd:    'readable-theme/assets/zocial/css',
					src:    ['*'],
					dest:   'web/readable-theme/assets/zocial/css'
				},
				 {
				 	expand: true,
				 	cwd:    'readable-theme/images',
				 	src:    ['**/*.{png,gif,jpg,jpeg}'],
				 	dest:   'web/readable-theme/images'
				 },
				{
					'web/readable-theme/assets/blur.svg': 'readable-theme/assets/blur.svg'
				}]
			}
		},
	});

	// Default task(s).
	grunt.registerTask('default', [
		'newer:assemble:dev',
		'autoprefixer:dev',
		'concurrent:dev'
	]);

	// building
	grunt.registerTask('build', [
		'clean:beforebuild',
		'copy:build',
		'newer:assemble:build',
		'newer:imagemin:build',
		'compass:build',
		'newer:autoprefixer:build',
		'requirejs',
		'useminPrepare',
		'concat', // automatically configured by usemin
		'cssmin', // automatically configured by usemin
		//'rev',
		'usemin',
		'clean:afterBuild'
	]);
};