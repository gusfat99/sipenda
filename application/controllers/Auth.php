<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		
	}

	// List all your items
	public function index( $offset = 0 )
	{
		if ($this->session->userdata('username')) {
			$this->session->set_flashdata('notif', 'Sesi anda masih aktif');
			redirect('home','refresh');
		}
		$this->load->view("auth");
	}

	public function authenticate() {
		$username = $this->input->post('user');
		$password = $this->input->post('pw');
		$user = $this->db->get_where("users", ["username" => $username])->row_array();
		if ($user) {
			if (password_verify($password, $user["password"])) {
				$data_sesi = [
					"username" => $user["username"],
					"name" => $user["nama"],
					"level" => $user["level"],
					"is_juri" => $user['is_juri']
				];
				$this->session->set_userdata( $data_sesi );
				echo json_encode(["auth" => true, "message" => "Login Berhasil"]);
			} else {
				echo json_encode(["auth" => false, "message" => "Gagal login, cek username dan password!"]);
			}
		} else {
			echo json_encode(["auth" => false, "message" => "Gagal login, cek username dan password!"]);
		}
	}

	public function logout() {
		$data_sesi = ["username", "name", "is_juri"];
		$this->session->unset_userdata($data_sesi);
		$this->session->set_flashdata('notif', 'Anda Berhasil Logout');
		redirect('auth','refresh');
	}
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
 ?>