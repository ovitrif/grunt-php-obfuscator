'use strict';

//noinspection JSUnresolvedFunction
var grunt = require('grunt');
//noinspection JSUnresolvedFunction
var util = require('../tasks/lib/util')(grunt);

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
    define: function(test) {
        test.expect(0);
        test.done();
    }
};