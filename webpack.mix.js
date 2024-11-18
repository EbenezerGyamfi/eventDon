const mix = require("laravel-mix");
const path = require("path");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.version();

mix.copyDirectory("resources/img", "public/img")
    .postCss("resources/css/app.css", "public/css")
    .postCss("resources/css/homepage.css", "public/css");

mix.js("resources/js/events.js", "public/js")
    .js("resources/js/select-teller.js", "public/js")
    .js("resources/js/sms-campaign.js", "public/js")
    .js("resources/js/event-ticketing.js", "public/js")
    .js("resources/js/scanner.js", "public/js")
    .js("resources/js/utils.js", "public/js");

mix.webpackConfig({
    output: {
        chunkFilename: "js/[name].js?id=[chunkhash]",
    },
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
        },
    },
});
