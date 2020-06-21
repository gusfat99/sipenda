<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_peserta extends CI_Model {

	private $table = "daftar_peserta";
	private $field_sesi = "id_r_sesi";
	private $order_column = [""];

	private function _make_query() {
		$this->db->select("*");
		$this->db->from($this->table)
		->join("sesi_lomba","sesi_lomba.id_sesi = daftar_peserta.id_r_sesi");
		$this->db->where("sesi_lomba.status_sesi",1);

		if (isset($_POST["search"]["value"])) {
			$this->db->like("nama_pangkalan",$_POST["search"]["value"]);
			$this->db->or_like("nomor_peserta", $_POST["search"]["value"]);
		}
		if(isset($_POST["order"])) {  
			$this->db->order_by($_POST['order']['0']['column'], $_POST['order']['0']['dir']);  
		} else {  
			$this->db->order_by('id_daftar_peserta', 'DESC');  
		}
	}

	public function make_datatables() {
		$this->_make_query();
		if($_POST["length"] != -1){  
        	$this->db->limit($_POST['length'], $_POST['start']);  
    	}
    	$query = $this->db->get();  
        return $query->result();
	}

	public function get_all_data() {
		$this->db->select("*");
		$this->db->from($this->table)
		->join("sesi_lomba","sesi_lomba.id_sesi = daftar_peserta.id_r_sesi");
		$this->db->where("sesi_lomba.status_sesi",1);
		return $this->db->count_all_results();
	}

	
	public function get_filtered_data() {
		$this->_make_query();
		$query = $this->db->get();  
           return $query->num_rows(); 
	}

	public function get_count_peserta(){
		$this->db->select("*");
		$this->db->from($this->table)
		->join("sesi_lomba","sesi_lomba.id_sesi = daftar_peserta.id_r_sesi");
		$this->db->where("status_sesi",1);
		$result = $this->db->get()->num_rows();
		return $result;
	}

	public function filter($search, $limit, $start, $order_field, $order_ascdesc) {
	    
		// $this->db->join("sesi_lomba","sesi_lomba.id_sesi = daftar_peserta.id_r_sesi");
		// $this->db->like('nama_pangkalan', $search); // Untuk menambahkan query where LIKE
	 //    $this->db->or_like('nomor_peserta', $search); // Untuk menambahkan query where OR LIKE
	 //    $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
	 //    $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
	    return $this->db->query("SELECT * FROM `daftar_peserta` INNER JOIN sesi_lomba ON sesi_lomba.id_sesi = daftar_peserta.id_r_sesi WHERE nama_pangkalan LIKE '%$search%' OR nomor_peserta LIKE '%$search%' order by $order_field $order_ascdesc LIMIT $start, $limit")->result_array(); // Eksekusi query sql sesuai kondisi diatas
	}

	public function count_filter($search) {
		$query = "SELECT * FROM daftar_peserta INNER JOIN sesi_lomba ON sesi_lomba.id_sesi = daftar_peserta.id_r_sesi  WHERE sesi_lomba.status_sesi = 1";
		// $this->db->select("*");
		// $this->db->from($this->table)
		// ->join("sesi_lomba","sesi_lomba.id_sesi = daftar_peserta.id_r_sesi");
		// $this->db->where("status_sesi",1);
		// $this->db->like('nama_pangkalan', $search); // Untuk menambahkan query where LIKE
	 //    $this->db->or_like('nomor_peserta', $search); // Untuk menambahkan query where OR LIKE
	     return $this->db->query($query)->num_rows(); // Eksekusi query sql sesuai kondisi diatas
	}


	public function get_all_peserta($golongan, $jenis) {

		$this->db->select("*");
		$this->db->from("daftar_peserta")
		->join("sesi_lomba","sesi_lomba.id_sesi = daftar_peserta.id_r_sesi");
		$this->db->where("sesi_lomba.status_sesi",1);
		$this->db->order_by("nomor_peserta","ASC");


		if (($golongan && $jenis ) && ($golongan != "null" && $jenis != "null")) {
			$this->db->where("tingkatan", $golongan);
			$this->db->where("jenis", $jenis);
		} else if($jenis && $jenis != "null") {
			$this->db->where("jenis", $jenis);
		} else if($golongan && $golongan != "null") {
			$this->db->where("tingkatan", $golongan);
		}
	
		return $this->db->get()->result();
	}

	public function get_peserta_by_id($id) {
		$this->db->select("*");
		$this->db->from("daftar_peserta")
		->join("sesi_lomba","sesi_lomba.id_sesi = daftar_peserta.id_r_sesi");
		$this->db->where("sesi_lomba.status_sesi",1);
		$this->db->where("id_daftar_peserta",$id);
		return $this->db->get()->row();	
	}

	public function get_sesi_lomba() {
		return $this->db->get_where("sesi_lomba", ["status_sesi" => 1])->row();
	}

	public function update_peserta($id, $dataInput) {
		$rest = '';
		$result = $this->db->update('daftar_peserta', $dataInput, ["id_daftar_peserta" => $id]);
		if($result){
			$this->session->set_flashdata('notif', 'Data Berhasil diupdate'); 
			return ["result" => 1, "message" => "Berhasil diupdate"]; 
		}else{ return 0; }
	}

	public function delete_peserta($id) {
		return $this->db->delete($this->table,["id_daftar_peserta"=>$id]);
	}

	public function add_peserta($post) {
		$sesi_lomba = $this->get_sesi_lomba();
		$data = [
			'id_r_sesi' => $sesi_lomba->id_sesi,
			"nomor_peserta" => $post[0],
			"nama_pangkalan" => $post[1],
			"jenis" => $post[2],
			"tingkatan" => $post[3],
			"tgl_regist" => $post[4]
		];
		$result = $this->db->insert("daftar_peserta",$data);
		if ($result) {
			$this->session->set_flashdata('notif', 'Daftar Peserta Berhasil diatambahkan');
			return true;
		}
		return false;
	}

}

/* End of file M_peserta.php */
/* Location: ./application/models/M_peserta.php */ ?>