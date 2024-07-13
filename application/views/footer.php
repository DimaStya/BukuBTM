
<footer class="main-footer">
<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
All rights reserved.
<div class="float-right d-none d-sm-inline-block">
  <b>Version</b> 3.2.0
</div>
</footer>

</div>
<!-- ./wrapper -->

<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js');?>"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js');?>"></script>
<!-- <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js');?>"></script> -->
<script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.js');?>"></script> 
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
<!-- ChartJS -->
<!-- <script src="<?php echo base_url('assets/plugins/chart.js/Chart.min.js');?>"></script> -->
<!-- Sparkline -->
<!-- <script src="<?php echo base_url('assets/plugins/sparklines/sparkline.js');?>"></script> -->
<!-- JQVMap -->
<!-- <script src="<?php echo base_url('assets/plugins/jqvmap/jquery.vmap.min.js');?>"></script> -->
<!-- <script src="<?php echo base_url('assets/plugins/jqvmap/maps/jquery.vmap.usa.js');?>"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="<?php echo base_url('assets/plugins/jquery-knob/jquery.knob.min.js');?>"></script> -->

<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js');?>"></script>
<!-- Summernote -->
<script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js');?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');?>"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/jszip/jszip.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/pdfmake/pdfmake.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/pdfmake/vfs_fonts.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url('assets/dist/js/demo.js');?>"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo base_url('assets/dist/js/pages/dashboard.js');?>"></script> -->
<script>
  jQuery('.date').datetimepicker({
    timepicker: false,
    format: 'Y-m-d'
  });
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();

    $(".uang").keyup(function(e){
        $(this).val(format($(this).val()));
      });
      $(".uang").click(function(e){
        $(this).val(format($(this).val()));
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
  })
</script>
<script>
  function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
  
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
  
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }
function notif(ico, titl, time) {
    var Toast = Swal.mixin({toast: false,position: 'center',showConfirmButton: false,timer: time, width: '350px'});
    Toast.fire({icon: ico,title: titl});
  }
</script>
<script language="javascript">
  function getkey(e) {
    if (window.event)
      return window.event.keyCode;
    else if (e)
      return e.which;
    else
      return null;
  }

  function goodchars(e, goods, field) {
    var key, keychar;
    key = getkey(e);
    if (key == null) return true;

    keychar = String.fromCharCode(key);
    keychar = keychar.toLowerCase();
    goods = goods.toLowerCase();

    // check goodkeys
    if (goods.indexOf(keychar) != -1)
      return true;
    // control keys
    if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
      return true;

    if (key == 13) {
      var i;
      for (i = 0; i < field.form.elements.length; i++)
        if (field == field.form.elements[i])
          break;
      i = (i + 1) % field.form.elements.length;
      field.form.elements[i].focus();
      return false;
    };
    // else return false
    return false;
  }
  
</script>
</body>
</html>
