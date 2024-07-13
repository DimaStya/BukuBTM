<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {    
  public function __construct(){
    parent::__construct();
  }
  
  public function index(){
    // echo FormatKurs(50000,0,'Rp');
    // echo $this->mlog->GetHashPassword('admin');
    $this->load->view('login');
  }
  public function check_login() {
    $this->mlog->CheckLogin();
  }
  public function proses()  {
    echo Buat(8);
  }
  // public function ceklist() {
  //   $this->mlog->LoadPage('content1');
  // }
  public function menu()
  {
    $this->mlog->LoadPage('content1');
  }
  public function child()
  {
    $this->mlog->LoadPage('content1');
  }
    
}