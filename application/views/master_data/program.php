<style>
  .select2-container {
width: 100% !important;
padding: 0;
}
</style>
<div class="modal fade" id="mdProgram">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Program</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="idProgram" id="idProgram">
          <div class="col-sm-9">
            <div class="form-group">
              <label>Nama Program :</label>
              <input type="text" class="form-control" name="namaProgram" id="namaProgram" required>
            </div>
          </div>
          <div class="col-sm-4">
              <div class="form-group">
                <label>Kategori :</label>
                <select name="idKategori" id="idKategori"  class="form-control select2" style="witdh:100%" onchange="loadBarangPilih();"></select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Barang :</label>
                <select name="kodeBarang" id="kodeBarang"  class="form-control select2" style="witdh:100%"></select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Tipe Program :</label>
                <select name="tipeProgram" id="tipeProgram"  class="form-control">
                  <option value="Kelipatan">Kelipatan</option>
                  <option value="Minimal">Minimal</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Tipe Potongan :</label>
                <select name="tipePotongan" id="tipePotongan"  class="form-control" onchange="tipe();">
                  <option value="Rupiah">Rupiah</option>
                  <option value="Persen">Persen</option>
                  <option value="Bonus">Bonus</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Jumlah(Ecer) :</label>
                <input type="text" class="form-control" name="jumlahEcer" id="jumlahEcer" onKeyPress="return goodchars(event,'1234567890.',this)">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Nilai / Jumlah :</label>
                <input type="text" class="form-control" name="nilai" id="nilai" onKeyPress="return goodchars(event,'1234567890.',this)">
              </div>
            </div>
            
            
            <div id="bonus" class="row col-sm-12">
              <div class="col-sm-12"><hr> <center><h4><u>Bonus Barang</u></h4></center></div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Sama?</label>
                  <select name="sama" id="sama" class="form-control" onchange="Sama();">
                    <option value="sama">Sama</option>
                    <option value="beda">Beda</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Kategori :</label>
                  <select name="idKategoriB" id="idKategoriB"  class="form-control select2" style="witdh:100%" disabled onchange="loadBarangPilihB();"></select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Barang :</label>
                  <select name="kodeBarangB" id="kodeBarangB"  class="form-control select2" style="witdh:100%" disabled></select>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveProgram();">Save changes</button>
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
          <h3 class="card-title">Program</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="modal('');"><i class="fas fa-plus-square"></i> Tambah</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <table id="tbProgram" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Program</th>
                <th>Untuk Barang</th>
                <th>Minim/Kelipatan</th>
                <th>Jumlah Ecer</th>
                <th>Tipe</th>
                <th>Nilai / Jumlah</th>
                <th>Bonus Barang</th>
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
  /*end of everithing else here is what matters*/

  $(document).ready(function() {
    loadKategori();
    loadKategoriB();
    loadBarang();
    loadBarangB();
    loadProgram();
    $("#bonus").hide();
  });
  function modal(idProgram) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataProgram") ?>",
      type: 'POST',
      data: {
        idProgram: idProgram
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#idProgram').val(response.idProgram);
        $('#namaProgram').val(response.namaProgram);
        // $('#idKategori').val(response.idKategori).trigger('change'),
        $('#kodeBarang').val(response.kodeBarang).trigger('change');
        $('#tipeProgram').val(response.tipeProgram);
        $('#tipePotongan').val(response.tipePotongan);
        $('#jumlahEcer').val(response.jumlahEcer);
        $('#nilai').val(response.nilai);
        $('#sama').val(response.sama);
        $('#kodeBarangB').val(response.kodeBarangB).trigger('change');
        tipe();
        Sama();
        $('#mdProgram').modal('show');
      }
    });
  }
  function loadKategori() {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListKategori") ?>",
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#idKategori').html(response.data).show();
        
      }
    });
  }
  function loadKategoriB() {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListKategori") ?>",
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#idKategoriB').html(response.data).show();
        
      }
    });
  }
  function loadBarang() {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListBarang") ?>",
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#kodeBarang').html(response.data).show();
        
      }
    });
  }
  function loadBarangB() {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListBarang") ?>",
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#kodeBarangB').html(response.data).show();
        
      }
    });
  }
  function loadBarangPilih() {
    var idKategori = $('#idKategori').val();
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListBarang/") ?>"+idKategori,
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#kodeBarang').html(response.data).show();
        
      }
    });
  }
  function loadBarangPilihB() {
    var idKategori = $('#idKategoriB').val();
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListBarangB/") ?>"+idKategori,
      type: 'POST',
      data: {kodeBarang : $('#kodeBarang').val()},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#kodeBarangB').html(response.data).show();        
      }
    });
  }
  function loadProgram() {
    var Program = $('#tbProgram').DataTable();
    Program.destroy();
    $('#tbProgram').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadProgram") ?>",
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
    Program.draw();
  }

  function SaveProgram() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveProgram") ?>",
      type: 'POST',
      data: {
        idProgram: $('#idProgram').val(),
        namaProgram: $('#namaProgram').val(),
        idKategori: $('#idKategori').val(),
        kodeBarang: $('#kodeBarang').val(),
        tipeProgram: $('#tipeProgram').val(),
        tipePotongan: $('#tipePotongan').val(),
        jumlahEcer: $('#jumlahEcer').val(),
        nilai: $('#nilai').val(),

        sama: $('#sama').val(),
        kodeBarangB: $('#kodeBarangB').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdProgram').modal('hide');
        loadProgram();
      }
    });
  }
  function hapus(idProgram) {
    if (confirm('Apakah Anda yakin ingin menon-Aktifkan data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelProgram") ?>",
        type: 'POST',
        data: {
          idProgram: idProgram
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadProgram();
        }
      });
    }
  }
  function aktif(idProgram) {
    if (confirm('Apakah Anda yakin ingin men-Aktifkan data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/AktifProgram") ?>",
        type: 'POST',
        data: {
          idProgram: idProgram
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadProgram();
        }
      });
    }
  }
  function tipe(){
    if($("#tipePotongan").val() == 'Bonus'){
      $("#bonus").show();
    }else{
      $("#bonus").hide();
    }
  }
  function Sama(){
    if($("#sama").val() == 'sama'){
      $("#idKategoriB").attr("disabled", true);
      $("#kodeBarangB").attr("disabled", true);
      $("#idKategoriB").val('').trigger('change');
      $("#kodeBarangB").val('').trigger('change');
    }else{
      $("#idKategoriB").attr("disabled", false);
      $("#kodeBarangB").attr("disabled", false);
    }
    
  }
</script>