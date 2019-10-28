$(document).ready(function(){

    $("#formLogin").submit(function(e){
            e.preventDefault();
            $("#login-submit").attr("disabled", true);
            $("#gifLoad").show();
            $.ajax({
                method:"post",
                url:"./php/login.php",
                data:$("#formLogin").serialize(),
                cache:false,
                success:function(resp){
                    $("#gifLoad").hide();
                    if(resp == 1){
                        $.alert({
                            title:".",
                            content:"Bienvenido!!!",
                            type:"green",
                            onDestroy:function(){
                                $(location).attr("href", "./php/altaGalardonado.php")
                            }
                        });
                    }else{
                        $.alert({
                            title:".",
                            content:"Usuario o contrase&ntilde;a incorrectos",
                            type:"red",
                            onDestroy:function(){
                                $("#login-submit").attr("disabled", false);
                            }
                        });
                    }
                }
            });
        });
});