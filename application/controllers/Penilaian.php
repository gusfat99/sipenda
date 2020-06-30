<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_menu", "menu");
		$this->load->model('M_lomba', 'lomba');
		$this->load->model('M_peserta', 'peserta');
		$this->load->model('M_penilaian', 'penilaian');
	}

	public function list($mataLombaId) {
		
		$data["mata_lomba"] = $this->lomba->get_mata_lomba($mataLombaId);
       
        $data['title'] = "Penilaian ".$data["mata_lomba"]->mata_lomba;
		$tingkatan = $data["mata_lomba"]->tingkatan;
		$data["tingkatan"] = $tingkatan;
        $jk = $this->input->get('jenis');
       

		$this->template->render_page("penilaian/index",$data);
	}

	public function get_data_peserta($golongan, $jk)
    {
        if ($jk == 'putra') {
           $jenis ="L";
        } elseif($jk == 'putri') {
            $jenis ="P";
        } else {
            $jenis = null;
        }
        $list = $this->penilaian->get_datatables($golongan, $jenis);
        $data = array();
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->id_daftar_peserta;
            $row[] = $field->nomor_peserta;
            $row[] = $field->nama_pangkalan;
            $row[] = $field->tingkatan;
            $row[] = $field->jenis;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->penilaian->count_all($golongan, $jenis),
            "recordsFiltered" => $this->penilaian->count_filtered($golongan, $jenis),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


}

/* End of file Penilaian.php */
/* Location: ./application/controllers/Penilaian.php */ ?>