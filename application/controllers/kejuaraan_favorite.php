<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kejuaraan_favorite extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function input() {
		$data["title"] = "Input Kejuaraan Favorite";
		$this->template->render_page("favorite/add_fav_v", $data);
	}

	public function add() {
		$countFormKriteria = intval($this->input->post('currentIndexForm'));
		$countFormKriteriaMin = intval($this->input->post('currentIndexFormMin'));

		var_dump($countFormKriteria);
		var_dump($countFormKriteriaMin); die;
		$this->form_validation->set_rules('kejuaraan_fav', 'Kejuaraan Favorite', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kriteria_fav', 'Kriteria Penilaian', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nilaimax_fav', 'Nilai Maksimum', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kriteriaMinus_fav', 'Kriteria Nilai Min', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nilaiMinus_fav', 'Nilai Minus', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$return = [
				"error" => true,
				"kejuaraan_err" => form_error('kejuaraan_fav'),
				"kriteria_err" => form_error('kriteria_fav'),
				"nilaimax_err" => form_error("nilaimax_fav"),
				"kriteriaMin_err" => form_error("kriteriaMinus_fav"),
				"nilaiMinus_err" => form_error("nilaiMinus_fav")
			];
		} else {
			$return = [
				"error" => false
			];
		}
		echo json_encode($return);
	}

}

/* End of file kejuaraan_favorite.php */
/* Location: ./application/controllers/kejuaraan_favorite.php */ ?>