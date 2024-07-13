<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mproses extends CI_Model {	
		
	public function Insert_multiple($tabel, $data){
		$this->db->insert_batch($tabel, $data);
	}
  public function Delete($table, $where){
    $res = $this->db->delete($table, $where); 
    return $res;
  }
	public function Insert($table,$data){
    $res = $this->db->insert($table, $data);
    return $res;
  }
  public function Update($table, $data, $where){
    $res = $this->db->update($table, $data, $where);
    return $res;
  }
  // select sederhana
  public function GetData($apa, $dari, $where = '', $format) {
    $q = (!empty($where)) ? $this->db->query("SELECT $apa FROM $dari WHERE $where") : $this->db->query("SELECT $apa FROM $dari");
    switch ($format) {
      case 'result':
        $query = $q->result();
        break;
      case 'row':
        $query = $q->row_array();
        break; 
      case 'result_array':
        $query = $q->result_array();
        break;      
      default:
        $query = 'error!!!';
        break;
    }
    return $query;
  }

  // gif|jpg|png|jpeg|bmp
  // xls|xlsx
  // pdf
  public function UploadFile($path, $type, $namaBaru, $namaInput) {
    $config['upload_path']="./".$path;
    $config['allowed_types']=$type;
    $config['file_name'] = $namaBaru;
    $this->load->library('upload',$config);

    if($this->upload->do_upload($namaInput)){
      $data = array('upload_data' => $this->upload->data());
      $image= $data['upload_data']['file_name'];
    }
  }
  public function UploadFileR($path, $type, $namaBaru, $namaInput, $quality, $w, $h) {
    $config['upload_path']="./".$path;
    $config['allowed_types'] = $type;
    $this->load->library('upload',$config);
    $this->load->library('image_lib');
    if(!empty($_FILES[$namaInput]['name'])){
      if ($this->upload->do_upload($namaInput)){
        $gbr = $this->upload->data();
        $temp = explode(".", $_FILES[$namaInput]["name"]);
        $nama_baru = $namaBaru . '.' . end($temp);
        //Comprese
        $config['image_library']='gd2';
        $config['source_image']='./'.$path.'/'.$gbr['file_name'];
        $config['create_thumb']= FALSE;
        $config['maintain_ratio']= FALSE;
        $config['quality']= $quality;
        $config['width']= $w;
        $config['height']= $h;
        $config['new_image']= './'.$path.'/'.$nama_baru;
        $this->image_lib->clear();
        $source =  @ImageCreateFromJpeg($filesave);

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        unlink($config['source_image']);
      }
    }

  }
  public function DeleteFile($path, $file) {
    $path = "./".$path;
    $get_file = $path.$file; 
    if(file_exists($get_file)){ unlink($get_file); }
  }
  public function GetKodeMax($tabel, $id) {
    $jumlah = $this->db->query("SELECT MAX($id) as id FROM $tabel")->num_rows();
    $sql = $this->db->query("SELECT MAX($id) as id FROM $tabel")->row_array();
    $data = array('id' => $sql['id'], 'jumlah' => $jumlah);
    return $data;
  }
  public function CreateKode($tabel, $id, $awal, $jumnol, $separe) {
    $kode = $this->GetKodeMax($tabel, $id);
    if($kode['jumlah'] == 0){ //data pertama
      $kode_asli = $awal.$separe.sprintf('%0'.$jumnol.'d',1);
    }else{ //data lebih dari satu
      $angka =  explode($awal.$separe, $kode['id']);
      $number = $angka[1];
      $number = sprintf('%0'.$jumnol.'d',$number+1);
      $kode_asli = $awal.$separe.$number;
    }
    return $kode_asli;
  }
}