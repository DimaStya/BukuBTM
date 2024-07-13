<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends My_controller {

	
	public function index()
	{
		$this->mlog->LoadPage('beranda');
	}
	public function cek(Type $var = null)
	{
		$today = date('Ymd');
		echo date('Ymd', strtotime('+1 days', strtotime($today)));
	}
}