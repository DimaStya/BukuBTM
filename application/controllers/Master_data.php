<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_data extends My_controller {

	
	public function index()
	{
		redirect(base_url('beranda'));
	}
  public function Kategori()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function Barang()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function Harga()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function Program()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function Member()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function Diskon_member()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function Supplier()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function date()
  {
    $this->load->view('datetime');
  }
  
}