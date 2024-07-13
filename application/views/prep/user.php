<div class="modal fade" id="mdUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <input type="hidden" name="husername" id="husername">
            <div class="form-group">
              <label>UserName :</label><small><span id="notif"></span></small>
              <input type="text" class="form-control" name="username" id="username" required onkeyup="validasiUser()">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Nama User :</label>
              <input type="text" class="form-control" name="nama" id="nama" required>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Perubahan Harga :</label>
              <select name="additional" id="additional" class="form-control">
                <option value="TIDAK">TIDAK</option>
                <option value="YA">YA</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveUser();" id="save">Save changes</button>
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
          <h3 class="card-title">User</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="modal('');"><i class="fas fa-plus-square"></i> Tambah</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <table id="tbUser" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>UserName</th>
                <th>Nama User</th>
                <th>Perubahan Harga</th>
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
    loadUser();
    
  });

  function modal(username) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataUser") ?>",
      type: 'POST',
      data: {
        username: username
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        if(response.username == ''){
          $('#username').prop('readonly', false);
        }else {
          $('#username').prop('readonly', true);
        }
        $('#username').val(response.username);
        $('#husername').val(response.username);
        $('#nama').val(response.nama);
        $('#additional').val(response.additional);
        $('#mdUser').modal('show');
      }
    });
  }

  function loadUser() {
    var User = $('#tbUser').DataTable();
    User.destroy();
    $('#tbUser').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadUser") ?>",
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
    User.draw();
  }

  function SaveUser() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveUser") ?>",
      type: 'POST',
      data: {
        husername: $('#husername').val(),
        username: $('#username').val(),
        nama: $('#nama').val(),
        additional: $('#additional').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdUser').modal('hide');
        loadUser();
      }
    });
  }
  function reset(username) {
    if (confirm('Apakah Anda yakin ingin reset Password User ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/ResetUser") ?>",
        type: 'POST',
        data: {
          username: username
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadUser();
        }
      });
    }
  }
  function hapus(username) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelUser") ?>",
        type: 'POST',
        data: {
          username: username
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadUser();
        }
      });
    }
  }
  function validasiUser() {
    $.ajax({
      url: "<?php echo site_url("Data/CheckUser") ?>",
      type: 'POST',
      data: {
        husername: $('#husername').val(),
        username: $('#username').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        if(response.hasil === 'boleh'){
          $('#save').attr('disabled', false);
          $('#notif').css({'color': 'green', 'font-size': '8pt' })
          $('#notif').html("User Bisa Dipakai!!!")
        }else{
          $('#notif').css({'color': 'red', 'font-size': '8pt' })
          $('#notif').html("User Tidak Bisa Dipakai!!!")
          $('#save').attr('disabled', true);
        }
      }
    });   
  }
</script>