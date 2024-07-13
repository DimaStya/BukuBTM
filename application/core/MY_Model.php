<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class MY_Model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
	 // mysql
  public function CreatQueryMysql($query, $order, $dir = '', $panjang ='')
  {
    $start = $_POST['start'];
    // $length = $_POST['length'];
    $search = $_POST['search']['value'];
    $length = (!empty($panjang)) ? $panjang : $_POST['length'];
    $ordermode = (!empty($dir)) ? $dir : $_POST['order'][0]['dir'];

    $data = array();
    $data['recordsTotal'] = $this->db->query($query)->num_rows();
    
    $where = '';
    if ($search != '') {
      $where = 'WHERE ';
      $cari = explode(';', $search);
      foreach ($cari as $row) {
        $where .= "cari like '%" . $row . "%' AND ";
      }
      $where = substr($where, 0, strlen($where) - 4);
    }
    $query = "SELECT * FROM ($query) as c $where";

    $data['recordsFiltered'] = $this->db->query($query)->num_rows();
    
    // $query = "Select  * , @rowid := @rowid + 1 AS ROWNUM from ( " . $query . " ORDER BY $order $ordermode ) as tbd, (SELECT @rowid := 0) dummy ";
    $query = "SELECT * FROM ($query) d ORDER BY $order $ordermode";
    
    if ($start == 0) {
      if ($length == -1) {
        $query = $query;
      } else {
        $query = $query." LIMIT $length";
      }
    } else {
      $order2 = $start + 1;
      $akhir = $start + $length;
      if ($length == -1) {
        $query = $query;
      } else {
        $query = $query." LIMIT $length OFFSET $start";
      }
    }
    $data['data'] = $this->db->query($query)->result();
    return $data;
  }

  //sql server

 public function CreatQuerySrv($query, $order, $dir='') {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $search = $_POST['search']['value'];
    if(!empty($dir)){
      $ordermode = $dir;
    }else{
      $ordermode = $_POST['order'][0]['dir'];
    }
    
    $data = array();
    $data['recordsTotal'] = $this->db->query($query)->num_rows();

    $where = '';
    if($search != ''){
      $where = 'WHERE ';
      $cari = explode(';', $search);
      foreach ($cari as $row) {
        $where .= "cari like '%".$row."%' AND ";
      }
      $where = substr($where,0, strlen($where)-4);
    }
    $query = "SELECT * FROM ($query) as c $where";

    $data['recordsFiltered'] = $this->db->query($query)->num_rows();

    $query = "Select  * , ROW_NUMBER() OVER(ORDER BY $order $ordermode) AS ROWNUM  from ( " . $query . " ) as tbd ";
      if ($start == 0) {
        if($length == -1){
          $query = "Select * from ($query) as d order by rownum";
        }else{
          $query = "Select * from ($query) as d where ROWNUM between " . $start . " and " .$length . " order by rownum";
        }
      } else {
        $order2 = $start + 1;
        $akhir = $start + $length;
        if($length == -1){
          $query = "Select * from ($query) as d order by rownum";
        }else{
          $query = "Select * from ($query) as d where ROWNUM between " . $order2 . " and " . $akhir . " order by rownum";
        }
        
      }
      $data['data'] = $this->db->query($query)->result();
      return $data;
  }
   // mysql
  public function CreatQueryMysql1($query, $order, $dir = '')
  {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $search = $_POST['search']['value'];
    if(!empty($dir)){
      $ordermode = $dir;
    }else{
      $ordermode = $_POST['order'][0]['dir'];
    }
    
    $data = array();
    $data['recordsTotal'] = $this->db->query($query)->num_rows();

    $where = '';
    if($search != ''){
      $where = 'WHERE ';
      $cari = explode(';', $search);
      foreach ($cari as $row) {
        $where .= "cari like '%".$row."%' AND ";
      }
      $where = substr($where,0, strlen($where)-4);
    }
    $query = "SELECT * FROM ($query) as c $where";

    $data['recordsFiltered'] = $this->db->query($query)->num_rows();

    
    if($start == 0){
      if($length == -1){
        $query = "SELECT * FROM (".$query.") as tbd ORDER BY $order $ordermode";
      }else{
        $p = ($length*10);
        $query = "SELECT * FROM (".$query.") as tbd ORDER BY $order $ordermode LIMIT $start,$p";
      }
    }else{
      if($length == -1){
        $query = "SELECT * FROM (".$query.") as tbd ORDER BY $order $ordermode";
      }else{
        $s = ($start * 10)+1;
        $p = ($start * 10)+($length*10);
        $query = "SELECT * FROM (".$query.") as tbd ORDER BY $order $ordermode LIMIT $s, $p";
      }      
    }
      $data['data'] = $this->db->query($query)->result_array();
      return $data;
  }

  //sql server

 public function CreatQuerySrv1($query, $order, $dir='') {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $search = $_POST['search']['value'];
    if(!empty($dir)){
      $ordermode = $dir;
    }else{
      $ordermode = $_POST['order'][0]['dir'];
    }
    
    $data = array();
    $data['recordsTotal'] = $this->db->query($query)->num_rows();

    $where = '';
    if($search != ''){
      $where = 'WHERE ';
      $cari = explode(';', $search);
      foreach ($cari as $row) {
        $where .= "cari like '%".$row."%' AND ";
      }
      $where = substr($where,0, strlen($where)-4);
    }
    $query = "SELECT * FROM ($query) as c $where";

    $data['recordsFiltered'] = $this->db->query($query)->num_rows();

    $query = "Select  * , ROW_NUMBER() OVER(ORDER BY $order $ordermode) AS ROWNUM  from ( " . $query . " ) as tbd ";
      if ($start == 0) {
        if($length == -1){
          $query = "Select * from ($query) as d order by rownum";
        }else{
          $query = "Select * from ($query) as d where ROWNUM between " . $start . " and " .$length . " order by rownum";
        }
      } else {
        $order2 = $start + 1;
        $akhir = $start + $length;
        if($length == -1){
          $query = "Select * from ($query) as d order by rownum";
        }else{
          $query = "Select * from ($query) as d where ROWNUM between " . $order2 . " and " . $akhir . " order by rownum";
        }
        
      }
      $data['data'] = $this->db->query($query)->result_array();
      return $data;
  }

  ######################################################
  public function ProsesAdd($data, $tabel, $id, $namaId)
	{
		$callback = array();
		if(empty($id)){ //insert
			$callback['proses'] = 'Ditambahkan';
			$q = $this->mproses->Insert($tabel, $data);
			$callback['hasil'] = ($q) ? 'success' : 'erorr';	
		}else{ //update
			$callback['proses'] = 'Dirubah';
			$where = array($namaId => $id,);
			$q = $this->mproses->Update($tabel, $data, $where);
			$callback['hasil'] = 'success';	
		}
		return $callback;
	}
	public function CreateArray($list)
	{
		$data = array();
		for ($i=0; $i < count($list); $i++) { 
			$data[$list[$i]] = $this->input->post($list[$i]);
		}
		return $data;
	}
	public function ProsesDel($tabel, $methode, $id, $namaId)
	{
		$callback = array();
			$callback['proses'] = 'Dihapus';
		if(empty($id)){ 
			$callback['hasil'] = 'erorr';
		}else{       
      $where = array($namaId => $id,);
      if($methode == 's'){
        $data = array('aktif' => 0, 'tanggalHapus' => date('Y-m-d H:i:s'),);
        $q = $this->mproses->Update($tabel, $data, $where);
			  $callback['hasil'] = 'success';
      }else if($methode == 'h'){
        $q = $this->mproses->Delete($tabel, $where);
        $callback['hasil'] = ($q) ? 'success' : 'erorr';
      }				
		}
		return $callback;
	}
  public function CreateData($query, $list)
  {
    $query = $this->db->query($query)->row_array();
    $data = array();
    for ($i=0; $i < count($list); $i++) { 
      $data[$list[$i]] = '';
    }
    if(is_null($query)){      
      for ($i=0; $i < count($list); $i++) { 
        $data[$list[$i]] = '';
      }
    }else{
      for ($i=0; $i < count($list); $i++) { 
        $data[$list[$i]] = $query[$list[$i]];
      }
    }
    return $data;
  }
}

?>