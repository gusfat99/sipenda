<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

   private $table = 'users'; //nama tabel dari database
   private $table_fr = "juri";
   private $column_order = array(null, 'username', null,'nama', 'id_level', 'id_mata_lomba', 'is_juri'); //field yang ada di table user
   private $column_search = array('username','nama'); //field yang diizin untuk pencarian 
   private $order = array('id_user' => 'asc'); // default order 

   private function _get_datatables_query()
   {

      $this->db->from($this->table);

      $i = 0;

      foreach ($this->column_search as $item) // looping awal
      {
         if ($this->input->post("search")) {
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

      if(isset($_POST['order'])) 
      {
       $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } 
      else if(isset($this->order))
      {
       $order = $this->order;
       $this->db->order_by(key($order), $order[key($order)]);
      }
   }

   function get_datatables()
   {
      $this->_get_datatables_query();
      if (isset($_POST['length'])) {
         if($_POST['length'] != -1) 
         $this->db->limit($_POST['length'], $_POST['start']);
      }
     
      $this->db->where("is_active",1);
      $query = $this->db->get();
      return $query->result();
   }

   public function fetchDataUser($username, $is_juri = 0) {
      if ($username) {
         if ($is_juri == 1) {
            $this->db->where("is_juri",1);
            return $this->db->get_where($this->table, ["username" => $username])->row();   
         }
         return $this->db->get_where($this->table, ["username" => $username])->row();
      } else {
         if ($is_juri == 1) {
              return $this->db->get_where($this->table, ["is_juri" => 1])->result();     
         }
         return $this->db->get($this->table)->result();
      }
   }

   public function fetchDataJuri($id_user = null) {
      if (!$id_user) {
          return $this->db->get($this->table_fr)->result();    
      }
      return $this->db->get_where($this->table_fr, ["id_r_user" => $id_user])->result();
   }

   public function insertUser($data) {
      $result = $this->db->insert($this->table, $data);
      if ($result) {
         // if ($data["is_juri"] == 1) {
         //    $lombaSelected = $this->input->post('matalomba');
         //    $this->_insertJuri($data["id_user"], $lombaSelected);
         // }
         return $result;
      }
      return false;
     
   }

   // private function _insertJuri($id, $lomba) {
   //    $data = [];
   //    for ($i=0; $i < count($lomba); $i++) { 
   //       $data[$i] = [
   //          "id_r_user" => $id,
   //          "id_r_mata_lomba" => $lomba[$i]
   //       ];
   //    }
   //    return $this->db->insert_batch($this->table_fr, $data);
   // }

   public function update_user($id, $data) {
      $lombaSelected = $this->input->post('matalombaEdit');
      $result =  $this->db->update($this->table,$data, ["id_user" => $id]);
      $dataLombaJuri = $this->fetchDataJuri($id);
      // $dataLomba = [];
      if ($result) {
         //  if(is_array($lombaSelected)) {
         //    $i = 0;
         //    foreach($dataLombaJuri as $juri){
         //       $dataLomba[$i] = [
         //          "id_juri" => $juri->id_juri,
         //          "id_r_user" => $id,
         //          "id_r_mata_lomba" => $lombaSelected[$i]
         //       ];
         //       $i++;
         //    }
         //    $this->update_juri($dataLomba);
         // }
         return $result;
      }
      return false;
   }

   // private function update_juri($data) {
   //    return $this->db->update_batch($this->table_fr, $data, "id_juri");
   // }

   function count_filtered()
   {
     $this->_get_datatables_query();
     $query = $this->db->get();
     return $query->num_rows();
   }

   public function count_all()
   {
     $this->db->from($this->table);
     return $this->db->count_all_results();
   }

   public function delete_user($user) {
      $users = $this->fetchDataUser($user);
      if ($users->is_juri == 1) {
         $this->db->delete($this->table_fr, ["id_r_user" => $users->id_user]);
      }
     return $this->db->delete($this->table, ["username" => $user]);
   }

}

/* End of file M_user.php */
/* Location: ./application/models/M_user.php */ ?>