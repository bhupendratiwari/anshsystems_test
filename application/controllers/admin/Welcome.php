<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Welcome extends ADMIN_Controller {

	function __constrcuct(){
		parent::__constrcuct();
	}

	public function _remap($method, $param = []){
		$this->$method();

	}

    public function index() {
        $this->load->blade('dashboard.index', ['test'=>'val']);
    }

    /** 
     * Call function after execution
     */
    
    public function _output(){
    	echo '________a';
    }

}
