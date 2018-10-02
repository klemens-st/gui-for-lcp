/*eslint indent: ["error", 2] */
/* global module, require */
'use strict';

module.exports = function( grunt ) {

  // auto load grunt tasks
  require( 'load-grunt-tasks' )( grunt );

  var pluginConfig = {

    // gets the package vars
    pkg: grunt.file.readJSON( 'package.json' ),

    // plugin directories
    dirs: {
      admin: {
        js: 'gui-for-lcp/admin/assets/js',
        css: 'gui-for-lcp/admin/assets/css',
        sass: 'gui-for-lcp/admin/assets/sass',
        images: 'gui-for-lcp/admin/assets/images',
      },
    },

    // svn settings
    svn_settings: {
      path: '/PATH/TO/YOUR/SVN/REPO/<%= pkg.name %>',
      tag: '<%= svn_settings.path %>/tags/<%= pkg.version %>',
      trunk: '<%= svn_settings.path %>/trunk',
      exclude: [
        '.editorconfig',
        '.git/',
        '.gitignore',
        '.eslintrc',
        '.sass-cache/',
        'node_modules/',
        'gui-for-lcp/admin/assets/js/dist/admin.js',
        'Gruntfile.js',
        'README.md',
        'package.json',
        '*.zip'
      ]
    },

    eslint: {
      target: [
        'Gruntfile.js',
        '<%= dirs.admin.js %>/*.js',
      ]
    },

    browserify: {
      dist: {
        src: '<%= dirs.admin.js %>/*.js',
        dest: '<%= dirs.admin.js %>/dist/admin.js',
        options: {
          transform: [
            ['babelify', {
              sourceMaps: true,
              presets: ['babel-preset-env'],
            }]
          ],
          browserifyOptions: {debug: true}
        }
      },
    },

    // uglify to concat and minify
    uglify: {
      dist: {
        options: {
          sourceMap: {
            content: 'inline',
            root: '/'
          },
        },
        files: {
          '<%= dirs.admin.js %>/dist/admin.min.js': [
            '<%= dirs.admin.js %>/dist/admin.js',
          ],
        }
      }
    },

    // scss
    sass: {
      dist: {
        options: {
          style: 'compressed'
        },
        src: '<%= dirs.admin.sass %>/admin.scss',
        dest: '<%= dirs.admin.css %>/admin.css'
      }
    },

    autoprefixer: {
      dist: {
        options: {
          map: true
        },
        src: '<%= dirs.admin.css %>/admin.css',
        dest: '<%= dirs.admin.css %>/admin.css'
      }
    },

    // watch for changes and trigger compass, jshint and uglify
    watch: {
      sass: {
        files: [
          '<%= dirs.admin.sass %>/**',
        ],
        tasks: ['sass', 'autoprefixer']
      },
      js: {
        files: '<%= eslint.target %>',
        tasks: ['eslint', 'browserify', 'uglify']
      }
    },

    // rsync commands used to take the files to svn repository
    rsync: {
      options: {
        args: ['--verbose'],
        exclude: '<%= svn_settings.exclude %>',
        syncDest: true,
        recursive: true
      },
      tag: {
        options: {
          src: './gui-for-lcp/',
          dest: '<%= svn_settings.tag %>'
        }
      },
      trunk: {
        options: {
          src: './gui-for-lcp/',
          dest: '<%= svn_settings.trunk %>'
        }
      }
    },

    // shell command to commit the new version of the plugin
    shell: {
      // Remove delete files.
      svn_remove: {
        command: 'svn st | grep \'^!\' | awk \'{print $2}\' | xargs svn --force delete',
        options: {
          stdout: true,
          stderr: true,
          execOptions: {
            cwd: '<%= svn_settings.path %>'
          }
        }
      },
      // Add new files.
      svn_add: {
        command: 'svn add --force * --auto-props --parents --depth infinity -q',
        options: {
          stdout: true,
          stderr: true,
          execOptions: {
            cwd: '<%= svn_settings.path %>'
          }
        }
      },
      // Commit the changes.
      svn_commit: {
        command: 'svn commit -m "updated the plugin version to <%= pkg.version %>"',
        options: {
          stdout: true,
          stderr: true,
          execOptions: {
            cwd: '<%= svn_settings.path %>'
          }
        }
      }
    }
  };

  // initialize grunt config
  // --------------------------
  grunt.initConfig( pluginConfig );

  // register tasks
  // --------------------------

  // default task
  grunt.registerTask( 'default', [
    'eslint',
    'sass',
    'autoprefixer',
    'browserify',
    'uglify'
  ] );

  // deploy task
  grunt.registerTask( 'deploy', [
    'default',
    'rsync:tag',
    'rsync:trunk',
    'shell:svn_remove',
    'shell:svn_add',
    'shell:svn_commit'
  ] );
};
