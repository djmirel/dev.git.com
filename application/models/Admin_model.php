<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model{

    function __construct()
    {
        parent::__construct();
        $this->gallery_path = realpath(APPPATH . '../upload');
        $this->gallery_path_url = base_url() . 'upload/';
    }

    function siteinfo(){
		$q = $this->db->query('SELECT * FROM settings WHERE ID = 1');
		foreach ($q->result() as $row) {
			$data = $row;
		}
		return $data;
	}

	/*
	 * CATEGORII - functii
	 * */

    function getCategorii(){

        $query = $this->db->query('SELECT * FROM categorii where sters = 0 ORDER BY -ordine DESC, ID ASC');

        if($query->num_rows()>0) {
            foreach ($query->result() as $row)
            {
                $data[$row->ID] =  $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function getCatById($id){
        $this->db->where('ID', $id);
        $query = $this->db->get('categorii');
        $row = $query->row();
        return $row;
    }

    function stergeCategoria(){
        $id = $this->input->post('catID',true);
        if($id){
            $datad = array('sters' => 1, 'lastedit' => date("Y-m-d H:i:s", time()));
            $where = 'ID = '.$id;
            $this->db->update('categorii', $datad, $where);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function actOnCat(){
        $id = $this->input->post('catID',true);
        $newval = $this->input->post('newval',true);
        $where = 'ID = '.$id;
        $datad = array('activ' => $newval, 'lastedit' => date("Y-m-d H:i:s", time()));
        $this->db->update('categorii', $datad, $where);
    }

    function addOrEditCategory(){
        $id = $this->input->post('catID-input');
        $nume = $this->input->post('nume-categorie-input');
        $header = $this->input->post('header-categorie-input');
        $footer = $this->input->post('footer-categorie-input');
        $data = array(
            'nume' => trim($nume),
            'header' => trim($header),
            'footer' => trim($footer),
            'lastedit' => date("Y-m-d H:i:s", time())
        );
        if($id == 0){
            $this->db->insert('categorii', $data);
        } else {
            $where = 'ID = '.$id;
            $this->db->update('categorii', $data, $where);
        }
    }

    /*
     * PRODUSE - functii
     * */

    function getProduseById($id){

        $query = $this->db->query('SELECT * FROM produse where categorie_id = ? AND sters = 0 ORDER BY -ordine DESC, ID ASC',$id);

        if($query->num_rows()>0) {
            foreach ($query->result() as $row)
            {
                $data[$row->ID] =  $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function addOrEditProd(){
        $catid = $this->input->post('catID-input');
        $prodId = $this->input->post('prodID-input');
        $nume = $this->input->post('nume-produs-input');
        $pret1 = $this->input->post('pret1-produs-input');
        $pret2 = $this->input->post('pret2-produs-input');
        $pret3 = $this->input->post('pret3-produs-input');
        $gramaj = $this->input->post('gramaj-produs-input');
        $ingrediente = $this->input->post('ingrediente-produs-input');
        $picant = $this->input->post('picant') ? 1 : 0;
        $special = $this->input->post('special') ? 1 : 0 ;
        $nou = $this->input->post('nou') ? 1 : 0;
        $livrabil = $this->input->post('livrabil') ? 1 : 0;
        $data = array(
            'categorie_id' => $catid,
            'nume' => trim($nume),
            'ingrediente' => trim($ingrediente),
            'gramaj' => trim($gramaj),
            'special' => $special,
            'picant' => $picant,
            'nou' => $nou,
            'pret1' => $pret1,
            'pret2' => $pret2,
            'pret3' => $pret3,
            'livrabil' => $livrabil
        );
        if($prodId == 0){
            $this->db->insert('produse', $data);
        } else {
            $where = 'ID = '.$prodId;
            $this->db->update('produse', $data, $where);
        }
    }

    function getSingleProdById(){
        $id = $this->input->post('prodID');
        $this->db->where('ID', $id);
        $query = $this->db->get('produse');
        $row = $query->row();
        return $row;
    }

    function stergeProdus(){
        $id = $this->input->post('prodID',true);
        if($id){
            $datad = array('sters' => 1, 'lastedit' => date("Y-m-d H:i:s", time()));
            $where = 'ID = '.$id;
            $this->db->update('produse', $datad, $where);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function actOnProd(){
        $id = $this->input->post('prodID',true);
        $newval = $this->input->post('newval',true);
        $where = 'ID = '.$id;
        $datad = array('activ' => $newval, 'lastedit' => date("Y-m-d H:i:s", time()));
        $this->db->update('produse', $datad, $where);
    }


    /**************************************/
    function ordoneaza($id){
        $list = $this->input->post('list', true);
        $list = parse_str($list, $output);
        foreach ($output['item'] as $key => $value){
            $key = $key+1;
            $data = array(
                'ordine' => $key,
            );
            $this->db->where('ID', $value);
            if($id == 0){
                $this->db->update('categorii', $data);
            } else {
                $this->db->update('produse', $data);
            }
        }
    }

    /*********************************************/
    function getTextForEdit($ceedit,$idedit){
        $this->db->where('ID', $idedit);
        switch ($ceedit){
            case 'categorii':
                $query = $this->db->get('categorii');
                break;
            case 'produse':
                $query = $this->db->get('produse');
                break;
        }
        $row = $query->row();
        return $row;
    }

    function saveText(){
        $id = $this->input->post('id');
        $text = $this->input->post('text');
        $ceedit = $this->input->post('ceedit');
        $where = 'ID = '.$id;
        $datad = array('aditional_info' => $text, 'lastedit' => date("Y-m-d H:i:s", time()));
        if($ceedit == 'categorii'){
            $this->db->update('categorii', $datad, $where);
        } else {
            $this->db->update('produse', $datad, $where);
        }
    }

    function uploadImage(){
        $config = array (
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->gallery_path.'/',
            'max_size' => 0
        );

        $folder = $this->input->post('folder');

        $this->load->library('upload',$config);
        $this->upload->do_upload('image');
        $image_data = $this->upload->data();

        $newpicname_1 = time();
        $newpicname_2 = $image_data['file_name'];
        $newpicname = $newpicname_1.'_'.$newpicname_2;

        $big = array (
            'source_image' => $image_data['full_path'],
            'new_image' => $this->gallery_path . '/'.$folder.'/'.$newpicname,
            'maintain_ratio' => TRUE,
            'master_dim' => 'auto',
            'quality' => 80,
            'width' => 1024
        );


        //$this->image_lib->initialize($big);

        //$this->image_lib->clear();
/**/
        $config['source_image'] = $image_data['full_path'];
        $config['new_image'] = $this->gallery_path . '/'.$folder.'/'.$newpicname;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = 'auto';
        $config['quality'] = 90;
        $config['width'] = 1024;
        $config['height'] = 1024;
// -- Check EXIF
        $exif = @exif_read_data($config['source_image']);
        if($exif && isset($exif['Orientation']))
        {
            $ort = $exif['Orientation'];

            if ($ort == 6 || $ort == 5)
                $config['rotation_angle'] = '270';
            if ($ort == 3 || $ort == 4)
                $config['rotation_angle'] = '180';
            if ($ort == 8 || $ort == 7)
                $config['rotation_angle'] = '90';
        }

        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        if ( ! @$this->image_lib->rotate())
        {
            // Error Message here
            //echo $this->image_lib->display_errors();
        }
        @$this->image_lib->resize();
        @$this->image_lib->rotate();
        $this->image_lib->clear();

/**/
        unlink($image_data['full_path']);

        $data['poza'] = $newpicname;

        return $data;
    }
    /*********************************************/
	function requestlogin(){
		$user = $this->input->post('username',TRUE);
        $pass = $this->input->post('password',TRUE);

        $logat = $this->checklogin($user,$pass);

        if($logat)
        {
        	$this->dologin($logat);
        	return true;
        } else {
        	//$this->dologout();
        	return false;
        }

	}

	function checklogin($user,$pass){
		$q = $this->db->query('SELECT * FROM users WHERE users.username = ? AND users.password = ?', array($user,$pass));
		if($q->num_rows()==1){
            foreach ($q->result() as $row)
            {
                $data = $row;
            }
            return $data;
        } else {
        	return false;
        }
	}

	function dologin($m){
		$data = array(
            'logat' => TRUE,
            'uid' => $m->ID,
            'username' => $m->username,
            'password' => $m->password,
            'utype' => $m->user_type
        );

        $this->session->set_userdata($data); 

		$datad = array('last_login_date' => date("Y-m-d H:i:s", time()), 'last_login_ip' => $this->input->ip_address());
		$where = "ID = $m->ID";
		$str = $this->db->update('users', $datad, $where);  

	}

	function dologout(){
		$this->session->sess_destroy();
	}

}