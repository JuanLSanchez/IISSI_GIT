
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add.css">
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
						echo '<div class="incorrecto"><p> El usuario no se ha insertado correctamente </p></div>';
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
					echo '<form METHOD="POST" ACTION="add_usuario.php" enctype="multipart/form-data">';
				?>
				
				<ul>
					<li><span>Seleccione la imagen: </span><input type="file" name="imagen" /></li>
					<li><span>Dni: </span><input type="text" name="dni" required/></li>
					<li><span>Nombre: </span><input type="text" name="nombre" required/></li>
					<li><span>Año de nacimiento(ej: 05/03/1999): </span><input type="text" name="nacido" required/></li>
					<li><span>Direccion: </span><input type="text" name="direccion" required/></li>
					<li><span>Email: </span><input type="email" name="email"/></li>
					<li><span>Telefono: </span><input type="text" name="telefono" required/></li>
					<li><span>Contraseña: </span><input type="password" name="key" required/></li>
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