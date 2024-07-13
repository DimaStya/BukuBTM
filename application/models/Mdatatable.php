<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mdatatable extends My_Model
{
  
  public function LoadIcon()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['icon', 'icon','icon','icon','icon','icon','icon','icon','icon','icon'];
    $order = $list[$orderid];
    
    $query = "SELECT icon, CONCAT(icon,' ') cari FROM icon";
    $hasil = $this->CreatQueryMysql1($query, $order);

    $data = array();
    $loop = ceil(COUNT($hasil['data']) / 10);
    $n = 0;
    for ($i=0; $i < $loop; $i++) { 
      $l = [];
      for ($j=0; $j < 10; $j++) { 
        if($n < COUNT($hasil['data'])){
          $l[] = '<button class="btn btn-xs btn-default" onclick="isiIcon(\''.$hasil['data'][$n]['icon'].'\')"><i class="'.$hasil['data'][$n]['icon'].'"></i> '.$hasil['data'][$n]['icon'].'</button>';
        }else{
          $l[] = 'kosong';
        }
        $n++;
      }
      $data[] =$l;
    }
   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadUser()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(username)', 'username','nama','additional','ln(username)'];
    $order = $list[$orderid];
    
    $query = "SELECT username, nama, additional, akses, CONCAT(username,' ',nama, ' ',additional) cari FROM user";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {
      $btnhps = ($row->akses == '1') ? '| <button class="btn btn-xs btn-outline-danger" title="Hapus" onclick="hapus(\''.$row->username.'\');"><i class="fas fa-trash"></i> </button>' : '';
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '<button class="btn btn-xs btn-outline-success" title="Edit" onclick="modal(\''.$row->username.'\');"><i class="fas fa-pencil-alt"></i> </button> | <button class="btn btn-xs btn-outline-warning" title="Reset Password" onclick="reset(\''.$row->username.'\');"><i class="fas fa-history"></i> </button> '.$btnhps : '';
      
      array_push($data, array(
        $no,
        $row->username,
        $row->nama,
        $row->additional,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadKategori()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(namaKategori)', 'namaKategori','kode','ln(namaKategori)'];
    $order = $list[$orderid];
    
    $query = "SELECT idKategori, namaKategori, kode, CONCAT(namaKategori,' ', kode) cari FROM kategori";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '<button class="btn btn-xs btn-outline-success" onclick="modal(\''.$row->idKategori.'\');"><i class="fas fa-pencil-alt"></i> </button> | <button class="btn btn-xs btn-outline-danger" onclick="hapus(\''.$row->idKategori.'\');"><i class="fas fa-trash"></i> </button>' : '';
      
      array_push($data, array(
        $no,
        $row->namaKategori,
        $row->kode,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadBarang()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(namaBarang)', 'namaKategori', 'namaBarang','kodeBarang','satuanEcer','satuanPaket','konversi','hargaJualEcer','hargaJualPaket','hargaBeliEcer','hargaBeliPaket','ln(namaBarang)'];
    $order = $list[$orderid];
    
    $query = "SELECT b.kodeBarang, b.namaBarang, b.satuanEcer, b.satuanPaket, b.konversi, b.hargaJualEcer, b.hargaJualPaket, b.hargaBeliEcer, b.hargaBeliPaket, k.namaKategori, b.updateHarga, CONCAT(b.namaBarang, ' ', b.kodeBarang, ' ', b.satuanEcer, ' ', b.satuanPaket, ' ', b.konversi, ' ', b.hargaJualEcer, ' ', b.hargaJualPaket, ' ', b.hargaBeliEcer, ' ', b.hargaBeliPaket, ' ', ' ', k.namaKategori) cari FROM barang b LEFT JOIN kategori k ON k.idKategori = b.idKategori";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {
      // if($this->session->userdata('aksesnya') == 'VE'){
      //   $cekT = $this->db->query('SELECT kodeBarang FROM pembelian')->num_rows();
      //   $btn = ($cekT > 0) ? '' : '<button class="btn btn-xs btn-outline-success" onclick="modal(\''.$row->kodeBarang.'\',\'data\');"><i class="fas fa-pencil-alt"></i> </button> |';
      //   $btn .= ($row->updateHarga == date('Y-m-d')) ? '' : '<button class="btn btn-xs btn-outline-primary" onclick="modal(\''.$row->kodeBarang.'\',\'hrg\');"><i class="fas fa-tags"></i> </button> |';
      //   $btn .= ($cekT > 0) ? '' : '<button class="btn btn-xs btn-outline-danger" onclick="hapus(\''.$row->kodeBarang.'\');"><i class="fas fa-trash"></i> </button>';
      // }else{
      //   $btn = '';
      // }

      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '
      <button class="btn btn-xs btn-outline-success" onclick="modal(\''.$row->kodeBarang.'\',\'data\');" title="Edit Data"><i class="fas fa-pencil-alt"></i> </button> | 
      <button class="btn btn-xs btn-outline-primary" onclick="modal(\''.$row->kodeBarang.'\',\'hrg\'); "title="Edit Harga"><i class="fas fa-tags"></i> </button> |
      <button class="btn btn-xs btn-outline-danger" onclick="hapus(\''.$row->kodeBarang.'\');" title="Hapus Data"><i class="fas fa-trash"></i> </button>' : '';
      
      array_push($data, array(
        $no,
        $row->namaKategori,
        $row->namaBarang,
        $row->kodeBarang,
        $row->satuanEcer,
        $row->satuanPaket,
        $row->konversi,
        FormatKurs($row->hargaJualEcer,1,'Rp'),
        FormatKurs($row->hargaJualPaket,1,'Rp'),
        FormatKurs($row->hargaBeliEcer,1,'Rp'),
        FormatKurs($row->hargaBeliPaket,1,'Rp'),
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadListBarang()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(namaBarang)', 'namaKategori', 'kodeBarang', 'namaBarang', 'ln(namaBarang)','satuan','hargaBeli','ln(namaBarang)'];
    $order = $list[$orderid];

    $tipeSatuan = $this->input->post('tipeSatuan');

    if($tipeSatuan == 'Paket'){
      $query = "SELECT *, CONCAT(namaBarang, ' ', kodeBarang, ' ', satuan,  ' ', hargaBeli, ' ', namaKategori) cari FROM
      (SELECT b.kodeBarang, b.namaBarang, k.namaKategori, b.satuanPaket satuan, b.hargaBeliPaket hargaBeli  FROM barang b LEFT JOIN kategori k ON k.idKategori = b.idKategori) d";
    }else if($tipeSatuan == 'Ecer'){
      $query = "SELECT *, CONCAT(namaBarang, ' ', kodeBarang, ' ', satuan,  ' ', hargaBeli, ' ', namaKategori) cari FROM
      (SELECT b.kodeBarang, b.namaBarang, k.namaKategori, b.satuanEcer satuan, b.hargaBeliEcer hargaBeli  FROM barang b LEFT JOIN kategori k ON k.idKategori = b.idKategori) d";
    }

    
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {
      // $btn = '<button class="btn btn-xs btn-outline-primary" onclick="addBarang(\''.$row->kodeBarang.'\',\''.$tipeSatuan.'\');">pilih</button>';      
      array_push($data, array(
        $no,
        $row->namaKategori,
        $row->kodeBarang,
        $row->namaBarang,
        $row->namaBarang,
        $row->satuan,
        FormatKurs($row->hargaBeli,1,'Rp'),
        $tipeSatuan,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadListBarangStok()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(namaBarang)', 'namaKategori', 'kodeBarang', 'namaBarang', 'ln(namaBarang)','satuan','hargaJual','ln(namaBarang)'];
    $order = $list[$orderid];

    $tipeSatuan = $this->input->post('tipeSatuan');
    $noJual = $this->input->post('noJual');
   
      $query = "SELECT * FROM (SELECT d.*, st.stok, CONCAT(d.namaBarang, ' ', d.kodeBarang, ' ', d.satuan,  ' ', d.hargaJual, ' ', d.namaKategori) cari, 
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
        
        ) st ON d.kodeBarang = st.kodeBarang) dat WHERE stok >= minim
      ";  
      // echo $query;exit();

    
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {
      // $btn = '<button class="btn btn-xs btn-outline-primary" onclick="addBarang(\''.$row->kodeBarang.'\',\''.$tipeSatuan.'\');">pilih</button>';      
      array_push($data, array(
        $no,
        $row->namaKategori,
        $row->kodeBarang,
        $row->namaBarang,
        $row->namaBarang,
        $row->satuan,
        FormatKurs($row->hargaJual,1,'Rp'),
        $tipeSatuan,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadHarga()
  {
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $idKategori = $this->input->post('idKategori');
    $kodeBarang = $this->input->post('kodeBarang');

    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(namaBarang)', 'namaKategori', 'namaBarang','kodeBarang'];
    

    $select = 'barang.namaKategori, barang.namaBarang, barang.kodeBarang';
    
    if(empty($kodeBarang) && empty($idKategori)){
      //all
      $barang = "(SELECT k.namaKategori, b.namaBarang, b.kodeBarang FROM barang b, kategori k WHERE b.idKategori = k.idKategori) barang";
    }else if(empty($kodeBarang)){
      //satu kategori
      $barang = "(SELECT k.namaKategori, b.namaBarang, b.kodeBarang FROM barang b, kategori k WHERE b.idKategori = k.idKategori AND k.idKategori='".$idKategori."') barang";
    }else{
      //satu barang
      $barang = "(SELECT k.namaKategori, b.namaBarang, b.kodeBarang FROM barang b, kategori k WHERE b.idKategori = k.idKategori AND b.kodeBarang='".$kodeBarang."') barang";
    }
    $tgl = [];
    $harga = '';
    if(strtotime($dari) == strtotime($sampai)){
      //1 tanggal
      $kecil = date("Ymd", strtotime($dari));
      $tgl[] = 'hrg'.$kecil;
      $list[] = 'hrg'.$kecil;
      $tanggal = date("Y-m-d", strtotime($dari));
      $select .= ',hrg'.$kecil.'.hrg as hrg'.$kecil;
      $harga .= " LEFT JOIN (SELECT kodeBarang, CONCAT(jualEcer,'/',jualPaket) hrg FROM harga WHERE tanggal = '".$tanggal."') hrg".$kecil." ON barang.kodeBarang = hrg".$kecil.".kodeBarang";
    }else {
      if(strtotime($dari) > strtotime($sampai)){
        //mundur
        $dari = date("Ymd", strtotime($dari));
        $sampai = date("Ymd", strtotime($sampai));
        while (strtotime($dari) >= strtotime($sampai)) {
          $tgl[] = 'hrg'.$dari;
          $list[] = 'hrg'.$dari;
          $tanggal = date("Y-m-d", strtotime($dari));
          $select .= ',hrg'.$dari.'.hrg as hrg'.$dari;
          $harga .= " LEFT JOIN (SELECT kodeBarang, CONCAT(jualEcer,'/',jualPaket) hrg FROM harga WHERE tanggal = '".$tanggal."') hrg".$dari." ON barang.kodeBarang = hrg".$dari.".kodeBarang";
          $dari = date('Ymd', strtotime('-1 days', strtotime($dari)));
        }        
      }else {
        //maju
        $dari = date("Ymd", strtotime($dari));
        $sampai = date("Ymd", strtotime($sampai));
        while (strtotime($dari) <= strtotime($sampai)) {
          $tgl[] = 'hrg'.$dari;
          $list[] = 'hrg'.$dari;
          $tanggal = date("Y-m-d", strtotime($dari));
          $select .= ',hrg'.$dari.'.hrg as hrg'.$dari;
          $harga .= " LEFT JOIN (SELECT kodeBarang, CONCAT(jualEcer,'/',jualPaket) hrg FROM harga WHERE tanggal = '".$tanggal."') hrg".$dari." ON barang.kodeBarang = hrg".$dari.".kodeBarang";
          $dari = date('Ymd', strtotime('+1 days', strtotime($dari)));
        }        
      }      
    }
    $order = $list[$orderid];
    $query = 'SELECT '.$select.' FROM '.$barang.$harga;

    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;  
    // print_r($hasil['data']);  
    foreach ($hasil['data'] as $row) { 
      $extend = [];
      $extend[] = $no;
      $extend[] = $row->namaKategori;
      $extend[] = $row->namaBarang;
      $extend[] = $row->kodeBarang;
      for ($i=0; $i < count($tgl); $i++) { 
        $dat = $tgl[$i];
        $listDat = (!empty($row->$dat)) ? $row->$dat : '-/-';
        $det = explode('/',$listDat);
        if($listDat == '-/-'){
          $extend[] = 'None';
        }else{
          $extend[] = FormatKurs($det[0],1,'Rp').'/ '.FormatKurs($det[1],1,'Rp');
        }
      }
      $data[] = $extend;
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadProgram()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(namaProgram)', 'namaProgram', 'namaBarang', 'tipeProgram','jumlahEcer','tipePotongan','nilai','namaBarangB','ln(namaProgram)'];
    $order = $list[$orderid];
    
    $query = "SELECT p.tanggalHapus, p.idProgram, p.namaProgram, b.namaBarang, p.tipeProgram, p.tipePotongan, p.jumlahEcer, p.nilai, b.satuanEcer, bo.namaBarang namaBarangB,  CONCAT(p.namaProgram, ' ', b.namaBarang, ' ', p.tipeProgram, ' ', p.tipePotongan, ' ', p.jumlahEcer, ' ', p.nilai,' ', b.satuanEcer, bo.namaBarang) cari FROM program p LEFT JOIN barang b ON p.kodeBarang = b.kodeBarang LEFT JOIN barang bo ON p.kodeBarangB = bo.kodeBarang";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {
      if($this->session->userdata('aksesnya') == 'VE'){
        $btn = (empty($row->tanggalHapus)) ? '<button class="btn btn-xs btn-outline-success" onclick="modal(\''.$row->idProgram.'\');"><i class="fas fa-pencil-alt"></i> </button>|<button class="btn btn-xs btn-outline-danger" onclick="hapus(\''.$row->idProgram.'\');"><i class="fas fa-power-off"></i> </button>' : '<button class="btn btn-xs btn-outline-primary" onclick="aktif(\''.$row->idProgram.'\');"><i class="fas fa-power-off"></i> </button>';
      }else{
        $btn = '';
      }
      if($row->tipePotongan == 'Persen'){
        $nilai = $row->nilai.'%';
      }else if($row->tipePotongan == 'Bonus'){
        $nilai = $row->nilai.' Pcs';
      } else if($row->tipePotongan == 'Rupiah'){
        $nilai = FormatKurs($row->nilai,1,'Rp');
      }    
      array_push($data, array(
        $no,
        $row->namaProgram,
        $row->namaBarang,
        $row->tipeProgram,
        $row->jumlahEcer.' '.$row->satuanEcer,
        $row->tipePotongan,
        $nilai,
        $row->namaBarangB,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadMember()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['idMember', 'namaMember', 'noHp','alamat','ln(namaMember)'];
    $order = $list[$orderid];
    
    $query = "SELECT idMember, namaMember, noHp, alamat, 
    CONCAT(idMember, ' ', namaMember, ' ', noHp, ' ', alamat, ' ') cari FROM member";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '
      <button class="btn btn-xs btn-outline-success" onclick="modal(\''.$row->idMember.'\');"><i class="fas fa-pencil-alt"></i> </button> |
      <button class="btn btn-xs btn-outline-danger" onclick="hapus(\''.$row->idMember.'\');"><i class="fas fa-trash"></i> </button>' : '';
           
      array_push($data, array(
        $no,
        $row->idMember,
        $row->namaMember,
        $row->noHp,
        $row->alamat,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadDiskonMember()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['kodeDiskon', 'besaran', 'member','besaran','minimum','maximumDiskon','exp','stat','ln(kodeDiskon)'];
    $order = $list[$orderid];
    
    $query = "SELECT *, CONCAT(kodeDiskon,' ',besaran,' ',member,' ',minimum,' ',maximumDiskon,' ',exp,' ',stat,' ') as cari FROM
    (SELECT dm.idDiskon, dm.kodeDiskon, CASE WHEN dm.metodeDiskon = 'persen' THEN CONCAT(dm.besaran,'%') WHEN dm.metodeDiskon = 'nominal' THEN CONCAT('Rp. ',dm.besaran) END as besaran, 
    CASE WHEN COUNT(idMember) = 0 THEN 'ALL Member' ELSE
    CONCAT(COUNT(idMember),' Member') END member, CONCAT('Rp. ',dm.minimum) minimum, CONCAT('Rp. ',dm.maximumDiskon) maximumDiskon, dm.exp, CASE WHEN dm.exp < CURDATE() THEN 'Expired' ELSE 'Berlaku' END as stat FROM diskon dm LEFT JOIN memberdiskon md ON dm.idDiskon = md.idDiskon GROUP BY dm.idDiskon, dm.kodeDiskon) hg WHERE idDiskon IS NOT NULL";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {      
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '      
      <button class="btn btn-xs btn-outline-success" onclick="modal(\''.$row->idDiskon.'\');"><i class="fas fa-pencil-alt"></i> </button> |
      <button class="btn btn-xs btn-outline-danger" onclick="hapus(\''.$row->idDiskon.'\');"><i class="fas fa-trash"></i> </button>' : '';
      $member = '<button class="btn btn-xs btn-outline-info" onclick="detailMember(\''.$row->idDiskon.'\');">'.$row->member.'</button>';
           
      array_push($data, array(
        $no,
        $row->kodeDiskon,
        $row->besaran,
        $member,
        $row->minimum,
        $row->maximumDiskon,
        $row->exp,
        $row->stat,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }  
  public function loadDetailMember()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['idMember', 'namaMember', 'noHp','alamat','ln(idMember)'];
    $order = $list[$orderid];
    $idDiskon = $this->input->post('idDiskon');
    
    $query = "SELECT m.*, md.idDiskon FROM memberdiskon md LEFT JOIN member m ON m.idMember = md.idMember WHERE md.idDiskon = '$idDiskon'";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '
      <button class="btn btn-xs btn-outline-danger" onclick="hapusMemberDiskon(\''.$row->idDiskon.'\',\''.$row->idMember.'\');"><i class="fas fa-trash"></i> </button>' : '';
           
      array_push($data, array(
        $no,
        $row->idMember,
        $row->namaMember,
        $row->noHp,
        $row->alamat,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }  
  public function LoadCariMember()
  {
    $draw = intval($_POST['draw']);  
    // $orderid = $_POST['order'][0]['column'];
    // $list = ['idMember', 'namaMember', 'noHp','alamat','ln(idMember)'];
    $order = 'idMember';
    $cariMember = $this->input->post('cariMember');

    
    $query = (empty($cariMember)) ? "SELECT * FROM member WHERE aktif = 1 AND idMember = '$cariMember' OR namaMember = '$cariMember' AND noHp = '$cariMember'" : "SELECT * FROM member WHERE aktif = 1 AND (idMember LIKE '%$cariMember%' OR namaMember LIKE '%$cariMember%' OR noHp LIKE '%$cariMember%')";
    $hasil = $this->CreatQueryMysql($query, $order,'desc','5');

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {           
      array_push($data, array(
        $row->idMember,
        $row->namaMember,
        $row->noHp,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadBeliPending()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['noBeli', 'noBeli', 'tanggal','namaSupplier','nama','noBeli'];
    $order = $list[$orderid];
    $user = $this->session->userdata('username');
    
    $query = "SELECT b.noBeli, b.tanggal, b.pending, b.done, us.nama, b.kodeSupplier, s.namaSupplier, CONCAT(b.noBeli,' ',b.tanggal,' ',s.namaSupplier,' ',us.nama,' ') as cari FROM beli b INNER JOIN supplier s ON s.kodeSupplier = b.kodeSupplier INNER JOIN user u ON u.idUser = b.idUser LEFT JOIN user us ON us.username = b.userLalu WHERE u.username = '$user' AND b.pending = 1";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {      
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '
      <button title="Lanjut Proses" class="btn btn-xs btn-outline-success" onclick="ProsesUlang(\''.$row->noBeli.'\');"><i class="fas fa-angle-double-up"></i> Lanjut</button> | 
      <button title="Ubah User" class="btn btn-xs btn-outline-warning" onclick="ubahUser(\''.$row->noBeli.'\');"><i class="fas fa-exchange-alt"></i> Alihkan</button>' : '';
           
      array_push($data, array(
        $no,
        $row->noBeli,
        $row->tanggal,
        $row->namaSupplier,
        $row->nama,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }  
  public function LoadSupplier()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['kodeSupplier', 'kodeSupplier', 'namaSupplier', 'jenisSupplier','noTelpSupplier','emailSupplier','alamatSupplier','keterangan', 'kodeSupplier',];
    $order = $list[$orderid];
    
    $query = "SELECT *, CONCAT(kodeSupplier,' ',namaSupplier,' ',jenisSupplier,' ',noTelpSupplier,' ',emailSupplier,' ',alamatSupplier,' ',keterangan,' ') as cari FROM supplier";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {      
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '
      <button class="btn btn-xs btn-outline-success" onclick="modal(\''.$row->kodeSupplier.'\');"><i class="fas fa-pencil-alt"></i> </button> |
      <button class="btn btn-xs btn-outline-danger" onclick="hapus(\''.$row->kodeSupplier.'\');"><i class="fas fa-trash"></i> </button>' : '';
           
      array_push($data, array(
        $no,
        $row->kodeSupplier,
        $row->namaSupplier,
        $row->jenisSupplier,
        $row->noTelpSupplier,
        $row->emailSupplier,
        $row->alamatSupplier,
        $row->keterangan,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadJualPending()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['noJual', 'noJual', 'tanggal','idMember','nama','noJual'];
    $order = $list[$orderid];
    $user = $this->session->userdata('username');
    
    $query = "SELECT j.noJual, j.tanggal, j.idMember, us.nama, CONCAT(j.noJual,' ',j.tanggal,' ',us.nama,' ') as cari FROM jual j INNER JOIN user u ON u.idUser = j.idUser LEFT JOIN user us ON us.username = j.userLalu WHERE u.username = '$user' AND j.pending = 1";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {      
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '
      <button title="Lanjut Proses" class="btn btn-xs btn-outline-success" onclick="ProsesUlang(\''.$row->noJual.'\');"><i class="fas fa-angle-double-up"></i> Lanjut</button> | 
      <button title="Ubah User" class="btn btn-xs btn-outline-warning" onclick="ubahUser(\''.$row->noJual.'\');"><i class="fas fa-exchange-alt"></i> Alihkan</button>' : '';
           
      array_push($data, array(
        $no,
        $row->noJual,
        $row->tanggal,
        $row->idMember,
        $row->nama,
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }  
  #########################transaksi##############
  public function LoadBeliBarang() {
		$draw = intval($_POST['draw']);  
    $order ='idPembelian';
    $noBeli = $this->input->post('noBeli');
    
    $query = "SELECT d.*, CONCAT(jumlahAsli,' ',jumlahEcer,' ',hargaAsli,' ',hargaEcer,' ',hargaView,' ',satuanAsli,' ',kodeBarang,' ',namaBarang,' ') as cari FROM 
    (SELECT be.done, p.idPembelian, p.jumlahAsli, p.jumlahEcer, p.hargaAsli, p.hargaEcer, p.hargaView, p.satuanAsli, p.kodeBarang, p.bonus, p.diskon, b.namaBarang FROM pembelian p INNER JOIN beli be ON be.noBeli = p.noBeli INNER JOIN barang b ON p.kodeBarang = b.kodeBarang WHERE p.noBeli = '$noBeli' ) d";
    $hasil = $this->CreatQueryMysql($query, $order,'desc','-1');
    
    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {      
      $btn = ($this->session->userdata('aksesnya') == 'VE' AND $row->done == 0) ? '
      <button class="btn btn-xs btn-outline-danger" onclick="hapus(\''.$row->idPembelian.'\');"><i class="fas fa-trash"></i> <small>Hapus</small></button>' : '';

      $harga = ($row->hargaView == $row->hargaAsli) ? FormatKurs($row->hargaAsli,0,'Rp') : 'Rp <strike>'.FormatKurs($row->hargaView,0,'').'</strike> '.FormatKurs($row->hargaAsli,0,'');
      $total = ($row->hargaView == $row->hargaAsli) ? FormatKurs(($row->hargaAsli * $row->jumlahAsli),0,'Rp') : 'Rp <strike>'.FormatKurs(($row->hargaView * $row->jumlahAsli),0,'').'</strike> '.FormatKurs(($row->hargaAsli * $row->jumlahAsli),0,'');

      $dis = ($this->session->userdata('aksesnya') == 'VE' AND $row->done == 0) ? '' : 'disabled';

      $Eqty = '<input type="text" class="forn-control col-sm-12" id="qtyEdit'.$row->idPembelian.'" name="qtyEdit'.$row->idPembelian.'" onkeydown="updateQty(this, \''.$row->idPembelian.'\');" onKeyPress="return goodchars(event,\'1234567890\',this)" value="'.$row->jumlahAsli.'" '.$dis.'>';

      $Ediskon = '<input type="text" class="forn-control col-sm-12" id="diskonEdit'.$row->idPembelian.'" name="diskonEdit'.$row->idPembelian.'" onkeydown="updateDiskon(this, \''.$row->idPembelian.'\');" onKeyPress="return goodchars(event,\'1234567890.\',this)" value="'.$row->diskon.'" '.$dis.'>';

      array_push($data, array(
        $no,
        $row->kodeBarang,
        $row->namaBarang,
        $Eqty,
        $row->satuanAsli,
        $row->jumlahEcer,
        $harga,
        $total,
        $Ediskon,
        $btn,
      ));
      $no++;
    }
    $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
	}
  // pembelian
  public function LoadBayarBeli()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(noBeli)', 'noBeli', 'namaSupplier', 'tanggal', 'tanggalDone', 'nama', 'total','terbayar','kurang','ln(noBeli)'];
    $order = $list[$orderid];
    
    $query = "SELECT *, CONCAT(noBeli,' ',tanggal,' ',tanggalDone,' ',nama,' ',total,' ',terbayar,' ',kurang,' ', namaSupplier, ' ') as cari FROM 
    (SELECT b.noBeli, b.tanggal, b.tanggalDone, b.total, b.terbayar, b.kurang, u.nama, p.namaSupplier   FROM beli b LEFT JOIN user u ON u.idUser = b.idUser LEFT JOIN supplier p ON p.kodeSupplier = b.kodeSupplier WHERE b.done = 1 AND kurang <> 0) d ";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {      
      $btn = ($this->session->userdata('aksesnya') == 'VE') ? '
      <button class="btn btn-xs btn-outline-success" onclick="bayar(\''.$row->noBeli.'\');"><i class="fas fa-cash-register"></i> Bayar</button>' : '';

      $noBeli = '<a title="Detail Barang" href="#" onclick="detail(\''.$row->noBeli.'\',\'barang\');">'.$row->noBeli.'</a>';
      $terbayar = '<a title="Detail Bayar" href="#" onclick="detail(\''.$row->noBeli.'\',\'bayar\');">'.FormatKurs($row->terbayar,0,'Rp').'</a>';
           
      array_push($data, array(
        $no,
        $noBeli,
        $row->namaSupplier,
        $row->tanggal,
        $row->tanggalDone,
        $row->nama,
        FormatKurs($row->total,0,'Rp'),
        $terbayar,
        FormatKurs($row->kurang,0,'Rp'),
        $btn,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadDetailBayarBeli()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['idBayarBeli', 'nama', 'tanggalBayar', 'nominal'];
    $order = $list[$orderid];
    $noBeli = $this->input->post('noBeli');
    
    $query = "SELECT b.idBayarBeli, b.nominal, b.tanggalBayar, u.nama, CONCAT(b.nominal,' ',b.tanggalBayar,' ',u.nama,' ') as cari FROM bayarbeli b LEFT JOIN user u ON u.username = b.user WHERE b.noBeli = '$noBeli'";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {                 
      array_push($data, array(
        $no,
        $row->nama,
        $row->tanggalBayar,
        FormatKurs($row->nominal,0,'Rp'),
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  public function LoadDetailBarangBeli()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['idPembelian', 'kodeBarang', 'namaBarang', 'jumlahAsli','satuanAsli','hargaAsli','hargaAsli'];
    $order = $list[$orderid];
    $noBeli = $this->input->post('noBeli');
    
    $query = "SELECT d.*, CONCAT(jumlahAsli,' ',jumlahEcer,' ',hargaAsli,' ',hargaEcer,' ',hargaView,' ',satuanAsli,' ',kodeBarang,' ',namaBarang,' ') as cari FROM 
    (SELECT be.done, p.idPembelian, p.jumlahAsli, p.jumlahEcer, p.hargaAsli, p.hargaEcer, p.hargaView, p.satuanAsli, p.kodeBarang, p.bonus, p.diskon, b.namaBarang FROM pembelian p INNER JOIN beli be ON be.noBeli = p.noBeli INNER JOIN barang b ON p.kodeBarang = b.kodeBarang WHERE p.noBeli = '$noBeli' ) d";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {         
      $harga = ($row->hargaView == $row->hargaAsli) ? FormatKurs($row->hargaAsli,0,'Rp') : 'Rp <strike>'.FormatKurs($row->hargaView,0,'').'</strike> '.FormatKurs($row->hargaAsli,0,'');
      $total = ($row->hargaView == $row->hargaAsli) ? FormatKurs(($row->hargaAsli * $row->jumlahAsli),0,'Rp') : 'Rp <strike>'.FormatKurs(($row->hargaView * $row->jumlahAsli),0,'').'</strike> '.FormatKurs(($row->hargaAsli * $row->jumlahAsli),0,'');  
      array_push($data, array(
        $no,
        $row->kodeBarang,
        $row->namaBarang,
        $row->jumlahAsli,
        $row->satuanAsli,
        $harga,
        $total,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }  
  public function LoadSelesaiBeli()
  {
    $draw = intval($_POST['draw']);  
    $orderid = $_POST['order'][0]['column'];
    $list = ['ln(noBeli)', 'noBeli', 'namaSupplier', 'tanggal', 'tanggalDone', 'tanggalBayar', 'nama', 'total'];
    $order = $list[$orderid];
    
    $query = "SELECT *, CONCAT(noBeli,' ',tanggal,' ',tanggalDone,' ',tanggalBayar, ' ',nama,' ',total,' ',terbayar,' ',kurang,' ', namaSupplier, ' ') as cari FROM 
    (SELECT b.noBeli, b.tanggal, b.tanggalDone, b.total, b.terbayar, b.kurang, u.nama, p.namaSupplier, bb.tanggalBayar  FROM beli b LEFT JOIN user u ON u.idUser = b.idUser LEFT JOIN supplier p ON p.kodeSupplier = b.kodeSupplier LEFT JOIN (SELECT max(tanggalBayar) tanggalBayar, noBeli FROM bayarbeli GROUP BY noBeli) bb ON bb.noBeli = b.noBeli WHERE b.done = 1 AND kurang = 0) d ";
    $hasil = $this->CreatQueryMysql($query, $order);

    $data = array();
    $no = 1;    
    foreach ($hasil['data'] as $row) {      
      $noBeli = '<a title="Detail Barang" href="#" onclick="detail(\''.$row->noBeli.'\',\'barang\');">'.$row->noBeli.'</a>';
      $total = '<a title="Detail Bayar" href="#" onclick="detail(\''.$row->noBeli.'\',\'bayar\');">'.FormatKurs($row->total,0,'Rp').'</a>';
           
      array_push($data, array(
        $no,
        $noBeli,
        $row->namaSupplier,
        $row->tanggal,
        $row->tanggalDone,
        $row->tanggalBayar,
        $row->nama,
        $total,
      ));
      $no++;
    }

   $output = array(
      "draw" => $draw ,
      "recordsTotal" => $hasil['recordsTotal'], 
      "recordsFiltered" => $hasil['recordsFiltered'], 
      "data" => $data,
    );
    echo json_encode($output); 
  }
  




  ####################Menu###############
  public function loadMenu()
  {
    $aksesnya = $this->session->userdata('aksesnya');
    $mn = $this->db->query("SELECT * FROM menu ORDER BY urutan")->result();
    $tb = '<table class="table table-bordered table-striped" width="100%">
    <thead>
      <tr>
        <th>No Urut</th>
        <th colspan="2">Menu</th>
        <th colspan="2">Icon</th>
        <th colspan="2">Link</th>
      </tr>
    </thead>
    <tbody>
    ';

    foreach ($mn as $row) {
      $bno = ($aksesnya == 'VE') ? '<button class="btn btn-xs btn-primary" title="Rubah Urutan Menu" onclick="urutan(\''.$row->idMenu.'\');"><i class="fas fa-sort-numeric-down"></i></button> 
      <button class="btn btn-xs btn-success" title="Edit Menu" onclick="modal(\''.$row->idMenu.'\');"><i class="fas fa-pencil-alt"></i></button> 
      <button class="btn btn-xs btn-danger"  title="Hapus Menu" onclick="hapus(\''.$row->idMenu.'\');"><i class="fas fa-trash-alt"></i></button>' : '';
      $tb .= '<tr><td>'.$row->urutan.' '.$bno.'</td>';
      $bmn = ($aksesnya == 'VE') ? '<button class="btn btn-xs btn-primary" title="Tambah Menus" onclick="modals(\''.$row->idMenu.'\',\'\');"><i class="fas fa-folder-plus"></i></button>' : '';
      $tb .= '<td colspan="2">'.$row->namaMenu.' '.$bmn.'</td>';
      $tb .= '<td><i class="nav-icon '.$row->menuIcon.'"></i></td>';
      $tb .= '<td></td>';
      $tb .= '<td></td></tr>';
      $ls = $this->db->query("SELECT * FROM menus WHERE idMenu = '".$row->idMenu."' ORDER BY urutans")->result();
      foreach ($ls as $rowls) {
        $tb .= '<tr><td>-</td>';
        $tb .= '<td></td>';
        $bmc = ($aksesnya == 'VE') ? '<button class="btn btn-xs btn-primary" title="Rubah Urutan Menus" onclick="urutans(\''.$row->idMenu.'\',\''.$rowls->idMenus.'\');"><i class="fas fa-sort-numeric-down"></i></button>
        <button class="btn btn-xs btn-success"  title="Edit Menus" onclick="modals(\''.$row->idMenu.'\',\''.$rowls->idMenus.'\');"><i class="fas fa-pencil-alt"></i></button> 
        <button class="btn btn-xs btn-danger"  title="Hapus Menus" onclick="hapuss(\''.$rowls->idMenus.'\');"><i class="fas fa-trash-alt"></i></button>' : '';
        $tb .= '<td>'.$rowls->namaMenus.' '.$bmc.'</td>';
        $tb .= '<td></td>';
        $tb .= '<td><i class="nav-icon '.$rowls->menusIcon.'"></i></td>';
        $tb .= '<td>'.$rowls->link.'</td></tr>';
      }
    }
    $tb .= '</tbody></table>';
    $output = array('data' => $tb);
    echo json_encode($output);
  }
  public function ListMenuUser()
  {
    $aksesnya = $this->session->userdata('aksesnya');
    $username = $this->input->post("username");
    if(empty($username)){
      $tb = '';
    }else{
      $dis = ($aksesnya == 'VE') ? '' : 'disabled';
      $mn = $this->db->query("SELECT * FROM menu ORDER BY urutan")->result();
      $tb = '<table class="table table-bordered table-striped" width="100%">
      <thead>
        <tr>
          <th>Menu</th>
          <th>Pilih</th>
          <th>Akses</th>
        </tr>
      </thead>
      <tbody>
      ';
      // &emsp;
      foreach ($mn as $row) {
        $aksesUser = $this->db->query("SELECT menus, akses, m.idMenu FROM
        (SELECT COUNT(idMenus) menus, idMenu  FROM menus GROUP BY idMenu) m LEFT JOIN 
        (SELECT COUNT(a.idMenus) akses, men.idMenu, a.username FROM akses a LEFT JOIN menus men ON men.idMenus = a.idMenus WHERE username = '$username' GROUP BY men.idMenu, a.username) d ON m.idMenu = d.idMenu WHERE m.idMenu = '$row->idMenu'")->row_array();
        $sid = ($dis == 'disabled' || ($aksesUser['menus'] == $aksesUser['akses'])) ? 'disabled' : '';
        $cid = (($aksesUser['menus'] == $aksesUser['akses'])) ? 1 : 0;
        $ck = $this->ck('M-'.$row->idMenu, $cid , $row->idMenu,$sid);
        $tb .= '<tr><td>'.$row->namaMenu.'</td><td>'.$ck.'</td><td></td></tr>';
        $ls = $this->db->query("SELECT a.idMenus, a.namaMenus, b.akses FROM (SELECT * FROM menus WHERE idMenu = '".$row->idMenu."') a LEFT JOIN (SELECT akses, idMenus FROM akses WHERE username = '".$username."') b ON a.idMenus = b.idMenus ORDER BY a.urutans")->result();
        
        foreach ($ls as $rowls) {
          $cl = (is_null($rowls->akses)) ? 0 : 1;
          $ck = $this->ck('C-'.$rowls->idMenus, $cl, $rowls->idMenus,$dis);
          $aktif = (is_null($rowls->akses)) ? "disabled" : "";
          $op1 = ($rowls->akses == '1') ? "selected" : "";
          $op2 = ($rowls->akses == '10') ? "selected" : "";
          $tb .= '<tr><td>&emsp;- '.$rowls->namaMenus.'</td><td>'.$ck.'</td><td>
          <select name="akses'.$rowls->idMenus.'" id="akses'.$rowls->idMenus.'" class="form-control" '.$aktif.' '.$dis.' onchange="PilihAkses(\''.$rowls->idMenus.'\')">
          <option value="1" '.$op1.'>View</option>
          <option value="10" '.$op2.'>View/Write</option>
        </select></td></tr>';
        }
      }
      $tb .= '</tbody></table>';
    }
    $output = array('data' => $tb);
    echo json_encode($output);
  }
  public function ck($id, $ck, $val, $dis)
  {
    $che = ($ck == 1) ? "checked" : "";
    return '<div class="icheck-primary d-inline"><input type="checkbox" style="opacity: 1;" id="'.$id.'" '.$che.' value="'.$val.'" onchange="PilihMenu(\''.$id.'\')" '.$dis.'></div>';
  }

}

?>