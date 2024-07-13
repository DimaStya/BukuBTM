<div class="modal fade" id="mdBayarBeli">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Detail Pembayaran <u><b><span id="Nobeli"></span></b></u></h4> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tbDetailBayar" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Dibayar</th>
              <th>Tanggal Bayar</th>
              <th>Nominal</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdDetailBarang">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Detail Barang <u><b><span id="NobeliBr"></span></b></u></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tbDetailBarang" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>QTY</th>
              <th>Satuan</th>
              <th>Harga</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdBayar">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Lakukan Pembayaran <u><b><span id="NobeliBayar"></span></b></u></h4> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" methode="POST" id="form">
        <div class="modal-body">
          <div class="row">
            <input type="hidden" name="noBeli" id="noBeli">
            <div class="col-sm-12">
              <div class="form-group" style="margin-bottom:0 px;">
                <label>Nominal Bayar :</label>
                <input type="text" class="form-control uang" name="nominal" id="nominal"   onKeyPress="return goodchars(event,'1234567890',this)" placeholder="Pembayaran" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <!-- <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div>
        </div> -->
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="card card-default color-palette-box">
        <div class="card-header">
          <h3 class="card-title">Data Pembelian Kurang Bayar</h3> &nbsp;
        </div>
        <div class="card-body">
          <table id="tbKurangBayar" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Supplier</th>
                <th>Tanggal Buat</th>
                <th>Tanggal Selesai</th>
                <th>Admin</th>
                <th>Total</th>
                <th>Terbayar</th>
                <th>Kekurangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  $(document).ready(function(){
    LoadBayarBeli()
    $("body").attr('class', 'sidebar-mini layout-fixed sidebar-collapse');
  });
  function LoadBayarBeli() {
    var kurang = $('#tbKurangBayar').DataTable();
    kurang.destroy();
    $('#tbKurangBayar').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadBayarBeli") ?>",
        type: 'POST',
        data: {},
      },
      "aLengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      "iDisplayLength": 25,
      "serverSide": true,
      initComplete: function() {},
    });
    kurang.draw();
  }
  function detail(noBeli, untuk) {
    if(untuk == 'barang'){
      $('#mdDetailBarang').modal('show');
      $('#NobeliBr').html(noBeli);
      LoadDetailBarangBeli(noBeli);
    }else if(untuk == 'bayar'){
      $('#mdBayarBeli').modal('show');
      $('#Nobeli').html(noBeli);
      LoadDetailBayarBeli(noBeli);
    }    
  }
  
  function LoadDetailBarangBeli(noBeli) {
    var detail = $('#tbDetailBarang').DataTable();
    detail.destroy();
    $('#tbDetailBarang').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadDetailBarangBeli") ?>",
        type: 'POST',
        data: {noBeli : noBeli,},
      },
      "aLengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      "iDisplayLength": 25,
      "serverSide": true,
      initComplete: function() {},
    });
    detail.draw();
  }
  
  function LoadDetailBayarBeli(noBeli) {
    var detail = $('#tbDetailBayar').DataTable();
    detail.destroy();
    $('#tbDetailBayar').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadDetailBayarBeli") ?>",
        type: 'POST',
        data: {noBeli : noBeli,},
      },
      "aLengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      "iDisplayLength": 25,
      "serverSide": true,
      initComplete: function() {},
    });
    detail.draw();
  }
  
  function bayar(noBeli) {    
    $('#mdBayar').modal('show');
    $('#NobeliBayar').html(noBeli);
    $('#noBeli').val(noBeli);
    $('#nominal').val('');
    
  }
  $('#mdBayar').on('shown.bs.modal', function () {
    $('#nominal').focus();
  }) 
  $("#form").submit(function(e){
    e.preventDefault();
    $.ajax({
      url: "<?php echo site_url("CrudTransaksi/AddPembayaran") ?>",
      type: 'POST',
      data: {
        noBeli: $('#noBeli').val(),
        nominal: $('#nominal').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) { 
        if(response.hasil == 'error'){
          notif(response.hasil, response.proses, 2000);
          $('#nominal').val(response.nominal);
        }else{
          notif(response.hasil, response.proses, 2000);
          $('#mdBayar').modal('hide');
          LoadBayarBeli() 
        }
      }
    });
  });
  
</script>