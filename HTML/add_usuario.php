<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<?php 
		include "cabecera.php";
		Cabecera();
	?>
	<link rel="stylesheet" href="css/add.css">

	<script type="text/javascript">
		function procesaFormulario(){
			var dni = document.getElementById("dni").value;
			var patronDNI = /^\w\d{8}|^\d{8}\w/;
			var nombre = document.getElementById("nombre").value;
			var nacido = document.getElementById("nacido").value;
			var patronNacido = /^(0[1-9]|[12][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/]\d{4}$/;
			var direccion = document.getElementById("direccion").value;
			var email = document.getElementById("email").value;
			var patronEmail=/^(.+)@(.+)$/;
			var telefono = document.getElementById("telefono").value;
			var patronTelefono = /^\d{9}/;
			var key = document.getElementById("key").value;
			var rkey = document.getElementById("rkey").value;
			var error = "";
			if(patronDNI.test(dni)==false){
				error += '<div class="incorrecto"><p>El DNI no es correcto.</p></div>';
			}
			if(nombre==""){
				error += '<div class="incorrecto"><p>Introduzca un nombre.</p></div>';
			}
			if(patronNacido.test(nacido)==false){
				error += '<div class="incorrecto"><p>La fecha de nacimiento no es correcto.</p></div>';
			}
			if(direccion==""){
				error += '<div class="incorrecto"><p>Introduzca una direccion.</p></div>';
			}
			if(patronEmail.test(email)==false&&!(email=="")){
				error += '<div class="incorrecto"><p>El email no es correcto.</p></div>';
			}
			if(patronTelefono.test(telefono)==false){
				error += '<div class="incorrecto"><p>El telefono no es correcto.</p></div>';
			}
			if(key!=rkey){
				error += '<div class="incorrecto"><p>Las contraseñas no coinciden.</p></div>';
			}
			if(error!=""){
				document.getElementById("error").innerHTML=error;
				return false;
			}else{
				return true;
			}

		}
	</script>
</head>
<body>
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<?php
				include "menus.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<article>
				<?php //Añadir usuario
				if(isset($_POST['nombre'])&&$_SESSION['dni'] == '00000000A'){
					include "conexion.php";
					$con = CrearConexionBD();
					$dni = $_POST['dni'];
					$_SESSION['formulario']['dni'] = $dni;
					if(isset($_POST['imagen'])){
						$_SESSION['formulario']['imagen'] = $_POST['imagen'];
					}
					$_SESSION['formulario']['nombre'] = $_POST['nombre'];
					$_SESSION['formulario']['nacido'] = $_POST['nacido'];
					$_SESSION['formulario']['direccion'] = $_POST['direccion'];
					$_SESSION['formulario']['email'] = $_POST['email'];
					$_SESSION['formulario']['telefono'] = $_POST['telefono'];

					$imagen = 'img_socios/'.$dni;
					$nombre = str_replace("'", "''", $_POST['nombre']);
					$nacido = $_POST['nacido'];
					$direccion = $_POST['direccion'];
					$email = $_POST['email'];
					$telefono = $_POST['telefono'];
					$key = $_POST['key'];
					
					list ($month1, $day1, $year1) = explode ("/", $nacido);
					$res = 0;
					$error = "";
					if(!checkdate($day1, $month1, $year1)){
						$error = $error.'<div class="incorrecto"><p>Fecha incorrecta.</p></div>';
					}
					if(!(preg_match("/^\w\d{8}|^\d{8}\w/",$dni))){
						$error = $error.'<div class="incorrecto"><p>DNI, incorrecto.</p></div>';
					}
					if(strlen ($nombre)>50||strlen($nombre)<1){
						$error = $error.'<div class="incorrecto"><p>Longitud del nombre incorrecta, tiene que estar entre 1 y 50 caracteres</p></div>';
					}
					if(strlen ($direccion)>50||strlen($direccion)<1){
						$error = $error.'<div class="incorrecto"><p>Longitud de la direccion incorrecta, tiene que estar entre 1 y 50 caracteres</p></div>';
					}
					if(strlen ($email)>50){
						$error = $error.'<div class="incorrecto"><p>Longitud del email incorrecta, tiene que estar entre 1 y 50 caracteres</p></div>';
					}
					if(!preg_match("/^\d{9}|^$/", $telefono)){
						$error = $error.'<div class="incorrecto"><p>Telefono incorrecto tiene que ser un numero de 9 digitos o dejarlo en blanco</p></div>';
					}
					if($error == ""){
						$sql = "insert into socios values ('$dni', '$nombre', to_date('$nacido', 'DD/MM/yyyy'), sysdate, '$direccion', '$email', '$telefono', '$key')";
						$res = $con->exec($sql);
						if(!$res==1){
							echo '<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';	
						}
					}else{
						echo $error;
					}

					if($res==1){
						if($_FILES['imagen']['error']==0){
							copy($_FILES['imagen']['tmp_name'],$imagen);	
						}	
						echo '<div class="correcto"><p> El usuario se ha insertado correctamente </p></div>';
					}else{
						echo '<div class="incorrecto"><p> El usuario no se ha insertado correctamente </p></div>
							<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
					}

					CerrarConexionBD($con);
				}
				?>
			</article>
			<article>
				<div id="error"></div>
				<?php
					if (isset($_SESSION['dni'])) {
						if(!($_SESSION['dni'] == '00000000A')){
							echo '<p>No eres el administrador, no se guardaran los cambios</p>';
						}else{
							if(!isset($_SESSION['formulario'])||isset($_POST['borrar'])){
								$_SESSION['formulario']['dni'] = "";
								$_SESSION['formulario']['imagen'] = "";
								$_SESSION['formulario']['nombre'] = "";
								$_SESSION['formulario']['nacido'] = "";
								$_SESSION['formulario']['direccion'] = "";
								$_SESSION['formulario']['email'] = "";
								$_SESSION['formulario']['telefono'] = "";
							}
							$formulario = $_SESSION['formulario'];
						}
					}else{
						echo '<p>Tienes que loguearte para que se guardaran los cambios</p>';
					}
				?>
				<form METHOD="POST" ACTION="add_usuario.php" enctype="multipart/form-data">
					<input type="SUBMIT" value="Borrar formulario" name="borrar"/>
				</form>
				<form METHOD="POST" onsubmit="return procesaFormulario()" ACTION="add_usuario.php" enctype="multipart/form-data">
				<table>
					<tr><td>Seleccione la imagen: </td><td><input type="file" name="imagen" <?php
						if($formulario['imagen']!=""){ echo 'value="'.$formulario['imagen']['name'].'"';}
						?>/></td></tr>
					<tr><td>Dni: </td><td><input title="Introduce un DNI correcto" id="dni"  type="text" name="dni" pattern="\w\d{8}|\d{8}\w" required <?php
						if($formulario['dni']!=""){ echo 'value="'.$formulario['dni'].'"';}
					?>/></td></tr>
					<tr><td>Nombre: </td><td><input type="text" name="nombre" id="nombre" required <?php
						if($formulario['nombre']!=""){ echo 'value="'.$formulario['nombre'].'"';}
					?>/></td></tr>
					<tr><td>Año de nacimiento: </td><td><input type="date" placeholder="ej: 15/03/1999" id="nacido" name="nacido" pattern="^(0[1-9]|[12][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/]\d{4}$" required <?php
						if($formulario['nacido']!=""){ echo 'value="'.$formulario['nacido'].'"';}
					?>/></td></tr>
					<tr><td>Direccion: </td><td><input type="text" id="direccion" name="direccion" required <?php
						if($formulario['direccion']!=""){ echo 'value="'.$formulario['direccion'].'"';}
					?>/></td></tr>
					<tr><td>Email: </td><td><input type="email" id="email" name="email" <?php
						if($formulario['email']!=""){ echo 'value="'.$formulario['email'].'"';}
					?>/></td></tr>
					<tr><td>Telefono: </td><td><input type="tel" pattern="\d{9}" id="telefono" name="telefono" maxlength="9" required <?php
						if($formulario['telefono']!=""){ echo 'value="'.$formulario['telefono'].'"';}
					?>/></td></tr>
					<tr><td>Contraseña: </td><td><input type="password" id="key" name="key" required/></td></tr>
					<tr><td>Repita la contraseña: </td><td><input type="password" id="rkey" name="rkey" required/></td></tr>
					<tr><td><input type="SUBMIT" value="Añadir"/></td><td></td></tr>
				</table>
			</form>
			</article>
		</section>
		<aside id="menu">
			<?php Menu(); ?>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>