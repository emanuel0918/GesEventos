$( document ).ready(function() {
	$("#formGAL").submit(function(e){
		e.preventDefault();
		$( ".form-recon" ).css( "border-color", "#d2d6de" );
		$( ".form-escuela" ).css( "border-color", "#d2d6de" );
		$( ".form-rfc" ).css( "border-color", "#d2d6de" );
		$( ".form-sexo" ).css( "border-color", "#d2d6de" );
		$( ".form-discapacidad" ).css( "border-color", "#d2d6de" );
		$( ".form-galardonado" ).css( "border-color", "#d2d6de" );
		$( ".form-primerApe" ).css( "border-color", "#d2d6de" );
		$( ".form-segundoApe" ).css( "border-color", "#d2d6de" );
		$.ajax({
			method:"post",
			url:"./validacion.php",
			data: {tabla:"escuela", row:"escuela",
				valor:$('#escuela').prop('selected', true).val()},
			cache:false,
			success:function(resp){
				if(resp==1){
				}else{
					$( ".form-escuela" ).css( "border-color", "#ff0000" );
				}
			}
		});
		$.ajax({
			method:"post",
			url:"./validacion.php",
			data: {tabla:"reconocimiento", row:"reconocimiento",
				valor:$('#recon').prop('selected', true).val()},
			cache:false,
			success:function(resp){
				if(resp==1){
				}else{
					$( ".form-recon" ).css( "border-color", "#ff0000" );
				}
			}
		});
		if($('#sexo').prop('selected', true).val()!='Hombre' && $('#sexo').prop('selected', true).val()!='Mujer'){
			$( ".form-sexo" ).css( "border-color", "#ff0000" );
		}
		if($('#discapacidad').prop('selected', true).val()!='Si' && $('#discapacidad').prop('selected', true).val()!='No'){
			$( ".form-discapacidad" ).css( "border-color", "#ff0000" );
		}
		if($("input#galardonado").val()==""){
			$( ".form-galardonado" ).css( "border-color", "#ff0000" );
		}
		if($("input#rfc").val()==""){
			$( ".form-rfc" ).css( "border-color", "#ff0000" );
		}else{
		$.ajax({
			method:"post",
			url:"./validar_rfc.php",
			data:{rfc:$("input#rfc").val()},
			cache:false,
			success:function(resp){
				if(resp==1){
				}else{
					$( ".form-rfc" ).css( "border-color", "#ff0000" );
				}
			}
		});
		}
		if($("input#primerApe").val()==""){
			$( ".form-primerApe" ).css( "border-color", "#ff0000" );
		}
		if($("input#segundoApe").val()==""){
			$( ".form-segundoApe" ).css( "border-color", "#ff0000" );
		}
		$.ajax({
			method:"post",
			url:"./validar_rfc.php",
			data:{rfc:$("input#rfc").val()},
			cache:false,
			success:function(resp){
				if(resp==1){
		$.ajax({
			method:"post",
			url:"./validacion.php",
			data: {tabla:"reconocimiento", row:"reconocimiento",
				valor:$('#recon').prop('selected', true).val()},
			cache:false,
			success:function(resp){
				if(resp==1){
					$.ajax({
						method:"post",
						url:"./validacion.php",
						data: {tabla:"escuela", row:"escuela",
							valor:$('#escuela').prop('selected', true).val()},
						cache:false,
						success:function(resp){
							if(resp==1){
								if($("input#galardonado").val()=="" || $("input#rfc").val()==""
								|| $("input#primerApe").val()=="" || $("input#segundoApe").val()==""
								|| ($('#sexo').prop('selected', true).val()!='Hombre' && $('#sexo').prop('selected', true).val()!='Mujer')
								|| ($('#discapacidad').prop('selected', true).val()!='Si' && $('#discapacidad').prop('selected', true).val()!='No')){
								}else{
									
									$("#btn-submit").attr("disabled", true);
									$.ajax({
										method:"post",
										url:"./altaGalardonado2.php",
										data:{nombre:$("input#galardonado").val(),
											primerApe:$("input#primerApe").val(),
											segundoApe:$("input#segundoApe").val(),
											correo:$("input#correo").val(),
											tel:$("input#tel").val(),
											sexo:$('#sexo').prop('selected', true).val(),
											discapacidad:$("input#discapacidad").val(),
											observaciones:$("#observaciones").val(),
											rfc: $("input#rfc").val(),
											escuela:$('#escuela').prop('selected', true).val(),
											recon:$('#recon').prop('selected', true).val()},
										cache:false,
										success:function(resp){
											if(resp !=0){
												$.alert({
													title:".",
													content:"Agregado",
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
							}
						}
					});
				}
			}
		});
				}else{
												$.alert({
													title:".",
													content:"RFC No v&aacute;lido",
													type:"red",
													onDestroy:function(){
														$("#btn-submit").attr("disabled", false);
													}
												});
				
				}
			}
			});
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
