<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class CrudTransaksi extends My_controller
{
  public function index()
  {
    redirect(base_url('beranda'));
  }
  function GetNoTransaksi($untuk, $username)
  {
    $getId = $this->db->query("SELECT idUser FROM user WHERE username = '$username'")->row_array();
    $tgl = date('Ymd');
    $no = $untuk . $getId['idUser'] . $tgl;

    if ($untuk == 'BL') { // Beli -> BL
      $getNo = $this->db->query("SELECT MAX(noBeli) nomor FROM beli WHERE noBeli LIKE '$no%'")->row_array();
    } else if ($untuk == 'SL') { // jual -> SL
      $getNo = $this->db->query("SELECT MAX(noJual) nomor FROM jual WHERE noJual LIKE '$no%'")->row_array();
    }
    if ($getNo['nomor'] == Null) {
      $nomor = $no . '001';
    } else {
      $spNo = explode($no, $getNo['nomor']);
      $nomor = $no . sprintf('%03d', $spNo[1] + 1);
    }
    $data['nomor'] = $nomor;
    $data['idUser'] = $getId['idUser'];
    return $data;
  }
  function BuatPembelian()
  {
    $kodeSupplier = $this->input->post('kodeSupplier');
    if (empty($kodeSupplier)) {
      $callback['proses'] = 'Gagal Buat Transaksi';
      $callback['hasil'] = 'error';
    } else {
      $noBeli = $this->GetNoTransaksi('BL', $this->session->userdata('username'));

      $data = array('noBeli' => $noBeli['nomor'], 'idUser' => $noBeli['idUser'], 'kodeSupplier' => $kodeSupplier,);
      $q = $this->mproses->Insert('beli', $data);
      $callback['proses'] = 'Transaksi Dibuat';
      $callback['hasil'] = ($q) ? 'success' : 'error';
    }
    echo json_encode($callback);
  }
  function BuatPenjualan()
  {
    $noJual = $this->GetNoTransaksi('SL', $this->session->userdata('username'));

    $data = array('noJual' => $noJual['nomor'], 'idUser' => $noJual['idUser']);
    $q = $this->mproses->Insert('jual', $data);
    $callback['proses'] = 'Transaksi Dibuat';
    $callback['hasil'] = ($q) ? 'success' : 'error';
    echo json_encode($callback);
  }
  function Pending()
  {
    $no = $this->input->post('no');
    $untuk = $this->input->post('untuk');
    if ($untuk == 'beli') {
      $ino = 'noBeli';
      $tbl = 'beli';
    } else if ($untuk == 'jual') {
      $ino = 'noJual';
      $tbl = 'jual';
    }
    if (empty($no)) {
      $callback['proses'] = 'Gagal Dihapus';
      $callback['hasil'] = 'error';
    } else {
      $data = array('pending' => 1, 'tanggalPending' => date('Y-m-d H:i:s'),);
      $where = array($ino => $no,);
      $q = $this->mproses->Update($tbl, $data, $where);
      $callback['proses'] = 'Dirubah';
      $callback['hasil'] = ($q) ? 'success' : 'error';
    }
    echo json_encode($callback);
  }

  public function ProsesUlang()
  {
    $no = $this->input->post('no');
    $untuk = $this->input->post('untuk');
    if ($untuk == 'beli') {
      $ino = 'noBeli';
      $tbl = 'beli';
    } else if ($untuk == 'jual') {
      $ino = 'noJual';
      $tbl = 'jual';
    }
    $where = array($ino => $no);
    $data = array('pending' => 0, 'tanggalLanjut' => date('Y-m-d H:i:s'), 'tanggalPending' => Null,);
    $q = $this->mproses->Update($tbl, $data, $where);
    echo json_encode('success');
  }
  function AddBarang()
  {
    $noBeli = $this->input->post('noBeli');
    $kodeBarang = $this->input->post('kodeBarang');
    $tipeSatuan = $this->input->post('satuan');
    // Ecer, Paket
    $getBarang = $this->db->query("SELECT b.kodeBarang, b.satuanEcer, b.hargaBeliEcer, b.satuanPaket, b.hargaBeliPaket, b.konversi, h.idHarga FROM barang b LEFT JOIN (SELECT MAX(idHarga) idHarga, kodeBarang FROM harga GROUP BY kodeBarang) h ON b.kodeBarang = h.kodeBarang WHERE b.kodeBarang = '$kodeBarang'")->row_array();
    if (empty($getBarang)) {
      $callback['proses'] = 'Barang Tidak ada';
      $callback['hasil'] = 'error';
    } else {
      if ($tipeSatuan == 'Ecer') {
        $jumlahAsli = 1;
        $jumlahEcer = 1;
        $satuanAsli = $getBarang['satuanEcer'];
        $satuanEcer = $getBarang['satuanEcer'];
        $hargaView = $getBarang['hargaBeliEcer'];
        $hargaEcer = $getBarang['hargaBeliEcer'];
        $hargaAsli = $getBarang['hargaBeliEcer'];
      } else if ($tipeSatuan == 'Paket') {
        $jumlahAsli = 1;
        $jumlahEcer = 1 * $getBarang['konversi'];
        $satuanAsli = $getBarang['satuanPaket'];
        $satuanEcer = $getBarang['satuanEcer'];
        $hargaView = $getBarang['hargaBeliPaket'];
        $hargaEcer = $getBarang['hargaBeliPaket'] / $getBarang['konversi'];
        $hargaAsli = $getBarang['hargaBeliPaket'];
      }
      $cekTerbeli = $this->db->query("SELECT * FROM pembelian WHERE noBeli = '$noBeli' AND kodeBarang = '$kodeBarang' AND bonus = 0 AND satuanAsli = '$satuanAsli'")->row_array();

      $data = array(
        'kodeBarang' => $kodeBarang,
        'noBeli' => $noBeli,
        'satuanAsli' => $satuanAsli,
        'satuanEcer' => $satuanEcer,
        'hargaView' => $hargaView,
        'idHarga' => $getBarang['idHarga'],
      );
      if (empty($cekTerbeli)) {
        $id = '';
        $data['jumlahAsli'] = $jumlahAsli;
        $data['jumlahEcer'] = $jumlahEcer;
        $data['hargaAsli'] = $hargaAsli;
        $data['hargaEcer'] = $hargaEcer;
        $data['stok'] = $jumlahEcer;
      } else {
        $id = $cekTerbeli['idPembelian'];
        $data['jumlahAsli'] = $cekTerbeli['jumlahAsli'] + $jumlahAsli;
        $data['jumlahEcer'] = $cekTerbeli['jumlahEcer'] + $jumlahEcer;
        $data['stok'] = $cekTerbeli['stok'] + $jumlahEcer;
        $data['hargaAsli'] = $hargaAsli - ($hargaAsli * $cekTerbeli['diskon'] / 100);
        $data['hargaEcer'] = $hargaEcer - ($hargaEcer * $cekTerbeli['diskon'] / 100);
      }
      $callback = $this->ProsesAdd($data, 'pembelian', $id, 'idPembelian');
    }
    echo json_encode($callback);
  }
  function UpdateQtyBarang()
  {
    $idPembelian = $this->input->post('idPembelian');
    $qty = $this->input->post('qty');
    // Ecer, Paket
    $getBarang = $this->db->query("SELECT p.satuanAsli, p.diskon, b.kodeBarang, b.satuanEcer, b.hargaBeliEcer, b.satuanPaket, b.hargaBeliPaket, b.konversi, h.idHarga FROM pembelian p LEFT JOIN barang b ON p.kodeBarang = b.kodeBarang LEFT JOIN (SELECT MAX(idHarga) idHarga, kodeBarang FROM harga GROUP BY kodeBarang) h ON b.kodeBarang = h.kodeBarang WHERE p.idPembelian = '$idPembelian'")->row_array();
    if (empty($getBarang)) {
      $callback['proses'] = 'Barang Tidak ada';
      $callback['hasil'] = 'error';
    } else {
      if ($getBarang['satuanAsli'] == $getBarang['satuanEcer']) { // ecer konversi 1
        $jumlahAsli = $qty;
        $jumlahEcer = $qty;
        $hargaAsli = $getBarang['hargaBeliEcer'] - ($getBarang['hargaBeliEcer'] * $getBarang['diskon'] / 100);
        $hargaEcer = $getBarang['hargaBeliEcer'] - ($getBarang['hargaBeliEcer'] * $getBarang['diskon'] / 100);
        $hargaView = $getBarang['hargaBeliEcer'];
        $stok = $qty;
      } else if ($getBarang['satuanAsli'] == $getBarang['satuanPaket']) { // ecer konversi data konversi
        $jumlahAsli = $qty;
        $jumlahEcer = $qty * $getBarang['konversi'];
        $hargaAsli = $getBarang['hargaBeliPaket'] - ($getBarang['hargaBeliPaket'] * $getBarang['diskon'] / 100);
        $hargaEcer = ($getBarang['hargaBeliPaket'] - ($getBarang['hargaBeliPaket'] * $getBarang['diskon'] / 100)) / $getBarang['konversi'];
        $hargaView = $getBarang['hargaBeliPaket'];
        $stok = $qty * $getBarang['konversi'];
      } else {
        exit();
      }
      $data = array(
        'jumlahAsli' => $jumlahAsli,
        'jumlahEcer' => $jumlahEcer,
        'hargaAsli' => $hargaAsli,
        'hargaEcer' => $hargaEcer,
        'hargaView' => $hargaView,
        'stok' => $stok,
        'idHarga' => $getBarang['idHarga'],
      );

      $callback = $this->ProsesAdd($data, 'pembelian', $idPembelian, 'idPembelian');
    }
    echo json_encode($callback);
  }
  function UpdateDiskonBarang()
  {
    $idPembelian = $this->input->post('idPembelian');
    $diskon = $this->input->post('diskon');
    // Ecer, Paket
    $getBarang = $this->db->query("SELECT p.satuanAsli, p.diskon, b.kodeBarang, b.satuanEcer, b.hargaBeliEcer, b.satuanPaket, b.hargaBeliPaket, b.konversi, h.idHarga FROM pembelian p LEFT JOIN barang b ON p.kodeBarang = b.kodeBarang LEFT JOIN (SELECT MAX(idHarga) idHarga, kodeBarang FROM harga GROUP BY kodeBarang) h ON b.kodeBarang = h.kodeBarang WHERE p.idPembelian = '$idPembelian'")->row_array();
    if (empty($getBarang)) {
      $callback['proses'] = 'Barang Tidak ada';
      $callback['hasil'] = 'error';
    } else {
      if ($getBarang['satuanAsli'] == $getBarang['satuanEcer']) { // ecer konversi 1
        $hargaAsli = $getBarang['hargaBeliEcer'] - ($getBarang['hargaBeliEcer'] * $diskon / 100);
        $hargaEcer = $getBarang['hargaBeliEcer'] - ($getBarang['hargaBeliEcer'] * $diskon / 100);
        $hargaView = $getBarang['hargaBeliEcer'];
      } else if ($getBarang['satuanAsli'] == $getBarang['satuanPaket']) { // ecer konversi data konversi
        $hargaAsli = $getBarang['hargaBeliPaket'] - ($getBarang['hargaBeliPaket'] * $diskon / 100);
        $hargaEcer = ($getBarang['hargaBeliPaket'] - ($getBarang['hargaBeliPaket'] * $diskon / 100)) / $getBarang['konversi'];
        $hargaView = $getBarang['hargaBeliPaket'];
      } else {
        exit();
      }
      $data = array(
        'hargaAsli' => $hargaAsli,
        'hargaEcer' => $hargaEcer,
        'hargaView' => $hargaView,
        'idHarga' => $getBarang['idHarga'],
        'diskon' => $diskon,
      );

      $callback = $this->ProsesAdd($data, 'pembelian', $idPembelian, 'idPembelian');
    }
    echo json_encode($callback);
  }
  public function DelPembelian()
  {
    $callback = $this->ProsesDel('pembelian', $this->input->post('idPembelian'), 'idPembelian');
    echo json_encode($callback);
  }
  public function DonePembelian()
  {
    $list = ['noBeli', 'total'];
    $data = $this->CreateArray($list);
    $data['done'] = 1;
    $data['tanggalDone'] = date('Y-m-d H:i:s');

    $bayar = str_replace(',', '', $this->input->post('bayar'));
    if (!empty($bayar) || $bayar > 0) {
      $data['kurang'] = $data['total'] - $bayar;
      $data['terbayar'] = $bayar;
      $databayar['noBeli'] = $data['noBeli'];
      $databayar['nominal'] = $bayar;
      $databayar['user'] = $this->session->userdata('username');
      $this->ProsesAdd($databayar, 'bayarbeli', '', 'idBayarBeli');
    } else {
      $data['kurang'] = $data['total'];
    }

    $callback = $this->ProsesAdd($data, 'beli', $this->input->post('noBeli'), 'noBeli');
    echo json_encode($callback);
  }
  public function AddPembayaran()
  {
    $noBeli = $this->input->post('noBeli');
    $nominal = str_replace(',', '', $this->input->post('nominal'));
    $checkKurang = $this->db->query("SELECT kurang FROM beli WHERE noBeli = '$noBeli'")->row_array();
    if ($nominal <= 0 || empty($nominal)) {
      $callback['hasil'] = 'error';
      $callback['proses'] = 'Nominal Tidak Boleh 0!!!';
      $callback['nominal'] = $nominal;
    } else if ($checkKurang['kurang'] == 0 || $checkKurang['kurang'] < $nominal) {
      $callback['hasil'] = 'error';
      $callback['proses'] = 'Nominal Melebihi Kekurangan';
      $callback['nominal'] = $checkKurang['kurang'];
    } else {
      $data = array('noBeli' => $noBeli, 'nominal' => $nominal, 'user' => $this->session->userdata('username'));
      $q = $this->mproses->Insert('bayarbeli', $data);
      $callback['hasil'] = ($q) ? 'success' : 'error';
      $callback['proses'] = 'Ditambahkan';
    }
    echo json_encode($callback);
  }
  function AddBarangJual()
  {
    $noJual = $this->input->post('noJual');
    $kodeBarang = $this->input->post('kodeBarang');
    $tipeSatuan = $this->input->post('satuan');
    // Ecer, Paket
    $getBarang = $this->db->query("SELECT * FROM (SELECT d.*, st.stok, CONCAT(d.namaBarang, ' ', d.kodeBarang, ' ', d.satuan,  ' ', d.hargaJual, ' ', d.namaKategori) cari, 
      CASE WHEN '$tipeSatuan' = 'Paket'
      THEN d.konversi ELSE 1 END AS minim FROM
      (SELECT b.kodeBarang, b.namaBarang, k.namaKategori, b.konversi, 
      CASE WHEN '$tipeSatuan' ='Paket'
      THEN b.satuanPaket WHEN '$tipeSatuan' ='Ecer' THEN b.satuanEcer ELSE '' END AS satuan,
      CASE WHEN '$tipeSatuan' ='Paket'
      THEN b.hargaJualPaket WHEN '$tipeSatuan' ='Ecer' THEN b.hargaJualEcer ELSE '' END AS hargaJual FROM barang b LEFT JOIN kategori k ON k.idKategori = b.idKategori) d
      INNER JOIN (
        SELECT s.kodeBarang, (s.stok + IFNULL(jl.jml,0)) as stok FROM
        (SELECT p.kodeBarang, SUM(p.stok) stok FROM beli b INNER JOIN pembelian p ON b.noBeli = p.noBeli WHERE b.done = 1 GROUP BY p.kodeBarang) s LEFT JOIN 
        (SELECT kodeBarang, SUM(jumlahEcer) jml FROM penjualan WHERE noJual = '$noJual' GROUP BY kodeBarang) jl ON s.kodeBarang = jl.kodeBarang
        
        ) st ON d.kodeBarang = st.kodeBarang) dat WHERE stok >= minim")->row_array();
    if (empty($getBarang)) {
      $callback['proses'] = 'Barang Tidak ada';
      $callback['hasil'] = 'error';
    } else {
      if ($tipeSatuan == 'Ecer') {
        $jumlahAsli = 1;
        $jumlahEcer = 1;
        $satuanAsli = $getBarang['satuanEcer'];
        $satuanEcer = $getBarang['satuanEcer'];
        $hargaView = $getBarang['hargaBeliEcer'];
        $hargaEcer = $getBarang['hargaBeliEcer'];
        $hargaAsli = $getBarang['hargaBeliEcer'];
      } else if ($tipeSatuan == 'Paket') {
        $jumlahAsli = 1;
        $jumlahEcer = 1 * $getBarang['konversi'];
        $satuanAsli = $getBarang['satuanPaket'];
        $satuanEcer = $getBarang['satuanEcer'];
        $hargaView = $getBarang['hargaBeliPaket'];
        $hargaEcer = $getBarang['hargaBeliPaket'] / $getBarang['konversi'];
        $hargaAsli = $getBarang['hargaBeliPaket'];
      }
      $cekTerbeli = $this->db->query("SELECT * FROM pembelian WHERE noJual = '$noJual' AND kodeBarang = '$kodeBarang' AND bonus = 0 AND satuanAsli = '$satuanAsli'")->row_array();

      $data = array(
        'kodeBarang' => $kodeBarang,
        'noBeli' => $noJual,
        'satuanAsli' => $satuanAsli,
        'satuanEcer' => $satuanEcer,
        'hargaView' => $hargaView,
        'idHarga' => $getBarang['idHarga'],
      );
      if (empty($cekTerbeli)) {
        $id = '';
        $data['jumlahAsli'] = $jumlahAsli;
        $data['jumlahEcer'] = $jumlahEcer;
        $data['hargaAsli'] = $hargaAsli;
        $data['hargaEcer'] = $hargaEcer;
        $data['stok'] = $jumlahEcer;
      } else {
        $id = $cekTerbeli['idPembelian'];
        $data['jumlahAsli'] = $cekTerbeli['jumlahAsli'] + $jumlahAsli;
        $data['jumlahEcer'] = $cekTerbeli['jumlahEcer'] + $jumlahEcer;
        $data['stok'] = $cekTerbeli['stok'] + $jumlahEcer;
        $data['hargaAsli'] = $hargaAsli - ($hargaAsli * $cekTerbeli['diskon'] / 100);
        $data['hargaEcer'] = $hargaEcer - ($hargaEcer * $cekTerbeli['diskon'] / 100);
      }
      $callback = $this->ProsesAdd($data, 'pembelian', $id, 'idPembelian');
    }
    echo json_encode($callback);
  }







  public function UbahUser()
  {
    $no = $this->input->post('no');
    $idUser = $this->input->post('idUser');
    if (!empty($no) && !empty($idUser)) {
      $untuk = $this->input->post('untuk');
      if ($untuk == 'beli') {
        $ino = 'noBeli';
        $tbl = 'beli';
      } else if ($untuk == 'jual') {
        $ino = 'noJual';
        $tbl = 'jual';
      }
      $where = array($ino => $no);
      $data = array(
        'idUser' => $idUser,
        'userLalu' => $this->session->userdata('username'),
        'tanggalAlih' => date('Y-m-d H:i:s'),
      );
      $this->mproses->Update($tbl, $data, $where);
      $callback['hasil'] = 'success';
      $callback['proses'] = 'Transaksi Dialihkan';
    } else {
      $callback['hasil'] = 'error';
      $callback['proses'] = 'Transaksi Gagal Dialihkan';
    }

    echo json_encode($callback);
  }
  public function ChangeMember()
  {
    $noJual = $this->input->post('noJual');
    $idMember = $this->input->post('idMember');
    if (!empty($noJual)) {
      $getDiskon = $this->db->query("SELECT m.idDiskon FROM memberdiskon m INNER JOIN diskon d ON d.idDiskon = m.idDiskon WHERE idMember = '$idMember' AND d.exp  >= CURDATE() ORDER BY id DESC")->row_array();
      $idDiskon = (empty($getDiskon)) ? NULL : $getDiskon['idDiskon'];
      $where = array('noJual' => $noJual);
      $data = array(
        'idMember' => $idMember,
        'idDiskon' => $idDiskon,
      );
      $this->mproses->Update('jual', $data, $where);
      $callback['hasil'] = 'success';
      $callback['proses'] = 'Member Berhasil Ditambahkan';
    } else {
      $callback['hasil'] = 'error';
      $callback['proses'] = 'Member Gagal Ditambahkan';
    }

    echo json_encode($callback);
  }
  public function HapusMember()
  {
    $noJual = $this->input->post('noJual');
    if (!empty($noJual)) {
      $get = $this->db->query("SELECT idMember, idDiskon FROM jual WHERE noJual = '$noJual'")->row_array();
      $getMemberDiskon = $this->db->query("SELECT idMember FROM memberdiskon WHERE idMember = '" . $get['idMember'] . "' AND idDiskon = '" . $get['idDiskon'] . "'")->row_array();


      $idDiskon = (empty($getMemberDiskon)) ? $get['idDiskon'] : NULL;

      $where = array('noJual' => $noJual);
      $data = array(
        'idMember' => NULL,
        'idDiskon' => $idDiskon,
      );
      $this->mproses->Update('jual', $data, $where);
      $callback['hasil'] = 'success';
      $callback['proses'] = 'Member Berhasil Dihapus';
    } else {
      $callback['hasil'] = 'error';
      $callback['proses'] = 'Member Gagal Dihapus';
    }

    echo json_encode($callback);
  }
  public function GantiDiskon()
  {
    $noJual = $this->input->post('noJual');
    $kodeDiskon = $this->input->post('kodeDiskon');
    if (!empty($noJual) && !empty($kodeDiskon)) {
      $getDiskon = $this->db->query("SELECT d.idDiskon, d.exp, d.am, j.noJual, md.id, j.idDiskon jdiskon FROM diskon d LEFT JOIN jual j ON j.noJUal = '$noJual' LEFT JOIN memberdiskon md ON md.idDiskon = d.idDiskon AND j.idMember = md.idMember WHERE d.kodeDiskon = '$kodeDiskon' AND d.exp >= CURDATE() ")->row_array();
      if (empty($getDiskon)) {
        $callback['hasil'] = 'error';
        $callback['proses'] = 'Diskon Tidak Ditemukan';
      } else if (($getDiskon['am'] == 1 && !is_null($getDiskon['am']) || $getDiskon['am'] == 0)) {
        // in
        if ($getDiskon['jdiskon'] == $getDiskon['idDiskon']) {
          $callback['hasil'] = 'error';
          $callback['proses'] = 'Diskon Telah Terpakai';
        } else {
          $where = array('noJual' => $noJual);
          $data = array('idDiskon' => $getDiskon['idDiskon'],);
          $this->mproses->Update('jual', $data, $where);
          $callback['hasil'] = 'success';
          $callback['proses'] = 'Diskon Berhasil Ditambahkan';
        }
      } else {
        $callback['hasil'] = 'error';
        $callback['proses'] = 'Diskon Tidak Ditemukan';
      }
    } else {
      $callback['hasil'] = 'error';
      $callback['proses'] = 'Diskon Gagal Ditambahkan';
    }

    echo json_encode($callback);
  }
}
