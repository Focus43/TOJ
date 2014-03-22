module.exports.buildSettings = function(grunt, _configs){

    // Generate path to file in package root
    function pkgPath( _path ){
        var _pkgPath = '../web/packages/toj/%s';
        return _pkgPath.replace('%s', _path);
    }


    /////////////////////////////// CONCAT FILES ///////////////////////////////
    _configs.concat.toj = { files: {} };

    // theme
    _configs.concat.toj.files[ pkgPath('js/compiled/toj.js') ] = [
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


    /////////////////////////////// JS LINT ///////////////////////////////
    _configs.jshint.toj = {
        options: {},
        files: {
            src: [pkgPath('js/*.js'), pkgPath('js/home/parallax.js')]
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

    var _targets = [
        pkgPath('js/compiled/toj.js'),
        pkgPath('js/compiled/parallax.js'),
        pkgPath('js/compiled/modernizr.js')
    ];

    for( var i = 0; i < _targets.length; i++ ){
        _configs.strip.toj.files[ _targets[i] ] = _targets[i];
        _configs.uglify.toj.files[ _targets[i] ] = _targets[i];
    };


    /////////////////////////////// SASS BUILDS ///////////////////////////////
    _configs.sass.toj = {
        options: {
            style: 'compressed',
            compass: false // @todo: auto-install compass in Vagrant to enable
        },
        files: [
            // theme
            {src: [pkgPath('css/build_manifest.scss')], dest: pkgPath('css/compiled/toj.css')},
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
        tasks : ['jshint:toj', 'newer:concat:toj']
    };

    _configs.watch.toj_sass = {
        files : [pkgPath('css/**/*.scss')],
        tasks : ['sass:toj']
    };

    _configs.watch.toj_css = {
        options : {livereload: 9090},
        files   : [pkgPath('css/compiled/*.css')],
        tasks   : []
    };


    /////////////////////////////// CUSTOM TASKS ///////////////////////////////
    grunt.registerTask('toj_dev', ['jshint:toj', 'concat:toj', 'sass:toj', 'bump:minor']);
    grunt.registerTask('toj_release', ['jshint:toj', 'concat:toj', 'strip:toj', 'uglify:toj', 'sass:toj', 'bump:major']);

}