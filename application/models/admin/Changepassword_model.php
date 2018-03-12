<?php
class Changepassword_model extends CI_Model {
    var $table = 'tbl_users';
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_password(){
        $getUsrPwd = $this->db->select('user_pwd')
                        ->from($this->table)
                        ->where('user_id = '.$this->session->userdata('admin_user_id') )
                        ->get();
        return $getUsrPwd->row()->password;
    }
    
    public function update_pwd(){
        $pwd = $this->input->post('npassword');

        $data = array('user_pwd' => md5($pwd));
        $this->db->where('user_id', $this->session->userdata('admin_user_id'));
        $this->db->update($this->table, $data);

    }
}
