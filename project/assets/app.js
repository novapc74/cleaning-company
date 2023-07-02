/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// import 'swiper/css/bundle';
import './app/src/scss/main.scss';
// import 'video.js/dist/video-js.min.css'


// start the Stimulus application
// import './bootstrap';

function requireAll(r) {
    r.keys().forEach(r);
}
// Переносим всв SVG из /app/src/static/img в /public/build
requireAll(require.context('./app/src/images', true, /\.png|jpg|gif|svg$/));


import './app/src/js/main'

