<?php
    session_start();
    include("./configBD.php");
    include("./sesionUsuario.php");
    if(isset($_SESSION["usuario"])){
		$usuario=$_SESSION["usuario"];
		$sesion=new SesionUsuario();
		$menu=$sesion->menuHTML($usuario);
		$numero_registros=0;
		$total_registros=0;
        $filasGalardonado = "";
        $botonMostrarMas = "";
		$sqlGetTotalGalardonado = "select count(*) as 'total' from vw_Galardonado;";
		$resGeTotaltGalardonado = mysqli_query($conexion,$sqlGetTotalGalardonado);
        while($total = mysqli_fetch_assoc($resGeTotaltGalardonado)){
			$total_s=$total["total"];
		}
		$total_registros=intval($total_s);
        $sqlGetGalardonado = "select * from vw_Galardonado order by primer_apellido;";
        $resGetGalardonado = mysqli_query($conexion,$sqlGetGalardonado);
        while($galardonado = mysqli_fetch_assoc($resGetGalardonado)){
            $filasGalardonado .= "<tr id='r-".$numero_registros."' class='' data-rfc='".$galardonado["rfc"]."'>"
                ."<td id='r-".$numero_registros."-1'>"
				.$galardonado["primer_apellido"]." ".$galardonado["segundo_apellido"]." "
				.$galardonado["nombre"]."</td><td  id='r-".$numero_registros."-2'>"
				.$galardonado["escuela"]."</td><td id='r-".$numero_registros."-3'>"
				.$galardonado["reconocimiento"]."</td>";
			$numero_registros++;
			if($numero_registros==5){
				break;
			}
        }
		if($numero_registros>0 && $total_registros>5){
			$botonMostrarMas.='<tr id="mostrar_mas" class="mostrar-mas"><td colspan="4" class="centrado">(+) mostrar m&aacute;s</td></tr>';
			$_SESSION["numero_registros"]=$numero_registros;
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
<title>Listado de Galardonados</title>
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
<link rel="stylesheet" href="./../css/listado/listado.css">
<link rel="stylesheet" href="./../css/listado/listado_buscador_galardonado.css">

<!-- Bootstrap time Picker -->
<link href="./../css/confirm330/css/jquery-confirm.css" rel="stylesheet">
<script src="./../js/jquery/dist/jquery.min.js"></script>
<script src="./../js/confirm330/js/jquery-confirm.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../js/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="./../js/AdminLTE/adminlte.min.js"></script>
<script src="./../js/listado/listado.js"></script>
<script src="./../js/listado/listado_buscador_galardonado.js"></script>
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
        Listado de Galardonados
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
				<table id='tabla_galardonado' class="expandido">
					<thead>
						<tr>
							<th><input type="text" placeholder="Nombre" id="buscador_1" class="form-control"></th>
							<th><input type="text" placeholder="Escuela" id="buscador_2" class="form-control"></th>
							<th><input type="text" placeholder="Reconocimiento" id="buscador_3" class="form-control"></th>
						</tr>
					</thead>
					<tbody id="filas_galardonado">
						<?php
							echo $filasGalardonado; 
						?>
					</tbody>
					<tfoot id="boton_mostrar_mas"><?php echo $botonMostrarMas; ?></tfoot>
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
