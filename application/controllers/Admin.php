<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->_template_to_use('admintemplate');
		
		$this->load->model('admin_model');
		$this->data['site'] = $this->admin_model->siteinfo();
		$this->data['my'] = $this->session->userdata();
		$this->_set_title($this->data['site']->title);
		$this->data['page_name'] = '';
		//$this->output->enable_profiler(TRUE);
	}

	function index(){
		$this->restrictedadrea();
        $this->data['page_name'] = 'Prima pagina';
		$this->_append_title('Administrare');
		$this->load->view('adminpages/admin_index',$this->data);
	}

	function categorii($id=NULL){
	    $this->restrictedadrea();
	    $this->_add_js_file('admin');
        if($id){
            $this->data['categorie'] = $this->admin_model->getCatById($id);
            if(!is_object($this->data['categorie'])){
                redirect(base_url().'admin/categorii','location');
            }
            $this->load->view('adminpages/admin_produse',$this->data);
        } else {
            $this->load->view('adminpages/admin_categorii',$this->data);
        }
    }

    function galerii($id=NULL){
	    $this->restrictedadrea();
        if($id){
            $this->data['categorie'] = $this->admin_model->getCatById($id);
            if(!is_object($this->data['categorie'])){
                redirect(base_url().'admin/categorii','location');
            }
            $this->load->view('adminpages/admin_produse',$this->data);
        } else {
            $this->load->view('adminpages/admin_galerii',$this->data);
        }
    }

    /*Adaugare functii Ajax*/
    function ajax($request=NULL,$parametru1=NULL,$parametru2=NULL){
        $this->restrictedadrea();
        $this->_template_to_use('ajax_template');
        switch ($request){
            case 'getCategoriiAll':
                $this->data['categorii'] = $this->admin_model->getCategorii();
                $this->load->view('adminpages/admin_ajax_categorii',$this->data);
                break;
            case 'ordoneazaCategorii':
                $this->data['ordine'] = $this->admin_model->ordoneaza(0);
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'stergecategorie':
                $this->data['data'] = $this->admin_model->stergeCategoria();
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'actdezact':
                $this->data['data'] = $this->admin_model->actOnCat();
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'addOrEditCategory':
                $this->data['data'] = $this->admin_model->addOrEditCategory();
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'getCatDetails':
                //$this->output->enable_profiler(TRUE);
                $id = $this->input->post('catID');
                $this->data['data'] = json_encode($this->admin_model->getCatById($id));
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'getProduseById':
                $this->data['produse'] = $this->admin_model->getProduseById($parametru1);
                $this->load->view('adminpages/admin_ajax_produse',$this->data);
                break;
            case 'addOrEditProd':
                $this->data['data'] = $this->admin_model->addOrEditProd();
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'getSingleProdById':
                $this->data['data'] = json_encode($this->admin_model->getSingleProdById());
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'ordoneazaProduse':
                $this->data['ordine'] = $this->admin_model->ordoneaza(1);
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'stergeProdus':
                $this->data['data'] = $this->admin_model->stergeProdus();
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'actdezactP':
                $this->data['data'] = $this->admin_model->actOnProd();
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'saveText':
                $this->data['data'] = $this->admin_model->saveText();
                $this->load->view('adminpages/admin_ajax_echo',$this->data);
                break;
            case 'uploadImg':
                $this->data['data'] = $this->admin_model->uploadImage();
                $this->load->view('adminpages/admin_ajax_echo_img',$this->data);
                break;
            default:
                echo '';
                break;
        }
    }

    /*Editare text pagini
     * */

    function textEditor($ceedit,$idedit){
        if($ceedit == 'categorii'){
            $this->data['return_folder'] = 'categorii';
        } else {
            $this->data['return_folder'] = 'produse';
        }
        $this->data['continut'] = $this->admin_model->getTextForEdit($ceedit,$idedit);
        if(!is_object($this->data['continut'])){
            redirect(base_url().'admin/categorii','location');
        }
        $this->load->view('adminpages/admin_editText',$this->data);
    }
/*
 * Login functions
 * Logout
 * restricted area functions
 */
	function login(){
	    if($this->session->userdata('logat')){
	        redirect(base_url().'admin/','location');
        }
		$this->_append_title('Login');
        $this->data['page_name'] = 'Login';
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
		    //
		} else {
			redirect(base_url().'admin/login','location');
		}
	}

}