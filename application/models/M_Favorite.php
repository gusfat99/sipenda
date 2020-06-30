<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Favorite extends CI_Model {

	private $table = "kejuaraan_favorite";
	private $table_r = "kriteria_penilaian_fav";

	public function add($titleKejuaraan, $dataKriteria) {

		$insert = $this->db->insert($this->table, $titleKejuaraan);
		if($insert) {
			return $this->db->insert_batch($this->table_r, $dataKriteria);;
		}
	}
}

/* End of file M_Favorite.php */
/* Location: ./application/models/M_Favorite.php */