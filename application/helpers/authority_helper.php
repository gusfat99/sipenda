<?php 

if (!function_exists('load_menu')) {

	function load_menu($levelUser="", $levelMenu="", $parent_menu="") {
		
		$CI = &get_instance();
		$CI->load->model("M_Menu");
		return $CI->M_Menu->get_menu($levelUser, $levelMenu, $parent_menu);
	}
	
}

if (!function_exists('get_sesi_lomba')) {
	function get_sesi_lomba() {
		$ci = &get_instance();
		return $ci->db->get_where("sesi_lomba",["status_sesi" => 1])->row();
	}
}

if (!function_exists('random_string')) {
	
	function random_string($n = 10) {
		$CI = &get_instance();
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	    $randomString = ''; 
	  
	    for ($i = 0; $i < $n; $i++) { 
	        $index = rand(0, strlen($characters) - 1); 
	        $randomString .= $characters[$index]; 
	    } 
	  
	    return $randomString;
	}
}

if (!function_exists('check_sesi_user')) {
	function check_sesi_user () {
		$CI =&get_instance();
		$CI->load->library("session");
		$username = $CI->session->userdata('username');
		if (!$username) {
			redirect('auth');
		}
	}
}
