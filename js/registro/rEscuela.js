$( document ).ready(function() {
	$("#formEscuela").submit(function(e){
		e.preventDefault();
		$( ".form-escuela" ).css( "border-color", "#d2d6de" );
		if($("input#escuela").val()==""){
			$( ".form-escuela" ).css( "border-color", "#ff0000" );
		}
		if($("input#escuela").val()==""){
		}else{
			
			$("#btn-submit").attr("disabled", true);
			$.ajax({
				method:"post",
				url:"./altaEscuela2.php",
				data:{escuela:$("input#escuela").val()},
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
							content:"Ya exise el registro",
							type:"red",
							onDestroy:function(){
								$("#btn-submit").attr("disabled", false);
							}
						});
					}
					//location.reload();
				}
			});
		}
	});
	//$( ".form-recon" ).css( "border-color", "#ff0000" );
});