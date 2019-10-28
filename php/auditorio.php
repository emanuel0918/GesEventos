<?php
    session_start();
    include("./configBD.php");
    include("./sesionUsuario.php");
    if(isset($_SESSION["usuario"])){
		$usuario=$_SESSION["usuario"];
		$sesion=new SesionUsuario();
		$menu=$sesion->menuHTML($usuario);
		$html_asientos='';
		$asiento_nombre='';
        $sqlGetFilas = "select * from fila where idauditorio=1;";
        $resGetFilas = mysqli_query($conexion,$sqlGetFilas);
        while($filas = mysqli_fetch_assoc($resGetFilas)){
			$html_asientos.='<tr><td align="right">'.chr((intval($filas["fila"])+64)).'</td>';
			$sqlGetAsientos = "select * from asiento where idfila=".$filas["idfila"];
			$resGetAsientos = mysqli_query($conexion,$sqlGetAsientos);
			while($asientos = mysqli_fetch_assoc($resGetAsientos)) {
				$asiento_nombre=$asientos["asiento"];
				if(intval($asiento_nombre)<10){
					$asiento_nombre='0'.$asientos["asiento"];
				}else{
					$asiento_nombre=$asientos["asiento"];
					
				}
				if($asientos["es_asiento"]=='0' || $asientos["es_asiento"]==0){
					$html_asientos.='<td align="center" class="asiento"></td>';
				}else{
					if($asientos["ocupado"]=='1' || $asientos["ocupado"]==1){
						$sqlVerGalardonado = "select * from vw_Auditorio where idasiento=".$asientos["idasiento"].";";
						$resVerGalardonado = mysqli_query($conexion,$sqlVerGalardonado);
						while($galardonado = mysqli_fetch_assoc($resVerGalardonado)) {
							if($galardonado["discapacidad"]=='0' || $galardonado["discapacidad"]==0){
								$html_asientos.='<td align="center" class="asiento ocupado">'
								.'<p class="asiento ver" data-rfc="'
								.$galardonado["rfc"].'">'.$asiento_nombre.'</p></td>';
							}else{
								$html_asientos.='<td align="center" class="asiento discapacitado">'
								.'<p class="asiento ver" data-rfc="'
								.$galardonado["rfc"].'">'.$asiento_nombre.'</p></td>';
							}
						}
					}else{
							$html_asientos.='<td align="center" class="asiento disponible">'
							.'<p class="asiento ver" data-rfc="">'.$asiento_nombre.'</p></td>';
					}
				}
			}
			$html_asientos.='<td align="left">'.chr((intval($filas["fila"])+64)).'</td></tr>';
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
<title>Auditorio</title>
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
<link rel="stylesheet" href="./../css/asientos/asientos.css">
<link rel="stylesheet" href="./../css/listado/listado.css">

<!-- Bootstrap time Picker -->
<link href="./../css/confirm330/css/jquery-confirm.css" rel="stylesheet">
<script src="./../js/jquery/dist/jquery.min.js"></script>
<script src="./../js/confirm330/js/jquery-confirm.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../js/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="./../js/AdminLTE/adminlte.min.js"></script>
<script src="./../js/asientos/asientos.js"></script>
<script src="./../js/listado/listado.js"></script>
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
	<?php echo $menu;?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Auditorio
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
			<table class="expandido">
				<?php echo $html_asientos; ?>
			</table>
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

?>