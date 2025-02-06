let mix = require('laravel-mix');

mix.sass('resources/sass/main.scss', 'assets/css');
mix.js('resources/js/main.js', 'assets/js');
mix.js('resources/js/app.js', 'assets/js');