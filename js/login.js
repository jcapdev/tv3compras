// JavaScript Document
$(document).ready(function(){	
	$("#btnIngresar").click(function(){
		if($("#email").val()!="" && $("#password").val()!=""){
			$.get("controles/ctrl_login.php",
			{
				"operacion":"accesar",
				"email":$("#email").val(),
				"password":$("#password").val()
			},
			function(dato){
				if(dato==""){
					var url = "principal.php";
					$(location).attr('href',url);
				}
				else{
					alert(dato);
				}
			});	
		}
		else
			alert("Datos incompletos");
	});
})