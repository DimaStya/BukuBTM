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
          <h3 class="card-title">Akses</h3> &nbsp; 
        </div>
        <div class="card-body">
            <div class="form-group row">
              <label for="username" class="col-sm-1 col-form-label">Username</label>
              <div class="col-sm-7">
              <select name="username" id="username" class="form-control select2" onchange="LoadMenu();">
                  <!-- <option value="">t</option>
                  <option value="">t1</option> -->
                </select>
              </div>
            </div>
            <hr>
          <div id = "listMenu">
          
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  $(document).ready(function() {
    loadUser();
  });
</script>
<script>
  function loadUser() {
    $.ajax({
      url: "<?php echo site_url("Data/GetDataListUser") ?>",
      type: 'POST',
      data: {},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#username').html(response.data).show();
        
      }
    });
  }
  function LoadMenu() {    
    $.ajax({
      url: "<?php echo site_url("Datatable/ListMenuUser") ?>",
      type: 'POST',
      data: {username : $('#username').val()},
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        $('#listMenu').html(response.data).show();
        
      }
    });
  }
  function PilihAkses(idMenus) {
    var akses = $('#akses'+idMenus).val();
    $.ajax({
      url: "<?php echo site_url("CrudData/PilihAkses") ?>",
      type: 'POST',
      data: {username:$('#username').val(), idMenus : idMenus, akses : akses, },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        LoadMenu()
        notif(response.hasil, response.proses, 1000);
      }
    });
  }
  function PilihMenu(id) {
    $.ajax({
      url: "<?php echo site_url("CrudData/PilihMenu") ?>",
      type: 'POST',
      data: {username:$('#username').val(), id : id, },
      dataType: "json",
      beforeSend: function(e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function(response) {
        LoadMenu()
        notif(response.hasil, response.proses, 1000);
      }
    });
  }
</script>