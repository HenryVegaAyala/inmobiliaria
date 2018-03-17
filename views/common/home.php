<?php
include("bussiness/menu.php");

$IdMenu = '0';
$Titulo = '';
$Cabecera = '';
$Descripcion = '';
$Icono = '';
$URLMenu = '';
$Tamanho = '';
$i = 0;

$objData = new clsMenu();

$lang = isset($_POST['lang']) ? $_POST['lang'] : 'lang';

$translate = new Translator($lang);
$rowMenu = $objData->ListMenuPerfil('HOME', $idperfil, 0, '00');
$countMenu = count($rowMenu);

$allheight = '';

if ($idperfil != '61')
  $allheight = ' all-height';
?>
<div class="wrapper<?php echo $allheight; ?>">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Cin</b>adsac</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Cin</b>adsac</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <?php if ($idperfil == '61'): ?>
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <h4 id="title_app" class="place-top-left padding-left70 white-text"></h4>
      <?php endif; ?>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $login; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                  <?php echo $login; ?>
                  <!-- <small>Member since Nov. 2012</small> -->
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Editar perfil</a>
                </div> -->
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Cerrar sesi&oacute;n</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
 
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $login; ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form> -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">Opciones del sitema</li>
        <?php
        if ($idperfil == '61'):
          if ($idproyecto_sesion == ''):
            if ($countMenu > 0):
              while($i < $countMenu):
        ?>
        <li><a data-id="<?php echo $rowMenu[$i]['tm_idmenu']; ?>" href="<?php echo $rowMenu[$i]['tm_uri']; ?>"><i class="<?php echo $rowMenu[$i]['tm_iconuri'] ?>"></i> <span><?php echo $rowMenu[$i]['tm_titulo']; ?></span></a></li>
        <?php
                ++$i;
              endwhile;
            endif;
          else:
        ?>
        <li><a data-id="152" href="?pag=admin&amp;subpag=condominio"><i class="icon-equalizer"></i> <span>Proyectos</span></a></li>
        <li><a data-id="138" href="?pag=admin&amp;subpag=propietario"><i class="icon-user-3"></i> <span>Propietarios</span></a></li>
        <?php if ($idpersona): ?>
          <?php if (($idpersona != '0') || ($idpersona != '')): ?>
        <li><a data-id="154" href="?pag=admin&subpag=propietario&screenmode=propietario"></i> <span>Editar mi informaci&oacute;n</span></a></li>
          <?php endif; ?>
        <?php endif; ?>
        <li><a data-id="159" href="?pag=security&subpag=usuarios&screenmode=usuarios"></i>  <span>Editar mi usuario</span></a></li>
        <li><a data-id="156" href="?pag=security&subpag=changepassword"></i> <span>Cambiar clave</span></a></li>
        <?php
          endif;
        else:
        ?>
        <li><a data-id="160" href="?pag=procesos&subpag=resumen&screenmode=propietario"></i> <span>Panel de control</span></a></li>
        <!-- <li><a data-id="137" href="?pag=procesos&subpag=estadocuenta">Estados de cuenta</a></li> -->
        <li><a data-id="154" href="?pag=security&subpag=usuarios&screenmode=usuarios"></i>  <span>Editar mi usuario</span></a></li>
        <li><a data-id="156" href="?pag=security&subpag=changepassword"></i> <span>Cambiar clave</span></a></li>
        <li><a data-id="157" href="?pag=reports&subpag=reportes&screenmode=propietario"></i> <span>Informes</span></a></li>
        <?php endif; ?>
      </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  </div><!-- /.content-wrapper -->


  <!-- Main Footer -->
  <!-- <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
  </footer> -->
</div><!-- ./wrapper -->
<?php include 'common/libraries-js.php'; ?>
<script src="dist/js/app/common/home.js"></script>