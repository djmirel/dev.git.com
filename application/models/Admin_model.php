<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model{

	function siteinfo(){
		$q = $this->db->query('SELECT * FROM settings WHERE ID = 1');
		foreach ($q->result() as $row) {
			$data = $row;
		}
		return $data;
	}

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
            'logat' => 'DA',
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