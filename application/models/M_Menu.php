<?php 

class M_Menu extends CI_Model {

	public function get_menu($id_level_user, $levelMenu, $parent_menu) {

		// if ($levelUser != 'admin') {
		// 	// $this->db->join("mata_lomba", "mata_lomba.id_mata_lomba = menu.id_r_mata_lomba");

		// }
		$this->db->select('*')
		->from('menu')
		->join('hak_akses_user', 'hak_akses_user.id_menu = menu.id_menu');
		$this->db->where("hak_akses_user.is_active",1);
		$this->db->order_by("menu.sort_index", "ASC");
		
		if($id_level_user != "")
		{
			$this->db->where('hak_akses_user.id_level_user',$id_level_user);
		}
		if($levelMenu!="")
		{
			
			$this->db->where('menu.level',$levelMenu);		
		}
		if($parent_menu!="")
		{
			$this->db->where('menu.parent_menu_id',$parent_menu);		
		}
		return $this->db->get();
	}

	public function get_menu_is_lomba() {
		$this->db->where("is_mata_lomba",1);
		return $this->db->get("menu")->result();
	}

	public function set_menu_for_juri($data, $isTwoGolongan) {
		if ($isTwoGolongan) {
			$result = $this->db->insert('juri', $data);
		} else {
			$result = $this->db->insert_batch('juri', $data);
		}
		return $result;
	}


	public function insert_menu($data) {
		$result = $this->db->insert('menu', $data);
		if ($result) {
			return $this->_insert_menu_akses($data["id_menu"]);
		}
	}

	private function _insert_menu_akses($id) {
		$data = [
			[
				"id_level_user" => "admin",
				"id_menu" => $id,
				"is_active" => 1
			],
			[
				"id_level_user" => "juri",
				"id_menu" => $id,
				"is_active" => 1
			],
			[
				"id_level_user" => "rekap",
				"id_menu" => $id,
				"is_active" => 1
			]
		];
		return $this->db->insert_batch('hak_akses_user', $data);
	}

	public function fetchJuriLomba() {
		$this->db->join('users', 'users.id_user = juri.id_r_user');
		return $this->db->get('juri')->result();
	}

	public function update_set_menu($id_juri) {
		if(is_array($id_juri)){
			$data = [
				[
					'id_juri' => $id_juri[0],
					"id_r_user" => $this->input->post('juri1'),
					"id_r_mata_lomba" => $this->input->post('id_mata_lomba'),
					"golongan_kelamin" => 'putra'
				],
				[
					'id_juri' => $id_juri[1],
					"id_r_user" => $this->input->post('juri2'),
					"id_r_mata_lomba" => $this->input->post('id_mata_lomba'),
					"golongan_kelamin" => 'putri'
				]
			];
			return $this->db->update_batch("juri", $data, 'id_juri');
		} else {
			$data = [
				"id_r_user" => $this->input->post('juri1'),
				"id_r_mata_lomba" => $this->input->post('id_mata_lomba'),
				"golongan_kelamin" => 'semua_jenis'
			];
			return  $this->db->update("juri", $data, ["id_juri" => $id_juri]);
		}
	}

}

?>