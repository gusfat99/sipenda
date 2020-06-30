<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model("M_peserta","peserta");
		check_sesi_user();

	}

	// List all your items
	public function index( )
	{
		$data["title"] = "Daftar Peserta";
		$golongan = $this->input->post('filterGolongan',true);
		$jenis = $this->input->post('filterJenis',true);
		$data["peserta"] = $this->peserta->get_all_peserta($golongan, $jenis);
		$this->template->render_page("daftar_peserta/index", $data);
	}

	public function get_peserta_by_id($id) {
		$data = $this->peserta->get_peserta_by_id($id);
		echo json_encode($data);
	}

	
	public function filter() {
		$golongan = $$this->input->post('filtergolongan',true);
		$jenis = $this->input->post('filterJenis',true);
		$this->peserta->filter_peserta($golongan, $jenis);
	}

	// Add a new item
	public function add()
	{
		$post = [
			$this->input->post("no_urut",true),
			$this->input->post("sekolah",true),
			$this->input->post('tingkatan',true),
			$this->input->post('date_regist',true),
			
		];
		$result = $this->peserta->add_peserta($post);
		if ($result) {
			echo json_encode($result);
		} else{return 0;}
	}

	//Update one item
	public function update()
	{
		$id = $this->input->post('id_daftar_peserta',true);
		$dataInput = [
			"nomor_peserta" => $this->input->post('no_urut',true),
			"nama_pangkalan" => $this->input->post('sekolah',true),
			"tingkatan" => $this->input->post('tingkatan',true),
			"jenis" => $this->input->post('jenis_kelamin',true)
		];
		$result = $this->peserta->update_peserta($id, $dataInput);
		echo json_encode($result);
	}

	//Delete one item
	public function delete( $id = NULL )
	{
		$result = $this->peserta->delete_peserta($id);
		if ($result) {
			$this->session->set_flashdata('notif', 'Data Berhasil dihapus');
			echo json_encode($result);
		} else {
			echo json_decode(false);
		}
		
	}
}

/* End of file Peserta.php */
/* Location: ./application/controllers/Peserta.php */
 ?>