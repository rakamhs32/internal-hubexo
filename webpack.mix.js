let mix = require("laravel-mix");
var path = require("path");

mix
	.setPublicPath(path.resolve("./"))
	.js("assets/js/main.js", "dist")
	.sass("assets/scss/style.scss", "dist")
	.version()
	.options({
		processCssUrls: false,
	})
	.browserSync({
		proxy: "hubexo.8a",
		files: ["dist/main.js", "dist/style.css", "**/*.php"],
	});
