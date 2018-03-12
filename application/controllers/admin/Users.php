<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Project Class
 *
 * @package		Project
 * @version		1.0
 */
class Users extends ADMIN_Controller {

    var $table = 'tbl_users';

    function __construct() {
        $this->checkLogin = true;
        $this->loginRedirect = true;
        parent::__construct();
        $this->load->model('admin/users_model');
    }

    public function index() {
        $data['page_title'] = lang('pgTitle_users');
        $data['meta'] = [
            ['name' => 'description', 'content' => lang('pgTitle_users')],
            ['name' => 'keywords', 'content' => lang('pgTitle_users')]
        ];
        $this->load->blade('users', $data);
    }

    /**
     * List all users grid
     */
    public function get_list() {
        $result = $this->users_model->get_list();
        echo json_encode($result);
        exit;
    }
    /**
     * List all users grid
     */
    public function get_users() {
        ob_start();
        $result = $this->users_model->get_users();
        if (count($result) > 0) {

            $timestamp = time();
            $filename="conseel_{$timestamp}.csv";
            $fp = fopen(FCPATH . "/assets/csv/{$filename}", 'w+');
            fputcsv($fp, array('Email', 'FirstName', 'LastName', 'PrimaryUse', 'Gender','DOB','Installation Date','Conseel Pro','Conseel Lite','Status'));

            foreach ($result as $user) {
               
                fputcsv($fp, array($user['email'], $user['first_name'], $user['last_name'], $user['primary_use'],(($user['user_gender']=='M')?'Male':(($user['user_gender']=='F')?'Female':'Other')), $user['user_birthdate'],$user['created_date'],$user['Conseel Pro'],$user['Conseel Lite'],($user['status']==1)?'Active':'Inactive'));
            }

            fclose($fp);
            echo json_encode(array('filename'=>$filename));exit;
        }

        
    }
 function csv_download()
 {
     $filename='';
          $request_data=$this->input->get();
          if(array_key_exists('filename', $_GET) && empty($_GET['filename'])==false)
          {
              $filename=$_GET['filename'];
               header("Content-type:application/csv");

// It will be called downloaded.pdf
            header("Content-Disposition:attachment;filename='{$filename}'");

// The PDF source is in original.pdf
            readfile(FCPATH . "/assets/csv/{$filename}");
           
          }
     
 }
    /**
     * Add users
     */
    public function add() {
        $post = $this->input->post();
        $return = array('success' => false, 'msg' => lang('fillAllReqValues'));
        if (!empty($post)) {
            $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|is_unique[users.user_email]',array('required' => 'Please enter  %s .', 'valid_email' => 'Please enter valid email %s .'));
            $this->form_validation->set_rules('password', lang('pswd'), 'trim|required',array('required' => 'Please enter %s .'));
            $this->form_validation->set_rules("status", lang('status'), "in_list[0,1]",array('required' => 'Please select %s .'));
            $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required',array('required' => 'Please enter %s .'));
            $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required',array('required' => 'Please enter %s .'));
            $this->form_validation->set_rules('primary_use', 'primary_use', 'trim|required',array('required' => 'Please enter %s .'));
            if ($this->form_validation->run()) {
                $result = $this->users_model->add();
                if ($result > 0)
                    $return = array('success' => true, 'msg' => lang('userAddSuccess'));
                else
                    $return = array('success' => false, 'msg' => lang('userAddFailure'));
            }
        }
        echo json_encode($return);
        die;
    }

    
    public function get_details($id = null) {
        $res = $this->users_model->get_user_details($id);
        echo json_encode($res->row());
        die;
    }

    /**
     * Update details
     */
    public function edit($id) {
        $post = $this->input->post();
       $return = array('success' => false, 'msg' => lang('fillAllReqValues'));
        if (!empty($post)) {
           # $this->form_validation->set_rules('id', lang('id'), 'trim|required|xss_clean',array('required' => 'Please provide  %s .'));
             $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email',array('required' => 'Please enter  %s .', 'valid_email' => 'Please enter valid email %s .'));
           // $this->form_validation->set_rules('password', lang('pswd'), 'trim|required',array('required' => 'Please enter %s .'));
            $this->form_validation->set_rules("status", lang('status'), "in_list[0,1]",array('required' => 'Please select %s .'));
            $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required',array('required' => 'Please enter %s .'));
            $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required',array('required' => 'Please enter %s .'));
            $this->form_validation->set_rules('primary_use', 'primary_use', 'trim|required',array('required' => 'Please enter %s .'));
            if ($this->form_validation->run() && $id > 0) {
                $result = $this->users_model->edit($id);
                if ($result > 0)
                    $return = array('success' => true, 'msg' => lang('userUpdSuccess'));
                else
                    $return = array('success' => false, 'msg' => lang('userUpdFailure'));
            }
            else
            {
                 $return = array('success' => false, 'msg' => validation_errors());
            }
        }
        echo json_encode($return);
        die;
    }

    /**
     * Delete users
     * @param post int $id id for delete user
     */
    function delete() {
        $id = $this->input->post('id');
        $status = delete($this->users_model->table, array('user_id' => $id));
        header('Content-type: application/json');
        echo json_encode(array("success" => $status));exit;
    }

    /**
     * Delete users
     * @param post int $id id for update user
     * @param post int $status active/inactive
     */
    public function update_status() {
        $st = $this->input->post('status');
        $st = boolval($st);
        $id = $this->input->post('id');
        change_status($this->table, array('user_status' => $st), array('user_id' => $id));
        echo 1;
    }

}
