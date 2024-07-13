<style>
  .select2-container {
width: 100% !important;
padding: 0;
}
</style>
<div class="modal fade" id="mdDiskonMember">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Diskon Member</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="idDiskon" id="idDiskon">
          <div class="col-sm-3">
            <div class="form-group">
              <label>Kode Diskon :</label> <span><button class="btn btn-xs btn-primary" onclick="GetKodeDiskon()" readonly>Generate</button></span> <span id="chekVoucher"></span>
              <input type="text" class="form-control" name="kodeDiskon" id="kodeDiskon" required onKeyUp="chekVoucher();" onKeyPress="return goodchars(event,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',this);" style="text-transform:uppercase">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Untuk Member :</label>
              <select name="idMember" id="idMember"  class="form-control select2" style="witdh:100%" multiple="multiple" data-placeholder="Select a State" style="width: 100%;"></select>
            </div>  
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Metode Diskon :</label>
              <select name="metodeDiskon" id="metodeDiskon" class="form-control" onchange= "Method();">
                <option value="persen">Persen %</option>
                <option value="nominal">Rupiah Rp</option>
              </select>
            </div>  
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>Besaran :</label>
              <input type="text" class="form-control uang" name="besaran" id="besaran" onchange= "besaran();" required onKeyPress="return goodchars(event,'1234567890.',this)">
            </div>  
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>Min Belanja :</label>
              <input type="text" class="form-control uang" name="minimum" id="minimum" required onKeyPress="return goodchars(event,'1234567890.',this)">
            </div>  
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>Max Diskon :</label>
              <input type="text" class="form-control uang" name="maximumDiskon" id="maximumDiskon" required onKeyPress="return goodchars(event,'1234567890.',this)">
            </div>  
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Exp Diskon :</label>
              <input type="text" class="form-control date" name="exp" id="exp" required onKeyPress="return goodchars(event,'',this)">
            </div>  
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveDiskonMember();">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdMember">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Member Dengan Diskon <u><span id="KodeDiskonMember"></u></span></h4> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table id="tbMember" class="table table-bordered table-striped" width="100%">
        <thead>
          <tr>
            <td>No</td>
            <td>Kode Member</td>
            <td>Nama Member</td>
            <td>No Hp Member</td>
            <td>Alamat</td>
            <td>Aksi</td>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
        <div id="listMember"></div>
        
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
          <h3 class="card-title">DiskonMember</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="modal('','');"><i class="fas fa-plus-square"></i> Tambah</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <table id="tbDiskonMember" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Diskon</th>
                <th>Diskon</th>
                <th>Member</th>
                <th>Min Belanja</th>
                <th>Max Diskon</th>
                <th>Exp</th>
                <th>Status</th>
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
    loadDiskonMember();
    loadMember();
    // $("#idKategori").select2({
    //   dropdownParent: $("#mdDiskonMember")
    // });
    $(function(){
      $(".uang").keyup(function(e){
        $(this).val(format($(this).val()));
      });
      $(".uang").click(function(e){
        $(this).val(format($(this).val()));
      });
    });
    var format = function(num){
      var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
      if(str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
      }
      str = str.split("").reverse();
      for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ",") {
          output.push(str[j]);
          if(i%3 == 0 && j < (len - 1)) {
            output.push(",");
          }
          i++;
        }
      }
      formatted = output.reverse().join("");
      return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };
  });
  function GetKodeDiskon() {
    $.ajax({
      url: "<?php echo site_url("Data/GetKodeDiskon") ?>",
      type: 'POST',
      data: {
        kodeDiskon : $('#kodeDiskon').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        if(response.stat == 'sudah'){
          alert('Sudah tersedia Kode Diskon!!!');
        }else{
          $('#kodeDiskon').val(response.kodeDiskon);
          chekVoucher();
        }
        
      }
    });
  }
  function Method() {
    var meth = $('#metodeDiskon').val();
    if(meth == 'nominal'){
      $('#maximumDiskon').attr('readonly', true); 
      $('#maximumDiskon').val($('#besaran').val());
    }else{
      $('#maximumDiskon').attr('readonly', false);  
    }
  }
  function besaran() {
    var meth = $('#metodeDiskon').val();    
    if(meth == 'nominal'){
      $('#maximumDiskon').val($('#besaran').val());
    }else{
      $('#maximumDiskon').val();
    }
  }
  function loadMember() {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListMember") ?>",
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#idMember').html(response.data).show();
        
      }
    });
  }
  function chekVoucher() {
    $.ajax({
      url: "<?php echo site_url("Data/chekVoucher") ?>",
      type: 'POST',
      data: {
        kodeDiskon : $('#kodeDiskon').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        if(response.stat == 'sudah'){
          $('#chekVoucher').css({ 'color': 'red', 'font-size': '10pt' });
          $('#chekVoucher').html('Ditolak!');
        }else{
          $('#chekVoucher').css({ 'color': 'green', 'font-size': '10pt' });
          $('#chekVoucher').html('Diterima!');
        }        
      }
    });
  }
  function modal(idDiskon) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataDiskonMember") ?>",
      type: 'POST',
      data: {
        idDiskon: idDiskon
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        if(response.idDiskon === ''){
          $('#kodeDiskon').attr('readonly', false);
        }else{
          $('#kodeDiskon').attr('readonly', true);
        }

        $('#idDiskon').val(response.idDiskon);
        $('#kodeDiskon').val(response.kodeDiskon);
        $('#metodeDiskon').val(response.metodeDiskon);
        $('#besaran').val(response.besaran);
        $('#minimum').val(response.minimum);
        $('#maximumDiskon').val(response.maximumDiskon);
        $('#exp').val(response.exp);
        $('#mdDiskonMember').modal('show');
        $('#idMember').val(response.idMember).change();
        Method();
      }
    });
  }
  function detailMember(idDiskon) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataDetailDiskonMember") ?>",
      type: 'POST',
      data: {
        idDiskon: idDiskon
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) { 
        $('#mdMember').modal('show');
        $('#KodeDiskonMember').html(response.kodeDiskon);
        loadDetailMember(response.idDiskon);
        // $('#listMember').html(response.tbl);
        // $('#tbMember').DataTable({responsive: true,});
      }
    });
  }
  function loadDetailMember(idDiskon) {
    var Member = $('#tbMember').DataTable();
    Member.destroy();
    $('#tbMember').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/loadDetailMember") ?>",
        type: 'POST',
        data: {idDiskon: idDiskon},
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

  function loadDiskonMember() {
    var DiskonMember = $('#tbDiskonMember').DataTable();
    DiskonMember.destroy();
    $('#tbDiskonMember').DataTable({
      responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadDiskonMember") ?>",
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
    DiskonMember.draw();
  }

  function SaveDiskonMember() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveDiskonMember") ?>",
      type: 'POST',
      data: {
        idDiskon : $('#idDiskon').val(),
        kodeDiskon : $('#kodeDiskon').val(),
        idMember : $('#idMember').val(),
        metodeDiskon : $('#metodeDiskon').val(),
        besaran : $('#besaran').val(),
        minimum : $('#minimum').val(),
        maximumDiskon : $('#maximumDiskon').val(),
        exp : $('#exp').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdDiskonMember').modal('hide');
        loadDiskonMember();
      }
    });
  }
  function hapus(idDiskon) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelDiskonMember") ?>",
        type: 'POST',
        data: {
          idDiskon: idDiskon
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadDiskonMember();
        }
      });
    }
  }
  function hapusMemberDiskon(idDiskon,idMember) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelDetailMember") ?>",
        type: 'POST',
        data: {
          idDiskon: idDiskon, 
          idMember: idMember, 
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadDetailMember(idDiskon);
          loadDiskonMember();
        }
      });
    }
  }
  
</script>