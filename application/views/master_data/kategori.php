<div class="modal fade" id="mdKategori">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Kategori</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-7">
            <input type="hidden" name="idKategori" id="idKategori">
            <div class="form-group">
              <label>Nama Kategori :</label>
              <input type="text" class="form-control" name="namaKategori" id="namaKategori" required>
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group">
              <label>Kode Kategori :</label>
              <input type="text" class="form-control" name="kode" id="kode" required onkeyup="this.value = this.value.toUpperCase();">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveKategori();">Save changes</button>
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
          <h3 class="card-title">Kategori</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="modal('');"><i class="fas fa-plus-square"></i> Tambah</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <table id="tbKategori" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Kode Kategori</th>
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
    loadKategori();
  });

  function modal(idKategori) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataKategori") ?>",
      type: 'POST',
      data: {
        idKategori: idKategori
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#idKategori').val(response.idKategori);
        $('#namaKategori').val(response.namaKategori);
        $('#kode').val(response.kode);
        $('#mdKategori').modal('show');
      }
    });
  }

  function loadKategori() {
    var Kategori = $('#tbKategori').DataTable();
    Kategori.destroy();
    $('#tbKategori').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadKategori") ?>",
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
    Kategori.draw();
  }

  function SaveKategori() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveKategori") ?>",
      type: 'POST',
      data: {
        idKategori: $('#idKategori').val(),
        namaKategori: $('#namaKategori').val(),
        kode: $('#kode').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdKategori').modal('hide');
        loadKategori();
      }
    });
  }
  function hapus(idKategori) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelKategori") ?>",
        type: 'POST',
        data: {
          idKategori: idKategori
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadKategori();
        }
      });
    }
  }
</script>