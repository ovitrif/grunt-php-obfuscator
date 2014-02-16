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
    var Hashids = require('hashids');
    //noinspection JSUnresolvedFunction
    var Utility = require('../lib/util');
    var util = new Utility();

    var _classes = [];
    var _constants = [];
    var _functions = [];
    var _variables = [];

    var keyWords = ['self', 'this', '$self', '$this', 'private', 'public', 'static', 'class', 'function', '__construct'];

    var regSComment = new RegExp('(\/\/|#).+', 'g');
    var regMComment = new RegExp('(?:/\\*(?:[^*]|(?:\\*+[^*/]))*\\*+/)|(?://.*)', 'g');

    var regClass = new RegExp('class[\\s\\n]+(\\S+)[\\s\n]*\\{', 'g');
    var regConstant = new RegExp('define\\(\\s*\'([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\'', 'g');
    var regFunction = new RegExp('function[\\s\n]+(\\S+)[\\s\n]*\\(', 'g');
    var regVariable = new RegExp('(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)', 'g');

    var alphabet = util.range('a', 'z').concat(util.range('A', 'Z')).join('');
    var hashids = new Hashids('this is my salt', 8, alphabet);

    //noinspection JSUnusedLocalSymbols
    function parse(file, content) {
        _classes.push.apply(_classes, util.parse(regClass, content, keyWords));
        _constants.push.apply(_constants, util.parse(regConstant, content, keyWords));
        _functions.push.apply(_functions, util.parse(regFunction, content, keyWords));
        _variables.push.apply(_variables, util.parse(regVariable, content, keyWords));
    }

    function obfuscate(file, content) {
        content = content.replace(regSComment, '');
        content = content.replace(regMComment, '');

//        content = content.replace(new RegExp('\\s+', 'g'), ' ');
        content = content.replace('; ', ';');

        content = util.obfuscate(_classes, content, hashids);
        content = util.obfuscate(_constants, content, hashids);
        content = util.obfuscate(_functions, content, hashids);
        content = util.obfuscate(_variables, content, hashids);

        grunt.file.write('tmp/' + file.replace(/^.*[\\\/]/, ''), content);
    }

    grunt.registerMultiTask('phpobfuscator', 'Grunt plugin for PHP obfuscation.', function() {
        // First parse content of files and find
        // classes/functions/variables to obfuscate.
        util.handleFiles(this, parse);
        // Then obfuscate the found classes/functions/variables.
        util.handleFiles(this, obfuscate);
    });
};