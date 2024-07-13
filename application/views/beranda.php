<script>
  $(function () {
            var Toast = Swal.mixin({toast: false,position: 'mid-end',showConfirmButton: false,timer: 2000});
            Toast.fire({icon: 'error',title: 'Login Gagal!!!'});
          });
  </script>