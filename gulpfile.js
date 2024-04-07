const gulp = require("gulp");

const sassBackend = require("sass");
const gulpSass = require("gulp-sass");
const sass = gulpSass(sassBackend);

function build()
{
	return gulp.src("css/**/*.scss")
		.pipe(sass.sync().on("error", sass.logError))
		// put the file two directories down, i.e. the root
		.pipe(gulp.dest("public/static/css"));
}

exports.build = build;
exports.default = build;