module.exports = function(grunt) {
	"use strict";

	grunt.file.defaultEncoding = 'utf8';

	grunt.initConfig({
		phplint: {
			default : {
				options: {
					phpCmd: "php",
				},
				src: [
					"*.php",
					"!node_modules/**",
				],
			},
		}
	});

	grunt.registerTask('build', '', function(branch) {
		var build_dir = 'build/';
		grunt.file.mkdir(build_dir);
		grunt.util.spawn({
			cmd: "git",
			args: ['archive', '--prefix=ncenterlite/', '--output=' + build_dir + 'xe-module-ncenterlite.zip', branch, '.']
		});
	});

	grunt.loadNpmTasks('grunt-phplint');

	grunt.registerTask('default', ['phplint']);
};
