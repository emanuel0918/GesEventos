<?php
    session_start();
    include("./configBD.php");
    include("./sesionUsuario.php");
    if(isset($_SESSION["usuario"])){
		$sesion=new SesionUsuario();
		$usuario=$_SESSION["usuario"];
		if($sesion->tipoUsuario($usuario)==0){
			$rfc=$_GET["gal"];
			$menu=$sesion->menuHTML($usuario);
			$html_escuelas='';
			$html_reconocimientos='';
			$reconocimientosGalaradonado=array();
			$escuelaGalardonado;
			
			$sqlVerGalardonado ="select * from galardonado where rfc='".$rfc."';";
			$resVerGalardonado= mysqli_query($conexion, $sqlVerGalardonado);
			$galardonado = mysqli_fetch_assoc($resVerGalardonado);
			
			$sqlGetReconGalardonado = "select * from vw_Reconocimientos where rfc='".$rfc."';";
			$resGetReconGalardonado = mysqli_query($conexion,$sqlGetReconGalardonado);
			while($reconsGalardonado = mysqli_fetch_assoc($resGetReconGalardonado)){
				array_push($reconocimientosGalaradonado,$reconsGalardonado["reconocimiento"]);
				$html_reconocimientos.='<label class="option-checkbox" for="'.$recons[1].'">'
					.'<input class="checkbox_" value="'.$recons[1].'" type="checkbox" checked/>'.$recons[1].'</label>';
			}
			
			$sqlGetRecon = "select * from reconocimiento;";
			$resGetRecon = mysqli_query($conexion,$sqlGetRecon);
			while($recons = mysqli_fetch_array($resGetRecon,MYSQLI_BOTH)){
				if(!in_array($recons[1],$reconocimientosGalaradonado)){
					$html_reconocimientos.='<label class="option-checkbox" for="'.$recons[1].'">'
						.'<input class="checkbox_" value="'.$recons[1].'" type="checkbox"/>'.$recons[1].'</label>';
				}
			}
			
			$sqlGetEscuelaGalardonado = "select * from escuela as e inner join galardonado as g"
			." where g.idescuela=e.idescuela and rfc='".$rfc."';";
			$resGetEscuelaGalardonado = mysqli_query($conexion,$sqlGetEscuelaGalardonado);
			while($escGalardonado = mysqli_fetch_assoc($resGetEscuelaGalardonado)){
				$html_escuelas.='<option value="'.$escGalardonado["escuela"]
				.'">'.$escGalardonado["escuela"].'</option>';
			}
			
			$sqlGetEscuela = "select * from escuela;";
			$resGetEscuela = mysqli_query($conexion,$sqlGetEscuela);
			while($escuelas = mysqli_fetch_array($resGetEscuela,MYSQLI_BOTH)){
				if($escuelaGalardonado!=$escuelas[1]){
					$html_escuelas.='<option value="'.$escuelas[1]
					.'">'.$escuelas[1].'</option>';
				}
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
<title>Editar Galardonado</title>
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
<link href="./../css/registro/eGalardonado.css" rel="stylesheet">
<script src="./../js/jquery/dist/jquery.min.js"></script>
<script src="./../js/confirm330/js/jquery-confirm.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../js/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="./../js/AdminLTE/adminlte.min.js"></script>
<script src="./../js/registro/eGalardonado.js"></script>
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
        Editar Galardonado
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
			  <h3>Datos del galardonado</h3>
              <div class="row">
              <div class="col-xs-12 col-md-4">
			  <h4>Nombre</h4>
              <div class="input-group">
                <span class="input-group-addon form-galardonado"><i class="fa fa-graduation-cap"></i></span>
                <input type="text" class="form-control form-galardonado" placeholder="Nombre" id="galardonado" name="galardonado" value="<?php echo $galardonado["nombre"];?>">
              </div>
              </div>
              <div class="col-xs-12 col-md-4">
			  <h4>Primer Apellido</h4>
              <div class="input-group">
                <span class="input-group-addon form-primerApe"><i class="fa fa-graduation-cap"></i></span>
                <input type="text" class="form-control form-primerApe" placeholder="Apellido" id="primerApe" name="primerApe" value="<?php echo $galardonado["primer_apellido"];?>">
              </div>
              </div>
              <div class="col-xs-12 col-md-4">
			  <h4>Segundo Apellido</h4>
              <div class="input-group">
                <span class="input-group-addon form-segundoApe"><i class="fa fa-graduation-cap"></i></span>
                <input type="text" class="form-control form-segundoApe" placeholder="Apellido" id="segundoApe" name="segundoApe" value="<?php echo $galardonado["segundo_apellido"];?>">
              </div>
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12 col-md-6">
              <h4>Sexo</h4>
				<div class="input-group">
                <span class="input-group-addon form-sexo"><i id="icon_sexo" class="fa fa-male"></i></span>
				  <select class="form-control form-sexo" name="sexo" id="sexo">
					<?php 
						if(intval($galardonado["sexo"])==0){
					?>
					<option>Hombre</option>
					<option>Mujer</option>
					
					<?php
						}else{
					?>
					<option>Mujer</option>
					<option>Hombre</option>
					
					<?php
						}
					?>
				  </select>
				</div>
              </div>
              <div class="col-xs-12 col-md-6">
              <h4>Discapacidades</h4>
				<div class="input-group">
                <span class="input-group-addon form-discapacidad"><i class="fa fa-wheelchair"></i></span>
				  <select class="form-control form-discapacidad" name="discapacidad" id="discapacidad">
					<?php 
						if(intval($galardonado["discapacidad"])==0){
					?>
					<option>No</option>
					<option>Si</option>
					
					<?php
						}else{
					?>
					<option>Si</option>
					<option>No</option>
					
					<?php
						}
					?>
				  </select>
				</div>
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12 col-md-6">
			  <h4>Direcci&oacute;n Correo Elctor&oacute;nico</h4>
              <div class="input-group">
                <span class="input-group-addon form-correo"><i class="fa fa-envelope"></i></span>
                <input type="text" class="form-control form-correo" placeholder="ejemplo@email.com" id="correo" name="correo" value="<?php echo $galardonado["correo"];?>">
              </div>
              </div>
              <div class="col-xs-12 col-md-6">
              <h4>Tel&eacute;fono</h4>
              <div class="input-group">
                <span class="input-group-addon form-tel"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control form-tel" placeholder="+(52) 0123456789" id="tel" name="tel" maxlength="13" value="<?php echo $galardonado["telefono"];?>">
              </div>
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12">
              <h4>Observaciones</h4>
				<div class="md-form">
				  <textarea type="text" class="md-textarea form-control" id="observaciones" name="observaciones">
					<?php echo $galardonado["observaciones"];?>
				  </textarea>
				</div>
			  </textarea>
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
				<div class="input-group expandido">
				  <div class="multiselect">
					<div class="selectBox">
					  <select class="select-checkbox-fixed">
						<option>Seleccionar Opci&oacute;n</option>
					  </select>
					  <div class="overSelect"></div>
					</div>
					<div id="checkboxes">
						<?php echo $html_reconocimientos;?>
					</div>
				  </div>
				</div>
              </div>
              </div>
			  <br>
              <div class="input-group btn-expand" >
                <input id="btn-submit" type="submit" class="btn btn-primary btn-expand" value="Actualizar"  >
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