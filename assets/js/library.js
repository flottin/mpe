// assets/js/library.js

//require('../css/app.css');

//console.log('Hello Webpack Encore');


// customize some Bootstrap variables
//$primary: darken(#428bca, 20%);

require('../css/library.scss');





const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');
const Raphael = require('raphael');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
    $('.alert').alert()
    var paper = Raphael(100, 500, 320, 200);

// Creates circle at x = 50, y = 40, with radius 10
    var circle = paper.circle(50, 40, 10);
// Sets the fill attribute of the circle to red (#f00)
    circle.attr("fill", "#f00");

// Sets the stroke attribute of the circle to white
    circle.attr("stroke", "#fff");
});