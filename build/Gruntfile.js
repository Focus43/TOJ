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
        src: ['../web/concrete/js/ccm.base.js', '../web/packages/toj/js/libs/bootstrap.min.js', '../web/packages/toj/js/toj.app.js'],
        dest: '../web/packages/toj/js/<%= filename %>.dev.js'
      }
    },
    strip: {
      main : {
        src : '<%= concat.dist.dest %>',
        dest : '../web/packages/toj/js/<%= filename %>.min.js'
      }
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: '<%= strip.main.dest %>',
        dest: '<%= strip.main.dest %>'
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
          cust_params: true,
          app: true,
          "$": true,
          fluid: true,
          asyncTest: true,
          deepEqual: true,
          equal: true,
          expect: true,
          module: true,
          notDeepEqual: true,
          notEqual: true,
          notStrictEqual: true,
          ok: true,
          QUnit: true,
          raises: true,
          start: true,
          stop: true,
          strictEqual: true,
          test: true
        }
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      lib_test: {
        src: ['../web/packages/toj/js/**/*.js'] // , 'test/**/*.js'
      }
    },
    sass: {
      build: {
        options: {
          style: 'compressed'
        },
        files: {
            '../web/packages/toj/css/<%= filename %>.min.css': '../web/packages/toj/css/manifest.scss'
        }
      }
    },
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      lib_test: {
        files: '<%= jshint.lib_test.src %>',
        tasks: ['default']
      },
      sassy_pants: {
        files: '../web/packages/**/*.scss',
        tasks: ['sass:build', 'bump']
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
  grunt.registerTask('default', ['concat', 'sass:build', 'bump']);
  //grunt.registerTask('build', ['jshint', 'concat', 'strip', 'uglify', 'sass:build', 'bump:minor']);
  grunt.registerTask('build', ['concat', 'strip', 'uglify', 'sass:build', 'bump:minor']);
  grunt.registerTask('release', ['jshint', 'concat', 'strip', 'uglify', 'sass:build', 'bump:major']);

};