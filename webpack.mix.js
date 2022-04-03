const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss'); /* Add this line at the top */


mix.js("resources/js/app.js", "public/js").vue()
    .sass("resources/sass/app.scss", "public/css").options({
        postCss: [
            require('postcss-import'),
            require('tailwindcss'),
        ]
    });