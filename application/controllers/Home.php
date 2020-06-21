<?php 
class Home extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("M_main","main");
		check_sesi_user();
	}

	public function index() {
		$data["sesi"] = $this->main->get_sesi_aktif();
		$data["title"] = "Dashboard";
		$data["user"] = $this->db->get_where("users", ["username" => $this->session->userdata('username')])->row();
		if ($data["sesi"] != null) {
			$this->template->render_page("home", $data);
		} else {
			$this->template->render_page_err("403");
		}
		
	}

	

}
 ?>