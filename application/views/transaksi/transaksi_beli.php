<style>
    .container1 {
      width: 100%;
      margin: 5px auto;
      padding: 0px;
      display: grid;
      /* border: 2px solid #333; */
      grid-template-areas: 
        "info supplier supplier jumlah jumlah"
        "tabel tabel tabel tabel tabel"
        "keterangan keterangan pembayaran pembayaran user";

      grid-template-columns: 0.8fr 0.3fr 0.9fr 0.5fr 0.5fr;
      grid-template-rows: 0.25fr 0.5fr 0.25fr;
    }
    .info {
      grid-area: info;
      margin-right : 10px;
      padding :10px;
    }
    .supplier {
      grid-area: supplier;
      margin-right : 10px;
      padding :10px;
    }

    .user {
      grid-area: user;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right : 10px;
      padding :10px;
      border: 4px solid #94d1ca;
    }

    .tabel {
      grid-area: tabel;
      display: flex;
      flex-wrap: wrap;
      padding :10px;
      margin-right : 10px;
    }

    .keterangan {
      grid-area: keterangan;
      padding :10px;
      margin-right : 10px;
    }
    .pembayaran {
      grid-area: pembayaran;
      padding :10px;
      margin-right : 10px;
    }
    .jumlah {
      grid-area: jumlah;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right : 10px;
      /* padding :10px; */
      border: 4px solid #94d1ca;
    }
    .card{
      margin-bottom: 0.5rem
    }
    .f-sm{
      height:20px;
      padding-left : 5px;
    }
  </style>
  <div class="modal fade" id="mdBarang">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
        <div class="row">
          <div class="col-sm-12">
            <table id="tbBarang" class="table table-bordered table-hover dataTable dtr-inline" width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kategeori</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>QTY</th>
                  <th>Satuan</th>
                  <th>Harga</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>            
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="content-wrapper">
  <div style="padding:2px">
    <div class="container-fluid">
      
    </div>
  </div>
  <section class="content">
    <div class="container1">
              <div class="info card card-default color-palette-box">
                <table width="100%">
                <?php 
                    echo $this->mdata->BuatTr('input', 'No Beli', $noBeli,'','disabled');
                    echo $this->mdata->BuatTr('input', 'Tanggal', $tanggal,'2','disabled');
                    echo $this->mdata->BuatTr('input', 'Jam', $jam,'','disabled');
                  ?>  
                </table>
              </div>
              <div class="supplier card card-default color-palette-box">
                <table width="100%">
                  <?php 
                    echo $this->mdata->BuatTr('input', 'Nama Supplier', $namaSupplier,'','disabled');
                    echo $this->mdata->BuatTr('textarea', 'Alamat', $alamatSupplier,'','disabled');
                    echo $this->mdata->BuatTr('input', 'No Telp', $noTelpSupplier,'','disabled');
                  ?>                
                </table>
              </div>
              <div class="user bg-info card card-default color-palette-box">
                <div class="widget-user-header">
                  <h5><center>User</center></h5>
                  <h4 class="widget-user-username"><?php echo $nama;?></h4>
                </div>
                
              </div>
              <div class="tabel card card-default color-palette-box">
                <div class="row">
                  <div class="col-sm-6">
                    <form action="#" id="form">
                      <input type="text" name="kodeBarang" id="kodeBarang" class="form-control" placeholder="Barang . . ." onkeyup="this.value = this.value.toUpperCase();" autofocus>
                    </form>
                  </div>
                  
                  <div class="col-sm-1">
                    <select name="tipeSatuan" id="tipeSatuan"class="form-control">
                      <option value="Paket">Paket</option>
                      <option value="Ecer">Ecer</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class=" btn-primary btn" onclick="listBarang();"><i class="fas fa-search"></i></button>
                  </div>
                  <div class="col-sm-12 mt-2">
                    <table class="table table-sm" id="tbBeli" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Qty</th>
                          <th>Unit</th>
                          <th>Qty Ecer</th>
                          <th>Harga</th>
                          <th>Total</th>
                          <th>Diskon <small>%</small></th>
                          <th>Action</th>                        
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>                
              </div>
              <div class="keterangan card card-default color-palette-box">
                <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                  <textarea style ="resize: none; width:100%;" class="form-control" placeholder="Keterangan Pembelian. . ."></textarea>
                </div>
              </div>
              <div class="jumlah card card-default color-palette-box">
                <div class="card-body">
                  <input type="hidden" id="total" name="total">
                  <h1><span id="jumlahBeli"></span></h1>
                </div>
                <div class="card-footer" style="padding:0px;background-color:white">
                  <small><span id="terbilangBeli"></span></small>
                </div>
                <!-- <h1>Jumlah</h1> -->
                <!-- <small>Terbilang</small> -->
              </div>
              <div class="pembayaran card card-default color-palette-box">
                <div class="form-group row">
                  <div class="col-sm-3">
                    <label for="terbayar">Terbayar <small>(Rp)</small></label>
                    <input type="text" class="form-control" id="terbayar" readonly>
                  </div>
                  <div class="col-sm-3">
                    <label for="bayar">Cash</label>
                    <input type="text" class="form-control uang" name="bayar" id="bayar" required onKeyPress="return goodchars(event,'1234567890.',this)" placeholder="pembayaran">
                  </div>
                  <div class="col-sm-3">
                    <label for="potongan">Potongan <small>(Rp)</small></label>
                    <input type="text" class="form-control" id="potongan" readonly>
                  </div>
                  <div class="col-sm-3">
                  <input type="hidden" id="Tkurang" name="Tkurang">
                    <label for="kurang">Kurang <small>(Rp)</small></label>
                    <input type="text" class="form-control" id="kurang" readonly>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-sm-6">
                    <button type="button" class="btn btn-block bg-gradient-success form-control" onclick="klik();"><i class="fas fa-save"></i> Simpan</button>
                  </div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm-5">
                    <button type="button" class="btn btn-block bg-gradient-warning form-control" onclick="pending('<?php echo $noBeli;?>');"><i class="fas fa-pause-circle"></i> Pending</button>
                  </div>
                </div>
              </div>
            </div>
    </section>
