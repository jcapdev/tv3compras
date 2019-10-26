// JavaScript Document
$(document).ready(function(){	
	var idOrden;
	var fechaHora;
	
	$("#btnConsultarTOrdenes").click(function(){
		consultarTOrdenes();
	});
	
	function consultarTOrdenes(){
		var hconsulta = $("#hContenido");
		$.get("controles/ctrl_principalA.php",
		{
			"operacion":"consultarTOrdenes"
		},
		function(dato){
			hconsulta.html("");
			hconsulta.append(dato);
			$(".btnInfoOrden").on("click", function(){
				var hinfo = $("#hContenido");
				idOrden = $(this).val();
				fechaHora = $(this).closest("tr");
				fechaHora = fechaHora.find("td:eq(3)").text();
				$.get("controles/ctrl_orden.php",
				{
					"operacion":"informacionOrdenA",
					"id":idOrden,
					"fechaHora":fechaHora
				},
				function(dato2){
					hinfo.html("");
					hinfo.append(dato2);
					
					$("#btnActualizarOrden").on("click",function(){
						var tab = $("#hTblArticulosS").tableToJSON();
						tab = {"myrows": tab};	//hace myrows el objeto padre
						tab = JSON.stringify(tab);
						$.get("controles/ctrl_orden.php",{
							"operacion":"actualizarOrdenA",
							"tabla":tab
						},
						function(dato3){
							alert(dato3);
						});
					});		
											
					$("#btnGenerarPDF").on("click",function(){
						$.get("controles/ctrl_PDF.php",{
							"operacion":"generarPDF",
							"idOrden":idOrden,
							"fechaHora":fechaHora
						},
						function(dato3){
							setTimeout(function(){
								window.open(dato3,'PDF','width=800, height=500');
							}, 2000);
						});
					});
					
					
					$("#btnAprobar").on("click", function(){
						var r = confirm("¿Está seguro de aprobar la orden "+idOrden+"?");
						if(r==true){
							$.get("controles/ctrl_orden.php",{
								"operacion":"aprobarOrdenA",
								"idOrden":idOrden,
								"fechaHora":fechaHora
							},
							function(dato3){
								alert(dato3);
								consultarOrdenesDeptos();
							});
						}
						else{}
					});
					
					$("#btnRechazar").on("click",function(){
						var r = confirm("¿Está seguro de rechazar la orden "+idOrden+"?");
						if(r==true){
							$.get("controles/ctrl_orden.php",{
								"operacion":"rechazarOrdenA",
								"idOrden":idOrden
							},
							function(dato3){
								alert(dato3);
								consultarOrdenesDeptos();
							});
						}
						else{}
					});
					
					$("#btnAgregarObservacion").on("click", function(){
						var observaciones = $("#txtObservaciones").val();
						$.get("controles/ctrl_orden.php",{
							"operacion":"agregarObservacionA",
							"txtObservacion": $("#txtObservaciones").val(),
							"idOrden":idOrden
						},
						function(dato4){
							if(dato4!=""){
								var lbObservaciones = $("#lbObservaciones");
								lbObservaciones.append(" "+observaciones+".");		
								$("#txtObservaciones").val("");					
							}
						})
					});

					
					
				});
			});
			//alert ("Presionado");			
		});
	}
	
	
	/************* Método para registrar usuario ************/	
	$("#btnRegistrarU").click(function(){
		registrarU();
	});
	
	function registrarU(){
		var hregistro = $("#hContenido");
		$.get("controles/ctrl_principalA.php",
		{
			"operacion":"registrarU"
		},
		function(dato){
			hregistro.html("");
			hregistro.append(dato);
			
			$("#btnRegistrarUsuario").on("click", function(){
				$.get("controles/ctrl_usuario.php",
				{
					"operacion":"registrarUsuario",
					"txtNombre":$("#txtNombre").val(),
					"txtNumero":$("#txtNumero").val(),
					"txtPass":$("#txtPass").val(),
					"txtCorreo":$("#txtCorreo").val(),
					"selUsuario":$("#selUsuario").val(),
					"selDepartamento":$("#selDepartamento").val(),
					"selActivo":$("#selActivo").val()
				},
				function(dato1){
					if(dato1=="Usuario registrado satisfactoriamente"){
						alert(dato1);
						$("#txtNumero").val()="";
						$("#txtPass").val()="";
						$("#txtCorreo").val()="";
						$("#selUsuario").val()=1;
						$("#selDepartamento").val()=1;
						$("#selActivo").val()=1;
					}
					else
						alert(dato1);
				});
			});
		});
	};
	
	
	$("#btnConsultarU").click(function(){
		consultarU();
	});
	
	function consultarU(){
		var hconsulta = $("#hContenido");
		$.get("controles/ctrl_principalA.php",
		{
			"operacion":"consultarU"
		},
		function(dato){
			hconsulta.html("");
			hconsulta.append(dato);
			$("#btnBuscarUsuario").on("click",function(){
				$.get("controles/ctrl_usuario.php",
				{
					"operacion":"buscarUsuario",
					"txtBusqueda":$("#txtBusqueda").val()
				},
				function(dato1){
					var tbl=$("#idUsuarios");
					tbl.html("");
					tbl.append(dato1);
					
					$(".btnInfo").on("click", function(){
						var hinfo = $("#hContenido");
						var idUsuario = $(this).val();
						$.get("controles/ctrl_principalA.php",
						{
							"operacion":"informacionU",
							"id":$(this).val()
						},
						function(dato2){
							hinfo.html("");
							hinfo.append(dato2);
							
							$("#btnActualizarUsuario").on("click",function(){
								$.get("controles/ctrl_usuario.php",
								{
									"operacion":"actualizarUsuario",
									"id":idUsuario,
									"txtNombre":$("#txtNombre").val(),
									"txtNumero":$("#txtNumero").val(),
									"txtCorreo":$("#txtCorreo").val(),
									"selUsuario":$("#selUsuario").val(),
									"selDepartamento":$("#selDepartamento").val(),
									"selActivo":$("#selActivo").val()
								},
								function(dato3){
									alert(dato3);
								});
							});
							
							$("#btnCambiarC").on("click",function(){
								$.get("controles/ctrl_usuario.php",
								{	
									"operacion":"cambiarContrasenia",
									"id":idUsuario,
									"txtPass":$("#txtPass").val()
								},
								function(dato3){
									alert(dato3);
								});
							});
						});
					});
				});
			});
			
			$(".btnInfo").on("click", function(){
				var hinfo = $("#hContenido");
				var idUsuario = $(this).val();
				$.get("controles/ctrl_principalA.php",
				{
					"operacion":"informacionU",
					"id":$(this).val()
				},
				function(dato2){
					hinfo.html("");
					hinfo.append(dato2);
					
					$("#btnActualizarUsuario").on("click",function(){
						$.get("controles/ctrl_usuario.php",
						{
							"operacion":"actualizarUsuario",
							"id":idUsuario,
							"txtNombre":$("#txtNombre").val(),
							"txtNumero":$("#txtNumero").val(),
							"txtCorreo":$("#txtCorreo").val(),
							"selUsuario":$("#selUsuario").val(),
							"selDepartamento":$("#selDepartamento").val(),
							"selActivo":$("#selActivo").val()
						},
						function(dato3){
							if(dato3=="Contraseña actualizada correctamente"){
								alert(dato3);
								consultarU();
							}
							else
								alert(dato3);
						});
					});
					
					$("#btnCambiarC").on("click",function(){
						$.get("controles/ctrl_usuario.php",
						{
							"operacion":"cambiarContraseniaU",
							"id":idUsuario,
							"txtPass":$("#txtPass").val()
						},
						function(dato3){
							alert(dato3);
							consultarU();
						});
					});
				});
			});
		});
	};
});