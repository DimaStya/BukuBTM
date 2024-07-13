<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends My_controller {

	
	public function index()
	{
		redirect(base_url('beranda'));
	}
  public function Pembelian($id = null)
  {
    $cekId = $this->mdata->cekId($id,'beli');
    if($id == $cekId['id'] && $cekId['id'] == ''){
      $this->mlog->LoadPage(URL_VIEW);
    }else if($id == $cekId['id'] && $cekId['id'] != ''){
      $menu = URL_VIEW;
      $akun = $this->session->userdata('username');
      $stat = $this->db->query("SELECT akses.akses FROM akses INNER JOIN menus ON menus.idMenus = akses.idMenus WHERE menus.link = '$menu'")->row_array();
      $this->load->view('header',array('head' =>'Form Pembelian'));
      $this->load->view('asside');
      if(empty($stat)){
        $this->load->view('nf');
      }else{
        // $data = array('id' => $id);
        $data = $this->db->query("SELECT b.noBeli, date(b.tanggal) tanggal, time(b.tanggal) jam, u.nama, s.kodeSupplier, s.namaSupplier, s.jenisSupplier, s.alamatSupplier, s.noTelpSupplier, s.emailSupplier FROM beli b INNER JOIN supplier s ON b.kodeSupplier = s.kodeSupplier INNER JOIN user u ON b.idUser = u.idUser WHERE b.noBeli = '$id'")->row_array();
        $this->load->view('transaksi/transaksi_beli', $data);
      }      
      $this->load->view('footer');
    }else if($id <> $cekId['id'] && $cekId['id'] == ''){
      // ke link tanpa id
      redirect(base_url('transaksi/pembelian'));
    }else if($id <> $cekId['id'] && $cekId['id'] != ''){
      // ke link dengan id
      redirect(base_url('transaksi/pembelian/'.$cekId['id']));
    }
  }
  public function Penjualan($id = null)
  {
    $cekId = $this->mdata->cekId($id,'jual');
    if($id == $cekId['id'] && $cekId['id'] == ''){
      $this->mlog->LoadPage(URL_VIEW);
    }else if($id == $cekId['id'] && $cekId['id'] != ''){
      $menu = URL_VIEW;
      $akun = $this->session->userdata('username');
      $stat = $this->db->query("SELECT akses.akses FROM akses INNER JOIN menus ON menus.idMenus = akses.idMenus WHERE menus.link = '$menu'")->row_array();
      $this->load->view('header',array('head' =>'Form Penjualan'));
      $this->load->view('asside');
      if(empty($stat)){
        $this->load->view('nf');
      }else{
        $data = $this->db->query("SELECT j.noJual, date(j.tanggal) tanggal, time(j.tanggal) jam, u.nama, m.idMember, m.namaMember, m.noHp, d.kodeDiskon, j.idDiskon FROM jual j INNER JOIN user u ON u.idUser = j.idUser LEFT JOIN member m ON m.idMember = j.idMember LEFT JOIN diskon d ON j.idDiskon = d.idDiskon WHERE j.noJual = '$id'")->row_array();
        $this->load->view('transaksi/transaksi_jual', $data);
      }      
      $this->load->view('footer');
    }else if($id <> $cekId['id'] && $cekId['id'] == ''){
      // ke link tanpa id
      redirect(base_url('transaksi/penjualan'));
    }else if($id <> $cekId['id'] && $cekId['id'] != ''){
      // ke link dengan id
      redirect(base_url('transaksi/penjualan/'.$cekId['id']));
    }
  }
  public function bayarbeli()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function bayarjual()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
}