</div>

<script>
$(document).ready(function(){  
  $("body").attr('class', 'sidebar-mini layout-fixed sidebar-collapse');
  setTimeout(loadBeliBarang, 200);
});
$("#mdBarang").on('hide.bs.modal', function(){
  $("#kodeBarang").val('');
  $('#kodeBarang').focus();
});
  function klik() {
    if(($('#bayar').val() > $('#total').val()) || ($('#bayar').val() > $('#Tkurang').val())){      
      alert('Pembayaran Melebihi Total / Kekurangan Bayar');
      $('#bayar').val($('#total').val());
    } else if($('#total').val() == 0 || $('#bayar').val() == 0){
      if (confirm('Total pembelian atau total bayar nasih 0 mau lanjut?')) {
        done();
      }      
    }else{
      if (confirm('Apakah Anda yakin ingin selesaikan pembelian ini?')) {
        done();
      }
    }
    // $('#kodeBarang').focus();
    // loadBeliBarang();
  }
  function listBarang() {
    var Barang = $('#tbBarang').DataTable();
    Barang.destroy();
    $('#tbBarang').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadListBarang") ?>",
        type: 'POST',
        data: {tipeSatuan:$('#tipeSatuan').val()},
      },
      "aLengthMenu": [
        [50, 75, 100, -1],
        [50, 75, 100, "All"]
      ],
      "iDisplayLength": 50,
      "serverSide": true,
      initComplete: function() {},
    });
    Barang.draw();
    $('#mdBarang').modal('show');    
  }
  // click on row tabel
  $('#tbBarang tbody').on('click', 'tr', function() {
    var table = $('#tbBarang').DataTable();
    // console.log(table.row(this).data());
    addBarang(table.row(this).data()[2],table.row(this).data()[7]);
  })
  function pending(noBeli) {
    if (confirm('Apakah Anda yakin ingin Pending data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudTransaksi/Pending") ?>",
        type: 'POST',
        data: {
          no: noBeli,
          untuk: 'beli',
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 1000);
          location.reload();
        }
      });
    }
  }

  $("#form").on("submit", function (e) {
    e.preventDefault();
    var kodeBarang = $("#kodeBarang").val();
    var satuan = $("#tipeSatuan").val();
    addBarang(kodeBarang, satuan);
  });
  function addBarang(kodeBarang, satuan) {
    $.ajax({
      url: "<?php echo site_url("CrudTransaksi/AddBarang") ?>",
      type: 'POST',
      data: {
        noBeli: '<?= $noBeli;?>',
        kodeBarang: kodeBarang,
        satuan: satuan,
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $("#kodeBarang").val('');
        $('#kodeBarang').focus();
        notif(response.hasil, response.proses, 1000);
        $('#mdBarang').modal('hide');  
        // location.reload();
        loadBeliBarang()
      }
    });
  }
  function loadBeliBarang() {
    var Barang = $('#tbBeli').DataTable();
    Barang.destroy();
    $('#tbBeli').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadBeliBarang") ?>",
        type: 'POST',
        data: {noBeli: '<?= $noBeli;?>',},
      },
      "bAutoWidth": false, 
      "aoColumns" : [
        { sWidth: '2%' },
        { sWidth: '18%' },
        { sWidth: '24%' },
        { sWidth: '5%' },
        { sWidth: '5%' },
        { sWidth: '5%' },
        { sWidth: '15%' },
        { sWidth: '15%' },
        { sWidth: '6%' },
        { sWidth: '5%' }
      ],
      "ordering": false,
      "bLengthChange" : false,
      "paging": false,
      "scrollCollapse": false,
      "scrollY": "30vh",
      // "iDisplayLength": -1,
      "searching": false,
      "info": false,
      "serverSide": true,
      initComplete: function() {},
    });
    Barang.draw();
    totalBeli();
  }
  function totalBeli() {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataBeliBarang") ?>",
      type: 'POST',
      data: {
        noBeli: '<?= $noBeli;?>',
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) { 
        $('#total').val(response.totalBeli); 
        $('#kurang').val(response.kurang);
        $('#Tkurang').val(response.Tkurang);
        $('#jumlahBeli').html(response.totalAsli); 
        $('#terbilangBeli').html(response.terbilang); 
        $('#potongan').val(response.potongan);        
      }
    });
  }
  
