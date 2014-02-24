<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/modificar_pelicula.css">
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
			<?php
			include "conexion.php";
			$con = CrearConexionBD();
			if(isset($_GET['id_pelicula'])){
				$sql = "select id_pelicula, nombre, edad_restrictiva, imagen, trailer, sinopsis, alquiler, to_char(year, 'DD/MM/yyyy') 
					from peliculas where id_pelicula=".$_GET['id_pelicula'];
				$get = '?id_pelicula=';
			}else{
				$sql = "select id_juego, nombre, edad_restrictiva, imagen, trailer, sinopsis, alquiler, to_char(year, 'DD/MM/yyyy') 
					from juegos where id_juego=".$_GET['id_juego'];
				$get = '?id_juego=';
			}
			$res = $con->query($sql);
			foreach ($res as $fila){
				$id = $fila[0];
				$nombre = $fila[1];
				$edad = $fila[2];
				$imagen = $fila[3];
				$trailer = $fila[4];
				$sinopsis = $fila[5];
				$alquiler = $fila[6];
				$year = $fila[7];
			}
			if(isset($nombre)){
			echo '
			<form METHOD="POST" ACTION="mod_pelicula2.php'.$get.$id.'" enctype="multipart/form-data">
			<article id="iz">
			<ul>
				<li><span>Id:</span></li>
				<li><input type="text" name="id" value="'.$id.'"</li>
				<li><span>Seleccionar otra imagen: </span></li>
				<li><input type="file" name="imagen" /></li>
				<li><img class="bl" src="'.$imagen.'" /></li>
				<li><span>Alquileres: </span></li>
				<li><input type="number" name="alquiler" value="'.$alquiler.'"/></li>
				<li><span>Año de lanzamiento: </span></li>
				<li><input type="number" name="year" value="'.$year.'"/></li>
				<li><span>Edad restrictiva: </span></li>
				<li><input type="number" name="edad" value="'.$edad.'"/></li>
				</ul>
			</article>
			<article id="de">
				<span>Nombre: </span>
				<input type="text" name="nombre" value="'.$nombre.'">
				<div id="sinopsis">
				<textarea id="sinopsis" name="sinopsis" cols="70" rows="15">'.$sinopsis.'</textarea>
				</div>
				<div id="genero"><span>Genero: Acción, Aventuras, Policiaca</span></div>
				<span>Trailer(URL): </span><input type="text" name="trailer" value="'.$trailer.'"/>
				<input type="SUBMIT" value="Modificar articulo"/>
			</article>
			</form>';
		}else{
			echo "<p>No existe ese articulo</p>";
		}
			CerrarConexionBD($con);
			?>
			<article>
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