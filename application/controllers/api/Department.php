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
class Department extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('api/department_model');
    }
    
    /**
     * @desc Get active department data
     */
    public function index_get(){
        $departmentInfo = $this->department_model->getDepartmentData();
        $response['data'] = $departmentInfo;
        $response['code'] = parent::HTTP_OK;
        $response['message'] = 'Department List';
        $response['status'] = true;
        $this->response($response, $response['code']);
    }
    
    /**
     * @desc Save department data
     */
    public function index_post(){
        $request_data = $this->_post_args;
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('name', 'Department Name', 'required|trim', array('required' => 'Please enter %s .'));
        $this->form_validation->set_rules('description', 'Description', 'required|trim', array('required' => 'Please enter %s .'));
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $request_data['name'],
                'description' => $request_data['description'],
            );
            
            $departmentNameExists = $this->department_model->check_deparyment_name_exists($request_data['name']);
            if (empty($departmentNameExists)) {
                $response['message'] = 'Department name already exist!';
                $response['code'] = parent::HTTP_NOT_FOUND;
                $response['data'] = array();
                $response['status'] = false;
            } else {
                $departmentData = $this->department_model->department_insert($data);
                if(!empty($departmentData)){
                    $data['department_id'] = $departmentData;
                    $response['message'] = 'Department created successfully.';
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
     * @desc Update the department data
     */
    public function index_put() {
        $request_data = $this->_put_args;
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_error_delimiters('', '');
        if(isset($request_data['name'])) {
            $this->form_validation->set_rules('name', 'Department Name', 'required|trim|valid_email', array('required' => 'Please enter  %s .'));
        }
        if(isset($request_data['description'])) {
            $this->form_validation->set_rules('description', 'Description', 'required|trim', array('required' => 'Please enter %s .'));
        }
        $this->form_validation->set_rules('department_id', 'Department Id', 'required|trim|numeric', array('required' => 'Please enter %s .', 'numeric'=>'Department id should be numeric.'));
        if ($this->form_validation->run() == TRUE) {
            $data = array();
            if(!empty($request_data['name'])) {
                $data['name'] = $request_data['name'];
            }
            if(!empty($request_data['description'])) {
                $data['description'] = $request_data['description'];
            }
            
            $departmentExists = $this->department_model->check_department_exists($request_data['department_id']);
            if (empty($departmentExists)) {
                $response['message'] = 'Department does not exist!';
                $response['code'] = parent::HTTP_NOT_FOUND;
                $response['data'] = array();
                $response['status'] = false;
            } else {
                $data['id'] = $request_data['department_id'];
                $departmentData = $this->department_model->department_update($data);
                if(!empty($departmentData)){
                    $arrDepartmentInfo = $this->department_model->get_department_data($request_data['department_id']);
                    $response['message'] = 'Department updated successfully.';
                    $response['code'] = parent::HTTP_OK;
                    $response['data'] = $arrDepartmentInfo;
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
     * @desc Delete the department
     */
    public function index_delete($id){
        $request_data['department_id'] = $id;
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('department_id', 'Department Id', 'required|trim|numeric', array('required' => 'Please enter %s .', 'numeric'=>'Department id should be numeric.'));
        if ($this->form_validation->run() == TRUE) {
            $departmentExists = $this->department_model->check_department_exists($request_data['department_id']);
            if (empty($departmentExists)) {
                $response['message'] = 'Department does not exist!';
                $response['code'] = parent::HTTP_NOT_FOUND;
                $response['data'] = array();
                $response['status'] = false;
            } else {
                $departmentData = $this->department_model->department_delete($request_data['department_id']);
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
     * @desc Get filter department data
     */
    public function search_post(){
        $request_data = $this->_post_args;
        $departmentInfo = $this->department_model->getDepartmentData($request_data);
        $response['data'] = $departmentInfo;
        $response['code'] = parent::HTTP_OK;
        $response['message'] = 'Department List';
        $response['status'] = true;
        $this->response($response, $response['code']);
    } 
    
}
