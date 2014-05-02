<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/moduser.css">
</head>
<body>
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<?php
				include "menus.php";
				include "conexion.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<article>
				<?php
					if(isset($_POST['modificar'])){//modificar datos
						if($_SESSION['dni']=='00000000A'){
							if($_POST['key']==$_POST['keyr']){
								$con=CrearConexionBD();
								$dni=$_SESSION['dni'];
								
								$dni=$_GET['dni'];								
								$nombreN = $_POST['nombre'];							
								$nacidoN = $_POST['nacido'];
								$direccionN = $_POST['direccion'];
								$emailN = $_POST['email'];
								$telefonoN = $_POST['telefono'];
								$keyN = $_POST['key'];														
								
								$sql="update socios set nombre='$nombreN',nacido='$nacidoN',direccion='$direccionN',
										email='$emailN',telefono='$telefonoN',key='$keyN' where dni='$dni'";
								$res=$con->exec($sql);
								
								if($res){
									echo '<div class="correcto"><p>Se ha modificado correctamente.</p></div>';
								}else{
									echo '<div class="incorrecto"><p>No se ha modificado correctamente.</p></div>';
								}
								CerrarConexionBD($con);
							}else{
								echo'<p class="incorrecto"> Las contraseñas no coinciden</p>';								
							}
							
							
						}
					}
					
						
						
						
					
				?>

				<?php
					if(isset($_SESSION)){
						if($_SESSION['dni']=='00000000A'){
							$con = CrearConexionBD();
							$dniGet=$_GET['dni'];							
							$sql = "select dni,nombre,nacido,direccion,email,telefono,key from socios where dni='$dniGet'";
							foreach($con->query($sql) as $fila){
								$dni = $fila[0];
								$nombre = $fila[1];
								$nacido = $fila[2];
								$direccion = $fila[3];
								$email = $fila[4];
								$telefono = $fila[5];
								$key = $fila[6];
								$keyr = $fila[6];
							}
							echo'<form METHOD="POST" ACTION="moduser.php?dni='.$dniGet.'">
									
									<ul>										
										<li><input type="hidden" name="dni" value="'.$dni.'"/></li>
										<li><p>Nombre:<input type="text" name="nombre" value="'.$nombre.'"/></p></li>
										<li><p>Nacido:<input type="text" name="nacido" value="'.$nacido.'"/></p></li>
										<li><p>Diección:<input type="text" name="direccion" value="'.$direccion.'"/></p></li>
										<li><p>E-mail:<input type="text" name="email" value="'.$email.'"/></p></li>
										<li><p>Teléfono:<input type="text" name="telefono" value="'.$telefono.'"/></p></li>
										<li><p>Contraseña:<input type="password" name="key" value="'.$key.'"/></p></li>
										<li><p>Repetir ontraseña:<input type="password" name="keyr" value="'.$keyr.'"/></p></li>
										<li><input type="submit" name="modificar" value="Modificar"/></li>
									</ul>
								 </form>';
							CerrarConexionBD($con);
						}
					}
				?>
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