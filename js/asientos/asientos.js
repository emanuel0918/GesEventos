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