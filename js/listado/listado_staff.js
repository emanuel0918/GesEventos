$(document).ready(function(){
	$(".ver").on("click",function(){
		var usr = $(this).attr("data-staff");
		$.ajax({
			method:"post",
			url:"verStaff.php",
			data:{usr:usr},
			cache:false,
			success:function(resp){
				var usuario = JSON.parse(resp);
				admin="";
				if(usuario.privilegio=='0'){
					admin="<h5>Administrador</h5>";
				}else{
					admin="<h5>Usuario Est&aacute;ndar</h5>";
				}
				var html = "<h4><i class='fa fa-user'></i> "
				+usuario.usuario+"</h4><br><h5>"+usuario.nombre
				+"</h5><br><h5>"+admin+"</h5>";
				$.alert({
					title:"Staff",
					content:html
				});
			}
		});
	});
});