// 

function updateQty(nilai, id) {
  if(event.key === 'Enter') {
    if(nilai.value > 0){
      $.ajax({
        url: "<?php echo site_url("CrudTransaksi/UpdateQtyBarang") ?>",
        type: 'POST',
        data: {
          idPembelian: id,
          qty: nilai.value,
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          $("#kodeBarang").val('');
          $('#kodeBarang').focus();
          notif(response.hasil, response.proses, 1000);
          $('#mdBarang').modal('hide');  
          // location.reload();
          loadBeliBarang()
        }
      });
    }else{
      alert('Isi dengan angka diatas 0!!!');
    }
    // alert(id);
    // nilai.value UpdateQtyBarang
  }
}
function updateDiskon(nilai, id) {
  if(event.key === 'Enter') {
    if(nilai.value <= 100 && nilai.value >= 0){
      $.ajax({
        url: "<?php echo site_url("CrudTransaksi/UpdateDiskonBarang") ?>",
        type: 'POST',
        data: {
          idPembelian: id,
          diskon: nilai.value,
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          $("#kodeBarang").val('');
          $('#kodeBarang').focus();
          notif(response.hasil, response.proses, 1000);
          $('#mdBarang').modal('hide');  
          // location.reload();
          loadBeliBarang()
        }
      });
    }else{
      alert('Isi dengan angka antar 0 - 100!!!');
    }
  }
    // alert(id);
    // nilai.value UpdateQtyBarang
}
function hapus(idPembelian) {
  if (confirm('Apakah Anda yakin ingin barang pembelian ini?')) {
    $.ajax({
      url: "<?php echo site_url("CrudTransaksi/DelPembelian") ?>",
      type: 'POST',
      data: {
        idPembelian: idPembelian
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 1000);
        loadBeliBarang();
      }
    });
  }
}
function done() {  
  $.ajax({
    url: "<?php echo site_url("CrudTransaksi/DonePembelian") ?>",
    type: 'POST',
    data: {
      noBeli: '<?= $noBeli;?>',
      total : $('#total').val(),
      bayar : $('#bayar').val(),
    },
    dataType: "json",
    beforeSend: function(e) {
      if (e && e.overrideMimeType) {
        e.overrideMimeType("application/json;charset=UTF-8");
      }
    },
    success: function(response) {
      notif(response.hasil, response.proses, 2000);
      location.reload();
    }
  });
}  
</script>