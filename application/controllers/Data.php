<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends My_controller {
	public function index()
	{
		redirect(base_url('beranda'));
	}
	public function GetDataMenu() {
		$this->mdata->GetDataMenu();
	}
	public function GetJumlahDataMenu() {
		$this->mdata->GetJumlahDataMenu();
	}
	public function GetJumlahDataMenus() {
		$this->mdata->GetJumlahDataMenus();
	}
	public function GetDataMenus() {
		$this->mdata->GetDataMenus();
	}
	public function GetDataListUser() {
		$this->mdata->GetDataListUser();
	}
	public function GetDataUser() {
		$this->mdata->GetDataUser();
	}
	public function GetDataKategori() {
		$this->mdata->GetDataKategori();
	}
	public function GetDataBarang() {
		$this->mdata->GetDataBarang();
	}
	public function GetDataListKategori() {
		$this->mdata->GetDataListKategori();
	}
	public function GetDataListBarang($idKategori = '') {
		$this->mdata->GetDataListBarang($idKategori);
	}
	public function GetDataListBarangB($idKategori = '') {
		$this->mdata->GetDataListBarangB($idKategori);
	}
	public function GetHeaderHarga() {
		$this->mdata->GetHeaderHarga();
	}
	public function GetDataProgram() {
		$this->mdata->GetDataProgram();
	}
	public function GetDataMember() {
		$this->mdata->GetDataMember();
	}
	public function GetKodeMember() {
		$this->mdata->GetKodeMember();
	}
	public function GetDataListMember() {
		$this->mdata->GetDataListMember();
	}
	public function GetKodeDiskon() {
		$this->mdata->GetKodeDiskon();
	}
	public function chekVoucher() {
		$this->mdata->chekVoucher();
	}
	public function GetDataDiskonMember() {
		$this->mdata->GetDataDiskonMember();
	}
	public function GetDataDetailDiskonMember() {
		$this->mdata->GetDataDetailDiskonMember();
	}
	public function GetDataSupplier() {
		$this->mdata->GetDataSupplier();
	}
	public function chekSupplier() {
		$this->mdata->chekSupplier();
	}
	public function GetDataListSupplier() {
		$this->mdata->GetDataListSupplier();
	}
	public function CheckUser() {
		$this->mdata->CheckUser();
	}
	public function CheckKodeBarang() {
		$this->mdata->CheckKodeBarang();
	}
	public function GetDataBeliBarang() {
		$this->mdata->GetDataBeliBarang();
	}
	public function UbahUser() {
		$this->mdata->UbahUser();
	}
	function GetDataDiskon() {
		$this->mdata->GetDataDiskon();
	}
	
}