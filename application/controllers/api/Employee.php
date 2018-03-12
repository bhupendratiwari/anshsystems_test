<?php

defined('BASEPATH') OR exit('No direct script access allowed');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Employee extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('api/employee_model');
    }
    
    /**
     * @desc Get active employee data
     */
    public function index_get(){
        $employeeInfo = $this->employee_model->getEmployeeData();
        $response['data'] = $employeeInfo;
        $response['code'] = parent::HTTP_OK;
        $response['message'] = 'Employees List';
        $response['status'] = true;
        $this->response($response, $response['code']);
    }
    
    /**
     * @desc Save employee data
     */
    public function index_post(){
        $request_data = $this->_post_args;
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', array('required' => 'Please enter  %s .', 'valid_email' => 'Please enter valid email %s .'));
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim', array('required' => 'Please enter %s .'));
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim', array('required' => 'Please enter %s .'));
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|trim', array('required' => 'Please enter %s .'));
        $this->form_validation->set_rules('department_id', 'Department', 'required|trim|numeric', array('required' => 'Please enter %s .', 'numeric'=>'Department id should be numeric.'));
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'first_name' => $request_data['first_name'],
                'last_name' => $request_data['last_name'],
                'email' => $request_data['email'],
                'status' => !empty($request_data['status']) ? $request_data['status'] : 'active',
                'contact_number' => $request_data['contact_number'],
                'department_id' => $request_data['department_id']
            );
            
            $departmentExists = $this->employee_model->check_deparyment_exists($request_data['department_id']);
            if (empty($departmentExists)) {
                $response['message'] = 'Department does not exist!';
                $response['code'] = parent::HTTP_NOT_FOUND;
                $response['data'] = array();
                $response['status'] = false;
            } else {
                $employeeData = $this->employee_model->employee_insert($data);
                if(!empty($employeeData)){
                    $data['employee_id'] = $employeeData;
                    $response['message'] = 'Empoyee created successfully.';
                    $response['code'] = parent::HTTP_CREATED;
                    $response['data'] = $data;
                    $response['status'] = true;
                } else {
                    $response['message'] = 'Something went wrong!';
                    $response['code'] = parent::HTTP_INTERNAL_SERVER_ERROR;
                    $response['data'] = array();
                    $response['status'] = false;
                }
            }
        } else {
            $response['data'] = array();
            $response['code'] = parent::HTTP_BAD_REQUEST;
            $response['message'] = validation_errors();
            $response['status'] = false;
        }

        $this->response($response, $response['code']);
    }
    
    /**
     * @desc Update the employee data
     */
    public function index_put() {
        $request_data = $this->_put_args;
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_error_delimiters('', '');
        if(isset($request_data['email'])) {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', array('required' => 'Please enter  %s .', 'valid_email' => 'Please enter valid email %s .'));
        }
        if(isset($request_data['first_name'])) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim', array('required' => 'Please enter %s .'));
        }
        if(isset($request_data['last_name'])) {
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim', array('required' => 'Please enter %s .'));
        }
        if(isset($request_data['contact_number'])) {
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|trim', array('required' => 'Please enter %s .'));
        }
        if(isset($request_data['department_id'])) {
            $this->form_validation->set_rules('department_id', 'Department', 'required|trim|numeric', array('required' => 'Please enter %s .', 'numeric'=>'Department id should be numeric.'));
        }
        $this->form_validation->set_rules('employee_id', 'Employee Id', 'required|trim|numeric', array('required' => 'Please enter %s .', 'numeric'=>'Employee id should be numeric.'));
        if ($this->form_validation->run() == TRUE) {
            $data = array();
            if(!empty($request_data['email'])) {
                $data['email'] = $request_data['email'];
            }
            if(!empty($request_data['first_name'])) {
                $data['first_name'] = $request_data['first_name'];
            }
            if(!empty($request_data['last_name'])) {
                $data['last_name'] = $request_data['last_name'];
            }
            if(!empty($request_data['contact_number'])) {
                $data['contact_number'] = $request_data['contact_number'];
            }
            if(!empty($request_data['department_id'])) {
                $data['department_id'] = $request_data['department_id'];
            }
            if(!empty($request_data['status'])) {
                $data['status'] = $request_data['status'];
            }
            
            $employeeExists = $this->employee_model->check_employee_exists($request_data['employee_id']);
            if (empty($employeeExists)) {
                $response['message'] = 'Employee does not exist!';
                $response['code'] = parent::HTTP_NOT_FOUND;
                $response['data'] = array();
                $response['status'] = false;
            } else {
                if(!empty($request_data['department_id'])){
                    $departmentExists = $this->employee_model->check_deparyment_exists($request_data['department_id']);
                } else {
                    $departmentExists = 1;
                }
                if (empty($departmentExists)) {
                    $response['message'] = 'Department does not exist!';
                    $response['code'] = parent::HTTP_NOT_FOUND;
                    $response['data'] = array();
                    $response['status'] = false;
                } else {
                    $data['id'] = $request_data['employee_id'];
                    $employeeData = $this->employee_model->employee_update($data);
                    if(!empty($employeeData)){
                        $arrEmployeeInfo = $this->employee_model->get_employee_data($request_data['employee_id']);
                        $response['message'] = 'Empoyee updated successfully.';
                        $response['code'] = parent::HTTP_OK;
                        $response['data'] = $arrEmployeeInfo;
                        $response['status'] = true;
                    } else {
                        $response['message'] = 'Something went wrong!';
                        $response['code'] = parent::HTTP_INTERNAL_SERVER_ERROR;
                        $response['data'] = array();
                        $response['status'] = false;
                    }
                }
            }
        } else {
            $response['data'] = array();
            $response['code'] = parent::HTTP_BAD_REQUEST;
            $response['message'] = validation_errors();
            $response['status'] = false;
        }

        $this->response($response, $response['code']);
    }
    
    /**
     * @desc Delete the employee
     */
    public function index_delete($id){
        $request_data['employee_id'] = $id;
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('employee_id', 'Employee Id', 'required|trim|numeric', array('required' => 'Please enter %s .', 'numeric'=>'Employee id should be numeric.'));
        if ($this->form_validation->run() == TRUE) {
            $employeeExists = $this->employee_model->check_employee_exists($request_data['employee_id']);
            if (empty($employeeExists)) {
                $response['message'] = 'Employee does not exist!';
                $response['code'] = parent::HTTP_NOT_FOUND;
                $response['data'] = array();
                $response['status'] = false;
            } else {
                $employeeData = $this->employee_model->employee_delete($request_data['employee_id']);
                $response['message'] = 'Empoyee deleted successfully.';
                $response['code'] = parent::HTTP_OK;
                $response['data'] = array();
                $response['status'] = true;
            }
        } else {
            $response['data'] = array();
            $response['code'] = parent::HTTP_BAD_REQUEST;
            $response['message'] = validation_errors();
            $response['status'] = false;
        }

        $this->response($response, $response['code']);
    }
    /**
     * @desc Get filter employee data
     */
    public function search_post(){
        $request_data = $this->_post_args;
        $employeeInfo = $this->employee_model->getEmployeeData($request_data);
        $response['data'] = $employeeInfo;
        $response['code'] = parent::HTTP_OK;
        $response['message'] = 'Employees List';
        $response['status'] = true;
        $this->response($response, $response['code']);
    } 
    
}
