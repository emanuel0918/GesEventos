<?php

class SesionUsuario
{
	#menuHtml
	var $menu;
	var $tipoUsr;
	var $valido;
	
    function __construct(){
		$this->menu='';
		$this->tipoUsr=0;
		$this->valido=0;
    }
	
	function menuHTML($usuario){
		include("./configBD.php");
		$hayAsistencia=0;
		include("./configBD.php");
		$sqlVerAsistencia = "select count(*) as 'asistencia' from asistencia where asistencia=1;";
		$resVerAsistencia = mysqli_query($conexion,$sqlVerAsistencia);
		$hayAsistencia=0;
		while($asistencia = mysqli_fetch_assoc($resVerAsistencia)){
			$hayAsistencia=intval($asistencia["asistencia"]);
		}
		$sqlGetTipoUsr = "select f_tipoUsuario('".$usuario."') as 'tipo';";
		$resGetTipoUsr = mysqli_query($conexion,$sqlGetTipoUsr);
		while($usr = mysqli_fetch_assoc($resGetTipoUsr)) {
			$this->tipoUsr=intval($usr["tipo"]);
			$this->valido=1;
		}
		if($this->tipoUsr>=0 && $this->tipoUsr<=2){
			switch($this->tipoUsr){
				case 0:
					$this->menu='
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">


      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <li class="treeview">
          <a href="/">
            <i class="fa fa-user"></i>
            <span>Staff</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./listadoStaff.php"><i class="fa fa-list"></i> Staff</a></li>';
		if($hayAsistencia==0){
							$this->menu.='<li><a href="./altaStaff.php"><i class="fa fa-plus"></i> Nuevo registro</a></li>
				<li><a href="./editarStaff.php"><i class="fa fa-pencil-alt"></i> Editar Staff</a></li>';

		}
          $this->menu.='</ul>
        </li>
        <li class="treeview">
          <a href="/">
            <i class="fa fa-graduation-cap"></i>
            <span>Galardonado</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./listadoGalardonados.php"><i class="fa fa-list"></i> Lista de galardonados</a></li>';
			
		if($hayAsistencia==0){
            $this->menu.='<li><a href="./altaGalardonado.php"><i class="fa fa-plus"></i> Nuevo Galardonado</a></li>
            <li><a href="./enviarNew.php"><i class="fa fa-envelope"></i> Enviar New</a></li>
            <li><a href="./pasarLista.php"><i class="fa fa-check"></i> Pasar Lista Manualmente</a></li>
            <li><a href="./altaGalardonadoFile.php"><i class="fa fa-file-excel-o"></i> Importar Archvio</a></li>
            <li><a href="./altaGalardonadoFile2.php"><i class="fa fa-file-excel-o"></i> Importar Archvio/Escuela/Correo</a></li>
            <li><a href="./editarGalardonado1.php"><i class="fa fa-pencil-alt"></i> Editar Galardonado</a></li>
            <li><a href="./borrarGalardonado1.php"><i class="fa fa-trash"></i> Eliminar Galardonado</a></li>';
		}
          $this->menu.='</ul>
        </li>
        <li class="treeview">
          <a href="/">
            <i class="fa fa-university"></i>
            <span>Escuela</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./listadoEscuelas.php"><i class="fa fa-list"></i> Listado de Escuelas</a></li>
            <li><a href="./altaEscuela.php"><i class="fa fa-plus"></i> Nueva Escuela</a></li>
            <li><a href="./altaEscuelaFile.php"><i class="fa fa-file-excel-o"></i> Importar Archvio</a></li>
            <li><a href="./borrarEscuela1.php"><i class="fa fa-trash"></i> Eliminar Escuela</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="/">
            <i class="fa fa-award"></i>
            <span>Reconocimiento</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./listadoReconocimientos.php"><i class="fa fa-list"></i> Listado de Reconocimientos</a></li>
            <li><a href="./altaReconocimiento.php"><i class="fa fa-plus"></i> Nuevo Reconocimiento</a></li>
            <li><a href="./altaReconocimientoFile.php"><i class="fa fa-file-excel-o"></i> Importar Archvio</a></li>
            <li><a href="./borrarReconocimiento1.php"><i class="fa fa-trash"></i> Eliminar Reconocimiento</a></li>
          </ul>
        </li>
        <li class="">
          <a href="./auditorio.php">
            <i class="fas fa-ticket-alt"></i>
            &nbsp;<span>Consultar el auditorio</span>
          </a>
        </li>
        <li class="">
          <a href="./listadoAsistencia.php">
            <i class="fas fa-check"></i>
            &nbsp;<span>Listado de Asistencia</span>
          </a>
        </li>
        <li class="">
          <a href="./estadisticas.php">
            <i class="fas fa-chart-pie"></i>
            &nbsp;<span>Estad&iacute;sticas</span>
          </a>
        </li>
        <li class="">
          <a href="./maestroCeremonia.php">
            <i class="fas fa-file-pdf-o"></i>
            &nbsp;<span>Maestro de Ceremon&iacute;as</span>
          </a>
        </li>
        <li class="">
          <a href="./logout.php">
            <i class="fas fa-sign-out-alt"></i>
            &nbsp;<span>Cerrar Sesi&oacute;n</span>
          </a>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>';
					$this->valido=0;
					break;
				default:
					$this->menu='
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">


      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <li class="treeview">
          <a href="/">
            <i class="fa fa-user"></i>
            <span>Staff</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./listadoStaff.php"><i class="fa fa-list"></i> Staff</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="/">
            <i class="fa fa-graduation-cap"></i>
            <span>Galardonado</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./listadoGalardonados.php"><i class="fa fa-list"></i> Lista de galardonados</a></li>
            <li><a href="./enviarNew.php"><i class="fa fa-envelope"></i> Enviar New</a></li>
            <li><a href="./pasarLista.php"><i class="fa fa-check"></i> Pasar Lista Manualmente</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="/">
            <i class="fa fa-university"></i>
            <span>Escuela</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./listadoEscuelas.php"><i class="fa fa-list"></i> Listado de Escuelas</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="/">
            <i class="fa fa-award"></i>
            <span>Reconocimiento</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./listadoReconocimientos.php"><i class="fa fa-list"></i> Listado de Reconocimientos</a></li>
          </ul>
        </li>
        <li class="">
          <a href="./auditorio.php">
            <i class="fas fa-ticket-alt"></i>
            &nbsp;<span>Consultar el auditorio</span>
          </a>
        </li>
        <li class="">
          <a href="./listadoAsistencia.php">
            <i class="fas fa-check"></i>
            &nbsp;<span>Listado de Asistencia</span>
          </a>
        </li>
        <li class="">
          <a href="./estadisticas.php">
            <i class="fas fa-chart-pie"></i>
            &nbsp;<span>Estad&iacute;sticas</span>
          </a>
        </li>
        <li class="">
          <a href="./maestroCeremonia.php">
            <i class="fas fa-file-pdf-o"></i>
            &nbsp;<span>Maestro de Ceremon&iacute;as</span>
          </a>
        </li>
        <li class="">
          <a href="./logout.php">
            <i class="fas fa-sign-out-alt"></i>
            &nbsp;<span>Cerrar Sesi&oacute;n</span>
          </a>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>';
					$this->valido=0;
					break;
			}
		}else{
			$this->menu='';
			$this->valido=0;
		}
		return $this->menu;
	}
	
	function esValido($usuario){
		include("./configBD.php");
		$this->valido=0;
		$sqlGetUsr = "select * from staff where usuario='".$usuario."';";
		$resGetUsr = mysqli_query($conexion,$sqlGetUsr);
		while($usr = mysqli_fetch_assoc($resGetUsr)) {
			$this->valido=1;
		}
		return $this->valido;
	}
	
	function tipoUsuario($usuario){
		include("./configBD.php");
		$this->tipoUsr=0;
		$sqlGetTipoUsr = "select f_tipoUsuario('".$usuario."') as 'tipo';";
		$resGetUsr = mysqli_query($conexion,$sqlGetTipoUsr);
		while($usr = mysqli_fetch_assoc($resGetUsr)) {
			$this->tipoUsr=intval($usr["tipo"]);
			$this->valido=1;
		}
		return $this->tipoUsr;
	}
}
?>