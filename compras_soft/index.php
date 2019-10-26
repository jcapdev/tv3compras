<?php 
	session_start();
	
	if(!empty($_SESSION['c0rr3ito'])) {
		if(!empty($_SESSION['t1poU'])){
			switch ($_SESSION['t1poU']){
				case 2: // gerente de departamento
					header("Location: principalG.php");
					exit;
				break;
				case 3: // gerente administrativo - Contadora
					header("Location: principalC.php");
					exit;
				break;
				case 4: // administrador
					header("Location: principalA.php");
					exit;
				break;
				case 5: // capturista
					header("Location: principal.php");
					exit;
				break;
				case 6: // supervisor de compras - Carlos
					header("Location: principalS.php");
					exit;
				break;
			}
		}
	}
	else{
?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>Sistema de Compras Televisa Puebla Regional</title>
            <link rel="stylesheet" href="css/styles.css">
            <script src="js/jquery-2.0.3.min.js"></script>
            <script src="js/login.js"></script>
        </head>
    
    <body>
        <div id="barra" align="center"><img src="images/COMPRAS AZUL_2.png" width="800" height="100"></div>
        <div id="login"> 
            <h2><span class="fontawesome-lock"></span>Accesar</h2>
    
                <fieldset>
                    <p>
                        <label for="email">Correo electrónico</label>
                    </p>
                    <p>
                        <input type="email" id="email" name="email" value="mail@address.com" name="email" onBlur="if(this.value=='')this.value='mail@address.com'" onFocus="if(this.value=='mail@address.com')this.value=''">
                    </p>
                    <p>
                        <label for="password">Contraseña</label>
                    </p>
                    <p>
                        <input type="password" id="password" name="password" value="password" name="password" onBlur="if(this.value=='')this.value='password'" onFocus="if(this.value=='password')this.value=''">
                    </p>
                    <p>
                        <input type="submit" name="login" value="Ingresar" id="btnIngresar">
                    </p>
                </fieldset>
    
        </div>
    
    </body>	
    </html>
<?php
	}
?>