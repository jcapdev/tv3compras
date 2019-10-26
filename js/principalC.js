// JavaScript Document
$(document).ready(function(){
	var idOrden;
	var fechaHora;
	
	$("#btnConsultarODeptos").click(function(){
		consultarOrdenesDeptos();
	});
	
	
	//******* consultar ordenes de departamentos ********
	function consultarOrdenesDeptos(){
		var hconsulta = $("#hContenido");
		$.get("controles/ctrl_principalC.php",
		{
			"operacion":"consultarOrdenesDeptos"
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
					"operacion":"informacionOrdenC",
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
							"operacion":"actualizarOrdenS",
							"tabla":tab
						},
						function(dato3){
							alert(dato3);
						});
					});		
											
					$("#btnGenerarPDF").on("click",function(){
						$.get("controles/ctrl_PDF.php",{
							"operacion":"generarPDFDeptos",
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
								"operacion":"aprobarOrdenC",
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
								"operacion":"rechazarOrdenC",
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
			//alert ("Presionado");			
		});
	}
	
	
});