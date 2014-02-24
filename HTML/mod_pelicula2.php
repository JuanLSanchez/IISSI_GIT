<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/pelicula.css">
</head>
<body>
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<ul>
				<li>Inicio</li>
				<li>Peliculas</li>
				<li>Juegos</li>
				<li>Comestibles</li>
				<li>Informacion</li>
			</ul>
		</nav>
		<section id="seccion">
			<article>
				<?php
					include "conexion.php";
					if(isset($_GET['id_pelicula'])){
						$id = $_GET['id_pelicula'];
						$imagen = "img_peliculas/" . $id;
						$articulo = "pelicula";
					}else{
						$id = $_GET['id_juego'];
						$imagen = "img_juegos/" . $id;
						$articulo = "juego";
					}
					$nombre = $_POST["nombre"];
					$edad = $_POST["edad"];
					$trailer = $_POST["trailer"];
					$sinopsis = $_POST["sinopsis"];
					$alquiler = $_POST["alquiler"];
					$year = $_POST["year"];
					
					if($_FILES['imagen']['error'] == 0){
						$sql = "update ".$articulo."s set nombre='$nombre', imagen='$imagen', edad_restrictiva='$edad', trailer='$trailer', sinopsis='$sinopsis', alquiler='$alquiler', year=to_date('$year', 'DD/MM/yyyy') where id_".$articulo."=$id";
						copy($_FILES['imagen']['tmp_name'],$imagen);
					}else{
						$sql = "update ".$articulo."s set nombre='$nombre', edad_restrictiva='$edad', trailer='$trailer', sinopsis='$sinopsis', alquiler='$alquiler', year=to_date('$year', 'DD/MM/yyyy') where id_".$articulo."=$id";
					}
					$con = CrearConexionBD();
					$res = $con->exec($sql);
					if($res == 1){
						echo '<a href="articulo.php?id_'.$articulo.'='.$id.'">'.$nombre.'<a>';
					}else{
						echo "<p>El articulo no se ha añadido</p>";
					}
					CerrarConexionBD($con);

				?>
			</article>
		</section>
		<aside id="menu">
			<ul>
				<li>Alquileres</li>
				<li>Devoluciones pendientes</li>
				<li>Amigos</li>
				<li>Pendientes</li>
				<li>Favoritas</li>
				<li>Mis puntuaciones</li>
				<li>Mi perfil</li>
			</ul>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>