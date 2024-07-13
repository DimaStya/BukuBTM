<div class="modal fade" id="mdBeli">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Tambah Pembelian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" methode="POST" id="form">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="kodeSupplier" >Supplier :</label>
                <select name="kodeSupplier" id="kodeSupplier"  class="form-control" style ="width:100%;" required></select>
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
<div class="modal fade" id="mdUbah">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Alihkan Transaksi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" methode="POST" id="formU">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" id="noBeli" name="noBeli">
                <label for="idUser" >User/Admin :</label>
                <select name="idUser" id="idUser"  class="form-control" style ="width:100%;" required></select>
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
          <h3 class="card-title">Data Pembelian Pending</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="newBeli();"><i class="fas fa-plus-square"></i> Tambah Pembelian</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <table id="tbPending" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Dari</th>
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
    LoadBeliPending()
    $("body").attr('class', 'sidebar-mini layout-fixed sidebar-collapse');
    document.addEventListener("keyup", (event) => {
      if (event.isComposing || event.keyCode === 78) {
        <?php
        if($this->session->userdata('aksesnya') == 'VE'){
          echo "newBeli();";
        }else{
          echo "alert('Kamu Tidak Memiliki Akses!!!');";
        }
        ?>
        
      }
  });
});
  $("#form").submit(function(e){
    e.preventDefault();
    $.ajax({
      url: "<?php echo site_url("CrudTransaksi/BuatPembelian") ?>",
      type: 'POST',
      data: {
        kodeSupplier: $('#kodeSupplier').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) { 
        notif(response.hasil, response.proses, 2000);
        setTimeout(location.reload(), 2500);
      }
    });
  });
function LoadBeliPending() {
    var Pending = $('#tbPending').DataTable();
    Pending.destroy();
    $('#tbPending').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadBeliPending") ?>",
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
    Pending.draw();
  }
  function newBeli() {
    // alert('Kamu Tidak Memiliki Akses!!!');
    $('#mdBeli').modal('show');
    loadSupplier();
  }
  function ProsesUlang(noBeli) {
    if (confirm('Apakah Anda yakin ingin melanjutkan data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudTransaksi/ProsesUlang") ?>",
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
          location.reload();
        }
      });
    }
  }
  function loadSupplier() {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListSupplier") ?>",
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#kodeSupplier').html(response.data).show();
        $('#kodeSupplier').select2({
          dropdownParent: $('#mdBeli')
      });
        
      }
    });
  }
  function ubahUser(noBeli) {
    $('#mdUbah').modal('show');
    $.ajax({
      url: "<?php echo site_url("Data/UbahUser") ?>",
      type: 'POST',
      data: {no : noBeli, untuk : 'beli'},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#noBeli').val(noBeli);
        $('#idUser').html(response.data).show();
        $('#idUser').select2({
          dropdownParent: $('#mdUbah')
      });
        
      }
    });
  }
  $("#formU").submit(function(e){
    e.preventDefault();
    $.ajax({
      url: "<?php echo site_url("CrudTransaksi/UbahUser") ?>",
      type: 'POST',
      data: {
        no : $('#noBeli').val(),
        idUser: $('#idUser').val(),
        untuk: 'beli',
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) { 
        notif(response.hasil, response.proses, 2000);
        $('#mdUbah').modal('hide');
        LoadBeliPending()
      }
    });
  });
  
  
</script>