
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add.css">

	<script type="text/javascript">
		function procesaFormulario(){
			var dni = document.getElementById("dni").value;
			var patronDNI = /^\w\d{8}|^\d{8}\w/;
			var nombre = document.getElementById("nombre").value;
			var nacido = document.getElementById("nacido").value;
			var patronNacido = /^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/]\d{4}$/;
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
				<div id="error"></div>
				<?php //Añadir articulo
				if(isset($_POST['nombre'])&&$_SESSION['dni'] == '00000000A'){
					include "conexion.php";
					$con = CrearConexionBD();
					$dni = $_POST['dni'];
					$imagen = 'img_socios/'.$dni;
					$nombre = $_POST['nombre'];
					$nacido = $_POST['nacido'];
					$direccion = $_POST['direccion'];
					$email = $_POST['email'];
					$telefono = $_POST['telefono'];
					$key = $_POST['key'];
					$sql = "insert into socios values ('$dni', '$nombre', to_date('$nacido', 'DD/MM/yyyy'), sysdate, '$direccion', '$email', '$telefono', '$key')";
					$res = $con->exec($sql);

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
				<?php
					if (isset($_SESSION['dni'])) {
						if(!($_SESSION['dni'] == '00000000A')){
							echo '<p>No eres el administrador, no se guardaran los cambios</p>';
						}
					}else{
						echo '<p>Tienes que loguearte para que se guardaran los cambios</p>';
					}
				?>
				
				<form METHOD="POST" onsubmit="return procesaFormulario()" ACTION="add_usuario.php" enctype="multipart/form-data">
				<ul>
					<li><span>Seleccione la imagen: </span><input type="file" name="imagen" /></li>
					<li><span>Dni: </span><input title="Introduce un DNI correcto" id="dni"  type="text" name="dni" pattern="\w\d{8}|\d{8}\w" required/></li>
					<li><span>Nombre: </span><input type="text" name="nombre" id="nombre" required/></li>
					<li><span>Año de nacimiento: </span><input type="date" placeholder="ej: 15/03/1999" id="nacido" name="nacido" required/></li>
					<li><span>Direccion: </span><input type="text" id="direccion" name="direccion" required/></li>
					<li><span>Email: </span><input type="email" id="email" name="email"/></li>
					<li><span>Telefono: </span><input type="tel" pattern="\d{9}" id="telefono" name="telefono" maxlength="9" required/></li>
					<li><span>Contraseña: </span><input type="password" id="key" name="key" required/></li>
					<li><span>Repita la contraseña: </span><input type="password" id="rkey" name="rkey" required/></li>
					<li><input type="SUBMIT" value="Añadir"/></li>
				</ul>
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