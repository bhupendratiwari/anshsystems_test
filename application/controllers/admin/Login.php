<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Login Class
 *
 * @package		Login
 * @version		1.0
 */

class Login extends ADMIN_Controller {
	function __construct(){
            parent::__construct();
	}

	/**
 	 * Login action
	 */
	public function index()
	{
            if($this->auth->check_login()){
                redirect(ADMIN_DIR.'dashboard');
            }
            $post = $this->input->post();
            $data['page_title'] = 'Sign in - '.SITE_NM;
            if(!empty($post)){
                $this->form_validation->set_rules('email', 'Username', 'trim|required|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
                
                $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
                if ($this->form_validation->run()){
                    $email = $this->input->post('email');
                    $password = $this->input->post('password');
                    $ret = $this->auth->login($email, $password);
                    set_flash_msg($ret['flsh_msg'],$ret['flsh_msg_type']);
                }
            }
           
            $this->load->blade('login', $data);
	}
        
	/**
 	 * logout 
	 */
        public function logout(){
            $this->auth->logout();
        }
        
        
}
