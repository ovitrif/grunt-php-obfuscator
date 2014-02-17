'use strict';

module.exports = function(grunt) {
    function Util() {

    }

    Util.prototype.range = function(start, stop) {
        var result = [];

        for (var i = start.charCodeAt(0), end = stop.charCodeAt(0); i <= end; ++i) {
            result.push(String.fromCharCode(i));
        }

        return result;
    };

    Util.prototype.encrypt = function(string) {
        return Array.prototype.map.call(string, function(m, i) {
            return string.charCodeAt(i);
        });
    };

    Util.prototype.decrypt = function(string) {
        return Array.prototype.map.call(string,function(c) {
            return String.fromCharCode(c);
        }).join('');
    };

    Util.prototype.parse = function(regex, content, exclude) {
        var match, _match, result = [];

        while (match = regex.exec(content)) {
            _match = match[1].trim();

            if (exclude.indexOf(_match) < 0) {
                result.push(_match);
            }
        }

        result = result.filter(function(element, position, self) {
            return self.indexOf(element) === position;
        });

        return result;
    };

    Util.prototype.obfuscate = function(list, content, hashids) {
        var regPrefix = '([^\/][\'|\\s])';

        list.forEach(function(i) {
            var regexp = new RegExp(regPrefix + i, 'g');
            content = content.replace(regexp, '$1' + hashids.encrypt(Util.prototype.encrypt(i)));
        });

        return content;
    };

    Util.prototype.handleFiles = function(scope, callback, option, options) {
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
                callback.apply(scope, [file, grunt.file.read(s), option, options]);
            });
        });
    };

    return new Util();
};