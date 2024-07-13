<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nf extends CI_Controller {
	public function index()
	{
    if(empty($this->session->userdata('username'))){
      $this->load->view('nf');
    }else{
      $this->load->view('header');
      $this->load->view('asside');
      $this->load->view('nf');
      $this->load->view('footer');
    }
	}
}
