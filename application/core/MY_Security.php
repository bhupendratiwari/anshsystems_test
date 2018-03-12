<?php

class MY_Security extends CI_Security {

    public function __construct() {
        parent::__construct();
        

    }

    /**
     * Show CSRF Error
     *
     * @return  void
     */
    public function csrf_show_error() {
        //show_error('The action you have requested is not allowed.');
        // Set 401 header instead of the default 500
        /*
        $this->load->library('user_agent');
        if ($this->agent->is_referral()) {
            $this->session->set_userdata(array('flsh_msg' => lang('csrf_token_expired'), 'flsh_msg_type' => 'error'));
            redirect($this->agent->referrer());
        }
         */
        show_error('The action you have requested is not allowed.', 401);
    }

}
