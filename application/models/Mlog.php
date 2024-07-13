<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mlog extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
  public function GetHashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
  }
  public function CheckLogin() {
    $username = $this->input->post('username');
    $pass = $this->input->post('pass');
    $data = $this->db->query("SELECT * FROM user WHERE username='$username'")->row_array();
    if(!empty($data)){
      $p_hash = $data['pass'];
      if(password_verify($pass,$p_hash)){
        $hasil = array('status' => true, 'nama' => $data['nama']);
        $this->session->set_userdata('username', $data['username']);
        $this->session->set_userdata('nama', $data['nama']);
        $this->session->set_userdata('akses', $data['akses']);
      }else{
        $hasil = array('status' => false,);
      }
    }else{
      $hasil = array('status' => false,);
    }
    echo json_encode($hasil);
  }
    
  public function IsLogin() {
    //jika login
    $username = $this->session->userdata('username');
    if(!empty($username)){
      // return true;
      $data = $this->db->query("SELECT * FROM user WHERE username='$username'")->row_array();
      if(empty($data)){
        return false;
      }else{
        $this->session->set_userdata('username', $data['username']);
        $this->session->set_userdata('nama', $data['nama']);
        $this->session->set_userdata('akses', $data['akses']);
        return true;
      }
    }else{
    //jika tidak login
      return false;
    }
  }
  public function GetMenu() {
    $akun = $this->session->userdata('username');
    $menu = [];
    $menulist = $this->db->query("SELECT idmenu, namaMenu FROM menu ORDER BY urutan")->result();
    foreach ($menulist as $row) {
      $menu[] = $this->db->query("SELECT mn.namaMenu as menu, mn.menuIcon as mico, mc.namaMenus as child, mc.menusIcon as cico, mc.link as link FROM akses ak, menus mc, menu mn WHERE ak.username = '$akun' AND mn.idmenu = '$row->idmenu' AND ak.idmenus = mc.idmenus AND mc.idmenu = mn.idmenu ORDER BY mc.urutans")->result_array();
    }
    return $menu;
  }
  public function RouteURLLogin($isLogin){
    if (!$isLogin) redirect(base_url('logout'));
  }
  
  public function RouteURLLogout($isLogin){
    if ($isLogin) redirect(base_url('beranda'));
  }
  public function LoadPage($menu, $data=null) {
    $akun = $this->session->userdata('username');
    $stat = $this->db->query("SELECT akses.akses FROM akses INNER JOIN menus ON menus.idMenus = akses.idMenus WHERE menus.link = '$menu'")->row_array();
    $this->load->view('header');
    $this->load->view('asside');
    if($menu == 'beranda' OR $menu == 'user/ubahPassword' OR $menu == 'content1'){
      $this->load->view($menu, $data);
    }else{
      if(empty($stat)){
        $this->load->view('nf');
      }else{
        $akses = ($stat['akses'] == 10) ? 'VE': 'V';
        $this->session->set_userdata('aksesnya', $akses);
        $this->load->view($menu, $data);
      }  
    }
      
    $this->load->view('footer');
  }
  public function setHarga()
  {
    $brg = $this->db->query("SELECT idBarang, hargaBeliEcer, hargaBeliPaket, hargaJualEcer, hargaJualPaket FROM barang")->result();
    foreach ($brg as $row) {
      $tgl = date('Ymd');
      $cekHarga = $this->db->query("SELECT idHarga,tanggal FROM harga WHERE idBarang = '".$row->idBarang."' ORDER BY tanggal DESC LIMIT 1")->row_array();
      $idHargaToday = $row->idBarang.$tgl;
      $tanggal =  $cekHarga['tanggal'];
      $idHargaCek =  $cekHarga['idHarga'];

      while ($idHargaToday > $idHargaCek) {
        $tanggal = date('Ymd', strtotime('+1 days', strtotime($tanggal)));
        $idHargaCek = $row->idBarang.$tanggal;
        $idHargaTodaySave = $row->idBarang.$tanggal;
        $dataH = array('idHarga' => $idHargaTodaySave,'tanggal' => $tanggal,'idBarang' => $row->idBarang,'beliEcer' => $row->hargaBeliEcer,'beliPaket' => $row->hargaBeliPaket,'jualEcer' => $row->hargaJualEcer,'jualPaket' => $row->hargaJualPaket);
        $q1 = $this->mproses->Insert('harga', $dataH);
      }
    }
  }
    
}

?>