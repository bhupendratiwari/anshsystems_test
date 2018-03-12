<?php

class Auth {

    var $CI;
    var $_username;
    
    function __construct($mode = 'admin') {
        $this->CI = & get_instance();
        $this->mode = $mode;
        $this->dir = $mode == 'admin' ? ADMIN_DIR : '';
    }

    function login($username, $password, $redirect_to = NULL, $set_cookie = false) {
        $query = $this->CI->db->get_where('tbl_users', array(
            'user_email' => $username,
            'user_pwd' => md5($password),
            'user_status' => 1,
            'user_type'=>'admin'
                ), 1
        ); 
       
      
        if ($query->num_rows() === 1) {
            $row = $query->row();
            $data = array(
                $this->mode . '_logged_in' => TRUE,
                $this->mode . '_user_id' => $row->user_id,
                $this->mode . '_type' => $this->mode == 'admin' ? $row->type : 'admin'
            );
            $this->CI->session->set_userdata($data);

            if ($set_cookie) {
                
            }
            if ($redirect_to !== NULL)
                redirect($redirect_to);
            else {
                $loginRedirect = $this->CI->session->userdata('loginRedirect');
                if ($loginRedirect != '') {
                    $this->CI->session->unset_userdata('loginRedirect');
                    redirect($loginRedirect);
                }
                redirect(lang_url($this->dir . 'users'));
            }
        } else {
            return array('flsh_msg_type' => 'error', 'flsh_msg' => 'Invalid email or passowrd');
        }
    }

    function check_login($redirect = false) {
        if ($this->mode == 'admin') {
            if ($redirect && !$this->CI->session->userdata($this->mode . '_logged_in')) {
                $this->CI->session->set_userdata('loginRedirect', base_url() . $this->CI->uri->uri_string());
                redirect(lang_url($this->dir . 'login'));
            }
            return $this->CI->session->userdata($this->mode . '_logged_in');
        }
    }

    function logout($redirect_to = NULL) {
        $this->CI->session->sess_destroy();
        if ($redirect_to != NULL) {
            redirect($redirect_to);
        } else {
            redirect(lang_url($this->dir . 'login'));
        }
    }

    function check_email() {
        $return = false;
        $email = $this->CI->input->post('email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = $this->CI->db->select('user_email')->from('tbl_users')->where(array('user_email' => $email))->get();
          
            if ($query->num_rows() > 0) {

                $newPassword = random_string();
                $data = array('user_pwd' => md5($newPassword));
                $this->CI->db->where('user_email', $email);
                $this->CI->db->update('tbl_users', $data);

                $row = $query->row();
                $return = $newPassword;
            }
        }
        return $return;
    }

}

/* End of file Auth.php */
/* Location: ./application/libraries/Auth.php */
