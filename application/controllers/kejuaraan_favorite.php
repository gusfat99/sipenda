<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kejuaraan_favorite extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("M_Favorite", 'Fav');
		$this->load->model('M_Menu', 'menu');
	}

	public function input() {
		$data["title"] = "Input Kejuaraan Favorite";
		$this->template->render_page("favorite/add_fav_v", $data);
	}

	public function add() {
		$countFormKriteria = intval($this->input->post('currentIndexForm'));
		$countFormKriteriaMin = intval($this->input->post('currentIndexFormMin'));


		$this->form_validation->set_rules('kejuaraan_fav', 'Kejuaraan Favorite', 'trim|required|xss_clean');

		$idSesi = get_sesi_lomba()->id_sesi;
		$strrdm = random_string(5);
		$kode = strtolower(date('yy').$idSesi.$strrdm.'FAV');
		$titleKejuaraan = [
			'id_juara_favorite' => $kode,
			"kejuaraan_favorite" => $this->input->post('kejuaraan_fav', true),
			"id_r_sesi" => $idSesi
		];
		$dataKriteria = [];

		for($i = 0; $i<=$countFormKriteria; $i++){
			$dataKriteria[$i] = [
				"id_r_mata_lomba" => $kode,
				"kriteria" => $this->input->post('kriteria_fav'.$i, true),
				"nilai_max" => $this->input->post('nilaimax_fav'.$i, true),
				"is_minus" => 0,
				"is_favorite" => 1
			];
			$this->form_validation->set_rules('kriteria_fav'.$i, 'Kriteria Penilaian', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nilaimax_fav'.$i, 'Nilai Maksimum', 'trim|required|numeric|xss_clean');
		}
		
		for($j=0; $j<=$countFormKriteriaMin; $j++) {
			$dataKriteria[$i] = [
				"id_r_mata_lomba" => $kode,
				"kriteria" => $this->input->post('kriteriaMinus_fav'.$j, true),
				"nilai_max" => -intval($this->input->post('nilaiMinus_fav'.$j, true)),
				"is_minus" => 1,
				"is_favorite" => 1
			];
			$this->form_validation->set_rules('kriteriaMinus_fav'.$j, 'Kriteria Nilai Min', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nilaiMinus_fav'.$j, 'Nilai Minus', 'trim|required|numeric|xss_clean');
			$i++;
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
			
			$result = $this->Fav->add($titleKejuaraan, $dataKriteria);

			if ($result >= 0) {
				$id_menu = random_string(3).'Fav';
				$menu = [
					"id_menu" => $id_menu,
					"title" => $titleKejuaraan["kejuaraan_favorite"],
					"level" => 'level 2',
					"parent_menu_id" => 10,
					"link" => "kejuaraan_favorite",
					"icon" => "",
					"sort_index" => 6,
					"is_active" =>  1,
					"is_mata_lomba" => 1,
					"id_r_mata_lomba" => $kode,
					"id_sesi_lomba" => $idSesi
				];
				$this->menu->insert_menu($menu);

				$return = [
					"error" => false,
					"rows_affected" => $result,
					"message" => "Berhasil di tambahkan"
				];
			}
			
		}
		echo json_encode($return);
	}

}

/* End of file kejuaraan_favorite.php */
/* Location: ./application/controllers/kejuaraan_favorite.php */ ?>