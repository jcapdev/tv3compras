// JavaScript Document
$(document).ready(function(){
	var idOrden;
	var fechaHora;
	
	$("#btnConsultarODepto").click(function(){
		consultarOrdenesDepto();
	});
	
	
	//******* consultar ordenes del departamento ********
	function consultarOrdenesDepto(){
		var hconsulta = $("#hContenido");
		$.get("controles/ctrl_principalG.php",
		{
			"operacion":"consultarOrdenesDepto"
		},
		function(dato){
			hconsulta.html("");
			hconsulta.append(dato);
			$(".btnInfoOrden").on("click", function(){
				var hinfo = $("#hContenido");
				idOrden = $(this).val();
				fechaHora = $(this).closest("tr");
				fechaHora = fechaHora.find("td:eq(2)").text();
				$.get("controles/ctrl_orden.php",
				{
					"operacion":"informacionOrdenG",
					"id":idOrden,
					"fechaHora":fechaHora
				},
				function(dato2){
					hinfo.html("");
					hinfo.append(dato2);
					
					$("#btnActualizarOrden").on("click",function(){
						var tab = $("#hTblArticulos").tableToJSON();
						tab = {"myrows": tab};	//hace myrows el objeto padre
						tab = JSON.stringify(tab);
						//alert(tab);
						$.get("controles/ctrl_orden.php",{
							"operacion":"actualizarOrdenG",
							"tabla":tab
						},
						function(dato3){
							alert(dato3);
						});
					});					
															
					$("#btnGenerarPDF").on("click",function(){
						$.get("controles/ctrl_PDF.php",{
							"operacion":"generarPDFDepto",
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
								"operacion":"aprobarOrdenG",
								"idOrden":idOrden
							},
							function(dato3){
								alert(dato3);
								consultarOrdenesDepto();
							});
						}
						else{}
					});
					
					$("#btnRechazar").on("click",function(){
						var r = confirm("¿Está seguro de rechazar la orden "+idOrden+"?");
						if(r==true){
							$.get("controles/ctrl_orden.php",{
								"operacion":"rechazarOrdenG",
								"idOrden":idOrden
							},
							function(dato3){
								alert(dato3);
								consultarOrdenesDepto();
							});
						}
						else{}
					});
					
					$("#btnAgregarObservacion").on("click", function(){
						var observaciones = $("#txtObservaciones").val();
						$.get("controles/ctrl_orden.php",{
							"operacion":"agregarObservacionG",
							"txtObservacion": $("#txtObservaciones").val(),
							"idOrden:":idOrden
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
		});
	}
	
	
});