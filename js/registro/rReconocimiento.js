$( document ).ready(function() {
	$("#formRecon").submit(function(e){
		e.preventDefault();
		$( ".form-recon" ).css( "border-color", "#d2d6de" );
		if($("input#recon").val()==""){
			$( ".form-recon" ).css( "border-color", "#ff0000" );
		}
		if($("input#recon").val()==""){
		}else{
			
			$("#btn-submit").attr("disabled", true);
			$.ajax({
				method:"post",
				url:"./altaReconocimiento2.php",
				data:{recon:$("input#recon").val()},
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