<?php
    session_start();
    include("./configBD.php");
    include("./sesionUsuario.php");
    if(isset($_SESSION["usuario"])){
		$sesion=new SesionUsuario();
		$usuario=$_SESSION["usuario"];
		if($sesion->tipoUsuario($usuario)==0){
			$menu=$sesion->menuHTML($usuario);
		

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Agregar Staff</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="./../css/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="./../css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="./../css/fontawesome/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="./../css/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="./../css/AdminLTE/AdminLTE.min.css">
<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
page. However, you can choose any other skin. Make sure you
apply the skin class to the body tag so the changes take effect. -->
<link rel="stylesheet" href="./../css/skins/skin-blue.min.css">

<!-- Bootstrap time Picker -->
<link href="./../css/confirm330/css/jquery-confirm.css" rel="stylesheet">
<link href="./../css/registro/rStaff.css" rel="stylesheet">
<script src="./../js/jquery/dist/jquery.min.js"></script>
<script src="./../js/confirm330/js/jquery-confirm.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../js/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="./../js/AdminLTE/adminlte.min.js"></script>
<script src="./../js/registro/rStaff.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>G</b>ES</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Ges</b>Eventos</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
    </nav>
  </header>
  
  <?php echo $menu; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Agregar Staff
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form id="formStaff" method="post">
			  <h3>Datos del staff</h3>
              <div class="row">
              <div class="col-xs-12 col-md-4">
			  <h4>Nombre</h4>
              <div class="input-group">
                <span class="input-group-addon form-nombre"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control form-nombre" placeholder="Nombre" id="nombre" name="nombre" required>
              </div>
              </div>
              <div class="col-xs-12 col-md-4">
			  <h4>Usuario</h4>
              <div class="input-group">
                <span class="input-group-addon form-usuario"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control form-usuario" placeholder="Usuario" id="usuario" name="usuario" required>
              </div>
              </div>
              <div class="col-xs-12 col-md-4">
              <h4>Privilegio</h4>
				<div class="input-group">
                <span class="input-group-addon form-privilegio"><i id="icon_privilegio" class="fa fa-male"></i></span>
				  <select class="form-control form-privilegio" name="privilegio" id="privilegio">
					<option>Admin</option>
					<option>Usuario Est&aacute;ndar</option>
				  </select>
				</div>
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12 col-md-6">
			  <h4>Contrase&ntilde;a</h4>
              <div class="input-group">
                <span class="input-group-addon form-contra1"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control form-contra1" placeholder="" id="contra1" name="contra1" required>
              </div>
              </div>
              <div class="col-xs-12 col-md-6">
			  <h4>Contrase&ntilde;a</h4>
              <div class="input-group">
                <span class="input-group-addon form-contra2"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control form-contra2" placeholder="" id="contra2" name="contra2" required>
              </div>
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12 col-md-6">
			  <h4>Direcci&oacute;n Correo Elctor&oacute;nico</h4>
              <div class="input-group">
                <span class="input-group-addon form-correo"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control form-correo" placeholder="ejemplo@email.com" id="correo" name="correo" required>
              </div>
              </div>
              <div class="col-xs-12 col-md-6">
              <h4>Tel&eacute;fono</h4>
              <div class="input-group">
                <span class="input-group-addon form-tel"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control form-tel" placeholder="+(52) 0123456789" id="tel" name="tel" maxlength="13">
              </div>
              </div>
              </div>
			  <br>
              <div class="input-group btn-expand" >
                <input id="btn-submit" type="submit" class="btn btn-primary btn-expand" value="Agregar"  >
              </div>
          </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- DataTables -->
<script src="./../js/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./../js/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="./../js/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="./../js/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./../js/demo/demo.js"></script>
 <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">TeamADOO</a>.</strong> All rights reserved.
  </footer>
</div>
</body>
</html>
<?php
		}else{
			header("location:./../index.php");
		}
	}else{
		header("location:./../index.php");
	}

?>