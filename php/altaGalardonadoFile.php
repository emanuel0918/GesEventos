<?php
    session_start();
    include("./configBD.php");
    include("./sesionUsuario.php");
    if(isset($_SESSION["usuario"])){
		$sesion=new SesionUsuario();
		$usuario=$_SESSION["usuario"];
		if($sesion->tipoUsuario($usuario)==0){
			$menu=$sesion->menuHTML($usuario);
			$html_escuelas='';
			$html_reconocimientos='';
			
			$sqlGetRecon = "select * from reconocimiento;";
			$resGetRecon = mysqli_query($conexion,$sqlGetRecon);
			while($recons = mysqli_fetch_array($resGetRecon,MYSQLI_BOTH)){
				$html_reconocimientos.='<option value="'.$recons[1]
				.'">'.$recons[1].'</option>';
			}
			
			$sqlGetEscuela = "select * from escuela;";
			$resGetEscuela = mysqli_query($conexion,$sqlGetEscuela);
			while($escuelas = mysqli_fetch_array($resGetEscuela,MYSQLI_BOTH)){
				$html_escuelas.='<option value="'.$escuelas[1]
				.'">'.$escuelas[1].'</option>';
			}
		

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
<title>Agregar Galardonado</title>
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
<link href="./../css/registro/rGalardonadoFile.css" rel="stylesheet">
<script src="./../js/jquery/dist/jquery.min.js"></script>
<script src="./../js/jquery3/jquery.min.js"></script>
<script src="./../js/excel/xls.core.min.js"></script>
<script src="./../js/excel/xlsx.core.min.js"></script>
<script src="./../js/confirm330/js/jquery-confirm.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../js/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="./../js/AdminLTE/adminlte.min.js"></script>
<script src="./../js/registro/rGalardonadoFile.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
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
	<?php echo $menu;?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Agregar Galardonado<small> (Importar archivo)</small>
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
              <form id="formGAL" method="post">
              <div class="row">
              <div class="col-xs-12">
              <h3>Importar archivo</h3>
              <h4>Archivo EXCEL</h4>
              <div class="input-group btn-expand">
				<input type="file" id="excelfile"  class="btn btn-primary btn-expand" >
              </div>
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12 col-md-6">
              <h4>Escuela</h4>
				<div class="input-group">
                <span class="input-group-addon form-escuela"><i class="fa fa-university"></i></span>
				  <select class="form-control form-escuela" name="escuela" id="escuela">
					<option>Seleccionar Opci&oacute;n</option>
					<?php echo $html_escuelas; ?>
				  </select>
				</div>
              </div>
              <div class="col-xs-12 col-md-6">
              <h4>Reconocimiento</h4>
				<div class="input-group">
                <span class="input-group-addon form-recon"><i class="fa fa-award"></i></span>
				  <select class="form-control form-recon" name="recon" id="recon">
					<option>Seleccionar Opci&oacute;n</option>
					<?php echo $html_reconocimientos; ?>
				  </select>
				</div>
              </div>
              </div>
			  <br>
              <div class="input-group btn-expand" >
                <input id="viewfile" type="submit" class="btn btn-primary btn-expand" value="Exportar"  >
              </div>
          </form>
			<div class="row">
			<div class="col-xs-12">
			<table id="exceltable"  class="expand-table">
			<!--<thead>
				<tr>
				<th>Nombre</th>
				<th>Primer Apellido</th>
				<th>Segundo Apellido</th>
				<th>RFC</th>
				<th>Sexo</th>
				<th>Discapacidad</th>
				<th>Correo</th>
				<th>Telefono</th>
				<th>Observaciones</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<td>Nombre</td>
				<td>Primer Apellido</td>
				<td>Segundo Apellido</td>
				<td>RFC</td>
				<td>Sexo</td>
				<td>Discapacidad</td>
				<td>Correo</td>
				<td>Telefono</td>
				<td>Observaciones</td>
				</tr>
			</tbody>-->
			</table>
            </div>
            </div>
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