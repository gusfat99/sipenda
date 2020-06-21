<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		check_sesi_user();
		$this->load->model("M_user","user");
		$this->load->model('M_lomba', 'lomba');

	}

	// List all your items
	public function index( $offset = 0 )
	{
		$data["title"] = "Manajemen User";
		$data["lomba"] = $this->lomba->get_mata_lomba();
		$this->template->render_page("user_manajemen/manajemen_user_v", $data);
	}

	public function get_data_user()
    {
        $list = $this->user->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $field) {
        	$status = "Nonaktif";
        	$badgeColor = "danger";
        	if ($field->is_active == 1) {
        		$status = "Active";
        		$badgeColor = "success";
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->username;
            $row[] = $field->nama;
            $row[] = $field->level;
            $row[] = "<span class='btn btn-sm btn-".$badgeColor."'>".$status."</span>";
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->user->count_all(),
            "recordsFiltered" => $this->user->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function fetchUser() {
    	$username = $this->uri->segment(3);
    	$result = $this->user->fetchDataUser($username);
    	echo json_encode($result);
    }

	// Add a new item
	public function add()
	{
		$id = strtolower(random_string(5));
		$is_juri = 0;
		if ($this->input->post('levelUser') === "juri") {
			$is_juri = 1;
		}

		$data = [
			"id_user" => $id,
			"username" => strtolower($this->input->post('username', true)),
			"password" => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
			"nama" => $this->input->post('name', true),
			"level" => $this->input->post('levelUser', true),
			"is_juri" => $is_juri,
			"is_active" => 1
		];
		echo json_encode($this->user->insertUser($data));
	}

	//Update one item
	public function update( $id = NULL )
	{
		$data = [
			"nama" => $this->input->post('editName'),
			"username" => $this->input->post('editUser')
		];
		$result = $this->user->update_user($id, $data);
		if ($result) {
			$this->session->flashdata('success', "Data user berhasil di update");
		}
		echo json_encode($result);
	}

	//Delete one item
	public function delete( $id = NULL )
	{
		$result = $this->user->delete_user($this->input->post('user', true));
		if ($result) {
			echo json_encode($result);
		}
	}
}

/* End of file Manajemen_juri.php */
/* Location: ./application/controllers/Manajemen_juri.php */
 ?>