<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="<?php echo base_url('beranda');?>" class="brand-link">
  <img src="<?php echo base_url('Image/logo.jpeg');?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">Buku BTM</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="<?php echo base_url('beranda');?>" class="nav-link <?php echo ($this->URI1 == 'beranda') ? "active" : "";?>">
          <i class="nav-icon fas fa-home"></i>
          <p>Beranda</p>
        </a>
      </li>
      <?php 
        $menu = $this->mlog->GetMenu();
        for ($i=0; $i < count($menu); $i++) { 
          if(COUNT($menu[$i]) == 1){
            $aktif = ($this->URI1.'/'.$this->URI2 == $menu[$i][0]['link']) ? 'active' : '';            
            echo '
            <li class="nav-item">
              <a href="'.base_url($menu[$i][0]['link']).'" class="nav-link '.$aktif.'">
                <i class="nav-icon '.$menu[$i][0]['mico'].'"></i>
                <p>'.$menu[$i][0]['menu'].'</p>
              </a>
            </li>
            ';
          }else if(COUNT($menu[$i]) > 1){
            $linkaktif = 0;
            $list = '<ul class="nav nav-treeview">';
            for ($j=0; $j < count($menu[$i]); $j++) {
              $mico = $menu[$i][$j]['mico'];
              $menutampil = $menu[$i][$j]['menu'];
              $aktif = ($this->URI1.'/'.$this->URI2 == $menu[$i][$j]['link']) ? 'active' : '';
              $linkaktif = ($this->URI1.'/'.$this->URI2 == $menu[$i][$j]['link']) ? 1 : $linkaktif;
              $list .= '<li class="nav-item">
              <a href="'.base_url($menu[$i][$j]['link']).'" class="nav-link '.$aktif.'">
                <i class="nav-icon '.$menu[$i][$j]['cico'].'"></i>
                <p>'.$menu[$i][$j]['child'].'</p>
              </a>
            </li>';
            }
            $list .= '</ul>';
            $open = ($linkaktif == 1) ? 'menu-open' : '';
            $maktif = ($linkaktif == 1) ? 'active' : '';
            echo '<li class="nav-item '.$open.'">
            <a href="#" class="nav-link '.$maktif.'">
              <i class="nav-icon '.$mico.'"></i>
              <p>
              '.$menutampil.'
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            '.$list.'
            </li>';
          }else{
            //skip
          }
        }
      ?>
      <div class="user-panel"></div>
      <li class="nav-item <?php echo ($this->URI1 == 'user') ? "menu-open" : "";?>">
        <a href="#" class="nav-link <?php echo ($this->URI1 == 'user') ? "active" : "";?>">
          <i class="nav-icon fas fa-user-cog"></i>
          <p>
            User
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?php echo base_url('user/ubahPassword');?>" class="nav-link <?php echo ($this->URI1 == 'user' && $this->URI2 == 'ubahpassword') ? "active" : "";?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Ubah Password</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('logout');?>" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Log Out</p>
            </a>
          </li>
        </ul>
      </li>
      
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>