$( document ).ready(function() {
	$(".borrar").on("click",function(){
		data_rec=$(this).attr("data-recon");
		$.confirm({
			title:"¿Est&aacute; seguro de eliminar este reconocimiento?",
			content:"Se borrar&aacute;n todos los galardonados asociados a este reconocimiento",
			type:"red",
			buttons:{
				Si:function(){
					$.ajax({
						method:"post",
						url:"./borrarReconocimiento2.php",
						data:{recon:data_rec},
						cache:false,
						success:function(resp){
						}
					});
					location.reload();
				},
				No:function(){
					
				}
			}
		});
	});
});