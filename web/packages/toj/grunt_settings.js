module.exports.buildSettings = function(grunt, _configs){

    // Generate path to file in package root
    function pkgPath( _path ){
        var _pkgPath = '../web/packages/toj/%s';
        return _pkgPath.replace('%s', _path);
    }


    /////////////////////////////// CONCAT FILES ///////////////////////////////
    _configs.concat.toj = { files: {} };

    // theme
    _configs.concat.toj.files[ pkgPath('js/compiled/<%= filename %>.js') ] = [
        pkgPath('js/libs/*.js'),
        pkgPath('js/session_storage.js'),
        pkgPath('js/app.js')
    ];

    // homepage
    _configs.concat.toj.files[ pkgPath('js/compiled/parallax.js') ] = [
        pkgPath('js/home/*.js')
    ];

    // modernizr
    _configs.concat.toj.files[ pkgPath('js/compiled/modernizr.js') ] = [
        pkgPath('js/modernizr/*.js')
    ];


    /////////////////////////////// UGLIFY FILES ///////////////////////////////
    _configs.uglify.toj = {
        options: {
            banner: '<%= banner %>',
            expand: true
        },
        files: {}
    };

    var _uglifyTargets = [
        pkgPath('js/compiled/<%= filename %>.js'),
        pkgPath('js/compiled/parallax.js'),
        pkgPath('js/compiled/modernizr.js')
    ];

    for( var i = 0; i < _uglifyTargets.length; i++ ){
        _configs.uglify.toj.files[ _uglifyTargets[i] ] = _uglifyTargets[i];
    };


    /////////////////////////////// SASS BUILDS ///////////////////////////////
    _configs.sass.toj = {
        options: {
            style: 'compressed',
            compass: true
        },
        files: [
            // theme
            {src: [pkgPath('css/build_manifest.scss')], dest: pkgPath('css/compiled/<%= filename %>-min.css')},
            // parallax
            {src: [pkgPath('css/independent/parallax.scss')], dest: pkgPath('css/compiled/parallax.css')},
            // singlepage: current
            {src: [pkgPath('css/independent/singlepage-current.scss')], dest: pkgPath('css/compiled/singlepage-current.css')}
        ]
    };


    /////////////////////////////// WATCH TASKS ///////////////////////////////
    var _watchableJS = [].concat.apply([], Object.keys(_configs.concat.toj.files).map(function(key){
        return _configs.concat.toj.files[key];
    }));

    _configs.watch.toj_js = {
        files : _watchableJS,
        tasks : ['newer:concat:toj']
    };

    _configs.watch.toj_sass = {
        files : [pkgPath('css/**/*.scss')],
        tasks : ['newer:sass:toj']
    };

    _configs.watch.toj_css = {
        options : {livereload: 9090},
        files   : [pkgPath('css/compiled/*.css')],
        tasks   : []
    };


    /////////////////////////////// CUSTOM TASKS ///////////////////////////////
    grunt.registerTask('toj-dev', ['concat:toj', 'sass:toj', 'bump:minor']);
    grunt.registerTask('toj-release', ['concat:toj', 'uglify:toj', 'sass:toj', 'bump:major']);

}

return;

module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        // Metadata.
        pkg: grunt.file.readJSON('package.json'),
        banner: '/*!***** <%= pkg.project %> // Build v:<%= pkg.version %> (<%= grunt.template.today("yyyy-mm-dd") %>), @auth: <%= pkg.author.name %> (<%= pkg.author.url %>) ******/\n;',
        filename: '<%= pkg.name %>',
        // Task configuration.
//        concat: {
//            options: {
//                banner: '<%= banner %>',
//                stripBanners: true
//            },
//            dist: {
//                src: ['../web/packages/toj/js/libs/*.js', '../web/packages/toj/js/session_storage.js', '../web/packages/toj/js/app.js'],
//                dest: '../web/packages/toj/js/compiled/<%= filename %>-dev.js'
//            },
//            home: {
//                src: ['../web/packages/toj/js/home/*.js'],
//                dest: '../web/packages/toj/js/compiled/parallax.js'
//            },
//            mdnzr: {
//                src: ['../web/packages/toj/js/modernizr/*.js'],
//                dest: '../web/packages/toj/js/compiled/modernizr.js'
//            }
//        },
        strip: {
            main : {
                src : '<%= concat.dist.dest %>',
                dest : '../web/packages/toj/js/compiled/<%= filename %>-min.js'
            },
            home : {
                src: '../web/packages/toj/js/compiled/parallax.js',
                dest: '../web/packages/toj/js/compiled/parallax.js'
            },
            mdnzr: {
                src: '../web/packages/toj/js/compiled/modernizr.js',
                dest: '../web/packages/toj/js/compiled/modernizr.js'
            }
        },
//        uglify: {
//            options: {
//                banner: '<%= banner %>'
//            },
//            dist: {
//                src: '<%= strip.main.dest %>',
//                dest: '<%= strip.main.dest %>'
//            },
//            home: {
//                src: '../web/packages/toj/js/compiled/parallax.js',
//                dest: '../web/packages/toj/js/compiled/parallax.js'
//            },
//            mdnzr: {
//                src: '../web/packages/toj/js/compiled/modernizr.js',
//                dest: '../web/packages/toj/js/compiled/modernizr.js'
//            }
//        },
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
                    '../web/packages/toj/css/compiled/<%= filename %>-min.css': '../web/packages/toj/css/build_manifest.scss',
                    '../web/packages/toj/css/compiled/parallax.css': '../web/packages/toj/css/independent/parallax.scss',
                    '../web/packages/toj/css/compiled/singlepage-current.css': '../web/packages/toj/css/independent/singlepage-current.scss',
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
            build_modernizr_js: {
                files: ['../web/packages/toj/js/modernizr/*.js'],
                tasks: ['concat:mdnzr']
            },
            sassy_pants: {
                files: ['../web/packages/toj/css/*.scss', '../web/packages/toj/css/independent/*.scss'],
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