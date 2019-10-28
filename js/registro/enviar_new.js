$( document ).ready(function() {
	$("#formNew").submit(function(e){
		e.preventDefault();
		$( ".form-titulo" ).css( "border-color", "#d2d6de" );
		$( ".form-mensaje" ).css( "border-color", "#d2d6de" );
		if($("input#titulo").val()==""){
			$( ".form-titulo" ).css( "border-color", "#ff0000" );
		}
		if($("#mensaje").val()==""){
			$( ".form-mensaje" ).css( "border-color", "#ff0000" );
		}
		if($("input#titulo").val()=="" || $("#mensaje").val()==""){
		}else{
			
			$("#btn-submit").attr("disabled", true);
			$.ajax({
				method:"post",
				url:"./enviarNew2.php",
				data:{titulo:$("input#titulo").val(),
					mensaje:$("#mensaje").val(),
					rfc: $("input#rfc").val()},
				cache:false,
				success:function(resp){
					if(resp !=0){
						$.alert({
							title:".",
							content:"Enviado",
							type:"green",
							onDestroy:function(){
								$("#btn-submit").attr("disabled", false);
							}
						});
					}else{
						$.alert({
							title:".",
							content:"Se presentó un error. Favor de intentarlo nuevamente",
							type:"red",
							onDestroy:function(){
								$("#btn-submit").attr("disabled", false);
							}
						});
					}
				}
			});
		}
	
	});
	
	$("select#sexo").on("change",function(){
		if($('#sexo').prop('selected', true).val()=='Hombre'){
			$("i#icon_sexo").attr('class', 'fa fa-male');
		}else{
			$("i#icon_sexo").attr('class', 'fa fa-female');
		}
	});
	//$( ".form-recon" ).css( "border-color", "#ff0000" );
});