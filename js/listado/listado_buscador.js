$(document).ready(function(){
	$(".ver").on("click",function(){
		var staff = $(this).attr("data-staff");
		var usuario = $(this).attr("data-usr");
		var hora = $(this).attr("data-hora");
			$.alert({
				title:".",
				type:"green",
				content:"Nombre: "+staff+"<br>Usuario: "+usuario+"<br>Hora: "+hora
			});
	});
	var jsonRespuestaMostrarMas;
	$("tr#mostrar_mas").on("click", function(){
		$.ajax({
			method:"post",
			url:"./multiConsulta_AX.php",
			cache:false,
			success:function(resp){
				try {
					jsonRespuestaMostrarMas=JSON.parse(resp);
					if(jsonRespuestaMostrarMas.mostrarBotonMostrarMas==0){
						$("tr#mostrar_mas").remove();
					}
					$("#filas_asistencia").append(
						jsonRespuestaMostrarMas.filasAsistencia);
				} catch (jsonError) {
				}
				$("head script").each(function(){
					var oldScript = this.getAttribute("src");
					$(this).remove();
					var newScript;
					newScript = document.createElement('script');
					newScript.type = 'text/javascript';
					newScript.src = oldScript;
					document.getElementsByTagName("head")[0].appendChild(newScript);
				});
				//$.loadScript('./../js/prohibida.js');
				
				//$("#load").click(function(){
				//	$.getScript('./../js/prohibida.js', function() {
				//	});
				//});
				
				//$("head script").each(function(){
				//	var oldScript = this.getAttribute("src");
				//	$(this).remove();
				//	var newScript;
				//	newScript = document.createElement('script');
				//	newScript.type = 'text/javascript';
				//	newScript.src = oldScript;
				//	document.getElementsByTagName("head")[0].appendChild(newScript);
				//});
			}
		});
		
	});
	$("input#buscador_1").on("keyup", function(){
		query=$("input#buscador_1").val();
		if(query==""){
			$("#boton_mostrar_mas").show();
		}else{
			$("#boton_mostrar_mas").hide();
		}
		n=0;
		$('#tabla_asistencia tr').each(function() {
			n++;
		});
		n-=2;
		if(!$('tr#mostrar_mas').length){
			n++;
		}
		for(i=0;i<n;i++){
			$("tr#r-"+i).show();
		}
		for(i=0;i<n;i++){
			if(!$("td#r-"+i+"-1").html().toLowerCase().includes(query.toLowerCase())){
				$("tr#r-"+i).hide();
			}
		}
	});
	$("input#buscador_2").on("keyup", function(){
		query=$("input#buscador_2").val();
		if(query==""){
			$("#boton_mostrar_mas").show();
		}else{
			$("#boton_mostrar_mas").hide();
		}
		n=0;
		$('#tabla_asistencia tr').each(function() {
			n++;
		});
		n-=2;
		if(!$('tr#mostrar_mas').length){
			n++;
		}
		for(i=0;i<n;i++){
			$("tr#r-"+i).show();
		}
		for(i=0;i<n;i++){
			if(!$("td#r-"+i+"-2").html().toLowerCase().includes(query.toLowerCase())){
				$("tr#r-"+i).hide();
			}
		}
	});
	$("input#buscador_3").on("keyup", function(){
		query=$("input#buscador_3").val();
		if(query==""){
			$("#boton_mostrar_mas").show();
		}else{
			$("#boton_mostrar_mas").hide();
		}
		n=0;
		$('#tabla_asistencia tr').each(function() {
			n++;
		});
		n-=2;
		if(!$('tr#mostrar_mas').length){
			n++;
		}
		for(i=0;i<n;i++){
			$("tr#r-"+i).show();
		}
		for(i=0;i<n;i++){
			if(!$("td#r-"+i+"-3").html().toLowerCase().includes(query.toLowerCase())){
				$("tr#r-"+i).hide();
			}
		}
	});
});