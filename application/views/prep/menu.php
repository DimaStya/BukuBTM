<div class="modal fade" id="mdMenu">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Menu</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-7">
            <input type="hidden" name="idMenu" id="idMenu">
            <div class="form-group">
              <label>Nama Menu :</label>
              <input type="text" class="form-control" name="namaMenu" id="namaMenu" required>
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group">
              <label>Icon : <button class ="btn btn-xs btn-success" onclick="listIcon('menu');">Pilih Icon</button> </label>
              <div class="input-group">
                <!-- <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-icons"></i></span>
                </div> -->
                <input type="text" class="form-control" id="menuIcon" name ="menuIcon" required readonly>
                <div class="input-group-append">
                  <div class="input-group-text"><i id = "menuvicon" name = "menuvicon"></i></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveMenu();">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdMenus">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Data Menus <u><b><span id="punyaMenu"></span></b></u></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-7">
            <input type="hidden" name="idMenuFC" id="idMenuFC">
            <input type="hidden" name="idMenus" id="idMenus">
            <div class="form-group">
              <label>Nama Menus :</label>
              <input type="text" class="form-control" name="namaMenus" id="namaMenus" required>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <label>Controller :</label>
                  <input type="text" class="form-control" name="contr" id="contr" required onkeyup="this.value = this.value.toLowerCase();">
                </div>
              </div>
              <div class="col-sm-1">
                <label>&nbsp;</label>
                <div class="form-control" style = "border:0px;">/</div>
              </div>
              <div class="col-sm-5">
                <div class="form-group">
                  <label>Method :</label>
                  <input type="text" class="form-control" name="meth" id="meth" required onkeyup="this.value = this.value.toLowerCase();">
                </div>
              </div>   
            </div>         
          </div>
          
          <div class="col-sm-7">
            <div class="form-group">
              <label>Icon : <button class ="btn btn-xs btn-success" onclick="listIcon('menus');">Pilih Icon</button> </label>
              <div class="input-group">
                
                <!-- <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-icons"></i></span>
                </div> -->
                <input type="text" class="form-control" id="menusIcon" name ="menusIcon" required readonly>
                <div class="input-group-append">
                  <div class="input-group-text"><i id = "menusvicon" name = "menusvicon"></i></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveMenus();">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdListIcon">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> List Icon</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        <input type="hidden" name="untuk" id="untuk">
          <div class="col-sm-12">
            <table id="tbIcon" class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <td width="10%">L1</td>
                  <td width="10%">L2</td>
                  <td width="10%">L3</td>
                  <td width="10%">L4</td>
                  <td width="10%">L5</td>
                  <td width="10%">L6</td>
                  <td width="10%">L7</td>
                  <td width="10%">L8</td>
                  <td width="10%">L9</td>
                  <td width="10%">L10</td>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>            
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdUrutan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Rubah Urutan Menu</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" id="idMenuUrutan" name="idMenuUrutan">
          <!-- <input type="number" id="urutan" name="urutan" min="1"> -->
          <select name="urutan" id="urutan" class="form-control"></select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="RubahUrutan();">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdUrutans">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Rubah Urutan Menus</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" id="idMenuUrutans" name="idMenuUrutans">
          <input type="hidden" id="idMenusUrutans" name="idMenusUrutans">
          <!-- <input type="number" id="urutan" name="urutan" min="1"> -->
          <select name="urutans" id="urutans" class="form-control"></select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="RubahUrutans();">Save changes</button>
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
          <h3 class="card-title">Menu</h3> &nbsp; 
          <?php if($this->session->userdata('aksesnya') == 'VE'){ ?> 
          <button class="btn btn-xs btn-primary" onclick="modal('');"><i class="fas fa-plus-square"></i> Tambah</button>
          <?php } ?>
        </div>
        <div class="card-body">
          <div id = "listMenu">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  $(document).ready(function() {
    loadMenu();
    // loadKategori();
  });  
  function modal(idMenu) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataMenu") ?>",
      type: 'POST',
      data: {
        idMenu: idMenu
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#idMenu').val(response.idMenu);
        $('#namaMenu').val(response.namaMenu);
        $("#menuvicon").removeAttr('class');
        $("#menuvicon").addClass(response.menuIcon);
        $("#menuIcon").val(response.menuIcon);
        $('#mdMenu').modal('show');
      }
    });
  }
  function modals(idMenu,idMenus) {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataMenus") ?>",
      type: 'POST',
      data: {
        idMenus: idMenus,
        idMenu: idMenu
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#idMenuFC').val(idMenu);
        $('#idMenus').val(response.idMenus);
        $('#namaMenus').val(response.namaMenus);
        $("#menusvicon").removeAttr('class');
        $("#menusvicon").addClass(response.menusIcon);
        $("#menusIcon").val(response.menusIcon);
        $('#punyaMenu').html(response.namaMenu).show();
        $("#contr").val(response.contr);
        $("#meth").val(response.meth);
        $('#mdMenus').modal('show');
      }
    });
  }
  function listIcon(untuk) {
    $('#mdListIcon').modal('show');
    var Icon = $('#tbIcon').DataTable();
    Icon.destroy();
    $('#tbIcon').DataTable({
      // responsive: true,
      "ajax": {
        url: "<?php echo site_url("Datatable/LoadIcon") ?>",
        type: 'POST',
        data: {},
      },
      "aLengthMenu": [
        [25, 50, 75, 100, -1],
        [25, 50, 75, 100, "All"]
      ],
      "iDisplayLength": 25,
      "serverSide": true,
      initComplete: function() {},
    });
    Icon.draw();    
    $('#untuk').val(untuk);
  }
  function isiIcon(icon) {    
    var untuk = $('#untuk').val();
    if(untuk === 'menu'){
      //menuIcon
      // menuvicon
      $("#menuvicon").removeAttr('class');
      $("#menuvicon").addClass(icon);
      $("#menuIcon").val(icon);
    }else if(untuk == 'menus'){
      //menusIcon
      $("#menusvicon").removeAttr('class');
      $("#menusvicon").addClass(icon);
      $("#menusIcon").val(icon);
    }
    $('#mdListIcon').modal('hide');
    
  }  
  function loadMenu() {
    $.ajax({
      url: "<?php echo site_url("Datatable/loadMenu") ?>",
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#listMenu').html(response.data).show();
        // console.log(response.data);
        
      }
    });
  }
  function SaveMenu() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveMenu") ?>",
      type: 'POST',
      data: {
        idMenu: $('#idMenu').val(),
        namaMenu: $('#namaMenu').val(),
        menuIcon: $('#menuIcon').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        if (response.hasil == 'sukses') {
          notif('success', response.proses, 2000);
          $('#mdMenu').modal('hide');
          loadMenu();
        } else if (response.hasil == 'gagal') {
          notif('error', response.proses, 2000);
          $('#mdMenu').modal('hide');
          loadMenu();
        }
      }
    });
  }
  function SaveMenus() {
    $.ajax({
      url: "<?php echo site_url("CrudData/SaveMenus") ?>",
      type: 'POST',
      data: {
        idMenu: $('#idMenuFC').val(),
        idMenus: $('#idMenus').val(),
        namaMenus: $('#namaMenus').val(),
        menusIcon: $('#menusIcon').val(),
        contr: $('#contr').val(),
        meth: $('#meth').val(),
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdMenus').modal('hide');
        loadMenu();        
      }
    });
  }
  function urutan(idMenu) {
    $.ajax({
      url: "<?php echo site_url("Data/GetJumlahDataMenu") ?>",
      type: 'POST',
      data: {
        idMenu: idMenu
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#urutan').html(response.data).show();
        $('#idMenuUrutan').val(idMenu);
        $('#mdUrutan').modal('show');
      }
    });
  }
  function urutans(idMenu,idMenus) {
    $.ajax({
      url: "<?php echo site_url("Data/GetJumlahDataMenus") ?>",
      type: 'POST',
      data: {
        idMenu : idMenu,
        idMenus : idMenus,
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#urutans').html(response.data).show();
        $('#idMenuUrutans').val(idMenu);
        $('#idMenusUrutans').val(idMenus);
        $('#mdUrutans').modal('show');
      }
    });
  }
  function RubahUrutan() {
    $.ajax({
      url: "<?php echo site_url("CrudData/RubahUrutan") ?>",
      type: 'POST',
      data: {
        idMenu: $('#idMenuUrutan').val(),
        urutanbaru: $('#urutan').val()
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdUrutan').modal('hide');
        loadMenu(); 
        
      }
    });
  }
  function RubahUrutans() {
    $.ajax({
      url: "<?php echo site_url("CrudData/RubahUrutans") ?>",
      type: 'POST',
      data: {
        idMenu: $('#idMenuUrutans').val(),
        idMenus: $('#idMenusUrutans').val(),
        urutanbaru: $('#urutans').val()
      },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        notif(response.hasil, response.proses, 2000);
        $('#mdUrutans').modal('hide');
        loadMenu(); 
      }
    });
  }


  function hapus(idMenu) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelMenu") ?>",
        type: 'POST',
        data: {
          idMenu: idMenu
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadMenu();           
        }
      });
    }
  }
  function hapuss(idMenus) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      $.ajax({
        url: "<?php echo site_url("CrudData/DelMenus") ?>",
        type: 'POST',
        data: {
          idMenus: idMenus
        },
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) {
          notif(response.hasil, response.proses, 2000);
          loadMenu(); 
        }
      });
    }
  }
</script>