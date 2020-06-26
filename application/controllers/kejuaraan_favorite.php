<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kejuaraan_favorite extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function input() {
		$data["title"] = "Input Kejuaraan Favorite";
		$this->template->render_page("favorite/add_fav_v", $data);
	}

}

/* End of file kejuaraan_favorite.php */
/* Location: ./application/controllers/kejuaraan_favorite.php */ ?>