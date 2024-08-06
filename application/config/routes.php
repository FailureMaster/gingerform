<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'drawingform'; // The default controller when no URI is specified
$route['drawingform'] = 'drawingform/index';  // Route for accessing the drawing form page
$route['drawingform/submit'] = 'drawingform/submit'; // Route for handling form submission
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
