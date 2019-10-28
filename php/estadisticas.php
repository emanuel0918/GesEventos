<?php
    session_start();
    include("./configBD.php");
    include("./sesionUsuario.php");
    if(isset($_SESSION["usuario"])){
		$usuario=$_SESSION["usuario"];
		$sesion=new SesionUsuario();
		$menu=$sesion->menuHTML($usuario);
		$total=0;
        $sqlGetEstadisticas = "select count(*) from galardonado;";
        $resGetEstadisticas = mysqli_query($conexion,$sqlGetEstadisticas);
        while($estadisticas = mysqli_fetch_array($resGetEstadisticas,MYSQLI_BOTH)){
			$total=intval($estadisticas[0]);
		}
		$r1=0;
        $sqlGetEstadisticas = "select count(*) from galardonado where edad<50;";
        $resGetEstadisticas = mysqli_query($conexion,$sqlGetEstadisticas);
        while($estadisticas = mysqli_fetch_array($resGetEstadisticas,MYSQLI_BOTH)){
			$r1=intval($estadisticas[0]);
		}
		$r2=0;
        $sqlGetEstadisticas = "select count(*) from galardonado where edad>=50 and edad<60;";
        $resGetEstadisticas = mysqli_query($conexion,$sqlGetEstadisticas);
        while($estadisticas = mysqli_fetch_array($resGetEstadisticas,MYSQLI_BOTH)){
			$r2=intval($estadisticas[0]);
		}
		$r3=0;
        $sqlGetEstadisticas = "select count(*) from galardonado where edad>=60 and edad<70;";
        $resGetEstadisticas = mysqli_query($conexion,$sqlGetEstadisticas);
        while($estadisticas = mysqli_fetch_array($resGetEstadisticas,MYSQLI_BOTH)){
			$r3=intval($estadisticas[0]);
		}
		$r4=0;
        $sqlGetEstadisticas = "select count(*) from galardonado where edad>=70;";
        $resGetEstadisticas = mysqli_query($conexion,$sqlGetEstadisticas);
        while($estadisticas = mysqli_fetch_array($resGetEstadisticas,MYSQLI_BOTH)){
			$r4=intval($estadisticas[0]);
		}
		$hombres=0;
        $sqlGetEstadisticas = "select count(*) from galardonado where sexo=0;";
        $resGetEstadisticas = mysqli_query($conexion,$sqlGetEstadisticas);
        while($estadisticas = mysqli_fetch_array($resGetEstadisticas,MYSQLI_BOTH)){
			$hombres=intval($estadisticas[0]);
		}
		$mujeres=0;
        $sqlGetEstadisticas = "select count(*) from galardonado where sexo=1;";
        $resGetEstadisticas = mysqli_query($conexion,$sqlGetEstadisticas);
        while($estadisticas = mysqli_fetch_array($resGetEstadisticas,MYSQLI_BOTH)){
			$mujeres=intval($estadisticas[0]);
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
<title>Estad&iacute;sticas</title>
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
<link rel="stylesheet" href="./../css/chart/grafica.css">

<!-- Bootstrap time Picker -->
<link href="./../css/confirm330/css/jquery-confirm.css" rel="stylesheet">
<script src="./../js/jquery/dist/jquery.min.js"></script>
<script src="./../js/confirm330/js/jquery-confirm.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../js/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="./../js/AdminLTE/adminlte.min.js"></script>
<script src="./../js/listado/listado.js"></script>
<script src="./../js/chart/Chart.bundle.js"></script>
<script src="./../js/chart/utils.js"></script>
	<script>
		$(document).ready(function(e){
			var config_edad = {
				type: 'pie',
				data: {
					datasets: [{
						data: [
							parseInt(<?php echo $r1?>),
							parseInt(<?php echo $r2?>),
							parseInt(<?php echo $r3?>),
							parseInt(<?php echo $r4?>)
							],
						backgroundColor: [
							window.chartColors.red,
							window.chartColors.orange,
							window.chartColors.yellow,
							window.chartColors.green,
							window.chartColors.blue
						],
						label: 'Dataset 1'
					}],
					labels: [
						document.getElementById("head-edad-1").innerHTML,
						document.getElementById("head-edad-2").innerHTML,
						document.getElementById("head-edad-3").innerHTML,
						document.getElementById("head-edad-4").innerHTML
					]
				},
				options: {
					responsive: true
				}
			};


			var config_genero = {
				type: 'pie',
				data: {
					datasets: [{
						data: [
							parseInt(<?php echo $hombres?>),
							parseInt(<?php echo $mujeres?>)
						],
						backgroundColor: [
							window.chartColors.blue,
							window.chartColors.red
						],
						label: 'Dataset 1'
					}],
					labels: [
						'Hombres',
						'Mujeres'
						]
				},
				options: {
					responsive: true
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('chart-area-edad').getContext('2d');
				window.myPie = new Chart(ctx, config_edad);
				var ctx = document.getElementById('chart-area-genero').getContext('2d');
				window.myPie = new Chart(ctx, config_genero);
			};
		});


	</script>
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
--><body class="hold-transition skin-blue sidebar-mini">
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
        Estad&iacute;sticas
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
			<div class="row">
			<div class="col-xs-12">
			<h3>Edades de los asistentes</h1>
			<div id="canvas-holder expandido">
				<canvas id="chart-area-edad"></canvas>
			</div>
            </div>
            </div>
			<div class="row">
			<div class="col-xs-12">
			<table class="striped responsive-table centered expandido">
				<thead>
					<tr>
						<th class="centrado" id="head-edad-1">Menos de 50 a&ntilde;os</th>
						<th class="centrado" id="head-edad-2">Entre 50 y 60 a&ntilde;os</th>
						<th class="centrado" id="head-edad-3">Entre 60 y 70 a&ntilde;os</th>
						<th class="centrado" id="head-edad-4">M&aacute;s de 70 a&ntilde;os</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="centrado" id="data-edad-1"><?php echo $r1?></td>
						<td class="centrado" id="data-edad-2"><?php echo $r2?></td>
						<td class="centrado" id="data-edad-3"><?php echo $r3?></td>
						<td class="centrado" id="data-edad-4"><?php echo $r4?></td>
					</tr>
					<tr>
						<td colspan="4" class="centrado" id="data-edad-1"><b>Total de asistentes:</b>&nbsp;<?php echo $total?></td>
					</tr>
				</tbody>
			</table>
            </div>
            </div>
			<div class="row">
			<div class="col-xs-12">
			<h3>Genero de los asistentes</h1>
			<div id="canvas-holder expandido">
				<canvas id="chart-area-genero"></canvas>
			</div>
            </div>
            </div>
			<div class="row">
			<div class="col-xs-12">
			<table class="striped responsive-table centered expandido">
				<thead>
					<tr>
						<th class="centrado">Hombres</th>
						<th class="centrado">Mujeres</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="centrado" id="data-genero-H"><?php echo $hombres?></td>
						<td class="centrado" id="data-genero-M"><?php echo $mujeres?></td>
					</tr>
					<tr>
						<td colspan="4" class="centrado" id="data-edad-1"><b>Total de asistentes:</b>&nbsp;<?php echo $total?></td>
					</tr>
				</tbody>
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

?>