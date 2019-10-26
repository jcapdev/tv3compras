<?php 
	session_start();
	
	if(!empty($_SESSION['c0rr3ito']) && $_SESSION['t1poU']==4) {
?>
	<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/footable.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="css/footable.bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
        <link rel="stylesheet" type="text/css" href="css/forms.css" />
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
       

        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src='js/tableEdit-0.1.js'></script>
        <script type='text/javascript' src='js/menu_jquery.js'></script>
        <script type='text/javascript' src='js/principalA.js'></script>
        <script type='text/javascript' src='js/principal.js'></script>
        <script src='js/jquery.tabletojson.min.js'></script>
        <script type='text/javascript' src='js/footable.js'></script>
        <script type='text/javascript' src='js/footable.min.js'></script>
        <!--
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
    <title>Sistema de Compras Televisa Puebla Regional</title>
    </head>
    <body>
        <div id="barra" align="center"><h4><img src="images/COMPRAS AZUL_2.png" width="800" height="100"></h4></div>
        <div id="container">            
            <div id="leftmenu">
                <div id="leftmenu_top"></div>    
                <div id='cssmenu'>
                    <div id="leftmenu_main"> 
                    <h3><span class="fontawesome-plus-sign"></span> Menú</h3>
                    </div>
                    <ul>
                        <li class='active' id="btnInicio"><a><span>Inicio</span></a></li>
                        <li class='has-sub' id="btnPerfil"><a><span>Mi perfil</span></a>
                        	<ul>
                        		<li class='last' id="btnContrasenia"><a><span>Cambiar contraseña</span></a></li>
                        	</ul>
                        </li>
                        <?php
							if($_SESSION['t1poU']==4){
						?>
								<li class='has-sub'><a><span>Gestión de usuarios</span></a>
									<ul>
										<li id="btnRegistrarU"><a><span>Registrar usuario</span></a></li>
										<li class='last' id="btnConsultarU"><a><span>Consultar usuarios</span></a></li>
									</ul>
								</li>
						<?php	
							}
                        ?>
                        <li class='has-sub'><a><span>Gestión de órdenes</span></a>
                            <ul>
                                <li id="btnAltaO"><a><span>Alta de orden</span></a></li>
                                <li class='last' id="btnConsultarMO"><a><span>Consultar mis órdenes</span></a></li>
                                <?php 
								if($_SESSION['t1poU']!=5 && $_SESSION['t1poU']==4){
                                ?>
								<li id="btnConsultarTOrdenes"><a><span>Consultar todas las ordenes</span></a></li>
								<?php 
								}
								?>
                            </ul>
                        </li>
                        <li class='last' id="btnCS"><a><span>Cerrar sesión</span></a></li>
                    </ul>
                </div>
                <div id="leftmenu_bottom"></div>
                <div id="footer">
                	<h3>
						<a>Televisa Puebla 2014</a>
                     </h3>
                </div>
            </div>
            <div id="content">
                <div id="content_top"></div>
                <div id="content_main">
					<div id="hContenido">
                    </div>
					<div id="content_right">
                  		<p1 id="horaFecha"></p1>
					</div>
                </div>
                <div id="content_bottom"></div>
            </div>
        </div>
        
    </body>
    </html>
<?php
	}
	else{
		header("Location: index.php");
		exit;
	}
?>