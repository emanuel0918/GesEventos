$( document ).ready(function() {
	$(".borrar").on("click",function(){
		data_rfc=$(this).attr("data-rfc");
		$.confirm({
			title:".",
			content:"¿Est&aacute; seguro de eliminar este registro?",
			type:"red",
			buttons:{
				Si:function(){
					$.ajax({
						method:"post",
						url:"./borrarGalardonado2.php",
						data:{rfc:data_rfc},
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