module.exports = function(grunt){

    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);

    var _configs = {
        pkg      : grunt.file.readJSON('package.json'),
        banner   : '/*! Town Of Jackson; Build: v<%= pkg.version %>; Author: <%= pkg.author.name %> */\n',
        filename : '%<= pkg.name %>',
        bump     : {options: {commit: false, push: false}},
        concat   : {},
        strip    : {},
        uglify   : {},
        sass     : {},
        watch    : {},
        jshint   : {
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
                globals: {
                    Modernizr: true,
                    TweenLite: true,
                    TweenMax: true,
                    Power4: true,
                    $: true
                }
            }
        }
    };

    require('../web/packages/toj/grunt_settings.js').buildSettings(grunt, _configs);

    grunt.initConfig(_configs);

    grunt.registerTask('default', []);

    /**
     * Every package's grunt_settings.js should register at least two tasks with
     * format: grunt.registerTask('{package_handle}_{environment}', [...]);
     */
    grunt.registerTask('package', 'Build package X for environment Y', function(_package, _environment){
        grunt.log.writeln('Building %s %s environment', _package, _environment);
        grunt.task.run( _package + '_' + _environment );
    });

}