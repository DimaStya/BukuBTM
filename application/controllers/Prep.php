<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prep extends My_controller {

	
	public function index()
	{
		redirect(base_url('beranda'));
	}
  public function Menu()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function Akses()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function User()
  {
    $this->mlog->LoadPage(URL_VIEW);
  }
  public function nf()
  {
    echo 'kosong';
  }
  
}