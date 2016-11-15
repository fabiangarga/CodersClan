var fs              = require('fs'),
    gulp            = require('gulp'),

    sass            = require('gulp-sass'),
    autoprefixer    = require('gulp-autoprefixer'),
    sassMaps        = require('gulp-sourcemaps'),

    concat          = require('gulp-concat'),
    uglify          = require('gulp-uglify'),

    notify          = require('gulp-notify'),
    plumber         = require('gulp-plumber'),

    livereload      = require('gulp-livereload')


var paths = {
    sass: './static/scss/',
    css: './static/',

    js: './static/js/src/',
}

var files = {
    sass: 'app.scss',
    js: 'js/main.js'
}


gulp.task('default', ['sass-dev', 'concat-js'], function() {    
    livereload.listen()
    gulp.watch(paths.sass + '**/*.scss', ['sass-dev'])
    gulp.watch(paths.js + '**/*.js', ['concat-js'])
})

gulp.task('reload', function(){
    gulp.src('index.html')
        .pipe(livereload())
})

gulp.task('concat-js', ['clean-js'], function(){
    return gulp.src(paths.js + '/**/*.js')            
        .pipe(concat(files.js))
        .pipe(uglify())
        .pipe(gulp.dest('.'))
})

gulp.task('sass-dev', ['clean'], function() {
    gulp.src(paths.sass + files.sass)    
        .pipe(sassMaps.init())
        .pipe(sass())        
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(sassMaps.write())
        .pipe(gulp.dest(paths.css))
})

gulp.task('sass-prod', ['clean'], function() {    
    gulp.src(paths.sass + 'main.scss')    
        .pipe(sass({
            outputStyle: 'compressed'    
        }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(paths.css))
})

gulp.task('clean', function() {

})

gulp.task('clean-js', function() {
    try {
        fs.unlinkSync(files.js)
    } catch (e) {
        if (e.code != 'ENOENT') throw e;
    }
})

function mkdir(path){
    try {
        fs.mkdirSync(path)
    } catch (e) {
        if (e.code != 'EEXIST') throw e
    }
} 
