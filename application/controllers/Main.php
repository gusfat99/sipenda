<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("M_main");
		check_sesi_user();
	}

	public function get_sesi() {
		$data = $this->db->get('sesi_lomba')->result();
		echo json_encode($data);
	}

	public function get_sesi_aktif() {
		$result = $this->M_main->get_sesi_aktif();
		echo json_encode($result);
		
	}

	public function index()
	{	
		
		$this->load->view('main');
	}

	public function nonaktif_sesi_lomba() {
		$data = ["status_sesi"=>0];
		$id = $this->input->post("id_sesi",true);
		$this->M_main->nonaktif_sesi_lomba($data, $id);
	}

	public function set_sesi_lomba() {
		$isNewSesi = $this->input->post("is_new_sesi",true);
		$endDate = date("Y-m-d", strtotime($this->input->post("tgl_berakhir",true)));
		
		if ($isNewSesi == "false" ) {
			$id_sesi = $this->input->post("id_sesi");
			
			$data = ["status_sesi" => 1, "tgl_mulai" => date('Y-m-d h:i:s'), "tgl_berakhir"=>$endDate];
			echo json_encode($this->db->update("sesi_lomba",$data,["id_sesi" => $id_sesi]));
		} else {
			
			$data = [
				"judul_kegiatan" => $this->input->post("title",true),
				"tema_kegiatan"	=>	$this->input->post("tema",true),
				"status_sesi" => 1,
				"tgl_mulai"		=> date('Y-m-d h:i:s'),
				"tgl_berakhir" => $endDate,
				"token_sesi" 	=> $this->M_main->_generate_token()
			];
			
			$this->M_main->set_sesi_lomba($data);
		}
		
	}
}
