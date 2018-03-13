<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    
        function __construct() {
            // Construct the parent class
            parent::__construct();
            $this->load->model('api/employee_model');
            $this->load->model('api/department_model');
        }
        
        /**
         * @desc List of all employee
         */
	public function index() {
            $postData = $this->input->post();
            if(!empty($postData)){
                if(!empty($postData['status'])){
                    $filters['status'] = $postData['status'];
                }
                if(!empty($postData['department'])){
                    $filters['department_id'] = $postData['department'];
                }
                $data = array(
                    'status' => $this->input->post('status'),
                    'department' => $this->input->post('department')
                );
            } else {
                $filters = array('status'=>'active');
            }
            $data['employeeInfo'] = $this->employee_model->getEmployeeData($filters);
            $data['departmentInfo'] = $this->department_model->getDepartmentData();
            $this->load->view('welcome_message', $data);
	}
}
