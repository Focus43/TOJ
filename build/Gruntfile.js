module.exports = function(grunt){

    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);

    var _configs = {
        pkg      : grunt.file.readJSON('package.json'),
        banner   : '/*! Town Of Jackson; Build: v<%= pkg.version %>; Author: <%= pkg.author.name %> */\n',
        filename : '%<= pkg.name %>',
        concat   : {},
        strip    : {},
        uglify   : {},
        jshint   : {},
        sass     : {},
        watch    : {}
    };

    require('../web/packages/toj/grunt_settings.js').buildSettings(grunt, _configs);

    grunt.initConfig(_configs);

    grunt.registerTask('default', []);

}