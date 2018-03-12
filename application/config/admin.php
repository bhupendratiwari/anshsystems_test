<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
$config['show_admin_header'] = TRUE;
$config['show_admin_footer'] = TRUE;
$config['show_admin_sidebar'] = TRUE;


/**
|--------------------------------------------------------------------------
| Admin language settigns
|--------------------------------------------------------------------------
|
  multi_language true/false - If true, site content will be shown in multiple language
| admin_multi_language true/false - If true, admin panel will shown in multiple languages
| admin_language - set default language for admin panel
| 
*/
$config['multi_language'] = FALSE;
$config['admin_multi_language'] = FALSE;
$config['admin_language'] = 'en';
