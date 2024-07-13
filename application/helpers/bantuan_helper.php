<?php 
date_default_timezone_set("Asia/Jakarta");
function z_log($id_data , $menu , $kegiatan ,$name  ){
   $ci = get_instance();

   $log_array = array(
        'id_data' =>$id_data,
        'nama_table' => $menu,
        'old_data' => $kegiatan,
        'userId' => $name);
    $result = $ci ->db->insert('z_log', $log_array);
 }
function Buat($angka) {
 	$hasil = $angka / 4;
 	return $hasil;
 }
function ToDay(){
    return date('Y-m-d');
  }
function Tgl(){
    return date('Ymd');
  }
function Year(){
    return date('Y');
  }
function Month(){
    return date('m');
  }
function FormatTanggal($tanggal='') {
    if(empty($tanggal)){
      return '';
    }else{        
      $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',];
      $pecahkan = explode('-', $tanggal);
      return $pecahkan[2] . ' ' . $bulan[ ((int)$pecahkan[1]-1) ] . ' ' . $pecahkan[0];
    }
  }
function Days($tanggal='') {
    if(empty($tanggal)){
      return '';
    }else{         
      return date('l', strtotime($tanggal));
    }
  }
   function Day($tanggal='') {
    if(empty($tanggal)){
      return '';
    }else{         
      return date('D', strtotime($tanggal));
    }
  }
function Hari($tanggal='') {
    if(empty($tanggal)){
      return '';
    }else{
      $hari = $this->Day($tanggal);
      switch($hari){
        case 'Sun':
          $hari_ini = "Minggu";
        break;     
        case 'Mon':     
          $hari_ini = "Senin";
        break;     
        case 'Tue':
          $hari_ini = "Selasa";
        break;     
        case 'Wed':
          $hari_ini = "Rabu";
        break;     
        case 'Thu':
          $hari_ini = "Kamis";
        break;     
        case 'Fri':
          $hari_ini = "Jumat";
        break;     
        case 'Sat':
          $hari_ini = "Sabtu";
        break;        
        default:
          $hari_ini = "Tidak di ketahui";   
        break;
      }
    }   
  return $hari_ini;
  }
function FormatKurs($angka, $koma = '', $kurs = '') {
    if($koma == 1){
      return $kurs.' ' . number_format($angka,2,',','.');
    }else if($koma == 0){
      return $kurs.' ' . number_format($angka,0,',','.');
    }else{
      return ;
    }
  }
  function FormatKurs1($angka, $koma = '', $kurs = '') {
    if($koma == 1){
      return $kurs.' ' . number_format($angka,2,'.',',');
    }else if($koma == 0){
      return $kurs.' ' . number_format($angka,0,'.',',');
    }else{
      return ;
    }
  }
  function terbilang($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = terbilang($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = terbilang($nilai/10)." puluh". terbilang($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . terbilang($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = terbilang($nilai/100) . " ratus" . terbilang($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . terbilang($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = terbilang($nilai/1000) . " ribu" . terbilang($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = terbilang($nilai/1000000) . " juta" . terbilang($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = terbilang($nilai/1000000000) . " milyar" . terbilang(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = terbilang($nilai/1000000000000) . " trilyun" . terbilang(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
?>