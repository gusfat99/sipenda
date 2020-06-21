<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_lomba extends CI_Model {

	private $_tabel_master = "mata_lomba";
	private $_tb_kriteria = "kriteria_penilaian";

	private function _join_tabel_sesi($tabel) {
		return $this->db->select("*")->from($tabel)
		->join("sesi_lomba","sesi_lomba.id_sesi = $tabel.id_r_sesi")
		->where("sesi_lomba.status_sesi",1);
	}

	public function add_lomba($post) {
		$idSesi = get_sesi_lomba()->id_sesi;
		$strrdm = random_string(3);
		$kode = strtolower(date('yy').$idSesi.$post[1].$strrdm);

		$data = [
			"id_mata_lomba" => $kode,
			"id_r_sesi" => $idSesi,
			"mata_lomba" => $post[0],
			"tingkatan" => $post[1],
			"satuan_terpisah" => $post[2],
			"kejuaraan_favorite" => $post[3]
		];

		$result = $this->db->insert($this->_tabel_master, $data);
		if ($result) {
			return $kode;
		}
		return false;
	}

	public function get_mata_lomba($id = null, $tingkatan = null) {
		$this->_join_tabel_sesi($this->_tabel_master);
		if ($id && $tingkatan) {
			$this->db->where("id_mata_lomba",$id);
			$this->db->where("tingkatan",$tingkatan);
			return  $this->db->get()->row();
		} elseif($id) {
			$this->db->where("id_mata_lomba",$id);
			return  $this->db->get()->row();
		} elseif ($tingkatan) {
			$this->db->where("tingkatan",$tingkatan);
		}
		return $this->db->get()->result();
	}

	public function get_kriteria($id = null) {
		$this->db->select("*")->from($this->_tb_kriteria)
		->join("$this->_tabel_master", "$this->_tabel_master.id_mata_lomba = kriteria_penilaian.id_r_mata_lomba");
		$this->db->join("sesi_lomba","sesi_lomba.id_sesi = $this->_tabel_master.id_r_sesi");
		$this->db->where("sesi_lomba.status_sesi",1);
		$this->db->where("id_r_mata_lomba", $id);
		$this->db->where("is_minus",0);
		return $this->db->get();
	}

	public function get_all_kriteria($id = null) {
		$this->db->select("*")->from($this->_tb_kriteria)
		->join("$this->_tabel_master", "$this->_tabel_master.id_mata_lomba = kriteria_penilaian.id_r_mata_lomba");
		$this->db->join("sesi_lomba","sesi_lomba.id_sesi = $this->_tabel_master.id_r_sesi");
		$this->db->where("sesi_lomba.status_sesi",1);
		$this->db->where("id_r_mata_lomba", $id);
		return $this->db->get();
	}

	public function get_kriteria_minus($id = null) {
		$this->db->select("*")->from($this->_tb_kriteria)
		->join("$this->_tabel_master", "$this->_tabel_master.id_mata_lomba = kriteria_penilaian.id_r_mata_lomba");
		$this->db->join("sesi_lomba","sesi_lomba.id_sesi = $this->_tabel_master.id_r_sesi");
		$this->db->where("sesi_lomba.status_sesi",1);
		$this->db->where("id_r_mata_lomba", $id);
		$this->db->where("is_minus",1);
		return $this->db->get();
	}

	public function add_kriteria_penilaian($data, $data2) {

		$result = $this->db->insert_batch($this->_tb_kriteria, $data);
		if ($result) {
			if (count($data2) > 0) {
				return $this->db->insert_batch($this->_tb_kriteria, $data2); 
			}
		}
		return false;
	}

	public function update_lomba($id, $data) {
		return $result = $this->db->update($this->_tabel_master, $data, ["id_mata_lomba" => $id]);
	}

	public function update_kriteria($data, $data2) {
		$this->db->where("is_minus",0);
		$update = $this->db->update_batch($this->_tb_kriteria, $data, "id_kriteria_penilaian");
		if ($update >= 0) {
			if (count($data2) > 0) {
				$this->update_kriteria_min($data2);
			}
			return true;
		}
		return false;
	}
	private function update_kriteria_min($data) {
		$this->db->where("is_minus",1);
		$result = $this->db->update_batch($this->_tb_kriteria, $data, "id_kriteria_penilaian");
		if ($result >= 0) {
			return true;
		}
	}

	public function delete_perlombaan($id) {
		$this->db->delete("menu", ["id_r_mata_lomba" => $id]);
		$delete = $this->db->delete($this->_tabel_master, ["id_mata_lomba" => $id]);
		if ($delete) {
			$this->delete_kriteria($id);
		}
	}

	private function delete_kriteria($id) {
		return $this->db->delete($this->_tb_kriteria, ["id_r_mata_lomba" => $id]);
	}

}

/* End of file M_lomba.php */
/* Location: ./application/models/M_lomba.php */ ?>