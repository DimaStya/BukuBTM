<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class CrudData extends My_controller
{
	public function index()
	{
		redirect(base_url('beranda'));
	}
	function getUrutan($tabel, $idmenu = '')
	{
		if ($tabel == 'menu') {
			$max = $this->db->query("SELECT MAX(urutan) urutan FROM menu")->row_array();
			$urutan = ($max['urutan'] == NULL) ? 1 : $max['urutan'] + 1;
		} else if ($tabel == 'menus' and !empty($idmenu)) {
			$max = $this->db->query("SELECT MAX(urutans) urutan FROM menus WHERE idMenu = '$idmenu'")->row_array();
			$urutan = ($max['urutan'] == NULL) ? 1 : $max['urutan'] + 1;
		} else {
			exit();
		}
		return $urutan;
	}
	public function SaveMenu()
	{
		$list = ['namaMenu', 'menuIcon'];
		$data = $this->CreateArray($list);
		if (empty($this->input->post('idMenu'))) {
			$data['urutan'] = $this->getUrutan('menu');
		}
		$callback = $this->ProsesAdd($data, 'menu', $this->input->post('idMenu'), 'idMenu');
		echo json_encode($callback);
	}
	public function SaveMenus()
	{
		$list = ['idMenu', 'namaMenus', 'menusIcon'];
		$data = $this->CreateArray($list);
		if (empty($this->input->post('idMenus'))) {
			$data['urutans'] = $this->getUrutan('menus', $data['idMenu']);
		}
		$data['link'] = strtolower($this->input->post('contr')) . '/' . strtolower($this->input->post('meth'));
		$callback = $this->ProsesAdd($data, 'menus', $this->input->post('idMenus'), 'idMenus');
		echo json_encode($callback);
	}
	public function RubahUrutan()
	{
		$callback = array();
		$idMenu = $this->input->post('idMenu');
		$urutanbaru = $this->input->post('urutanbaru');
		$urut = $this->db->query("SELECT urutan FROM menu WHERE idMenu = $idMenu")->row_array();
		$urutan = $urut['urutan'];
		$up1 = $this->db->query("UPDATE menu SET urutan = -1 WHERE idMenu = $idMenu");
		if ($urutan > $urutanbaru) {
			// turun
			$up2 = $this->db->query("UPDATE menu SET urutan = urutan+1 WHERE urutan BETWEEN $urutanbaru AND $urutan AND urutan > 0");
		} else if ($urutan < $urutanbaru) {
			// naik
			$up2 = $this->db->query("UPDATE menu SET urutan = urutan-1 WHERE urutan BETWEEN $urutan AND $urutanbaru AND urutan > 0");
		}
		$up3 = $this->db->query("UPDATE menu SET urutan = $urutanbaru WHERE idMenu = $idMenu");
		$callback['hasil'] = ($up3) ? 'success' : 'error';
		$callback['proses'] = 'Dirubah';
		$callback['hasil'] = 'success';

		echo json_encode($callback);
	}
	public function RubahUrutans()
	{
		$callback = array();
		$idMenu = $this->input->post('idMenu');
		$idMenus = $this->input->post('idMenus');
		$urutanbaru = $this->input->post('urutanbaru');

		$urut = $this->db->query("SELECT urutans FROM menus WHERE idMenus = $idMenus")->row_array();
		$urutan = $urut['urutans'];
		$up1 = $this->db->query("UPDATE menus SET urutans = -1 WHERE idMenus = $idMenus");

		if ($urutan > $urutanbaru) {
			// turun
			$up2 = $this->db->query("UPDATE menus SET urutans = urutans+1 WHERE urutans BETWEEN $urutanbaru AND $urutan AND urutans > 0 AND idMenu = $idMenu");
		} else if ($urutan < $urutanbaru) {
			// naik
			$up2 = $this->db->query("UPDATE menus SET urutans = urutans-1 WHERE urutans BETWEEN $urutan AND $urutanbaru AND urutans > 0 AND idMenu = $idMenu");
		}
		$up3 = $this->db->query("UPDATE menus SET urutans = $urutanbaru WHERE idMenus = $idMenus");
		$callback['hasil'] = ($up3) ? 'success' : 'error';
		$callback['proses'] = 'Dirubah';
		$callback['hasil'] = 'success';

		echo json_encode($callback);
	}
	public function DelMenu()
	{
		$idMenu = $this->input->post('idMenu');
		$urut = $this->db->query("SELECT urutan FROM menu WHERE idMenu = $idMenu")->row_array();
		$urutan = $urut['urutan'];
		if (empty($idMenu)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$callback['proses'] = 'Berhasil Dihapus';
			$where = array('idMenu' => $idMenu,);
			$q = $this->mproses->Delete('menu', $where);
			if ($q) {
				$callback['hasil'] = 'success';
				$up2 = $this->db->query("UPDATE menu SET urutan = urutan-1 WHERE urutan > $urutan");
			} else {
				$callback['hasil'] = 'error';
			}
		}
		echo json_encode($callback);
	}
	public function DelMenus()
	{
		$idMenus = $this->input->post('idMenus');
		$uruts = $this->db->query("SELECT urutans, idmenu FROM menus WHERE idMenus = $idMenus")->row_array();
		$urutans = $uruts['urutans'];
		$idMenu = $uruts['idmenu'];
		if (empty($idMenus)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$callback['proses'] = 'Berhasil Dihapus';
			$where = array('idMenus' => $idMenus,);
			$q = $this->mproses->Delete('menus', $where);
			if ($q) {
				$callback['hasil'] = 'success';
				$up2 = $this->db->query("UPDATE menus SET urutans = urutans-1 WHERE urutans > $urutans AND idMenu = '$idMenu'");
			} else {
				$callback['hasil'] = 'error';
			}
		}
		echo json_encode($callback);
	}
	public function PilihMenu()
	{
		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$kode = explode('-', $id);

		if ($kode[0] == 'M') {
			$menu = $this->db->query("SELECT idMenus FROM menus WHERE idMenu = '" . $kode[1] . "' AND idMenus NOT IN (SELECT idMenus FROM akses WHERE username = '" . $username . "')")->result();
			$data = array();
			foreach ($menu as $row) {
				array_push($data, array('idMenus' => $row->idMenus, 'username' => $username, 'akses' => 1));
			}
			$q = $this->mproses->Insert_multiple('akses', $data);
			$callback['hasil'] = 'success';
			$callback['proses'] = 'Berhasil Proses';
		} else if ($kode[0] == 'C') {
			$chek = $this->db->query("SELECT idMenus FROM akses WHERE username = '" . $username . "' AND idMenus = '" . $kode[1] . "'")->num_rows();
			if ($chek == 0) {
				$data = array('idMenus' => $kode[1], 'username' => $username, 'akses' => 1);
				$q = $this->mproses->Insert('akses', $data);
			} else {
				$where = array('idMenus' => $kode[1], 'username' => $username);
				$q = $this->mproses->Delete('akses', $where);
			}
			$callback['hasil'] = ($q) ? 'success' : 'error';
			$callback['proses'] = ($q) ? 'Berhasil Proses' : 'Gagal Proses';
		}


		echo json_encode($callback);
	}
	public function PilihAkses()
	{
		$idMenus = $this->input->post('idMenus');
		$username = $this->input->post('username');
		$akses = $this->input->post('akses');
		// $kode = explode('-',$id);

		$data = array('akses' => $akses);
		$where = array('idMenus' => $idMenus, 'username' => $username);
		$q = $this->mproses->Update('akses', $data, $where);
		$callback['hasil'] = ($q) ? 'success' : 'error';
		$callback['proses'] = ($q) ? 'Berhasil Proses' : 'Gagal Proses';

		echo json_encode($callback);
	}
	public function SaveUser()
	{
		$husername = $this->input->post('husername');
		$username = $this->input->post('username');
		$nama = $this->input->post('nama');
		$additional = $this->input->post('additional');
		if (empty($husername)) {
			$callback['proses'] = 'Ditambahkan';
			$pass = $this->mlog->GetHashPassword('12345678');
			$data = array('username' => $username, 'nama' => $nama, 'pass' => $pass, 'akses' => 1, 'additional' => $additional);
			$q = $this->mproses->Insert('user', $data);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$data = array('username' => $username, 'nama' => $nama, 'additional' => $additional);
			$where = array('username' => $husername,);
			$q = $this->mproses->Update('user', $data, $where);

			$callback['hasil'] = 'success';
		}
		echo json_encode($callback);
	}
	public function ResetUser()
	{
		$username = $this->input->post('username');
		if (empty($username)) {
			$callback['proses'] = 'Gagal di reset';
			$callback['hasil'] = 'error';
		} else {
			$callback['proses'] = 'Berhasil di reset';
			$pass = $this->mlog->GetHashPassword('12345678');
			$data = array('pass' => $pass,);
			$where = array('username' => $username,);
			$q = $this->mproses->Update('user', $data, $where);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		}
		echo json_encode($callback);
	}
	public function DelUser()
	{
		$username = $this->input->post('username');
		if (empty($username)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$callback['proses'] = 'Berhasil Dihapus';
			$where = array('username' => $username,);
			$q = $this->mproses->Delete('user', $where);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		}
		echo json_encode($callback);
	}
	public function SaveKategori()
	{
		$idKategori = $this->input->post('idKategori');
		$namaKategori = $this->input->post('namaKategori');
		$kode = $this->input->post('kode');
		if (empty($idKategori)) {
			$callback['proses'] = 'Ditambahkan';
			$data = array('namaKategori' => $namaKategori, 'kode' => $kode,);
			$q = $this->mproses->Insert('kategori', $data);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$data = array('namaKategori' => $namaKategori, 'kode' => $kode,);
			$where = array('idKategori' => $idKategori,);
			$q = $this->mproses->Update('kategori', $data, $where);

			$callback['hasil'] = 'success';
		}
		echo json_encode($callback);
	}
	public function DelKategori()
	{
		$idKategori = $this->input->post('idKategori');
		if (empty($idKategori)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$chek = $this->db->query("SELECT idKategori FROM barang WHERE idKategori = '$idKategori'")->num_rows();
			if ($chek > 0) {
				$callback['proses'] = 'Gagal Dihapus';
				$callback['hasil'] = 'error';
			} else {
				$where = array('idKategori' => $idKategori,);
				$q = $this->mproses->Delete('kategori', $where);
				$callback['hasil'] = ($q) ? 'success' : 'error';
				$callback['proses'] = ($q) ? 'Behasil Dihapus' : 'Gagal Dihapus';
			}
		}
		echo json_encode($callback);
	}
	public function SaveBarang()
	{
		$namaBarang = $this->input->post('namaBarang');
		$kodeBarangH = $this->input->post('kodeBarangH');
		$kodeBarang = $this->input->post('kodeBarang');
		$idKategori = $this->input->post('idKategori');
		$satuanEcer = $this->input->post('satuanEcer');
		$satuanPaket = $this->input->post('satuanPaket');
		$konversi = $this->input->post('konversi');

		$hargaBeliEcer = str_replace(',', '', $this->input->post('hargaBeliEcer'));
		$hargaBeliPaket = str_replace(',', '', $this->input->post('hargaBeliPaket'));
		$hargaJualEcer = str_replace(',', '', $this->input->post('hargaJualEcer'));
		$hargaJualPaket = str_replace(',', '', $this->input->post('hargaJualPaket'));
		$untukPerubahan = $this->input->post('untukPerubahan');

		if (empty($kodeBarangH)) {
			$callback['proses'] = 'Ditambahkan';
			$data = array('namaBarang' => $namaBarang, 'kodeBarang' => $kodeBarang, 'idKategori' => $idKategori, 'satuanEcer' => $satuanEcer, 'satuanPaket' => $satuanPaket, 'konversi' => $konversi, 'hargaBeliEcer' => $hargaBeliEcer, 'hargaBeliPaket' => $hargaBeliPaket, 'hargaJualEcer' => $hargaJualEcer, 'hargaJualPaket' => $hargaJualPaket,);
			$q = $this->mproses->Insert('barang', $data);
			$barangid = $this->db->select('kodeBarang')->where($data)->get('barang')->row_array();
			$tanggal = date('Ymd');
			$dataH = array('idHarga' => $barangid['kodeBarang'] . $tanggal, 'tanggal' => $tanggal, 'kodeBarang' => $barangid['kodeBarang'], 'beliEcer' => $hargaBeliEcer, 'beliPaket' => $hargaBeliPaket, 'jualEcer' => $hargaJualEcer, 'jualPaket' => $hargaJualPaket);
			$q1 = $this->mproses->Insert('harga', $dataH);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$where = array('kodeBarang' => $kodeBarangH,);
			if ($untukPerubahan == 'data') {
				$data = array('namaBarang' => $namaBarang, 'kodeBarang' => $kodeBarang, 'idKategori' => $idKategori, 'satuanEcer' => $satuanEcer, 'satuanPaket' => $satuanPaket, 'konversi' => $konversi,);
				$q = $this->mproses->Update('barang', $data, $where);
				$callback['hasil'] = 'success';
			} else if ($untukPerubahan == 'hrg') {
				$tanggal = date('Ymd');
				$data = array('idKategori' => $idKategori, 'hargaBeliEcer' => $hargaBeliEcer, 'hargaBeliPaket' => $hargaBeliPaket, 'hargaJualEcer' => $hargaJualEcer, 'hargaJualPaket' => $hargaJualPaket, 'updateHarga' => $tanggal);
				$q = $this->mproses->Update('barang', $data, $where);
				$chekIdHarga = $this->db->query("SELECT * FROM harga WHERE idHarga = '" . $kodeBarang . $tanggal . "'")->num_rows();

				$dataH = array('idHarga' => $kodeBarang . $tanggal, 'tanggal' => $tanggal, 'kodeBarang' => $kodeBarang, 'beliEcer' => $hargaBeliEcer, 'beliPaket' => $hargaBeliPaket, 'jualEcer' => $hargaJualEcer, 'jualPaket' => $hargaJualPaket);
				if ($chekIdHarga == 0) {
					$this->mproses->Insert('harga', $dataH);
				} else {
					$whereH = array('idHarga' => $kodeBarang . $tanggal,);
					$q1 = $this->mproses->Update('harga', $dataH, $whereH);
				}


				$callback['hasil'] = 'success';
			} else {
				$callback['hasil'] = 'error';
			}
		}
		echo json_encode($callback);
	}
	public function DelBarang()
	{
		$kodeBarang = $this->input->post('kodeBarang');
		if (empty($kodeBarang)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$chek = $this->db->query("SELECT kodeBarang FROM pembelian WHERE kodeBarang = '$kodeBarang'")->num_rows();
			if ($chek > 0) {
				$callback['proses'] = 'Gagal Dihapus';
				$callback['hasil'] = 'error';
			} else {
				$where = array('kodeBarang' => $kodeBarang,);
				$q = $this->mproses->Delete('barang', $where);
				$callback['hasil'] = ($q) ? 'success' : 'error';
				$callback['proses'] = ($q) ? 'Behasil Dihapus' : 'Gagal Dihapus';
			}
		}
		echo json_encode($callback);
	}
	public function SaveProgram()
	{
		$idProgram = $this->input->post('idProgram');
		$namaProgram = $this->input->post('namaProgram');
		$kodeBarang = $this->input->post('kodeBarang');
		$tipeProgram = $this->input->post('tipeProgram');
		$tipePotongan = $this->input->post('tipePotongan');
		$jumlahEcer = $this->input->post('jumlahEcer');
		$nilai = $this->input->post('nilai');
		if ($tipePotongan == 'Bonus') {
			$sama = $this->input->post('sama');
			if ($sama == 'sama') {
				$kodeBarangB = $kodeBarang;
			} else {
				$kodeBarangB = $this->input->post('kodeBarangB');
			}
		} else {
			$kodeBarangB = Null;
		}

		if (empty($idProgram)) {
			$callback['proses'] = 'Ditambahkan';
			$data = array('namaProgram' => $namaProgram, 'kodeBarang' => $kodeBarang, 'tipeProgram' => $tipeProgram, 'tipePotongan' => $tipePotongan, 'jumlahEcer' => $jumlahEcer, 'nilai' => $nilai, 'kodeBarangB' => $kodeBarangB,);
			$q = $this->mproses->Insert('program', $data);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$data = array('namaProgram' => $namaProgram, 'kodeBarang' => $kodeBarang, 'tipeProgram' => $tipeProgram, 'tipePotongan' => $tipePotongan, 'jumlahEcer' => $jumlahEcer, 'nilai' => $nilai, 'kodeBarangB' => $kodeBarangB,);
			$where = array('idProgram' => $idProgram,);
			$q = $this->mproses->Update('program', $data, $where);

			$callback['hasil'] = 'success';
		}
		echo json_encode($callback);
	}
	public function DelProgram()
	{
		$idProgram = $this->input->post('idProgram');
		if (empty($idProgram)) {
			$callback['proses'] = 'Gagal DiUbah';
			$callback['hasil'] = 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$where = array('idProgram' => $idProgram,);
			$data = array('tanggalHapus' => toDay());
			$q = $this->mproses->Update('program', $data, $where);
			$callback['hasil'] = 'success';
		}
		echo json_encode($callback);
	}
	public function AktifProgram()
	{
		$idProgram = $this->input->post('idProgram');
		if (empty($idProgram)) {
			$callback['proses'] = 'Gagal DiUbah';
			$callback['hasil'] = 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$where = array('idProgram' => $idProgram,);
			$data = array('tanggalHapus' => NULL);
			$q = $this->mproses->Update('program', $data, $where);
			$callback['hasil'] = 'success';
		}
		echo json_encode($callback);
	}
	public function SaveMember()
	{
		$idMember = $this->input->post('idMember');
		$namaMember = $this->input->post('namaMember');
		$noHp = $this->input->post('noHp');
		$alamat = $this->input->post('alamat');
		if (empty($idMember)) {
			$callback['proses'] = 'Ditambahkan';
			$data = array('namaMember' => $namaMember, 'noHp' => $noHp, 'alamat' => $alamat,);
			$q = $this->mproses->Insert('member', $data);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$data = array('namaMember' => $namaMember, 'noHp' => $noHp, 'alamat' => $alamat,);
			$where = array('idMember' => $idMember,);
			$q = $this->mproses->Update('member', $data, $where);

			$callback['hasil'] = 'success';
		}
		echo json_encode($callback);
	}
	public function DelMember()
	{
		$idMember = $this->input->post('idMember');
		if (empty($idMember)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$chek = $this->db->query("SELECT idMember FROM jual WHERE idMember = '$idMember'")->num_rows();
			if ($chek > 0) {
				$callback['proses'] = 'Gagal Dihapus';
				$callback['hasil'] = 'error';
			} else {
				$where = array('idMember' => $idMember,);
				$q = $this->mproses->Delete('member', $where);
				$callback['hasil'] = ($q) ? 'success' : 'error';
				$callback['proses'] = ($q) ? 'Behasil Dihapus' : 'Gagal Dihapus';
			}
		}
		echo json_encode($callback);
	}
	public function SaveDiskonMember()
	{
		$idMember = $this->input->post('idMember');
		$am = (!empty($idMember)) ? 1 : 0;

		$idDiskon = $this->input->post('idDiskon');
		$kodeDiskon = strtoupper($this->input->post('kodeDiskon'));
		$metodeDiskon = $this->input->post('metodeDiskon');
		$maximumDiskon = ($metodeDiskon == 'persen') ? str_replace(',', '', $this->input->post('maximumDiskon')) : str_replace(',', '', $this->input->post('besaran'));
		$besaran = str_replace(',', '', $this->input->post('besaran'));
		$minimum = str_replace(',', '', $this->input->post('minimum'));
		// $maximumDiskon = str_replace(',','',$this->input->post('maximumDiskon'));
		$exp = $this->input->post('exp');
		if (empty($idDiskon)) {
			$callback['proses'] = 'Ditambahkan';
			$data = array('kodeDiskon' => $kodeDiskon, 'metodeDiskon' => $metodeDiskon, 'besaran' => $besaran, 'minimum' => $minimum, 'maximumDiskon' => $maximumDiskon, 'exp' => $exp, 'oleh' => $this->session->userdata('username'), 'am' => $am);
			$q = $this->mproses->Insert('diskon', $data);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$data = array('kodeDiskon' => $kodeDiskon, 'metodeDiskon' => $metodeDiskon, 'besaran' => $besaran, 'minimum' => $minimum, 'maximumDiskon' => $maximumDiskon, 'exp' => $exp, 'am' => $am);
			$where = array('idDiskon' => $idDiskon,);
			$q = $this->mproses->Update('diskon', $data, $where);

			$this->mproses->Delete('memberdiskon', $where);
			$callback['hasil'] = 'success';
		}

		$getId = $this->db->query("SELECT idDiskon FROM diskon WHERE kodeDiskon = '$kodeDiskon'")->row_array();
		if (!empty($idMember)) {
			for ($i = 0; $i < count($idMember); $i++) {
				$data1 = array('idDiskon' => $getId['idDiskon'], 'idMember' => $idMember[$i]);
				$q = $this->mproses->Insert('memberdiskon', $data1);
			}
		}
		echo json_encode($callback);
	}
	public function DelDiskonMember()
	{
		$idDiskon = $this->input->post('idDiskon');
		if (empty($idDiskon)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$chek = $this->db->query("SELECT idDiskon FROM jual WHERE idDiskon = '$idDiskon'")->num_rows();
			if ($chek > 0) {
				$callback['proses'] = 'Gagal Dihapus';
				$callback['hasil'] = 'error';
			} else {
				$where = array('idDiskon' => $idDiskon,);
				$q = $this->mproses->Delete('diskon', $where);
				$callback['hasil'] = ($q) ? 'success' : 'error';
				$callback['proses'] = ($q) ? 'Behasil Dihapus' : 'Gagal Dihapus';
			}
		}
		echo json_encode($callback);
	}
	public function DelDetailMember()
	{
		$idDiskon = $this->input->post('idDiskon');
		$idMember = $this->input->post('idMember');
		if (empty($idDiskon) || empty($idMember)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$where = array('idDiskon' => $idDiskon, 'idMember' => $idMember,);
			$q = $this->mproses->Delete('memberdiskon', $where);
			$chek = $this->db->query("SELECT idDiskon FROM memberdiskon WHERE idDiskon = '$idDiskon'")->num_rows();
			if ($chek == 0) {
				$data = array('am' => 0);
				unset($where['idMember']);
				$q = $this->mproses->Update('diskon', $data, $where);
			}
			$callback['hasil'] = ($q) ? 'success' : 'error';
		}
		echo json_encode($callback);
	}
	public function SaveSupplier()
	{
		$kodeSupplierH = $this->input->post('kodeSupplierH');
		$kodeSupplier = strtoupper($this->input->post('kodeSupplier'));
		$namaSupplier = $this->input->post('namaSupplier');
		$noTelpSupplier = $this->input->post('noTelpSupplier');
		$jenisSupplier = $this->input->post('jenisSupplier');

		$emailSupplier = $this->input->post('emailSupplier');
		$alamatSupplier = $this->input->post('alamatSupplier');
		$keterangan = $this->input->post('keterangan');
		if (empty($kodeSupplierH)) {
			$callback['proses'] = 'Ditambahkan';
			$data = array('kodeSupplier' => $kodeSupplier, 'namaSupplier' => $namaSupplier, 'noTelpSupplier' => $noTelpSupplier, 'jenisSupplier' => $jenisSupplier, 'emailSupplier' => $emailSupplier, 'alamatSupplier' => $alamatSupplier, 'keterangan' => $keterangan,);
			$q = $this->mproses->Insert('supplier', $data);
			$callback['hasil'] = ($q) ? 'success' : 'error';
		} else {
			$callback['proses'] = 'Dirubah';
			$data = array('kodeSupplier' => $kodeSupplier, 'namaSupplier' => $namaSupplier, 'noTelpSupplier' => $noTelpSupplier, 'jenisSupplier' => $jenisSupplier, 'emailSupplier' => $emailSupplier, 'alamatSupplier' => $alamatSupplier, 'keterangan' => $keterangan,);
			$where = array('kodeSupplier' => $kodeSupplierH,);
			$q = $this->mproses->Update('supplier', $data, $where);

			$callback['hasil'] = 'success';
		}
		echo json_encode($callback);
	}
	public function DelSupplier()
	{
		$kodeSupplier = $this->input->post('kodeSupplier');
		if (empty($kodeSupplier)) {
			$callback['proses'] = 'Gagal Dihapus';
			$callback['hasil'] = 'error';
		} else {
			$chek = $this->db->query("SELECT kodeSupplier FROM supplier WHERE kodeSupplier = '$kodeSupplier'")->num_rows();
			if ($chek > 0) {
				$callback['proses'] = 'Gagal Dihapus';
				$callback['hasil'] = 'error';
			} else {
				$where = array('kodeSupplier' => $kodeSupplier,);
				$q = $this->mproses->Delete('supplier', $where);
				$callback['hasil'] = ($q) ? 'success' : 'error';
				$callback['proses'] = ($q) ? 'Behasil Dihapus' : 'Gagal Dihapus';
			}
		}
		echo json_encode($callback);
	}
}
