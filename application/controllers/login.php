<?php
class Login extends CI_Controller{
	function __construct(){
        		parent::__construct();
		//konstruktif pertama kali meload model model_app
        		$this->load->model('model_app');  
    	}
    	function index(){
        		$data=array(
           		 'title'=>'Login Page'
        		);
		//meload view v_login pada folder pages sebagai halaman index
        		$this->load->view('pages/v_login',$data);
   	 }
    	function cek_login() {
        		$username = $this->input->post('username');
        		$password = $this->input->post('password');
        		//input data melalui form post username dan password login di cek apakah ada pada database pada modul model_app function login 
        		$result = $this->model_app->login($username, $password);
        		if($result) {
            		$sess_array = array();
            		foreach($result as $row) {
               			 //create the session
                			$sess_array = array(
                   				 'ID' => $row->kd_pegawai,
                   				 'USERNAME' => $row->username,
                    			'PASS'=>$row->password,
                   				 'NAME'=>$row->nama,
                    			'LEVEL' => $row->level,
                    			'login_status'=>true,
                			);
                			//set session with value from database
                			$this->session->set_userdata($sess_array);
				//jika ada maka menuju ke controller dashboard dengan nilai TRUE
                			redirect('dashboard','refresh');
            		}
           		 return TRUE;
        		} else {
           		 //jika tidak ada maka menuju ke controller dashboard dengan nilai FALSE
           		 redirect('dashboard','refresh');
            		return FALSE;
        		}
    	}
    	function logout() {
        		$this->session->unset_userdata('ID');
        		$this->session->unset_userdata('USERNAME');
        		$this->session->unset_userdata('PASS');
        		$this->session->unset_userdata('NAME');
        		$this->session->unset_userdata('LEVEL');
        		$this->session->unset_userdata('login_status');
        		$this->session->set_flashdata('notif','Terimakasih Telah Menggunakan Aplikasi Ini !!');
        		redirect('login');
   	 }
}
