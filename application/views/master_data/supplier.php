<div class="modal fade" id="mdSupplier">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Supplier</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">              
            <input type="hidden" name="kodeSupplierH" id="kodeSupplierH">
              <label>Kode Supplier :</label>  <span id="chekSupplier"></span>
              <input type="text" class="form-control" name="kodeSupplier" id="kodeSupplier" required onKeyUp="chekSupplier()" onKeyPress="return goodchars(event,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',this)" style="text-transform:uppercase">
            </div>
          </div>
          <div class="col-sm-8">
            <div class="form-group">
              <label>Nama Supplier :</label>
              <input type="text" class="form-control" name="namaSupplier" id="namaSupplier" required>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label>No Telp Supplier :</label>
              <input type="text" class="form-control" name="noTelpSupplier" id="noTelpSupplier" required>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label>Jenis Supplier :</label>
              <input type="text" class="form-control" name="jenisSupplier" id="jenisSupplier" required>
            </div>
          </div>          
          <div class="col-sm-4">
            <div class="form-group">
              <label>Email Supplier :</label>
              <input type="text" class="form-control" name="emailSupplier" id="emailSupplier" required>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Alamat Supplier :</label><br>
              <textarea rows="3" style="width:100%;" class="form-control" name="alamatSupplier" id="alamatSupplier"></textarea>
              <!-- <input type="text" class="form-control" name="alamatSupplier" id="alamatSupplier" required> -->
            </div>
          </div>          
          <div class="col-sm-6">
            <div class="form-group">
              <label>Keterangan :</label><br>
              <textarea rows="3" style="width:100%;" class="form-control" name="keterangan" id="keterangan"></textarea>
              <!-- <input type="text" class="form-control" name="keterangan" id="keterangan" required> -->
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveSupplier();">Save changes</button>
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
          <h3 class="card-title">Supplier</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="modal('');"><i class="fas fa-plus-square"></i> Tambah</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <table id="tbSupplier" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>Jenis Supplier</th>
                <th>No Telp</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Keterangan</th>
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
  $(document).ready(function() {
    loadSupplier();
  });

  function modal(kodeSupplier) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataSupplier") ?>",
      type: 'POST',
      data: {
        kodeSupplier: kodeSupplier
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#kodeSupplier').val(response.kodeSupplier);
        $('#kodeSupplierH').val(response.kodeSupplier);
        $('#namaSupplier').val(response.namaSupplier);
        $('#noTelpSupplier').val(response.noTelpSupplier);
        $('#jenisSupplier').val(response.jenisSupplier);
        $('#emailSupplier').val(response.emailSupplier);
        $('#alamatSupplier').val(response.alamatSupplier);
        $('#keterangan').val(response.keterangan);
        $('#mdSupplier').modal('show');
      }
    });
  }

  function loadSupplier() {
    var Supplier = $('#tbSupplier').DataTable();
    Supplier.destroy();
    $('#tbSupplier').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadSupplier") ?>",
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
    Supplier.draw();
  }
  function chekSupplier() {
    $.ajax({
      url: "<?php echo site_url("Data/chekSupplier") ?>",
      type: 'POST',
      data: {
        kodeSupplier : $('#kodeSupplier').val(),
        kodeSupplierH : $('#kodeSupplierH').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        if(response.stat == 'sudah'){
          $('#chekSupplier').css({ 'color': 'red', 'font-size': '10pt' });
          $('#chekSupplier').html('Ditolak!');
        }else{
          $('#chekSupplier').css({ 'color': 'green', 'font-size': '10pt' });
          $('#chekSupplier').html('Diterima!');
        }        
      }
    });
  }

  function SaveSupplier() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveSupplier") ?>",
      type: 'POST',
      data: {
        kodeSupplierH: $('#kodeSupplierH').val(),
        kodeSupplier: $('#kodeSupplier').val(),
        namaSupplier: $('#namaSupplier').val(),
        noTelpSupplier: $('#noTelpSupplier').val(),
        jenisSupplier: $('#jenisSupplier').val(),
        emailSupplier: $('#emailSupplier').val(),
        alamatSupplier: $('#alamatSupplier').val(),
        keterangan: $('#keterangan').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdSupplier').modal('hide');
        loadSupplier();
      }
    });
  }
  function hapus(kodeSupper) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelSupplier") ?>",
        type: 'POST',
        data: {
          kodeSupper: kodeSupper
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadSupplier();
        }
      });
    }
  }
</script>