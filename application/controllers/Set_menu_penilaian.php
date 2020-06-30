<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_menu_penilaian extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_lomba", "lomba");
		$this->load->model("M_menu", "menu");
		$this->load->model('M_user', 'user');
	}

	public function index()
	{
		$data["title"] = "Setting Menu Penilaian";
		$data["lomba"] = $this->lomba->get_mata_lomba();
		$data["menu_lomba"] = $this->menu->get_menu_is_lomba();
		$data["juri"] = $this->user->fetchDataUser(null, 1);
		$data['juriLomba'] = $this->menu->fetchJuriLomba();
		$this->template->render_page("menu/index", $data);
	}

	public function add() {
		$data = [
			"id_menu" => random_string(5),
			"title" => $this->input->post('title'),
			"level" => "level 2",
			"parent_menu_id" => 9,
			"link" => "penilaian",
			"is_active" => 1,
			"is_mata_lomba" => 1,
			"id_r_mata_lomba" => $this->input->post('id'),
			"id_r_juara_lomba" => 0,
			"id_sesi_lomba" => get_sesi_lomba()->id_sesi
		];
		$result = $this->menu->insert_menu($data);
		echo json_encode($result);
	}

	public function setMenu() {
		$for2type = $this->input->post('untuk2Golongan');
		if ($for2type == 1) {
			$isTwo_golongan = true;
			$obj = [
				"id_r_user" => $this->input->post('juri1'),
				"id_r_mata_lomba" => $this->input->post('id_mata_lomba'),
				"golongan_kelamin" => 'semua_jenis'
			];
		} else {
			$isTwo_golongan = false;
			$obj = [
				[
					"id_r_user" => $this->input->post('juri1'),
					"id_r_mata_lomba" => $this->input->post('id_mata_lomba'),
					"golongan_kelamin" => 'putra'
				],
				[
					"id_r_user" => $this->input->post('juri2'),
					"id_r_mata_lomba" => $this->input->post('id_mata_lomba'),
					"golongan_kelamin" => 'putri'
				]
			];
		}
		$result = $this->menu->set_menu_for_juri($obj, $isTwo_golongan);
		if ($result) {
			echo json_encode($result);
		}
		
	}

	public function delete() {
		$id = $this->input->post('id', true);
		$menu = $this->db->get_where("menu", ["id_r_mata_lomba" => $id])->row();
		$id_menu = $menu->id_menu;
		if ( $this->db->delete('menu', ["id_r_mata_lomba" => $id]) ) {
			$result = $this->db->delete('hak_akses_user', ["id_menu" => $id_menu]);
		}
		echo json_encode($result);
	}

	public function fetchDataJuri($id = null){
		$this->db->join('users', 'users.id_user = juri.id_r_user');
		$result = $this->db->get_where("juri", ["id_r_mata_lomba" => $id])->result();
		echo json_encode(['result' => $result, 'count' => count($result)]);
	}

	public function updateSetMenu($id_juri1, $id_juri2 = null) {
		if ($id_juri2) {
			if ( intval($this->input->post('untuk2Golongan')) == 0) {
				$id_juri = [$id_juri1, $id_juri2];
			} else {
				$query = "DELETE FROM juri WHERE id_juri IN($id_juri1,$id_juri2)";
				$delete = $this->db->query($query);
				if ($delete) {
					return $this->setMenu();
				}
				return;
				
			}	
		} else {
			if ( intval( $this->input->post('untuk2Golongan') ) == 1) {
				$id_juri = $id_juri1;
			} else {
				$query = "DELETE FROM juri WHERE id_juri = $id_juri1";
				$delete = $this->db->query($query);
				if ($delete) {
					return $this->setMenu();
				}
				return;
			}
			
		}
		$result = $this->menu->update_set_menu($id_juri);
		echo json_encode($result);

	}

}

/* End of file Set_menu_penilaian.php */
/* Location: ./application/controllers/Set_menu_penilaian.php */ ?>