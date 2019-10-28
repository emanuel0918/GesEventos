$( document ).ready(function() {
	$(".borrar").on("click",function(){
		data_esc=$(this).attr("data-esc");
		$.confirm({
			title:"¿Est&aacute; seguro de eliminar esta escuela?",
			content:"Se borrar&aacute;n todos los galardonados asociados a esta escuela",
			type:"red",
			buttons:{
				Si:function(){
					$.ajax({
						method:"post",
						url:"./borrarEscuela2.php",
						data:{escuela:data_esc},
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