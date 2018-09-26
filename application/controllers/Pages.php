<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {


	function __construct(){
		parent::__construct();
		$this->_template_to_use('html5template');
		$this->data['nimic'] = '';
		
		$this->load->model('admin_model');
		$this->data['site'] = $this->admin_model->siteinfo();
		$this->_set_title($this->data['site']->title);
		//$this->output->enable_profiler(TRUE);
	}

	function index(){
		$this->_append_title('Acasa');
		$this->load->view("pages/page-index",$this->data);
	}

}