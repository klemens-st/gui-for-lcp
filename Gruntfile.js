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
        fonts: 'gui-for-lcp/admin/assets/fonts'
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
        '.jshintrc',
        '.sass-cache/',
        'node_modules/',
        'gui-for-lcp/admin/assets/sass/',
        'gui-for-lcp/admin/assets/js/admin.js',
        'Gruntfile.js',
        'README.md',
        'package.json',
        '*.zip'
      ]
    },

    eslint: {
      target: [
        'Gruntfile.js',
        '<%= dirs.admin.js %>/**',
      ]
    },

    // uglify to concat and minify
    uglify: {
      dist: {
        options: {
          sourceMap: {
            url: 'inline'
          },
          wrap: 'gflcp'
        },
        files: {
          '<%= dirs.admin.js %>/admin.min.js': [
            '<%= dirs.admin.js %>/gflcp-mainmodel.js',
            '<%= dirs.admin.js %>/gflcp-taxtermssubview.js',
            '<%= dirs.admin.js %>/gflcp-modalcontentview.js',
            '<%= dirs.admin.js %>/gflcp-shortcode.js',
            '<%= dirs.admin.js %>/gflcp-admin.js',

          ],
        }
      }
    },

    // compass and scss
    compass: {
      options: {
        httpPath: '',
        environment: 'production',
        relativeAssets: true,
        noLineComments: true,
        outputStyle: 'compressed'
      },
      admin: {
        options: {
          sassDir: '<%= dirs.admin.sass %>',
          cssDir: '<%= dirs.admin.css %>',
          imagesDir: '<%= dirs.admin.images %>',
          javascriptsDir: '<%= dirs.admin.js %>',
          fontsDir: '<%= dirs.admin.fonts %>'
        }
      },
    },

    // watch for changes and trigger compass, jshint and uglify
    watch: {
      compass: {
        files: [
          '<%= compass.admin.options.sassDir %>/**',
        ],
        tasks: ['compass:admin']
      },
      js: {
        files: '<%= eslint.target %>',
        tasks: ['eslint', 'uglify']
      }
    },

    // image optimization
    imagemin: {
      dist: {
        options: {
          optimizationLevel: 7,
          progressive: true
        },
        files: [
          {
            expand: true,
            cwd: '<%= dirs.admin.images %>/',
            src: '**/*.{png,jpg,gif}',
            dest: '<%= dirs.admin.images %>/'
          },
          {
            expand: true,
            cwd: './',
            src: 'screenshot-*.png',
            dest: './'
          }
        ]
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
    'compass',
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
