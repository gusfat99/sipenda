<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Penilaian extends CI_Model {

	private $table = 'daftar_peserta'; //nama tabel dari database
	private $table_fr = "juri";
	private $column_order = array(null, null, null,'nomor_peserta', 'nama_pangkalan', 'jenis', 'tingkatan', 'tgl_regist'); //field yang ada di table peserta
	private $column_search = array('nomor_peserta','nama_pangkalan'); //field yang diizin untuk pencarian 
	private $order = array('nomor_peserta' => 'asc'); // default order 

	private function _get_datatables_query() {
		$this->db->from($this->table);

		$i = 0;

	    foreach ($this->column_search as $item) // looping awal
	    {
	      	if (isset($_POST["search"])) {
	            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
	            {

	                 if($i===0) // looping awal
	                 {
	                 	$this->db->group_start(); 
	                 	$this->db->like($item, $_POST['search']['value']);
	                 }
	                 else
	                 {
	                 	$this->db->or_like($item, $_POST['search']['value']);
	                 }

	                 count($this->column_search) - 1 == $i ? $this->db->group_end() : null; 
	             }
	         }

        	$i++;
    	}

	    if(isset($_POST['order'])) {
	     	$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	    } 
	    else if(isset($this->order))
	    {
	     	$order = $this->order;
	     	$this->db->order_by(key($order), $order[key($order)]);
	    }
	}

	public function get_datatables($golongan, $jenis) {
	 	$this->_get_datatables_query();

	 	if($this->input->post('length') != -1)
	 		$this->db->limit( $this->input->post('length'), $this->input->post('start') );
	 	$this->db->where("jenis", $jenis);
	 	$this->db->where("tingkatan", $golongan);
	 	$query = $this->db->get();
	 	return $query->result();
	}

	public function count_all($golongan, $jenis){
		$this->db->from($this->table);
		$this->db->where("jenis", $jenis);
		$this->db->where("tingkatan", $golongan);
     	return $this->db->count_all_results();
	}

	public function count_filtered($golongan, $jenis){
		$this->_get_datatables_query();
		$this->db->where("jenis", $jenis);
		$this->db->where("tingkatan", $golongan);
		$query = $this->db->get();
		return $query->num_rows();
	}

}

/* End of file M_Penilaian.php */
/* Location: ./application/models/M_Penilaian.php */ ?>