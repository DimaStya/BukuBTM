<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends My_controller {

	
	public function index()
	{
		redirect(base_url('beranda'));
	}
  public function selesaibeli()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function selesaijual()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function stok()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function penjualan_barang()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function pendapatan()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
}