<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . 'libraries/Blade.php';
use Philo\Blade\Blade;
class MY_Loader extends CI_Loader {

    public function __construct() {
        parent::__construct();
    }
    public function blade($view, array $parameters = array()) {
        $CI = & get_instance();
        $views = $CI->config->item('views_path');
        $cache = $CI->config->item('cache_path');
        
        $blade = new Blade($views, $cache);
        echo $blade->view()->make($view, $parameters)->render();
    }

}
