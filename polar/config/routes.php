<?php
/**
 * @copyright Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 * @author    Kristian Matthews <kristian.matthews@my.westminster.ac.uk>
 * @package   Polar
 */

/**
 * Routes configuration.
 *
 * @package Polar\Config
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = 'errors/not_found';
$route['translate_uri_dashes'] = FALSE;

/**
 * Authentication routes.
 */
$route['auth'] = 'sign';
$route['auth/signin'] = 'sign/in';
$route['auth/signout'] = 'sign/out';
$route['auth/signup'] = 'sign/up';

/**
 * Admin routes.
 */
$route['admin'] = 'admin/dashboard';

/**
 * API routes.
 */
$route['api/form/unique']['GET'] = 'api/form/get_unique';
$route['api/quizzes/search'] = 'api/quizzes/search';
$route['api/quizzes']['GET'] = 'api/quizzes/get_quizzes';
$route['api/quizzes']['POST'] = 'api/quizzes/post_quizzes';
$route['api/schools/search'] = 'api/schools/search';
$route['api/schools']['GET'] = 'api/schools/get_schools';
$route['api/schools']['POST'] = 'api/schools/post_schools';