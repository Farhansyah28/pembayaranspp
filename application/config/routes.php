<?php
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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin Routes
$route['admin/users'] = 'admin/users';
$route['admin/users/(:any)'] = 'admin/users/$1';
$route['admin/logs'] = 'admin/logs';
$route['admin/master/(:any)'] = 'admin/master/$1';
$route['admin/import'] = 'admin/import';
$route['admin/import/(:any)'] = 'admin/import/$1';

// Keuangan Routes
$route['keuangan/wali'] = 'keuangan/wali';
$route['keuangan/wali/(:any)'] = 'keuangan/wali/$1';
$route['keuangan/santri'] = 'keuangan/santri';
$route['keuangan/santri/(:any)'] = 'keuangan/santri/$1';
$route['keuangan/tagihan'] = 'keuangan/tagihan';
$route['keuangan/tagihan/(:any)'] = 'keuangan/tagihan/$1';
$route['keuangan/pembayaran'] = 'keuangan/pembayaran';
$route['keuangan/pembayaran/(:any)'] = 'keuangan/pembayaran/$1';

// Wali Routes
$route['wali/tagihan'] = 'wali/tagihan';
$route['wali/tagihan/(:any)'] = 'wali/tagihan/$1';

// Common Routes
$route['profile'] = 'profile';
$route['profile/update'] = 'profile/update';
