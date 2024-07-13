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
          <h3 class="card-title">Data Pembelian Selesai</h3> &nbsp;
        </div>
        <div class="card-body">
          <table id="tbSelesai" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Supplier</th>
                <th>Tanggal Buat</th>
                <th>Tanggal Simpan</th>
                <th>Pembayaran Terakhir</th>
                <th>Admin</th>
                <th>Total</th>
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
    LoadSelesaiBeli()
    $("body").attr('class', 'sidebar-mini layout-fixed sidebar-collapse');
  });
  function LoadSelesaiBeli() {
    var kurang = $('#tbSelesai').DataTable();
    kurang.destroy();
    $('#tbSelesai').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadSelesaiBeli") ?>",
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
</script>