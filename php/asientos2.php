<?php
    session_start();
    include("./configBD.php");
    include("./crearAuditorio.php");
	if(isset($_SESSION["usuario"])){
		//$auditorio=new CrearAuditorio();
		$nombre_auditorio='';
		$sqlGetAuditorio = "select * from auditorio where idauditorio=1;";
		$resGetAuditorio = mysqli_query($conexion,$sqlGetAuditorio);
		while($auditorio = mysqli_fetch_assoc($resGetAuditorio)) {
			$nombre_auditorio=$auditorio["nombre"];
		}
		$altoAuditorio=0;
		$sqlGetAlto = "select count(*) as 'alto' from fila where idauditorio=1;";
		$resGetAlto = mysqli_query($conexion,$sqlGetAlto);
		while($alto = mysqli_fetch_assoc($resGetAlto)) {
			$altoAuditorio=$alto["alto"];
		}
		$anchoAuditorio=0;
		$sqlGetAncho = "select f_anchoAuditorio('".$nombre_auditorio."') as 'ancho';";
		$resGetAncho = mysqli_query($conexion,$sqlGetAncho);
		while($ancho = mysqli_fetch_assoc($resGetAncho)) {
			$anchoAuditorio=$ancho["ancho"];
		}
		$html_filas='';
		$html_asientos='';
		$html_json='\'{"Areas":[{"ColumnCount":'.$anchoAuditorio.',"Rows":[';
		$n_filas=0;
		$n_asientos=0;
		$i_fila=0;
		$i_asiento=0;
		$index_img=0;
        $sqlGetFilas = "select * from fila where idauditorio='1';";
        $resGetFilas = mysqli_query($conexion,$sqlGetFilas);
        while($filas = mysqli_fetch_array($resGetFilas,MYSQLI_BOTH)){
			if($i_fila!=0 && $i_fila!=($altoAuditorio+1)){
				$html_asientos.='<tr style="line-height: 25px; height: 25px;">';
				$html_filas.='<tr><td style="background-color:white;">'.chr(((intval($filas[1]))+63)).'</td></tr>';
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
				if($i_fila!=0 && $i_fila!=($altoAuditorio+1)){
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
				.',"Priority":0,"Id":"'.($anchoAuditorio - $asientos["asiento"])
				.'","Status":'.$asientos["ocupado"].',"OriginalSeatStatus":0,"SeatsInGroup":null}\''. PHP_EOL;
				$i_asiento++;
			}
			if($i_fila!=0 && $i_fila!=($altoAuditorio+1)){
				$html_asientos.='</tr>';
			}
			$html_json.='+\']}';
			$i_fila++;
        }
		$html_json.='],"AreaCategoryCode":"0000000001","AreaNumber":1,"HasSofaSeatingEnabled":false}],'
		.'"AreaCategories":{"0000000001":{"AreaCategoryCode":"0000000001","SeatsToAllocate":1,"SeatsNotAllocatedCount":0}}}\'';
	
	
?>
<html><head><meta http-equiv="X-UA-Compatible" content="IE=8"><title>

</title><link href="./../css/asientos/visStyles.css?v4.1" type="text/css" rel="stylesheet"><link rel="stylesheet" type="text/css" href="chrome-extension://immhpnclomdloikkpcefncmfgjbkojmh/css/emoji.css"></head>
<body style="">
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
	