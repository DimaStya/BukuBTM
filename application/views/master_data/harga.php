<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="card card-default color-palette-box">
        <div class="card-header">
          <h3 class="card-title">Harga</h3> &nbsp; 
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label>Kategori :</label>
                <select name="idKategori" id="idKategori"  class="form-control select2" style="witdh:100%" onchange="loadBarangPilih();"></select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label>Barang :</label>
                <select name="kodeBarang" id="kodeBarang"  class="form-control select2" style="witdh:100%"></select>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group row">
                <label>Dari :</label>
                <input type="text" class="form-control date" id="dari" name="dari" value="<?php echo toDay(); ?>" onKeyPress="return goodchars(event,'',this)" autocomplete="">
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group row">
                <label>Sampai :</label>
                <input type="text" class="form-control date" id="sampai" name="sampai" value="<?php echo toDay(); ?>" onKeyPress="return goodchars(event,'',this)" autocomplete="">
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <label>&nbsp;</label>
                <button type="buttong" class="form-control btn btn-info" onclick="loadHarga();"><i class="fas fa-search-dollar"></i> Lihat</button>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="card-body">
          <div id="data"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  /*end of everithing else here is what matters*/

  $(document).ready(function() {
    loadKategori();
    loadBarang();
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
  function loadHarga() {
    var dari = $('#dari').val();
    var sampai = $('#sampai').val();
    $.ajax({
      url: "<?php echo site_url("Data/GetHeaderHarga") ?>",
      type: 'POST',
      data: {dari:dari, sampai:sampai},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#data').html(response.data).show();
        loadHargaBarang();
      }
    });
  }
  function loadHargaBarang() {
    var Harga = $('#tbHarga').DataTable();
    Harga.destroy();
    $('#tbHarga').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadHarga") ?>",
        type: 'POST',
        data: {
          dari:$('#dari').val(),
          sampai:$('#sampai').val(),
          idKategori:$('#idKategori').val(),
          kodeBarang:$('#kodeBarang').val()
        },
      },
      "aLengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      "iDisplayLength": 25,
      "serverSide": true,
      initComplete: function() {},
    });
    Harga.draw();
  }
</script>