<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable extends My_controller {
	public function index()
	{
		redirect(base_url('beranda'));
	}
	public function loadMenu() {
		$this->mdatatable->loadMenu();
	}
	public function ListMenuUser() {
		$this->mdatatable->ListMenuUser();
	}
	public function LoadUser() {
		$this->mdatatable->LoadUser();
	}
	public function LoadKategori() {
		$this->mdatatable->LoadKategori();
	}
	public function LoadBarang() {
		$this->mdatatable->LoadBarang();
	}
	public function LoadHarga() {
		$this->mdatatable->LoadHarga();
	}
	public function LoadProgram() {
		$this->mdatatable->LoadProgram();
	}
	public function LoadMember() {
		$this->mdatatable->LoadMember();
	}
	public function LoadDiskonMember() {
		$this->mdatatable->LoadDiskonMember();
	}
	public function loadDetailMember() {
		$this->mdatatable->loadDetailMember();
	}
	public function LoadSupplier() {
		$this->mdatatable->LoadSupplier();
	}
	public function LoadIcon() {
		$this->mdatatable->LoadIcon();
	}
	public function LoadListBarang() {
		$this->mdatatable->LoadListBarang();
	}
	public function LoadListBarangStok() {
		$this->mdatatable->LoadListBarangStok();
	}
	public function LoadCariMember() {
		$this->mdatatable->LoadCariMember();
	}


	##############################Transaksi############################	
	public function LoadBeliPending() {
		$this->mdatatable->LoadBeliPending();
	}
	public function LoadBeliBarang() {
		$this->mdatatable->LoadBeliBarang();
	}
	public function LoadBayarBeli() {
		$this->mdatatable->LoadBayarBeli();
	}
	public function LoadDetailBayarBeli() {
		$this->mdatatable->LoadDetailBayarBeli();
	}
	public function LoadDetailBarangBeli() {
		$this->mdatatable->LoadDetailBarangBeli();
	}
	public function LoadSelesaiBeli() {
		$this->mdatatable->LoadSelesaiBeli();
	}
	public function LoadJualPending() {
		$this->mdatatable->LoadJualPending();
	}
}