<?php
    session_start();
    include("./configBD.php");
    include("./sesionUsuario.php");
    include("./crearAuditorio.php");
	if(isset($_SESSION["usuario"])){
		$sesion=new SesionUsuario();
		$usuario=$_SESSION["usuario"];
		$menu=$sesion->menuHTML($usuario);
		$auditorio=new CrearAuditorio();
		$html_filas='';
		$html_asientos='';
		$html_json='\'{"Areas":[{"ColumnCount":'.$auditorio->anchoAuditorio.',"Rows":[';
		$n_filas=0;
		$n_asientos=0;
		$i_fila=0;
		$i_asiento=0;
		$index_img=0;
        $sqlGetFilas = "select * from fila where idauditorio='1';";
        $resGetFilas = mysqli_query($conexion,$sqlGetFilas);
        while($filas = mysqli_fetch_array($resGetFilas,MYSQLI_BOTH)){
			if($i_fila!=0 && $i_fila!=($auditorio->altoAuditorio+1)){
				$html_asientos.='<tr style="line-height: 25px; height: 25px;">';
				$html_filas.='<tr><td style="background-color:white;">'.$filas[1].'</td></tr>';
			}
			if($i_fila!=0){
				$html_json.=',';
				$html_json.='{"Seats":[\'';
			}else{
				$html_json.='{"Seats":[';
			}
			$sqlGetAsientos = "select * from asiento where idfila=".$filas[0];
			$resGetAsientos = mysqli_query($conexion,$sqlGetAsientos);
			while($asientos = mysqli_fetch_assoc($resGetAsientos)) {
				$index_img=0;
				if($i_asiento!=0){
					$html_json.='+\',';
				}
				if($i_fila!=0 && $i_fila!=($auditorio->altoAuditorio+1)){
					if($asientos["ocupado"]==1){
						$index_img=1;
					}else if($asientos["invalido"]==1){
						$index_img=0;
					}
					$html_asientos.='<td>';
					if($asientos["es_asiento"]==1){
						$html_asientos.='<p style="width: 39px; line-height: 25px;">'.$asientos["asiento"]
						.'</p><img src="./../Images/Seating/25/seat_'.$index_img
						.'.png" data-row="'.($filas[0]-1).'" data-col="'.$asientos["asiento"]
						.'" style="width: 38px; height: 25px;">';
					}
					$html_asientos.='</td>';
				}
				$html_json.='{"RowIndex":'.($filas[0]-1	)
				.',"ColumnIndex":'.$asientos["asiento"]
				.',"Priority":0,"Id":"'.($auditorio->anchoAuditorio - $asientos["asiento"])
				.'","Status":'.$asientos["ocupado"].',"OriginalSeatStatus":0,"SeatsInGroup":null}\''. PHP_EOL;
				$i_asiento++;
			}
			if($i_fila!=0 && $i_fila!=($auditorio->altoAuditorio+1)){
				$html_asientos.='</tr>';
			}
			$html_json.='+\']}';
			$i_fila++;
        }
		$html_json.='],"AreaCategoryCode":"0000000001","AreaNumber":1,"HasSofaSeatingEnabled":false}],'
		.'"AreaCategories":{"0000000001":{"AreaCategoryCode":"0000000001","SeatsToAllocate":1,"SeatsNotAllocatedCount":0}}}\'';
	
?>
<html><head><meta http-equiv="X-UA-Compatible" content="IE=8"><title>

</title>
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

<!-- Bootstrap time Picker -->
<link href="./../css/confirm330/css/jquery-confirm.css" rel="stylesheet">
<link href="./../css/asientos/visStyles.css?v4.1" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="chrome-extension://immhpnclomdloikkpcefncmfgjbkojmh/css/emoji.css">
<script src="./../js/jquery/dist/jquery.min.js"></script>
<script src="./../js/confirm330/js/jquery-confirm.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../js/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="./../js/AdminLTE/adminlte.min.js"></script>
<script src="./../js/listado/listado.js"></script>
<link href="./../css/asientos/asientos.css" type="text/css" rel="stylesheet">
</head>
<body style="">
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
        Listado Escuelas
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
	<form name="form1" method="post" action="visSeatingControl.aspx" id="form1">
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwULLTE4NTU0OTc4OTgPZBYCAgMPZBYCAgEPDxYEHgVXaWR0aBsAAAAAAICBQAEAAAAeBF8hU0ICgAIWAh4FY2xhc3MFD1NlYXRpbmctQ29udHJvbGRkFtUc77adprAGDC7d20bjpHj5cEw=">

<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="4C6D3851">
<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEWAgLIjoLJAgKWl7DEAi5w4dXvffXVhAayJ4pyPjrPAtTP">
	<!-- la clase "ticketsSelect" pone las flechitas. Las flechitas andan solo en la pc y no en movil. Sin flechitas anda el scroll
	en el movil y se puede scrollear en la pc solo con la barra de abajo.-->
	<div class="ticketsSelectNO_USAR respon-mov" style="overflow: auto;"><a href="#" class="nav-mov izquierda"><span></span></a><a href="#" class="nav-mov derecha"><span></span></a>
		<div id="objSeatPlan" class="Seating-Control" style="width: 688px;">
	<div style="height: 278px;"><div class="Seating-Screen" style="width: 688px;">
	</div>
	<div class="Seating-Container" style="width: 688px; height: 250px; visibility: visible;">
		<div class="Seating-RowLabelContainer">
			<table cellpadding="0" cellspacing="0" style="top:0%;height:100%;">
				<tbody>
				
				<?php echo $html_filas;  ?>
				
				</tbody></table>
		</div>
		<div class="Seating-Theatre" style="width: 650px; height: 250px;" data-originalsize="250">
			<table id="objSeatPlan_1" class="Seating-Area" data-area-number="1" cellspacing="0" cellpadding="0" style="left:0%;top:0%;width:100%;height:100%;table-layout:fixed;">
				<tbody>
				
				
				<?php echo $html_asientos;?>
				</tbody></table>
	</div><div class="Seating-RowLabelContainer"><table cellpadding="0" cellspacing="0" style="top:0%;height:100%;">
		<tbody>
		
				
				<?php echo $html_filas;?>
		</tbody></table>
	</div></div></div><table class="Seating-Popup" cellpadding="0" cellspacing="0">
		<tbody><tr>
			<td class="Seating-PopupMessage"></td>
		</tr>
	</tbody></table>
	<input type="hidden" name="objSeatPlan:SelectedSeatsHiddenField" id="objSeatPlan_SelectedSeatsHiddenField">
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

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">TeamADOO</a>.</strong> All rights reserved.
  </footer>
</div>
<script type="text/javascript">
var m_theatre = <?php echo $html_json;  ?>;
var m_selectedSeats = [{"AreaCategoryCode":"0000000001","Seats":[{"RowIndex":2,"ColumnIndex":14,"AreaNumber":1}]}];
var m_selectionMode = 'sequential';
var m_validationRules = {"CinemaSofaEnabled":"CinemaSofaEnabled",
"SellSpecialSeats":"SellSpecialSeats",
"MustFillSofa":"No tiene suficientes asientos para reservar para llenar este sofá.",
"AllSeatsInOrderMustBeSelected":"Por favor seleccione el mismo número de asientos que ha solicitado.",
"AllSeatsAllocated":"Tiene seleccionados todos los asientos en su orden. Por favor quite de la selección un asiento para moverlo.",
"InvalidSeatSelected":"Estos asientos no están disponibles",
"InvalidAreaSelected":"Esta área de asientos son no-seleccionables.",
"WheelChairSelected":"Usted ha seleccionado un asiento para persona en silla de ruedas, le solicitamos sea respetado."
+"Puede que no existan asientos en este espacio. Los asientos adyacentes estan designados para un acompañante de la persona en silla ruedas,"
+" de ser requerido se le podrá pedir que se traslade a otro asiento disponible o de no haber cupo en la sala se le devuelva una cortesía de entrada"};
var m_sofaSeatingEnabled = false;
var m_hiddenFieldId = "objSeatPlan_SelectedSeatsHiddenField";
var m_isLayout = true;
</script>
</form>
	<script type="text/javascript" src="./../js/asientos/jquery-1.10.0.min.js"></script>
	<script type="text/javascript" src="./../js/asientos/SeatingControl.js?v4.1"></script>
	
	<script type="text/javascript">
   document.getElementById('objSeatPlan').style.width='688px'
    $(".Seating-Screen").width(688);
     $(".Seating-Container").width(688);
     $(".Seating-Theatre").width(650);
    
    


	    var iframeLoaded = false;

	    $(function () {
	        checkSeatingLoaded();
	        initZoomButtons();
	    });

	    function initZoomButtons() {
	        // TODO: Conditionally hide / show the zoom buttons?

	        var btnZoomIn = parent.document.getElementById('ibtnShowMySeats'),
                btnZoomOut = parent.document.getElementById('ibtnShowAllSeats');

	        //btnZoomIn.style.display = 'none';
	        //btnZoomOut.style.display = 'none';
	    }

	    function checkSeatingLoaded() {
	        try {
	            if (seatingLoaded) {
	                if (parent.IFrameLoaded) {
	                    parent.IFrameLoaded();
	                    iframeLoaded = true;
	                }
	            }
	        }
            catch (e) { }
            finally {
                if (!iframeLoaded) {
                    setTimeout(checkSeatingLoaded, 200);
                }
	        }
	    }
	</script>
	<script type="text/javascript" src="./../js/asientos/jquery.kinetic.min.js"></script>
	<script type="text/javascript">
		/* Selección de asientos */
    		var $contentAsientos= $('.pasosCompra').width()-40;
    		$('.ticketsSelect').css("width", $contentAsientos);
    		$('.ticketsSelect').kinetic();
	</script>
	
	<script type="text/javascript" src="./../js/asientos/asientos-movil.js"></script>


</body></html>
<?php
}else{
    header("location:./../");
}
?>
	