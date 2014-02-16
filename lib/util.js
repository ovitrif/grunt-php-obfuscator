'use strict';

//noinspection JSUnresolvedFunction
var grunt = require('grunt');

var Utility = module.exports = function() {

};

Utility.prototype.range = function(start, stop) {
    var result = [];

    for (var i = start.charCodeAt(0), end = stop.charCodeAt(0); i <= end; ++i) {
        result.push(String.fromCharCode(i));
    }

    return result;
};

Utility.prototype.encrypt = function(string) {
    return Array.prototype.map.call(string, function(m, i) {
        return string.charCodeAt(i);
    });
};

Utility.prototype.decrypt = function(string) {
    return Array.prototype.map.call(string,function(c) {
        return String.fromCharCode(c);
    }).join('');
};

Utility.prototype.parse = function(regex, content, exclude) {
    var match, _match, result = [];

    while (match = regex.exec(content)) {
        _match = match[1].trim();

        if (exclude.indexOf(_match) < 0) {
            result.push(_match);
        }
    }

    return result;
};

Utility.prototype.obfuscate = function(list, content, hashids) {
    list.forEach(function(i) {
        content = content.replace(new RegExp(i, 'g'), hashids.encrypt(Utility.prototype.encrypt(i)));
    });

    return content;
};

Utility.prototype.handleFiles = function(scope, callback) {
    if (typeof(callback) !== 'function') {
        grunt.log.error('No callback function defined.');
    }

    // Iterate over all specified file groups.
    scope.files.forEach(function(file) {
        var src = file.src.filter(function(path) {
            // Warn on and remove invalid source files (if nonull was set).
            //noinspection JSUnresolvedVariable,JSUnresolvedFunction
            if (!grunt.file.exists(path)) {
                grunt.log.warn('Source file "' + path + '" not found.');
                return false;
            }

            return true;
        });

        src.forEach(function(s) {
            callback.apply(scope, [s, grunt.file.read(s)]);
        });
    });
};