module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    haml: {
      dist: {
        files: {
          'index.html': 'index.haml'
        }
      }
    },

    coffeelint: {
      options: {
        "max_line_length": {
          value: 80,
          level: "warn"
        },
        "no_trailing_semicolons": {
          level: "warn"
        }
      },
      app: ['js/scripts.coffee']
    },

    coffee: {
      compile: {
        options: {
          bare: true
        },
        files: {
          'js/scripts.js': 'js/scripts.coffee'
        }
      }
    },

    jshint: {
      options: {
        browser: true
      },
      all: ['Gruntfile.js', 'js/scripts.js']
    },

    min: {
      code: {
        'src': [
          'js/scripts.js',
        ],
      dest: 'js/scripts.min.js'
      }
    },

    sass: {
      options: {
        style: 'compressed'
      },
      dist: {
        files: {
          'css/styles.min.css': 'css/styles.sass',
          'css/ie.min.css': 'css/ie.sass'
        }
      }
    },

    watch: {
      haml: {
        files: ['index.haml'],
        tasks: ['haml']
      },

      coffeelint: {
        files: ['js/scripts.coffee'],
        tasks: ['coffeelint']
      },

      coffee: {
        files: ['js/scripts.coffee'],
        tasks: ['coffee']
      },
      
      jshintMin: {
        files: ['js/scripts.js'],
        tasks: ['jshint', 'min']
      },

      sass: {
        files: ['css/styles.sass', 'css/ie.sass'],
        tasks: ['sass']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-haml');
  grunt.loadNpmTasks('grunt-coffeelint');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-yui-compressor');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.registerTask('all', ['watch']);
};