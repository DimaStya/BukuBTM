<?php
  
class MY_Controller extends CI_Controller {
  public $ACT = null;
  public function __construct() {
    parent::__construct();
    // $this->mlog->setHarga();
    if ($this->URI1 == 'login') {
      $this->mlog->RouteURLLogout($this->IS_LOGIN);
    } else {
      $this->mlog->RouteURLLogin($this->IS_LOGIN);
      
    }
  }

  public function ProsesAdd($data, $tabel, $id, $namaId)
	{
		$callback = array();
		if(empty($id)){ //insert
			$callback['proses'] = 'Ditambahkan';
			$q = $this->mproses->Insert($tabel, $data);
			$callback['hasil'] = ($q) ? 'success' : 'error';	
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
	public function ProsesDel($tabel, $id, $namaId)
	{
		$callback = array();
			$callback['proses'] = 'Dihapus';
		if(empty($id)){ 
			$callback['hasil'] = 'error';
		}else{ 
			$where = array($namaId => $id,);
			$q = $this->mproses->Delete($tabel, $where);
			$callback['hasil'] = ($q) ? 'success' : 'error';	
		}
		return $callback;
	}
  
}