<?php

class MY_Controller extends CI_Controller {

    /**
     * $checkLogin - Authenticate user
     */
    protected $checkLogin = false;

    /**
     * $loginRedirect - Redirect user to login page if not logged in, depends on $checkLogin
     */
    protected $loginRedirect = false;

    /**
     *  $multi_lang;
     */
    public $multi_lang;

    /**
     *  $default_language set in config;
     */
    public $default_language;

    /**
     *  $default_language_id;
     */
    public $default_language_id;

    /**
     * @var $default_date_format - Display date format based on selected language
     */
    public $default_date_format = 'Y-m-d';

    /**
     * @var $default_time_format - Display time format based on selected language
     */
    public $default_time_format = 'H:i:s';

    /**
     * @var $language_list array - List of all languages
     */
    public $language_list = [];

    /**
     * @var $api_logged_in_user_id - Used for api_logged_in_user_id
     */
    public $api_logged_in_user_id;

    /**
     * @var $device_type - Device id for mobile
     */
    public $device_type;

    /**
     * @var $device_id - Device id of mobile device if any
     */
    public $device_id;

    function __construct() {
        parent::__construct();
        $this->default_language = $this->config->item('language');
    }

    protected function _check_login() {
        if ($this->checkLogin) {
            $this->auth->check_login($this->loginRedirect);
        }
    }

    function _initialize_language($multi_lang = TRUE) {

        // Verify user language is correct, and load language
        $lang = $this->uri->segment(1);
        $lang_valid = FALSE;


        /*
         * Check user selected language is valid or not
         * Only allow if it is multilang
         */
        $this->multi_lang = $multi_lang;
        if ($lang != '' && $multi_lang) {
            $res = $this->db->select('id, date_format, time_format')->from('languages')->where(['code' => $lang])->order_by('orders', 'asc')->get()->row();
            if (!empty($res)) {
                $this->session->set_userdata('lang_preference', $lang);
                $this->session->set_userdata('lang_id', $res->id);
                $this->default_language = $lang;
                $this->default_language_id = $res->id;
                $this->default_date_format = $res->date_format;
                $this->default_time_format = $res->time_format;
                $lang_valid = TRUE;
            }
            if (!$lang_valid) {
                $this->session->set_userdata('lang_preference', $this->default_language);
                $res = get_language_id($this->default_language);
                $this->session->set_userdata('lang_id', $res);
                redirect(base_url($this->default_language));
            }
        } else if ($multi_lang) {
            $lang = $this->session->userdata('lang_preference');
            redirect(base_url($lang == '' ? $this->default_language : $lang));
        }

        $this->_get_languages($multi_lang);

        $this->config->set_item('language', $this->default_language);
        $this->lang->load($this->default_language, $this->default_language);
        //$this->lang->load('form_validation', $this->default_language);
    }

    public function _get_languages($multi_lang, $reset = false) {
        if ($reset)
            $this->language_list = [];

        if ($multi_lang) {
            $lang = $this->db->select('GROUP_CONCAT(code) AS languages')->from('languages')->get()->result();
            $this->language_list = $lang[0]->languages != '' ? explode(',', $lang[0]->languages) : '';
        } else {
            $this->language_list[] = $this->default_language;
        }
    }

}

class Admin_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('auth', 'admin');
        $this->load->config('admin');

        // Initialize admin language
        $is_multi_lang = $this->config->item('admin_multi_language');
        $this->default_language = $this->config->item('admin_language');
        $this->_initialize_language($is_multi_lang);
        $this->_get_languages($this->config->item('multi_language'), TRUE);

        $this->config->set_item('views_path', APPPATH . 'views/admin');
       

        $this->_check_login();
    }

}




