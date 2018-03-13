<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->department_tableName = $this->db->dbprefix('department');
        
    }

    /**
     * @desc Save department data
     * 
     * @param type $data
     * @return boolean
     */
    function department_insert($data = array()) {

        if (!empty($data)) {
            $this->db->insert($this->department_tableName, $data);
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
     * @desc Update department data
     * 
     * @param type $data
     * @return boolean
     */
    function department_update($data = array()) {
        if (!empty($data)) {
            $this->db->where('id', $data['id']);
            $this->db->update($this->department_tableName, $data);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @desc Get department data
     * 
     * @param type $filters
     * @return type
     */
    function getDepartmentData($filters = array()) {
        $this->db->from($this->department_tableName);
        $query_filters = array();
        if(array_key_exists('department_id', $filters) && !empty($filters['department_id'])){
            $query_filters['id'] = $filters['department_id'];
        }
        if(array_key_exists('name', $filters) && !empty($filters['name'])) {
            $query_filters['name'] = $filters['name'];
        }
        if(!empty($query_filters)) {
            $this->db->where($query_filters);
        }
        $departmentInfo = $this->db->get();
        return $departmentInfo->result_array();
    }
    
    /**
     * @desc Check department based on id
     * 
     * @param type $departmentId
     * @return boolean
     */
    function check_department_exists($departmentId = NULL) {
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
     * @desc Check department data
     * 
     * @param type $departmentName
     * @return boolean
     */
    function check_deparyment_name_exists($departmentName = NULL) {
        $query = null;
        $this->db->select('id');
        $this->db->from('tbl_department');
        $this->db->where(array('name' => $departmentName));
        $query = $this->db->get()->row();
        if ($query != NULL) {
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * @desc Delete the department
     * 
     * @param type $departmentId
     * @return boolean
     */
    function department_delete($departmentId = NULL) {
       $this->db->where('id', $departmentId);
       $this->db->delete($this->department_tableName); 
       return true;
    }
    
    /**
     * @desc Get department data
     * 
     * @param type $departmentId
     * @return boolean
     */
    function get_department_data($departmentId = NULL) {
        $query = null;
        $this->db->select('*');
        $this->db->from($this->department_tableName);
        $this->db->where(array('id' => $departmentId));
        $result = $this->db->get()->row();
        if ($result != NULL) {
            return $result;
        } else {
            return false;
        }
    }
}
