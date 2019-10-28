$(document).ready(function(){
	$(".pasarLista").on("click",function(){
		var rfc = $(this).attr("data-rfc");
		if(rfc!=''){
			$.ajax({
				method:"post",
				url:"pasarLista2.php",
				data:{rfc:rfc},
				cache:false,
				success:function(resp){
					$.alert({
						title:"Se pas&oacute; lista exitosamente",
						content:"",
						onDestroy: function () {
							location.reload();
						}
					})
				}
			});
			//location.reload();
		}
	});
});