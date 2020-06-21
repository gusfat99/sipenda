<?php 

class M_main extends CI_Model {
	public function set_sesi_lomba($value) {
		echo json_encode($this->db->insert("sesi_lomba", $value));
	}

	public function _generate_token() {
		$n = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	    $randomString = ''; 
	  
	    for ($i = 0; $i < $n; $i++) { 
	        $index = rand(0, strlen($characters) - 1); 
	        $randomString .= $characters[$index]; 
	    } 
	  
	    return $randomString;
	}

	public function nonaktif_sesi_lomba($data, $id) {
		echo json_encode($this->db->update("sesi_lomba",$data,["id_sesi" => $id]));
	}

	public function get_sesi_aktif() {

		return $this->db->get_where("sesi_lomba",['status_sesi'=>1])->row();
	}

}

 ?>