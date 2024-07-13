<div class="modal fade" id="mdMember">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Member</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
              <label>Kode Member :</label><span><button class="btn btn-xs btn-primary" onclick="GetKodeMember();">Generate</button></span>
              <input type="text" class="form-control" name="idMember" id="idMember" required readonly>
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group">
              <label>Nama Member :</label>
              <input type="text" class="form-control" name="namaMember" id="namaMember" required>
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group">
              <label>No Hp Member :</label>
              <input type="text" class="form-control" name="noHp" id="noHp" required onKeyPress="return goodchars(event,'1234567890.',this)">
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group">
              <label>Alamat Member :</label>
              <textarea rows="4" cols="3" class="form-control" name="alamat" id="alamat"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveMember();">Save changes</button>
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
          <h3 class="card-title">Member</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="modal('');"><i class="fas fa-plus-square"></i> Tambah</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <table id="tbMember" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Member</th>
                <th>Nama Member</th>
                <th>No Hp Member</th>
                <th>Alamat</th>
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
    loadMember();
  });
  function GetKodeMember() {
    $.ajax({
      url: "<?php echo site_url("Data/GetKodeMember") ?>",
      type: 'POST',
      data: {
        idMember : $('#idMember').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        if(response.stat == 'sudah'){
          alert('Sudah tersedia Kode Member!!!');
        }else{
          $('#idMember').val(response.idMember);
        }
        loadMember();
      }
    });
  }
  function modal(idMember) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataMember") ?>",
      type: 'POST',
      data: {
        idMember: idMember
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#idMember').val(response.idMember);
        $('#namaMember').val(response.namaMember);
        $('#noHp').val(response.noHp);
        $('#alamat').val(response.alamat);
        $('#mdMember').modal('show');
      }
    });
  }

  function loadMember() {
    var Member = $('#tbMember').DataTable();
    Member.destroy();
    $('#tbMember').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadMember") ?>",
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
    Member.draw();
  }

  function SaveMember() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveMember") ?>",
      type: 'POST',
      data: {
        idMember: $('#idMember').val(),
        namaMember: $('#namaMember').val(),
        noHp: $('#noHp').val(),
        alamat: $('#alamat').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdMember').modal('hide');
        loadMember();
      }
    });
  }
  function hapus(idMember) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelMember") ?>",
        type: 'POST',
        data: {
          idMember: idMember
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadMember();
        }
      });
    }
  }
</script>