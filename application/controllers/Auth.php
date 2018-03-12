<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('api/user_model');
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $request_data = $this->input->get();
            $token_userId = ParseToken($request_data);
            if ($token_userId == false) {
                echo "Unauthorized access";
                exit;
            }
            $this->load->view('auth/index', array('request_token' => $request_data['accesstoken']));
        }
    }

    public function reset_pwd() {
        //error_reporting(E_ALL);ini_set('display_errors',1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request_data = $this->input->post();
           
            $this->form_validation->set_data($request_data);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('accesstoken', 'Access Token', 'required');
            $this->form_validation->set_rules('newpwd', 'Password', 'required|min_length[5]|max_length[15]');
            $this->form_validation->set_rules('confirmpwd', 'Confirmation Password', 'required|min_length[5]|max_length[15]|matches[newpwd]');
            
            if ($this->form_validation->run() == TRUE) {
               
                $token_userId = ParseToken($request_data);
                if ($token_userId == false) {
                    echo "Unauthorized access";
                    exit;
                } else {
                    $user_info = $this->user_model->getUserData($token_userId);
                    if (count($user_info) == 0) {
                        echo "Invalid User";
                        exit;
                    } else {
                        $hash = generate_password_hash($request_data['newpwd']);

                        $update_data = array(
                            'user_pwd' => $hash,
                            'user_id' => $token_userId
                        );
                        if ($this->user_model->user_update($update_data)) {
                            $this->session->set_flashdata('success_msg', 'success');
                            $data['msg'] = "your password has been reset";
                        }
                    }
                }
                redirect(base_url('auth/index?accesstoken='.$request_data['accesstoken']));
            }
            else
            {
                print_r(validation_errors());exit;
            }
        }
    }

}
