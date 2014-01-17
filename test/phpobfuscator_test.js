'use strict';

//noinspection JSUnresolvedFunction
var grunt = require('grunt');
//noinspection JSUnresolvedFunction
var exec = require('child_process').exec;

/*
 ======== A Handy Little Nodeunit Reference ========
 https://github.com/caolan/nodeunit

 Test methods:
 test.expect(numAssertions)
 test.done()
 Test assertions:
 test.ok(value, [message])
 test.equal(actual, expected, [message])
 test.notEqual(actual, expected, [message])
 test.deepEqual(actual, expected, [message])
 test.notDeepEqual(actual, expected, [message])
 test.strictEqual(actual, expected, [message])
 test.notStrictEqual(actual, expected, [message])
 test.throws(block, [error], [message])
 test.doesNotThrow(block, [error], [message])
 test.ifError(value)
 */

exports.phpobfuscator = {
    setUp: function(done) {
        // setup here if necessary
        done();
    },
    options: function(test) {
        test.expect(1);

        test.equal(undefined, grunt.config('options'));

        test.done();
    },
    obfuscation: function(test) {
        test.expect(1);

        var file = 'test/fixtures/file.php';
        var actual = grunt.file.read(file);
        var expected = grunt.file.read('test/expected/options.php');

        var tmpFile = grunt.file.copy(file, 'tmp/file.php');

        exec('../../bin/phpobfuscator ' + tmpFile, function(error, stdout, stderr) {
            test.equal(actual, expected);
            test.done();
        });
    }
//    default_options: function(test) {
//        test.expect(1);
//
//        var actual = grunt.file.read('tmp/default_options');
//        var expected = grunt.file.read('test/expected/default_options');
//        test.equal(actual, expected, 'should describe what the default behavior is.');
//
//        test.done();
//    },
//    custom_options: function(test) {
//        test.expect(1);
//
//        var actual = grunt.file.read('tmp/custom_options');
//        var expected = grunt.file.read('test/expected/custom_options');
//        test.equal(actual, expected, 'should describe what the custom option(s) behavior is.');
//
//        test.done();
//    }
};