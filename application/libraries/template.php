<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Template {
	protected $_ci;

	function __construct() {
		$this->_ci = &get_instance();
	}

	function render_page($content, $data = null, $isPage2 = false) {

		$data["menu"] = $this->_ci->db->get("menu")->result();
		$data["sesi"] = $this->_ci->db->get_where("sesi_lomba",["status_sesi" => 1])->row();
		$data["header"] = $this->_ci->load->view("templates/header", $data, true);
		$data["sidebar"] = $this->_ci->load->view("templates/sidebar", $data, true);
		$data["navigation"] = $this->_ci->load->view("templates/navigation", $data, true);
		$data["content"] = $this->_ci->load->view($content, $data, true);
		$data["footer"] = $this->_ci->load->view("templates/footer", $data, true);
		$data["title"] = $data["title"];
		$this->_ci->db->join("mata_lomba",  "mata_lomba.id_mata_lomba = juri.id_r_mata_lomba");
		$data["juri"] = $this->_ci->db->get('juri')->result();
		if ($isPage2) {
			echo $this->_ci->load->view("templates/index2", $data, true);
		} else {
			echo  $this->_ci->load->view("templates/index", $data, true);
		}
		
		
	}


	public function render_page_err($type, $msg="") {
		$data["type"] = $type;
		$err_title = "";
		
		if ($type == "403") {
			$err_title = "Access denied";
		} elseif($type = "404") {
			$err_title = "Sorry but we couldn't find this page";
		} else {
			$err_title = "Check your connection";
		}
		$data["err_title"] = $err_title;
		$data["msg"] = $msg;
		$data["header"] = $this->_ci->load->view("errors/header", $data, true);
		$data["footer"] = $this->_ci->load->view("errors/footer", $data, true);
		return $this->_ci->load->view("errors/index", $data);

	}
}
 ?>
