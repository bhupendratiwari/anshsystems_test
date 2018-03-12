<?php
/**
 * Dashboard Class
 *
 * @package		Dashboard
 * @version		1.0
 * @author 		Mukund Topiwala
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends ADMIN_Controller {

    public function __construct() {
        $this->checkLogin = true;
        $this->loginRedirect = true;
        parent::__construct();
    }

	/**
 	 * Default method
	 */
    public function index() {
        $data['page_title'] = lang('pgTitle_dashboard');
       
        $this->load->blade('dashboard', $data);
    }

}
