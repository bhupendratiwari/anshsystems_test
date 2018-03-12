<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->employee_tableName = $this->db->dbprefix('employee');
        
    }

    /**
     * @desc Save employee data
     * 
     * @param type $data
     * @return boolean
     */
    function employee_insert($data = array()) {

        if (!empty($data)) {
            $this->db->insert($this->employee_tableName, $data);
            $last_insert_id = $this->db->insert_id();
            if ($last_insert_id > 0) {
                return $last_insert_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * @desc Update employee data
     * 
     * @param type $data
     * @return boolean
     */
    function employee_update($data = array()) {
        if (!empty($data)) {
            $this->db->where('id', $data['id']);
            $this->db->update($this->employee_tableName, $data);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @desc Get employee data
     * 
     * @param type $filters
     * @return type
     */
    function getEmployeeData($filters = array()) {
        $this->db->from($this->employee_tableName.' as e');
        $this->db->join('tbl_department as dp', "dp.id= e.department_id");
        $query_filters = array();
        if(array_key_exists('status', $filters) && in_array($filters['status'],array('active','inactive')))
        {
            $query_filters['e.status']=$filters['status'];
        }
        if(array_key_exists('dept_name', $filters) && !empty($filters['dept_name']))
        {
            $query_filters['dp.name']=$filters['dept_name'];
        }
        if(empty($query_filters)){
            $query_filters = array('status'=>'active');
        }
        $this->db->where($query_filters);
        $employeeInfo = $this->db->get();
        return $employeeInfo->result_array();
    }
    
    /**
     * @desc Check department based on id
     * 
     * @param type $departmentId
     * @return boolean
     */
    function check_deparyment_exists($departmentId = NULL) {
        $query = null;
        $this->db->select('id');
        $this->db->from('tbl_department');
        $this->db->where(array('id' => $departmentId));
        $query = $this->db->get()->row();
        if ($query != NULL) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @desc Check employee data
     * 
     * @param type $employeeId
     * @return boolean
     */
    function check_employee_exists($employeeId = NULL) {
        $query = null;
        $this->db->select('id');
        $this->db->from($this->employee_tableName);
        $this->db->where(array('id' => $employeeId));
        $query = $this->db->get()->row();
        if ($query != NULL) {
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * @desc Delete the employee
     * 
     * @param type $employeeId
     * @return boolean
     */
    function employee_delete($employeeId = NULL) {
       $this->db->where('id', $employeeId);
       $this->db->delete($this->employee_tableName); 
       return true;
    }
    
    /**
     * @desc Get employee data
     * 
     * @param type $employeeId
     * @return boolean
     */
    function get_employee_data($employeeId = NULL) {
        $query = null;
        $this->db->select('*');
        $this->db->from($this->employee_tableName);
        $this->db->where(array('id' => $employeeId));
        $result = $this->db->get()->row();
        if ($result != NULL) {
            return $result;
        } else {
            return false;
        }
    }
}
