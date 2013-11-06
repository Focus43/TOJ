/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.project %> - Deploy v: <%= pkg.version %> (<%= grunt.template.today("yyyy-mm-dd") %>)\n' +
        'Author: <%= pkg.author.name %> (<%= pkg.author.url %>) */\n',
    filename: '<%= pkg.name %>',
    // Task configuration.
    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      },
      dist: {
        src: ['../web/packages/toj/js/libs/*.js', '../web/packages/toj/js/session_storage.js', '../web/packages/toj/js/app.js'],
        dest: '../web/packages/toj/js/compiled/<%= filename %>-dev.js'
      },
      home: {
        src: ['../web/packages/toj/js/home/*.js'],
        dest: '../web/packages/toj/js/compiled/parallax.js'
      }
    },
    strip: {
      main : {
        src : '<%= concat.dist.dest %>',
        dest : '../web/packages/toj/js/compiled/<%= filename %>-min.js'
      },
      home : {
        src: '../web/packages/toj/js/compiled/parallax.js',
        dest: '../web/packages/toj/js/compiled/parallax.js'
      }
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: '<%= strip.main.dest %>',
        dest: '<%= strip.main.dest %>'
      },
      home: {
        src: '../web/packages/toj/js/compiled/parallax.js',
        dest: '../web/packages/toj/js/compiled/parallax.js'
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        browser: true,
        devel: true,
        jquery: true,
        es5: true,
        globals: {
          Modernizr: true,
          TweenLite: true,
          TweenMax: true,
          $: true
        }
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      lib_test: {
        src: ['../web/packages/toj/js/session_storage.js', '../web/packages/toj/js/app.js'] // , 'test/**/*.js'
      }
    },
    sass: {
      build: {
        options: {
          style: 'compressed'
        },
        files: {
            '../web/packages/toj/css/compiled/<%= filename %>-min.css': '../web/packages/toj/css/app_manifest.scss',
            '../web/packages/toj/css/compiled/parallax.css': '../web/packages/toj/css/home/parallax.scss'
        }
      }
    },
    watch: {
      build_js: {
        files: '<%= jshint.lib_test.src %>',
        tasks: ['jshint:lib_test', 'concat']
      },
      build_home_js: {
        files: ['../web/packages/toj/js/home/*.js'],
        tasks: ['concat:home']
      },
      sassy_pants: {
        files: ['../web/packages/toj/css/*.scss', '../web/packages/toj/css/home/*.scss'],
        tasks: ['sass:build']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-strip');
  grunt.loadNpmTasks('grunt-bump');

  // Default task.
  grunt.registerTask('default', ['concat', 'sass:build']);
  grunt.registerTask('build', ['concat', 'strip', 'uglify', 'sass:build', 'bump:minor']);
  grunt.registerTask('release', ['jshint', 'concat', 'strip', 'uglify', 'sass:build', 'bump:major']);

};