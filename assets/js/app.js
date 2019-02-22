
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');
import $ from 'jquery';
import jQuery from 'jquery';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'datatables.net-dt/css/jquery.dataTables.min.css';
import '@fortawesome/fontawesome-free/css/all.css';

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('../css/app.scss');
require('../css/flash.scss');
require('../css/datatable.scss');
require('../css/card.scss');
require('../css/map.scss');


console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
