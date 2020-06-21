<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Lomba extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library("form_validation");
		$this->load->model('M_lomba', 'lomba');
		check_sesi_user();
		//Load Dependencies
	}

	public function input_lomba() {
		$type = $this->input->get('input', true);
		if ($type) {
			$data["title"] = "Tambah Mata Lomba";
			$insertId = $this->input->get('insertId');
			$data["mata_lomba"] = $this->lomba->get_mata_lomba($insertId);
			$this->template->render_page("lomba/add_kriteria_v",$data);
		} else {
			$data["title"] = "Tambah Mata Lomba";
			$this->template->render_page("lomba/add_lomba_v",$data);
		}
		
	}

	public function add_lomba() {
		$post = [
			$this->input->post('namaLomba', true),
			$this->input->post('golongan',true),
			$this->input->post('satuan', true),
			$this->input->pos('kejuaraan_fav', true)
		];
		$insertId = $this->lomba->add_lomba($post);
		$session = array(
			'insertLombaId' => $insertId
		);
		
		$this->session->set_userdata( $session );
		echo json_encode(["message" => "berhasil", "insertId" => $insertId]);
	}

	public function add_kriteria_penilaian($count, $id_r_mata_lomba = null, $minus = null) {
		$data = [];
		$data2 = [];
		for ($i=0; $i < $count ; $i++) { 
			$data[$i] = [
				"id_r_mata_lomba" => $id_r_mata_lomba,
				"kriteria" => $this->input->post('kriteria'.$i),
				"nilai_max" => $this->input->post('nilaimax'.$i),
				"is_minus" => 0
			];
		}
		for ($i=0; $i < $minus; $i++) { 
			$data2[$i] = [
				"id_r_mata_lomba" => $id_r_mata_lomba,
				"kriteria" => $this->input->post('kriteriamin'.$i),
				"nilai_max" => $this->input->post('nilaimin'.$i),
				"is_minus" => 1
			];
		}
		$result = $this->lomba->add_kriteria_penilaian($data, $data2);
		if ($result) {
			$this->session->set_flashdata('notif', 'Data Lomba Berhasil di tambahkan');
			echo json_encode($result);
		} elseif ($result) {
			$this->session->set_flashdata('notif', 'Gagal ditambahkan');
		}
	}

	public function get_lomba_all() {
		$result = $this->lomba->fetch_data_lomba();
		echo json_encode($result);
	}

	public function get_mata_lomba($id = null) {
		$result = $this->lomba->get_mata_lomba($id);
		echo json_encode($result);
	} 

	public function get_kriteria_penilaian($id = null, $minus = null) {
		if ($minus) {
			$result = $this->lomba->get_kriteria_minus($id)->result();
		} else {
			$result = $this->lomba->get_kriteria($id)->result();
		}
		
		echo json_encode($result);
	}



	// List all your items
	public function penggalang_sd()
	{
		$data["title"] = "Mata Lomba Penggalang SD";
		$data["lomba"] = $this->lomba->get_mata_lomba(null,"SD");
		$this->template->render_page("lomba/penggalang_sd_v", $data);
	}

	public function penggalang() {
		$data["title"] = "Mata Lomba Penggalang";
		$data["lomba"] = $this->lomba->get_mata_lomba(null,"SMP");
		$this->template->render_page("lomba/penggalang_v", $data);
	}

	public function penegak() {
		$data["title"] = "Mata Lomba Penegak";
		$data["lomba"] = $this->lomba->get_mata_lomba(null,"SMA");
		$this->template->render_page("lomba/penegak_v", $data);
	}


	//Update one item
	public function update_lomba()
	{
		$id = $this->input->post('id_mata_lomba',true);
		$data = [
			"mata_lomba" => $this->input->post("edtMataLomba",true),
			"tingkatan" => $this->input->post('edtTingkatan',true),
			"satuan_terpisah" => $this->input->post('editSatuan', true),
		];
		$result = $this->lomba->update_lomba($id, $data);
		if ($result) {
			$this->update_kriteria($id);
		} else {
			return false;
		}
		

	}

	private function update_kriteria($id) {
		$kriteria = $this->input->post('editKriteria', true);
		$kriteriaMin =  $this->input->post('editKriteriaMin', true);
		$id_mata_lomba = $this->input->post('id_mata_lomba', true);

		$kriteria = $this->lomba->get_kriteria($id_mata_lomba)->result();
		$kriteriaMin = $this->lomba->get_kriteria_minus($id_mata_lomba)->result();
		$data = [];
		$data2 = [];
		$i = 0; $j = 0;
		foreach ($kriteria as $kr) {
			array_push($data, [
				"id_kriteria_penilaian" => $kr->id_kriteria_penilaian,
				"kriteria" => $this->input->post('editKriteria', true)[$i],
				"nilai_max" => $this->input->post('editNilaimax', true)[$i]
			]);
			$i++;
		}

		foreach ($kriteriaMin as $krmin) {
			array_push($data2, [
				"id_kriteria_penilaian" => $krmin->id_kriteria_penilaian,
				"kriteria" => $this->input->post('editKriteriaMin', true)[$j],
				"nilai_max" => $this->input->post('editNilaiMin', true)[$j]
			]);
			$j++;
		}
		
		$result = $this->lomba->update_kriteria($data, $data2);
		if ($result) {
			$this->session->set_flashdata('notif', 'Data Perlombaan berhasil diubah');
			echo json_encode($result);
		}
	}

	//Delete one item
	public function delete( )
	{
		$id = $this->input->post("id", true);
		$result = $this->lomba->delete_perlombaan($id);
		$this->session->set_flashdata('notif', 'Data Perlombaan berhasil dihapus');
		echo json_encode($result);
	}
}

/* End of file Lomba.php */
/* Location: ./application/controllers/Lomba.php */
?>