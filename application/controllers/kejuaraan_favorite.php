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


		$this->form_validation->set_rules('kejuaraan_fav', 'Kejuaraan Favorite', 'trim|required|xss_clean');

		for($i = 0; $i<=$countFormKriteria; $i++){
			$this->form_validation->set_rules('kriteria_fav'.$i, 'Kriteria Penilaian', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nilaimax_fav'.$i, 'Nilai Maksimum', 'trim|required|numeric|xss_clean');
		}
		
		for($j=0; $j<=$countFormKriteriaMin; $j++) {
			$this->form_validation->set_rules('kriteriaMinus_fav'.$j, 'Kriteria Nilai Min', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nilaiMinus_fav'.$j, 'Nilai Minus', 'trim|required|numeric|xss_clean');
		}
		
		

		if ($this->form_validation->run() == FALSE) {
			$return = [
				"error" => true,
				"kejuaraan_fav" => form_error("kejuaraan_fav")
			];
			for($i = 0; $i<=$countFormKriteria; $i++) {
				$return["kriteria_fav".$i] = form_error("kriteria_fav".$i);
				$return["nilaimax_fav".$i] = form_error("nilaimax_fav".$i);
				
			}
			for($j=0; $j<=$countFormKriteriaMin; $j++) {
				$return["kriteriaMinus_fav".$j] = form_error("kriteriaMinus_fav".$j); 
				$return["nilaiMinus_fav".$j] = form_error("nilaiMinus_fav".$j);
			}
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