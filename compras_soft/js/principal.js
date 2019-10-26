// JavaScript Document
$(document).ready(function(){	
	$("#btnCS").click(function(){
		$.get("controles/ctrl_logout.php",
		{
			"operacion":"salir"
		},
		function(dato){
			var url = "index.php";
			$(location).attr('href',url);
		});	
	});
	
	$("#btnInicio").click(function(){
		bienvenida();
	});
	
	function bienvenida(){
		var hbienvenida = $("#hContenido");
		$.get("controles/ctrl_principal.php",
		{
			"operacion":"bienvenida"
		},
		function(dato){
			hbienvenida.html("");
			hbienvenida.append(dato);
		});
	}
	
	$("#btnContrasenia").click(function(){
		contrasenia();
	});
	
	function contrasenia(){
		var hcontrasenia = $("#hContenido");
		$.get("controles/ctrl_principal.php",
		{
			"operacion":"contrasenia"
		},
		function(dato){
			hcontrasenia.html("");
			hcontrasenia.append(dato);
			
			$("#btnActualizarPass").on("click", function(){
				$.get("controles/ctrl_perfil.php",
				{
					"operacion":"cambiarContrasenia",
					"txtPass0":$("#txtPass0").val(),
					"txtPass1":$("#txtPass1").val(),
					"txtPass2":$("#txtPass2").val()
				},
				function(dato1){
					alert(dato1);
				});
			});
		});
	};
	
	$("#btnAltaO").click(function(){
		altaO();
	});
	
	function altaO(){
		var haltaO = $("#hContenido");
		$.get("controles/ctrl_principal.php",
		{
			"operacion":"altaOrden",
		},
		function(dato){
			haltaO.html("");
			haltaO.append(dato);

			// ******** evento del boton eliminar la fila  *******
			$(".btnEliminaF").on("click", function(){
				var parent = $(this).parents().get(0);
				$(parent).remove();
			});
			
			// ******** evento para agregar fila ************
			$("#btnAgregarPartida").on('click', function(){	
				var lugar = $("#txtLugar").val();			
				var cantidad = $("#txtCantidad").val();
				var unidad = $('#selUnidad option:selected').text(); 
				var descripcion = $("#txtDescripcion").val();
				
				if(cantidad=="" || unidad=="" || descripcion=="" || lugar=="")
					alert("Todos los campos deben estar completados");
				else if(cantidad<=0)
					alert("La cantidad debe ser mayor que cero");
				else{
					var t = $("#tabla1 tbody tr:eq(0)").clone().removeClass('fila-base');
					t.find("td:eq(0)").text(cantidad);
					t.find("td:eq(1)").text(unidad);
					t.find("td:eq(2)").text(descripcion);
					t.find("td:eq(3)").text(lugar);
					t.appendTo("#hTblPartidas tbody");
					
					//***** reiniciar campos *****/				
					$("#txtCantidad").val(0);
					$("#selUnidad").val('1');
					$("#txtDescripcion").val("");
					$("#txtLugar").val("Lugar");
					
					$(".btnEliminaF").on("click", function(){
						var parent = $(this).parents().get(0);
						$(parent).remove();
					});
				}
			});
			
			$("#btnEnviarOrden").on('click', function(){
				var tab = $("#hTblPartidas").tableToJSON();
				tab = {"myrows": tab};	//hace myrows el objeto padre
				tab = JSON.stringify(tab);
				//alert(tab);
				$.get("controles/ctrl_orden.php",
				{
					"operacion":"enviarOrden",
					"txtDescripcionO":$("#txtDescripcionO").val(),
					"tabla":tab
				},
				function(dato){
					if(dato=="Se ha registrado la orden correctamente, tu orden será procesada"){
						alert(dato);
						altaO();
					}
					else				
						alert(dato);		
				});			
			});
		});
	}
	
	
	$("#btnConsultarMO").click(function(){
		consultarMO();
	});
	
	function consultarMO(){
		var hconsulta = $("#hContenido");
		$.get("controles/ctrl_principal.php",
		{
			"operacion":"consultarMO"
		},
		function(dato){
			hconsulta.html("");
			hconsulta.append(dato);
			
			$(".btnObtenerPDF").on("click", function(){
				var parent = $(this).closest("tr");
				var idOrden = parent.find("td:eq(0)").text();
				var fechaHora = parent.find("td:eq(2)").text();
				$.get("controles/ctrl_PDF.php",{
					"idOrden":idOrden,
					"fechaHora":fechaHora
				},
				function(dato3){
					setTimeout(function(){
						window.open(dato3,'PDF','width=800, height=500');
					}, 500);
				});
			});
		});
	}
	
	
	/******* Tiempo y hora actual********/
	workDate = new Date();
	UTCDate = new Date();
	UTCDate.setTime(workDate.getTime()+workDate.getTimezoneOffset()*60000);
	function startTime(offset){
		offset++;
		tempDate = new Date()
		tempDate.setTime(UTCDate.getTime()+3600000*(offset));
		var today = new Date();
		var h = ((tempDate.getHours()<10) ? ("0"+tempDate.getHours()) : (""+tempDate.getHours()));
		var m = today.getMinutes();
		var s = today.getSeconds();
		// agrega un cero enfrente de los numeros<10
		m = tiempo(m);
		s = tiempo(s);
		document.getElementById("horaFecha").innerHTML="Fecha y hora actuales: "+
						today.getDate()+"/"+(today.getMonth()+1)+"/"+today.getFullYear()+" "+h+":"+m+":"+s;
		t = setTimeout(function(){startTime("-7")},500);
	}
	
	function tiempo(i){
		if (i<10){
		  i="0" + i;
		}
		return i;
	}
	
	bienvenida();
	startTime("-7");	
});