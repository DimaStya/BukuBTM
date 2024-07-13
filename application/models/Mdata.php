<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Mdata extends MY_Model {
	public function GetDataMenu() {
		$idMenu = $this->input->post('idMenu');

		$query = $this->db->query("SELECT * FROM menu WHERE idMenu = '$idMenu'")->row_array();
    if(is_null($query)){
      $data = array('idMenu' => '', 'namaMenu' => '', 'menuIcon' => '');
    }else{
      $data = array('idMenu' => $query['idMenu'], 'namaMenu' => $query['namaMenu'], 'menuIcon' => $query['menuIcon'],);
    }
    
    echo json_encode($data);
	}
  public function GetJumlahDataMenu()
  {
    $idMenu = $this->input->post('idMenu');
    $mn = $this->db->query("SELECT urutan FROM menu WHERE idMenu <> $idMenu ORDER BY urutan")->result();
    $ls = '';
    foreach ($mn as $row) {
      $ls .= '<option value="'.$row->urutan.'">'.$row->urutan.'</option>';
    }
    $output = array('data' => $ls);
    echo json_encode($output);
  }
  public function GetJumlahDataMenus()
  {
    $idMenus = $this->input->post('idMenus');
    $idMenu = $this->input->post('idMenu');
    $mn = $this->db->query("SELECT urutans FROM menus WHERE idMenus <> $idMenus AND idMenu = $idMenu ORDER BY urutans")->result();
    $ls = '';
    foreach ($mn as $row) {
      $ls .= '<option value="'.$row->urutans.'">'.$row->urutans.'</option>';
    }
    $output = array('data' => $ls);
    echo json_encode($output);
  }
  public function GetDataMenus() {
		$idMenus = $this->input->post('idMenus');

		$query = $this->db->query("SELECT mc.*, mn.namaMenu FROM menus mc, menu mn WHERE mn.idMenu = mc.idMenu AND mc.idMenus = '$idMenus'")->row_array();
    if(is_null($query)){
      $idMenu = $this->input->post('idMenu');
      $mn = $this->db->query("SELECT namaMenu FROM menu WHERE idMenu = '$idMenu'")->row_array();
      $data = array('idMenus' => '', 'namaMenus' => '', 'menuIcons' => '','namaMenu' => $mn['namaMenu'], 'contr' => '', 'meth' => '' );      
    }else{
      $link = explode('/',$query['link']);
      $data = array('idMenus' => $query['idMenus'], 'namaMenus' => $query['namaMenus'], 'menusIcon' => $query['menusIcon'],'namaMenu' => $query['namaMenu'],'contr' => $link[0], 'meth' => $link[1]);
    }    
    echo json_encode($data);
	}
  public function GetDataListUser()
  {
    $user = $this->db->query("SELECT username, nama FROM user")->result();
    $ls = '<option value="">Pilih User</option>';
    foreach ($user as $row) {
      $ls .= '<option value="'.$row->username.'">'.$row->nama.'</option>';
    }
    $data = array('data' => $ls, );
    echo json_encode($data);
  }
  public function GetDataUser()
  {
    $username = $this->input->post('username');
    $query = $this->db->query("SELECT username, nama, additional FROM user WHERE username = '$username'")->row_array();
    if(is_null($query)){
      $data = array('username' => '', 'nama' => '', 'additional' => 'TIDAK');
    }else{
      $data = array('username' => $query['username'], 'nama' => $query['nama'], 'additional' => $query['additional']);
    }   
    echo json_encode($data);
  }
  public function CheckUser()
  {
    $hUsername = $this->input->post('hUsername');
    $username = $this->input->post('username');
    if (empty($username)) {
      $data['hasil'] = 'tidak';
    } else {
      if (empty($hUsername)) {
        $q = $this->db->query("SELECT * FROM user WHERE username = '$username'")->num_rows();
      } else {
        $q = $this->db->query("SELECT * FROM user WHERE username = '$username' AND username <> '$hUsername'")->num_rows();
      }

      $data['hasil'] = ($q == 1) ? 'tidak' : 'boleh';
    }
    echo json_encode($data);
  }
  public function GetDataKategori()
  {
    $idKategori = $this->input->post('idKategori');
    $query = $this->db->query("SELECT idKategori, namaKategori, kode FROM kategori WHERE idKategori = '$idKategori'")->row_array();
    if(is_null($query)){
      $data = array('idKategori' => '', 'namaKategori' => '', 'kode' => '');
    }else{
      $data = array('idKategori' => $query['idKategori'], 'namaKategori' => $query['namaKategori'], 'kode' => $query['kode']);
    }   
    echo json_encode($data);
  }
  public function GetDataBarang()
  {
    $kodeBarang = $this->input->post('kodeBarang');
    $query = $this->db->query("SELECT kodeBarang, namaBarang, idKategori, satuanEcer, satuanPaket, konversi, hargaBeliEcer, hargaBeliPaket, hargaJualEcer, hargaJualPaket FROM barang WHERE kodeBarang = '$kodeBarang'")->row_array();
    if(is_null($query)){
      $data = array('kodeBarang' => '', 'namaBarang' => '', 'kodeBarang' => '', 'idKategori' => '', 'satuanEcer' => '', 'satuanPaket' => '', 'konversi' => '', 'hargaBeliEcer' => '', 'hargaBeliPaket' => '', 'hargaJualEcer' => '', 'hargaJualPaket' => '');
    }else{
      $data = array('kodeBarang' => $query['kodeBarang'], 'namaBarang' => $query['namaBarang'], 'idKategori' => $query['idKategori'], 'satuanEcer' => $query['satuanEcer'], 'satuanPaket' => $query['satuanPaket'], 'konversi' => $query['konversi'], 'hargaBeliEcer' => $query['hargaBeliEcer'], 'hargaBeliPaket' => $query['hargaBeliPaket'], 'hargaJualEcer' => $query['hargaJualEcer'], 'hargaJualPaket' => $query['hargaJualPaket']);
    }   
    echo json_encode($data);
  }  
  public function CheckKodeBarang()
  {
    $kodeBarangH = $this->input->post('kodeBarangH');
    $kodeBarang = $this->input->post('kodeBarang');
    if (empty($kodeBarang)) {
      $data['hasil'] = 'tidak';
    } else {
      if (empty($kodeBarangH)) {
        $q = $this->db->query("SELECT * FROM barang WHERE kodeBarang = '$kodeBarang'")->num_rows();
      } else {
        $q = $this->db->query("SELECT * FROM barang WHERE kodeBarang = '$kodeBarang' AND kodeBarang <> '$kodeBarangH'")->num_rows();
      }

      $data['hasil'] = ($q == 1) ? 'tidak' : 'boleh';
    }
    echo json_encode($data);
  }
  public function GetDataListKategori()
  {
    $kategori = $this->db->query("SELECT namaKategori, kode, idKategori FROM kategori")->result();
    $ls = '<option value="">Pilih Kategori</option>';
    foreach ($kategori as $row) {
      $ls .= '<option value="'.$row->idKategori.'">('.$row->kode.') '.$row->namaKategori.'</option>';
    }
    $data = array('data' => $ls, );
    echo json_encode($data);
  }
  public function GetDataListBarang($idKategori)
  {
    if(!empty($idKategori)){
      $barang = $this->db->query("SELECT namaBarang, kodeBarang, kodeBarang FROM barang WHERE idKategori = '".$idKategori."'")->result();
    }else{
      $barang = $this->db->query("SELECT namaBarang, kodeBarang, kodeBarang FROM barang")->result();
    }
    $ls = '<option value="">Pilih Barang</option>';
    foreach ($barang as $row) {
      $ls .= '<option value="'.$row->kodeBarang.'">('.$row->kodeBarang.') '.$row->namaBarang.'</option>';
    }
    $data = array('data' => $ls, );
    echo json_encode($data);
  }
  public function GetDataListBarangB($idKategori)
  {
    $kodeBarang = $this->input->post('kodeBarang');
    if(!empty($idKategori)){
      $barang = $this->db->query("SELECT namaBarang, kodeBarang, kodeBarang FROM barang WHERE idKategori = '".$idKategori."' AND kodeBarang <> '$kodeBarang'")->result();
    }else{
      $barang = $this->db->query("SELECT namaBarang, kodeBarang, kodeBarang FROM barang WHERE kodeBarang <> '$kodeBarang'")->result();
    }
    $ls = '<option value="">Pilih Barang</option>';
    foreach ($barang as $row) {
      $ls .= '<option value="'.$row->kodeBarang.'">('.$row->kodeBarang.') '.$row->namaBarang.'</option>';
    }
    $data = array('data' => $ls, );
    echo json_encode($data);
  }
  public function GetHeaderHarga()
  {
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $tb = '<table id="tbHarga" class="table table-bordered table-striped" width="100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Kategori</th>
        <th>Nama Barang</th>
        <th>Kode Barang</th>';
    if(strtotime($dari) == strtotime($sampai)){
      //1 tanggal
      $kecil = date("Ymd", strtotime($dari));
      $tb .= '<th>'.$kecil.'</th>';
    }else {
      if(strtotime($dari) > strtotime($sampai)){
        //mundur
        $dari = date("Ymd", strtotime($dari));
        $sampai = date("Ymd", strtotime($sampai));
        while (strtotime($dari) >= strtotime($sampai)) {
          $tb .= '<th>'.$dari.'</th>';
          $dari = date('Ymd', strtotime('-1 days', strtotime($dari)));
        }        
      }else {
        //maju
        $dari = date("Ymd", strtotime($dari));
        $sampai = date("Ymd", strtotime($sampai));
        while (strtotime($dari) <= strtotime($sampai)) {
          $tb .= '<th>'.$dari.'</th>';
          $dari = date('Ymd', strtotime('+1 days', strtotime($dari)));
        }        
      }      
    }  

    $tb .= '</tr>
    </thead>
    <tbody>

    </tbody>
  </table>';
  
    $data = array('data' => $tb, );
    echo json_encode($data);
  }
  public function GetDataProgram()
  {
    $idProgram = $this->input->post('idProgram');
    $query = $this->db->query("SELECT p.idProgram, p.namaProgram, k.idKategori, b.kodeBarang, p.tipeProgram, p.tipePotongan, p.jumlahEcer, p.nilai, p.kodeBarangB FROM program p LEFT JOIN barang b ON p.kodeBarang = b.kodeBarang LEFT JOIN kategori k ON b.idKategori = k.idKategori WHERE p.idProgram = '".$idProgram."'")->row_array();
    if(is_null($query)){
      $data = array('idProgram' => '', 'namaProgram' => '', 'idKategori' => '', 'kodeBarang' => '', 'tipeProgram' => 'Kelipatan', 'tipePotongan' => 'Rupiah', 'jumlahEcer' => '', 'nilai' => '', 'kodeBarangB' => '', 'sama' => 'sama',);
    }else{
      $sama = ($query['kodeBarang'] == $query['kodeBarangB']) ? 'sama' : 'beda';
      $data = array('idProgram' => $query['idProgram'], 'namaProgram' => $query['namaProgram'], 'idKategori' => $query['idKategori'], 'kodeBarang' => $query['kodeBarang'], 'tipeProgram' => $query['tipeProgram'], 'tipePotongan' => $query['tipePotongan'], 'jumlahEcer' => $query['jumlahEcer'], 'nilai' => $query['nilai'], 'kodeBarangB' => $query['kodeBarangB'], 'sama' => $sama,);
    }   
    echo json_encode($data);
  }
  public function makeRand($arr, $loop, $table, $id)
  {
    $kode = '';
    for ($i=0; $i < $loop; $i++) {
      $kode .= $arr[rand(0,(strlen($arr)-1))];
    }
    
    $cek = $this->db->query("SELECT $id FROM $table WHERE $id = '$kode'")->num_rows();
    $data = array('cek' => $cek, $id => $kode);
    return $data;

  }
  public function GetKodeMember()
  {
    // $ar = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    // $get = $this->makeRand($ar,10,'member', 'idMember');
    // print_r($get);
    $idMember = $this->input->post('idMember');
    if(empty($idMember)){ 
      $ar = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $get = $this->makeRand($ar,20, 'member', 'idMember');
      while ($get['cek'] == 1) {
        $get = $this->makeRand($ar,20, 'member', 'idMember');
      }
      $in = array('idMember' => $get['idMember']);
			$q = $this->mproses->Insert('member', $in);
      if($q){
        $data = array('stat' => 'belum', 'idMember' => $get['idMember']);
      }else{
        $data = array('stat' => 'sudah', 'idMember' => $get['idMember']);
      }     
    }else{
      $data = array('stat' => 'sudah', 'idMember' => $idMember);
    }
    echo json_encode($data);
  }
  public function GetDataMember()
  {
    $idMember = $this->input->post('idMember');
    $query = $this->db->query("SELECT idMember, namaMember, noHp, alamat FROM member WHERE idMember = '".$idMember."'")->row_array();
    if(is_null($query)){
      $data = array('idMember' => '', 'namaMember' => '', 'noHp' => '', 'alamat' => '');
    }else{
      $data = array('idMember' => $query['idMember'], 'namaMember' => $query['namaMember'], 'noHp' => $query['noHp'], 'alamat' => $query['alamat']);
    }   
    echo json_encode($data);
  }
  public function GetDataListMember()
  {
    $barang = $this->db->query("SELECT namaMember, idMember, noHp FROM member")->result();
    $ls = '';
    foreach ($barang as $row) {
      $ls .= '<option value="'.$row->idMember.'">('.$row->idMember.' - '.$row->noHp.') '.$row->namaMember.'</option>';
    }
    $data = array('data' => $ls, );
    echo json_encode($data);
  }
  public function GetKodeDiskon()
  {
    // $ar = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    // $get = $this->makeRand($ar,10);
    // print_r($get);
    $kodeDiskon = $this->input->post('kodeDiskon');
    if(empty($kodeDiskon)){ 
      $ar = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $get = $this->makeRand($ar,7, 'diskon', 'kodeDiskon');
      while ($get['cek'] == 1) {
        $get = $this->makeRand($ar,7, 'diskon', 'kodeDiskon');
      }
      $data = array('stat' => 'belum', 'kodeDiskon' => $get['kodeDiskon']);
       
    }else{
      $data = array('stat' => 'sudah', 'kodeDiskon' => $kodeDiskon);
    }
    echo json_encode($data);
  }
  public function GetDataDiskon()
  {
    $idDiskon = $this->input->post('idDiskon');   
    
    $query = "SELECT kodeDiskon, besaran, minimum,  maximumDiskon, exp, metodeDiskon FROM diskon WHERE idDiskon = '$idDiskon'";
    $list = ['kodeDiskon', 'besaran', 'minimum', 'maximumDiskon', 'exp', 'metodeDiskon'];
    $data = $this->CreateData($query,$list); 
    
    echo json_encode($data);
  }
  public function chekVoucher()
  {
    $kodeDiskon = $this->input->post('kodeDiskon');
    $cek = $this->db->query("SELECT kodeDiskon FROM diskon WHERE kodeDiskon = '$kodeDiskon'")->num_rows();
    if($cek == 0 AND !empty($kodeDiskon)){
      $data = array('stat' => 'belum');
    }else{
      $data = array('stat' => 'sudah');
    }
    echo json_encode($data);
  }
  public function GetDataDiskonMember()
  {
    $idDiskon = $this->input->post('idDiskon');
    $query = $this->db->query("SELECT idDiskon, kodeDiskon, metodeDiskon, besaran, minimum, maximumDiskon, exp, am FROM diskon WHERE idDiskon = '".$idDiskon."'")->row_array();
    
    if(is_null($query)){
      $data = array('idDiskon' => '', 'kodeDiskon' => '', 'metodeDiskon' => 'persen', 'besaran' => '', 'minimum' => '', 'maximumDiskon' => '', 'exp' => '', 'idMember' => '');
    }else{
      if($query['am'] == 1){
        $mbr = $this->db->query("SELECT idMember FROM memberDiskon WHERE idDiskon = '".$idDiskon."'")->result();
        $idMember = [];
        foreach ($mbr as $row) {
          $idMember[] .= $row->idMember;
        }
        // $idMember .= "";
      }else{
        $idMember = '';
      }
      
      
      $data = array('idDiskon' => $query['idDiskon'], 'kodeDiskon' => $query['kodeDiskon'], 'metodeDiskon' => $query['metodeDiskon'], 'besaran' => $query['besaran'], 'minimum' => $query['minimum'], 'maximumDiskon' => $query['maximumDiskon'], 'exp' => $query['exp'], 'idMember' => $idMember,);
    }   
    echo json_encode($data);
  }
  public function GetDataDetailDiskonMember()
  {
    $idDiskon = $this->input->post('idDiskon');
    $chekKode = $this->db->query("SELECT kodeDiskon FROM diskon WHERE idDiskon = '$idDiskon'")->row_array();
    $kodeDiskon = $chekKode['kodeDiskon'];

    $data = array('kodeDiskon' => $kodeDiskon, 'idDiskon' => $idDiskon);
    echo json_encode($data);
  }  
  function GetDataSupplier() {
    $kodeSupplier = $this->input->post('kodeSupplier');
    $query = $this->db->query("SELECT kodeSupplier, namaSupplier, noTelpSupplier, jenisSupplier, emailSupplier, alamatSupplier, keterangan FROM supplier WHERE kodeSupplier = '".$kodeSupplier."'")->row_array();
    if(is_null($query)){
      $data = array('kodeSupplier' => '', 'namaSupplier' => '', 'noTelpSupplier' => '', 'jenisSupplier' => '', 'emailSupplier' => '', 'alamatSupplier' => '', 'keterangan' => '',);
    }else{
      $data = array('kodeSupplier' => $query['kodeSupplier'], 'namaSupplier' => $query['namaSupplier'], 'noTelpSupplier' => $query['noTelpSupplier'], 'jenisSupplier' => $query['jenisSupplier'], 'emailSupplier' => $query['emailSupplier'], 'alamatSupplier' => $query['alamatSupplier'], 'keterangan' => $query['keterangan'],);
    }   
    echo json_encode($data);
  }
  public function chekSupplier()
  {
    $kodeSupplier = $this->input->post('kodeSupplier');
    $kodeSupplierH = $this->input->post('kodeSupplierH');
    if(empty($kodeSupplierH)){
      $cek = $this->db->query("SELECT kodeSupplier FROM supplier WHERE kodeSupplier = '$kodeSupplier'")->num_rows();
    }else{
      $cek = $this->db->query("SELECT kodeSupplier FROM supplier WHERE kodeSupplier = '$kodeSupplier' AND kodeSupplier <> '$kodeSupplierH'")->num_rows();
    }
    
    if($cek == 0 AND !empty($kodeSupplier)){
      $data = array('stat' => 'belum');
    }else{
      $data = array('stat' => 'sudah');
    }
    echo json_encode($data);
  }  
  public function GetDataListSupplier()
  {
    $supplier = $this->db->query("SELECT kodeSupplier, namaSupplier, noTelpSupplier FROM supplier")->result();
    $ls = '<option value="">Pilih Supplier</option>';
    foreach ($supplier as $row) {
      $ls .= '<option value="'.$row->kodeSupplier.'">('.$row->kodeSupplier.') '.$row->namaSupplier.'-'.$row->noTelpSupplier.'</option>';
    }
    $data = array('data' => $ls, );
    echo json_encode($data);
  }
  public function UbahUser()
  {
    $untuk = $this->input->post('untuk');
    $no = $this->input->post('no');
    if($untuk == 'beli'){
      $user = $this->db->query("SELECT username, nama, idUser FROM user WHERE idUser <> (SELECT idUser FROM beli WHERE noBeli = '$no')")->result();
    }else if($untuk == 'jual'){
      $user = $this->db->query("SELECT username, nama, idUser FROM user WHERE idUser <> (SELECT idUser FROM jual WHERE noJual = '$no')")->result();
    }
    
    $ls = '<option value="">Pilih User</option>';
    foreach ($user as $row) {
      $ls .= '<option value="'.$row->idUser.'">('.$row->username.') '.$row->nama.'</option>';
    }
    $data = array('data' => $ls, );
    echo json_encode($data);
  }
  public function GetDataBeliBarang()
  {
    $noBeli = $this->input->post('noBeli');
		$query = "SELECT terbayar, totalAsli, totalView, (totalView - totalAsli) potongan, (totalAsli - terbayar) kurang FROM (SELECT b.terbayar, SUM((hargaAsli*jumlahAsli)) totalAsli, SUM((hargaView*jumlahAsli)) totalView FROM beli b INNER JOIN pembelian p ON p.noBeli = b.noBeli WHERE b.noBeli = '$noBeli') d";
    // echo $query; exit();
    $list = ['terbayar', 'totalAsli', 'totalView', 'potongan', 'kurang'];
    $data = $this->CreateData($query,$list);  
    $data['terbilang'] = terbilang($data['totalAsli']);
    $data['totalBeli'] = $data['totalAsli'];
    $data['totalAsli'] = FormatKurs($data['totalAsli'],0,'');
    $data['potongan'] = FormatKurs($data['potongan'],0,'');
    $data['Tkurang'] = $data['kurang'];
    $data['kurang'] = FormatKurs($data['kurang'],0,'');
    
    echo json_encode($data);
  }
  

#######################################################
  public function cekId($id = Null, $tabel)
  {
    $user = $this->session->userdata('username');
    $kolom = ucfirst($tabel);
    if(!empty($id)){
      $q = $this->db->query("SELECT tb.* FROM $tabel tb, user u WHERE no$kolom = '$id' AND u.username = '$user' AND tb.done = 0 AND tb.pending = 0 AND tb.idUser = u.idUser")->num_rows();
      $stat = ($q == 1) ? 'Aktif' : 'Tidak Aktif';
      $idBack = ($q == 1) ? $id : '';
    }else{
      $q = $this->db->query("SELECT tb.* FROM $tabel tb, user u WHERE u.username = '$user' AND tb.done = 0 AND tb.pending = 0 AND tb.idUser = u.idUser")->row_array();
      $stat = (!empty($q)) ? 'Aktif' : 'Tidak Aktif';
      $idBack = (!empty($q)) ? $q['no'.$kolom] : '';
    }
    $data = array('status' => $stat, 'id' =>$idBack);
    return $data;    
  }
  function BuatTr($input, $namaKolom, $valueKolom, $cl='', $dis, $fungsi='') {
    if($input == 'input'){
      $tr = '<tr '.$fungsi.'><td width="34%">'.$namaKolom.'</td><td width="2%">:</td><td width="58%"><input type="text" class="form-control f-sm"  value="'.$valueKolom.'" '.$dis.'></td><td width="3%"></td></tr>';
    }else{
      $tr = '<tr '.$fungsi.'><td width="34%">'.$namaKolom.'</td><td width="2%">:</td><td width="58%">
      <textarea rows="'.$cl.'"  '.$dis.' style ="resize: none; width:100%; padding-left:5px;" >'.$valueKolom.'</textarea></td><td width="3%"></td></tr>';
    }
    return $tr;
  }
}