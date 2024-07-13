<style>
  .select2-container {
width: 100% !important;
padding: 0;
}
</style>
<div class="modal fade" id="mdBarang">
  <div class="modal-dialog modal-l">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="kodeBarangH" id="kodeBarangH">
          <input type="hidden" name="untukPerubahan" id="untukPerubahan">
          <div class="col-sm-4">
            <div class="form-group" style="margin-bottom:0 px;">
              <label>Nama Barang :</label>
              <input type="text" class="form-control" name="namaBarang" id="namaBarang" required>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group" style="margin-bottom:0 px;">
              <label>Kode Barang :</label>
              <input type="text" class="form-control" name="kodeBarang" id="kodeBarang" required onkeyup="this.value = this.value.toUpperCase();validasiKodeBarang();" onKeyPress="return goodchars(event,'1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.',this)">
            </div>  
          </div>
          <div class="col-sm-4" style="margin-bottom:0 px;">
            <div class="form-group">
              <label>Kategori :</label>
              <select name="idKategori" id="idKategori"  class="form-control select2" style="witdh:100%"></select>
            </div>  
          </div>
          <div class="col-sm-12 mt-0"><center><small><span id="notif"></span></small></center></div>
          <div class="col-sm-3"></div>
          <div class="col-sm-4"><label>Ecer</label></div>
          <div class="col-sm-4"><label>Paket</label></div>
          <div class="col-sm-1"></div>

          <div class="col-sm-2"><label>Satuan :</label></div>
          <div class="col-sm-4 form-group">
            <input type="text" class="form-control" name="satuanEcer" id="satuanEcer" required>
          </div>
          <div class="col-sm-4 form-group">
            <input type="text" class="form-control" name="satuanPaket" id="satuanPaket" required>
          </div>
          <div class="col-sm-2 form-group">
            <input type="text" class="form-control" name="konversi" id="konversi" placeholder="KVS" onKeyPress="return goodchars(event,'1234567890.',this)">
          </div>
          
          <div class="col-sm-2"><label>Harga Beli :</label></div>
          <div class="col-sm-4 form-group">
            <input type="text" class="form-control uang" name="hargaBeliEcer" id="hargaBeliEcer" required onKeyPress="return goodchars(event,'1234567890.',this)">
          </div>
          <div class="col-sm-4 form-group">
            <input type="text" class="form-control uang" name="hargaBeliPaket" id="hargaBeliPaket" required onKeyPress="return goodchars(event,'1234567890.',this)">
          </div>
          <div class="col-sm-2"></div>
          <div class="col-sm-2"><label>Harga Jual :</label></div>
          <div class="col-sm-4 form-group">
            <input type="text" class="form-control uang" name="hargaJualEcer" id="hargaJualEcer" required onKeyPress="return goodchars(event,'1234567890.',this)">
          </div>
          <div class="col-sm-4 form-group">
            <input type="text" class="form-control uang" name="hargaJualPaket" id="hargaJualPaket" required onKeyPress="return goodchars(event,'1234567890.',this)">
          </div>
          <div class="col-sm-2"></div>
          <!-- <div class="col-sm-4">
            <div class="form-group">
              <label>Harga Grosir :</label>
              <input type="text" class="form-control" name="hargaGrosir" id="hargaGrosir" required>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label>Min Grosir :</label>
              <input type="text" class="form-control" name="minimalGrosir" id="minimalGrosir" required>
            </div>
          </div> -->
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveBarang();" id="save">Save changes</button>
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
          <h3 class="card-title">Barang</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="modal('','');"><i class="fas fa-plus-square"></i> Tambah</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <table id="tbBarang" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Kode Barang</th>
                <th>Satuan Ecer</th>
                <th>Satuan Paket</th>
                <th>KVS</th>
                <th>H J Ecer</th>
                <th>H J Paket</th>
                <th>H B Ecer</th>
                <th>H B Paket</th>
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
    loadBarang();
    loadKategori();
    // $("#idKategori").select2({
    //   dropdownParent: $("#mdBarang")
    // });
    
    
  });  
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
  function modal(kodeBarang,untuk) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataBarang") ?>",
      type: 'POST',
      data: {
        kodeBarang: kodeBarang
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {   
        $('#notif').css({'font-size': '8pt' })
        $('#notif').html("")     
        $('#untukPerubahan').val(untuk);
        if(untuk == 'data'){
          $('#namaBarang').prop('readonly', false);
          $('#kodeBarang').prop('readonly', false);
          $('#satuanEcer').prop('readonly', false);
          $('#satuanPaket').prop('readonly', false);
          $('#konversi').prop('readonly', false);
          $('#hargaBeliEcer').prop('readonly', true);
          $('#hargaBeliPaket').prop('readonly', true);
          $('#hargaJualEcer').prop('readonly', true);
          $('#hargaJualPaket').prop('readonly', true);
          // $('#hargaGrosir').prop('readonly', true);
          // $('#minimalGrosir').prop('readonly', false);
        }else if(untuk == 'hrg'){
          $('#namaBarang').prop('readonly', true);
          $('#kodeBarang').prop('readonly', true);
          $('#satuanEcer').prop('readonly', true);
          $('#satuanPaket').prop('readonly', true);
          $('#konversi').prop('readonly', true);
          $('#hargaBeliEcer').prop('readonly', false);
          $('#hargaBeliPaket').prop('readonly', false);
          $('#hargaJualEcer').prop('readonly', false);
          $('#hargaJualPaket').prop('readonly', false);
          // $('#hargaGrosir').prop('readonly', false);
          // $('#minimalGrosir').prop('readonly', true);
        }else{
          $('#namaBarang').prop('readonly', false);
          $('#kodeBarang').prop('readonly', false);
          $('#satuanEcer').prop('readonly', false);
          $('#satuanPaket').prop('readonly', false);
          $('#konversi').prop('readonly', false);
          $('#hargaBeliEcer').prop('readonly', false);
          $('#hargaBeliPaket').prop('readonly', false);
          $('#hargaJualEcer').prop('readonly', false);
          $('#hargaJualPaket').prop('readonly', false);
          // $('#hargaGrosir').prop('readonly', false);
          // $('#minimalGrosir').prop('readonly', false);
        }

        $('#kodeBarangH').val(response.kodeBarang);
        $('#kodeBarang').val(response.kodeBarang);
        $('#namaBarang').val(response.namaBarang);
        $('#satuanEcer').val(response.satuanEcer);
        $('#satuanPaket').val(response.satuanPaket);
        $('#konversi').val(response.konversi);
        $('#hargaBeliEcer').val(response.hargaBeliEcer);
        $('#hargaBeliPaket').val(response.hargaBeliPaket);
        $('#hargaJualEcer').val(response.hargaJualEcer);
        $('#hargaJualPaket').val(response.hargaJualPaket);
        // $('#hargaGrosir').val(response.hargaGrosir);
        // $('#minimalGrosir').val(response.minimalGrosir);
        $('#mdBarang').modal('show');
        $("#idKategori").val(response.idKategori).trigger('change');
      }
    });
  }

  function loadBarang() {
    var Barang = $('#tbBarang').DataTable();
    Barang.destroy();
    $('#tbBarang').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadBarang") ?>",
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
    Barang.draw();
  }

  function SaveBarang() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveBarang") ?>",
      type: 'POST',
      data: {
        kodeBarangH : $('#kodeBarangH').val(),
        namaBarang : $('#namaBarang').val(),
        kodeBarang : $('#kodeBarang').val(),
        idKategori : $('#idKategori').val(),
        satuanEcer : $('#satuanEcer').val(),
        satuanPaket : $('#satuanPaket').val(),
        konversi : $('#konversi').val(),
        hargaBeliEcer : $('#hargaBeliEcer').val(),
        hargaBeliPaket : $('#hargaBeliPaket').val(),
        hargaJualEcer : $('#hargaJualEcer').val(),
        hargaJualPaket : $('#hargaJualPaket').val(),
        // hargaGrosir : $('#hargaGrosir').val(),
        // minimalGrosir : $('#minimalGrosir').val(),
        untukPerubahan : $('#untukPerubahan').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdBarang').modal('hide');
        loadBarang();
      }
    });
  }
  function hapus(kodeBarang) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelBarang") ?>",
        type: 'POST',
        data: {
          kodeBarang: kodeBarang
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadBarang();
        }
      });
    }
  }
  function validasiKodeBarang() {
    $.ajax({
      url: "<?php echo site_url("Data/CheckKodeBarang") ?>",
      type: 'POST',
      data: {
        kodeBarangH: $('#kodeBarangH').val(),
        kodeBarang: $('#kodeBarang').val(),
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
          $('#notif').html("Kode Barang Bisa Dipakai!!!")
        }else{
          $('#notif').css({'color': 'red', 'font-size': '8pt' })
          $('#notif').html("Kode Barang Tidak Bisa Dipakai!!!")
          $('#save').attr('disabled', true);
        }
      }
    });   
  }
</script>