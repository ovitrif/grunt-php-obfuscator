/*
 * grunt-phpobfuscator
 * https://github.com/designst/grunt-phpobfuscator
 *
 * Copyright (c) 2014 designst
 * Licensed under the MIT license.
 */

'use strict';

//noinspection JSUnresolvedFunction
var exec = require('child_process').exec;

//noinspection JSUnresolvedVariable
module.exports = function(grunt) {
    //noinspection JSUnresolvedFunction
    grunt.registerMultiTask('phpobfuscator', 'Grunt plugin for PHP obfuscation.', function() {
        // Iterate over all specified file groups.
        this.files.forEach(function(f) {
            // Concat specified files.
            var src = f.src.filter(function(filepath) {
                // Warn on and remove invalid source files (if nonull was set).
                //noinspection JSUnresolvedVariable,JSUnresolvedFunction
                if (!grunt.file.exists(filepath)) {
                    grunt.log.warn('Source file "' + filepath + '" not found.');
                    return false;
                } else {
                    return true;
                }
            });

            src.forEach(function(s) {
                //noinspection JSUnresolvedVariable
                exec(__dirname + '/../bin/phpobfuscator ' + s, function(error, stdout, stderr) {

                });
            });
        });
    });
};