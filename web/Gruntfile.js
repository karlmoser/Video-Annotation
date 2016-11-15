module.exports = function(grunt) {

  grunt.initConfig({
    sass: {
      dist: {
        files: {
          'public/css/default.css' : 'public/css/default.scss'
        }
      }
    },
    watch: {
      files: ['public/css/*.scss'],
      tasks: ['sass']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');

  grunt.registerTask('default', ['watch']);

};