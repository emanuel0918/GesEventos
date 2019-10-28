$( document ).ready(function() {
	$("#formStaff").submit(function(e){
		e.preventDefault();
		$( ".form-nombre" ).css( "border-color", "#d2d6de" );
		$( ".form-contra1" ).css( "border-color", "#d2d6de" );
		$( ".form-contra2" ).css( "border-color", "#d2d6de" );
		$( ".form-usuario" ).css( "border-color", "#d2d6de" );
		$( ".form-privilegio" ).css( "border-color", "#d2d6de" );
		$( ".form-correo" ).css( "border-color", "#d2d6de" );
		$.ajax({
			method:"post",
			url:"./validar_iguales.php",
			data: {contra1:$("input#contra1").val(), contra2:$("input#contra2").val()},
			cache:false,
			success:function(resp){
				if(resp==1){
				}else{
					$( ".form-contra1" ).css( "border-color", "#ff0000" );
					$( ".form-contra2" ).css( "border-color", "#ff0000" );
					$("#contraMal").show();
					$.alert({
						title:"Las contrase&ntilde;as no son iguales",
						content:"",
						type:"red"
					});
				}
			}
		});
		$.ajax({
			method:"post",
			url:"./validacion.php",
			data: {tabla:"staff", row:"usuario",
				valor:$("input#usuario").val()},
			cache:false,
			success:function(resp){
				if(resp==1){
					$.alert({
						title:"El usuario ya existe",
						content:"",
						type:"red"
					});
						$( ".form-usuario" ).css( "border-color", "#ff0000" );
				}else{
				}
			}
		});
		if($("input#nombre").val()==""){
			$( ".form-nombre" ).css( "border-color", "#ff0000" );
		}
		if($("input#usuario").val()==""){
			$( ".form-usuario" ).css( "border-color", "#ff0000" );
		}
		if($("input#contra1").val()==""){
			$( ".form-contra1" ).css( "border-color", "#ff0000" );
		}
		if($("input#contra2").val()==""){
			$( ".form-contra2" ).css( "border-color", "#ff0000" );
		}
		if($("input#correo").val()==""){
			$( ".form-correo" ).css( "border-color", "#ff0000" );
		}else{
		$.ajax({
			method:"post",
			url:"./validar_correo.php",
			data: {correo:$("input#correo").val()},
			cache:false,
			success:function(resp){
				if(resp==0){
				}else{
					$.alert({
						title:"El correo no es v&aacute;lido",
						content:"",
						type:"red"
					});
					$( ".form-correo" ).css( "border-color", "#ff0000" );
				}
			}
		});
		}
		if($('#privilegio').prop('selected', true).val()!='Admin' && $('#privilegio').prop('selected', true).val()!='Usuario Estándar'){
			$( ".form-privilegio" ).css( "border-color", "#ff0000" );
		}
		$.ajax({
			method:"post",
			url:"./validacion.php",
			data: {tabla:"staff", row:"usuario",
				valor:$("input#usuario").val()},
			cache:false,
			success:function(resp){
				if(resp!=1){
					$.ajax({
						method:"post",
						url:"./validar_iguales.php",
						data: {contra1:$("input#contra1").val(), contra2:$("input#contra2").val()},
						cache:false,
						success:function(resp){
							if(resp==1){
								if($("input#nombre").val()=="" || $("input#usuario").val()==""
								|| $("input#contra1").val()=="" || $("input#contra2").val()==""
								|| $("input#correo").val()=="" 
								|| ($('#privilegio').prop('selected', true).val()!='Admin' 
								&& $('#privilegio').prop('selected', true).val()!='Usuario Estándar')){
								}else{
									
									$.ajax({
										method:"post",
										url:"./validar_correo.php",
										data: {correo:$("input#correo").val()},
										cache:false,
										success:function(resp){
											if(resp==0){
												$("#btn-submit").attr("disabled", true);
												$.ajax({
													method:"post",
													url:"./altaStaff2.php",
													data:{nombre:$("input#nombre").val(),
														usuario:$("input#usuario").val(),
														privilegio:$('#privilegio').prop('selected', true).val(),
														correo:$("input#correo").val(),
														tel:$("input#tel").val(),
														contra:$("input#contra1").val()},
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
									});
									
									
								}
							}
						}
					});
				}
			}
		});
	});
});