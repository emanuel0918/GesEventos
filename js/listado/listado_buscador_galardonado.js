$(document).ready(function(){
$(document).ready(function(){
	$(".ver").on("click",function(){
		var rfc = $(this).attr("data-rfc");
		if(rfc!=''){
			$.ajax({
				method:"post",
				url:"verGalardonado.php",
				data:{rfc:rfc},
				cache:false,
				success:function(resp){
					var galardonado = JSON.parse(resp);
					disc_html="";
					if(galardonado.discapacidad=='1'){
						disc_html="<i class='fa fa-wheelchair'></i> Si";
					}
					var html = "<h4><i class='fa fa-graduation-cap'></i> "
					+galardonado.nombre+" "
					+galardonado.primer_apellido+" "+galardonado.segundo_apellido
					+"</h4><br><h5><i class='fa fa-university'></i> "
					+galardonado.escuela+"</h5><br><h5><i class='fa fa-award'></i> "
					+galardonado.reconocimiento+"</h5><br>Observaciones:<br><h6>"
					+galardonado.observaciones+"</h6><br><h5>"+disc_html+"</h5>";
					$.alert({
						title:"Galardonado",
						content:html
					});
				}
			});
		}
	});
});
	var jsonRespuestaMostrarMas;
	$("tr#mostrar_mas").on("click", function(){
		$.ajax({
			method:"post",
			url:"./multiConsultaGalardonado.php",
			cache:false,
			success:function(resp){
				try {
					jsonRespuestaMostrarMas=JSON.parse(resp);
					if(jsonRespuestaMostrarMas.mostrarBotonMostrarMas==0){
						$("tr#mostrar_mas").remove();
					}
					$("#filas_galardonado").append(
						jsonRespuestaMostrarMas.filasGalardonado);
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
		$('#tabla_galardonado tr').each(function() {
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
		$('#tabla_galardonado tr').each(function() {
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
		$('#tabla_galardonado tr').each(function() {
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