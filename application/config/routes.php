<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Authentication
$route['login']                  = 'authentication/authentication/login';
$route['register']               = 'authentication/authentication/register';

// Dashboard
$route['dashboard']                         = 'dashboard/dashboard';

// Manajemen Uang
$route['keuangan/uang-masuk']              = 'manajemen_uang/uang_masuk';
$route['keuangan/uang-keluar']             = 'manajemen_uang/uang_keluar';

$route['default_controller'] = 'authentication/authentication';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
