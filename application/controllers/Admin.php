<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->_template_to_use('admintemplate');
		
		$this->load->model('admin_model');
		$this->data['site'] = $this->admin_model->siteinfo();
		$this->_set_title($this->data['site']->title);
		//$this->output->enable_profiler(TRUE);
	}

	function index(){
		$this->restrictedadrea();
		$this->_append_title('Administrare');
		$this->load->view('adminpages/admin_index',$this->data);
	}

	function login(){
		$this->_append_title('Login');
		$this->load->view('adminpages/admin_loginform', $this->data);
	}

	function dologin(){
		$raspuns = $this->admin_model->requestlogin();

		if($raspuns){
			redirect(base_url().'admin','location');
		} else {
			$this->session->set_flashdata('nelogat','nu te-ai logat');
			redirect(base_url().'admin/login','location');
		}
	}

	public function logout(){
		$this->admin_model->dologout();
		redirect(base_url().'admin/login','location');
	}

	private function restrictedadrea(){
		$logat = $this->session->userdata('logat');
		if($logat)
		{
			//redirect(base_url().'admin','location');
		} else {
			redirect(base_url().'admin/login','location');
		}
	}

}