<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Buku BMT</title>
  <link rel="shortcut icon" href="<?php echo base_url('Image/logo.ico');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css');?>">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="<?php echo base_url('assets/login/common-1.css');?>"/>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="<?php echo base_url('assets/login/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css');?>">

</head>
<body>
  <div class="demo form-bg">
    <div class="container">
      <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
          <div class="form-container">
            <h3 class="title">My Account</h3>
            <form class="form-horizontal">
              <div class="form-icon">
                <i class="fas fa-user-circle"></i>
              </div>
              <div class="form-group">
                <span class="input-icon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Username" name="username" id ="username">
              </div>
              <div class="form-group">
                <span class="input-icon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="Password" name="pass" id ="pass">
              </div>
              <button type="button" class="btn signin" onclick="login();">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/login/script.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>


<script>
    $( "#username" ).on( "keydown", function(event) {
    if(event.which == 13) 
       login();
  });
  $( "#pass" ).on( "keydown", function(event) {
    if(event.which == 13) 
       login();
  });
	function login(){
    var username = $('#username').val();
    var pass = $('#pass').val();
    $.ajax({
      url: '<?php echo base_url()."Login/check_login"; ?>',
      type: 'post',
      data: {username:username,pass:pass},
      dataType: 'json',
      success: function(data) {
        // alert(data);
        if(data['status']){
          $(function () {
            var Toast = Swal.mixin({toast: true,position: 'top-end',showConfirmButton: false,timer: 3000});
            Toast.fire({icon: 'success',title: 'Login Berhasil Selamat!!! Selamat Datang '+data['nama'] });
          });            
          link = '<?php echo base_url();?>beranda';
          document.location.href=link;
        }else{
          $(function () {
            var Toast = Swal.mixin({toast: false,position: 'mid-end',showConfirmButton: false,timer: 2000});
            Toast.fire({icon: 'error',title: 'Login Gagal!!!'});
          });
        }
        }
    });
    e.preventDefault();
  }
  </script>
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.js');?>"></script>    
</body>
</html>