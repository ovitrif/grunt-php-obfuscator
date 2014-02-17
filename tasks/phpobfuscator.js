/*
 * grunt-phpobfuscator
 * https://github.com/designst/grunt-phpobfuscator
 *
 * Copyright (c) 2014 designst
 * Licensed under the MIT license.
 */

'use strict';

//noinspection JSUnresolvedVariable
module.exports = function(grunt) {
    //noinspection JSUnresolvedFunction
    var path = require('path');
    //noinspection JSUnresolvedFunction
    var Hashids = require('hashids');
    //noinspection JSUnresolvedFunction
    var util = require('./lib/util')(grunt);

    var _classes = [];
    var _constants = [];
    var _functions = [];
    var _variables = [];

//    var regSComment = new RegExp('(\/\/)|(#(?=(?:[^\']|\'[^\']*\')*$)).+', 'g');
    var regSComment = new RegExp('(\/\/|[\\s*]#).+', 'g');
    var regMComment = new RegExp('(?:/\\*(?:[^*]|(?:\\*+[^*/]))*\\*+/)|(?://.*)', 'g');

    var regClass = new RegExp('[\\s*]class[\\s\\n]+(\\S+)[\\s\n]*\\{', 'g');
    var regConstant = new RegExp('define\\(\\s*\'([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\'', 'g');
    var regFunction = new RegExp('function[\\s\n]+(\\S+)[\\s\n]*\\(', 'g');
    var regVariable = new RegExp('(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)', 'g');

    function obfuscate(file, content, hashids, options) {
        if (options.comments) {
            // Preserve http://, files://, '//, "//
            content = content.replace(/:\/\//g, 'tHiSiSnOtAcOmMeNt0');
            content = content.replace(/'\/\//g, 'tHiSiSnOtAcOmMeNt1');
            content = content.replace(/"\/\//g, 'tHiSiSnOtAcOmMeNt2');

            content = content.replace(regSComment, '');
            content = content.replace(regMComment, '');

            // Restore http://, files://, '//, "//
            content = content.replace(/tHiSiSnOtAcOmMeNt0/g, '://');
            content = content.replace(/tHiSiSnOtAcOmMeNt1/g, '\'//');
            content = content.replace(/tHiSiSnOtAcOmMeNt2/g, '\"//');
        }

        if (options.minify) {
            content = content.replace(new RegExp('\\s+', 'g'), ' ');
            content = content.replace('; ', ';');
        }

        if (options.classes) {
            content = util.obfuscate(_classes, content, hashids);
        }

        if (options.constants) {
            content = util.obfuscate(_constants, content, hashids);
        }

        if (options.functions) {
            content = util.obfuscate(_functions, content, hashids);
        }

        if (options.variables) {
            content = util.obfuscate(_variables, content, hashids);
        }

        grunt.file.write(file.dest, content);
    }

    //noinspection JSUnusedLocalSymbols
    function parse(file, content, keywords, options) {
        grunt.log.ok('Parsing: ' + file.src);

        if (options.classes) {
            var __classes = util.parse(regClass, content, keywords);
            grunt.log.debug('Classes: ' + __classes);

            _classes.push.apply(_classes, __classes);
        }

        if (options.constants) {
            var __constants = util.parse(regConstant, content, keywords);
            grunt.log.debug('Constants: ' + __constants);

            _constants.push.apply(_constants, __constants);
        }

        if (options.functions) {
            var __functions = util.parse(regFunction, content, keywords);
            grunt.log.debug('Functions: ' + __functions);

            _functions.push.apply(_functions, __functions);
        }

        if (options.variables) {
            var __variables = util.parse(regVariable, content, keywords);
            grunt.log.debug('Variables: ' + __variables);

            _variables.push.apply(_variables, __variables);
        }
    }

    grunt.registerMultiTask('phpobfuscator', 'Grunt plugin for PHP obfuscation.', function() {
        var options = this.options();
        var alphabet;

        if (options.alphabet === true) {
            alphabet = util.range('a', 'z').concat(util.range('A', 'Z')).join('');
        }

        var hashids = new Hashids(options.salt, options.length, alphabet ? alphabet : options.alphabet);

        // First parse content of files and find
        // classes/functions/variables to obfuscate.
        util.handleFiles(this, parse, options.keywords, options.obfuscate);
        // Then obfuscate the found classes/functions/variables.
        util.handleFiles(this, obfuscate, hashids, options.obfuscate);
    });
};