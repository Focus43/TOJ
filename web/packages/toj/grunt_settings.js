module.exports.buildSettings = function(grunt, _configs){

    // Generate path to file in package root
    function pkgPath( _path ){
        var _pkgPath = '../web/packages/toj/%s';
        return _pkgPath.replace('%s', _path);
    }


    /////////////////////////////// CONCAT FILES ///////////////////////////////
    _configs.concat.toj = { files: {} };

    // theme
    _configs.concat.toj.files[ pkgPath('js/application.js') ] = [
        pkgPath('bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js'),
        pkgPath('bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js'),
        pkgPath('bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js'),
        pkgPath('bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js'),
        pkgPath('bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js'),
        pkgPath('bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/popover.js'),
        pkgPath('bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js'),
        pkgPath('bower_components/simpleWeather/jquery.simpleWeather.js'),
        pkgPath('js/build_src/custom_components/session_storage.js'),
        pkgPath('js/build_src/modernizr-rules.js'),
        pkgPath('js/build_src/application.js')
    ];

    // homepage
    _configs.concat.toj.files[ pkgPath('js/home-parallax.js') ] = [
        pkgPath('bower_components/gsap/src/uncompressed/TweenLite.js'),
        pkgPath('bower_components/gsap/src/uncompressed/plugins/CSSPlugin.js'),
        pkgPath('bower_components/gsap/src/uncompressed/easing/EasePack.js'),
        pkgPath('bower_components/perfect-scrollbar/src/jquery.mousewheel.js'),
        pkgPath('bower_components/perfect-scrollbar/src/perfect-scrollbar.js'),
        pkgPath('js/build_src/home-parallax.js')
    ];

    // modernizr
    _configs.concat.toj.files[ pkgPath('js/modernizr.js') ] = [
        pkgPath('js/build_src/custom_components/modernizr.min.js')
    ];

    // single page: current
    _configs.concat.toj.files[ pkgPath('js/single_pages/current.js') ] = [
        pkgPath('bower_components/masonry/dist/masonry.pkgd.js'),
        pkgPath('js/build_src/single_pages/current.js')
    ];

    // single page: agendas
    _configs.concat.toj.files[ pkgPath('js/single_pages/agendas.js') ] = [
        pkgPath('js/build_src/single_pages/agendas.js')
    ];


    /////////////////////////////// JS LINT ///////////////////////////////
    _configs.jshint.toj = {
        options: {},
        files: {
            src: [pkgPath('js/build_src/*.js')]
        }
    };


    /////////////////////////////// STRIP + UGLIFY FILES ///////////////////////////////
    _configs.strip.toj = {
        options: {
            nodes: ['console.log', 'console.time', 'console.timeEnd']
        },
        files : {}
    }

    _configs.uglify.toj = {
        options: {
            banner: '<%= banner %>',
            expand: true
        },
        files: {}
    };

    Object.keys(_configs.concat.toj.files).forEach(function(script){
        _configs.strip.toj.files[ script ] = script;
        _configs.uglify.toj.files[ script ] = script;
    });


    /////////////////////////////// SASS BUILDS ///////////////////////////////
    _configs.sass.toj = {
        options: {
            style: 'compressed',
            compass: true // @todo: might need to update Vagrantfile to auto-install compass
        },
        files : [
            // core
            {src: [pkgPath('css/build_src/manifest.scss')], dest: pkgPath('css/application.css')},
            // single pages
            {
                expand  : true,
                cwd     : pkgPath('css/build_src'),
                src     : ['unique/**.scss'],
                dest    : pkgPath('css'),
                ext     : '.css'
            }
        ]
    }


    /////////////////////////////// WATCH TASKS ///////////////////////////////
    var _watchableJS = [].concat.apply([], Object.keys(_configs.concat.toj.files).map(function(key){
        return _configs.concat.toj.files[key];
    }));

    _configs.watch.options = {
        spawn: false,
        interval: 5007
    }

    _configs.watch.toj_js = {
        files : _watchableJS,
        tasks : ['jshint:toj', 'newer:concat:toj']
    };

    _configs.watch.toj_sass = {
        files : [pkgPath('css/**/*.scss')],
        tasks : ['sass:toj']
    };

    _configs.watch.toj_css = {
        options : {livereload: 9090},
        files   : [pkgPath('css/**/*.css')],
        tasks   : []
    };


    /////////////////////////////// CUSTOM TASKS ///////////////////////////////
    grunt.registerTask('toj_dev', ['jshint:toj', 'concat:toj', 'sass:toj']);
    grunt.registerTask('toj_release', ['jshint:toj', 'concat:toj', 'strip:toj', 'uglify:toj', 'sass:toj']);

}