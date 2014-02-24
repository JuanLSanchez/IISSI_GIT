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
					$con = CrearConexionBD();
					if($_POST["articulo"]=='Juego'){
						$sql = "select id_juego.nextval from dual";
					}else{
						$sql = "select id_pelicula.nextval from dual";
					}
					$id_p = $con->query($sql);

					foreach ($id_p as $fila) {
						$id = $fila[0];
					}

					$nombre = $_POST["nombre"];
					$edad = $_POST["edad"];
					$trailer = $_POST["trailer"];
					$sinopsis = $_POST["sinopsis"];
					$alquiler = $_POST["alquiler"];
					$year = $_POST["year"];
					if($_POST["articulo"]=="Juego"){
						$imagen = "img_juegos/" . $id;
						$sql2 = "insert into juegos values('$id', '$nombre', '$edad', '$imagen', '$trailer', '$sinopsis', '$alquiler', to_date('$year', 'DD/MM/yyyy'))";
						$salida='<a href="http://ori/articulo.php?id_juego='.$id.'">'.$nombre.'<a>';
					}else{
						$imagen = "img_peliculas/" . $id;
						$sql2 = "insert into peliculas values('$id', '$nombre', '$edad', '$imagen', '$trailer', '$sinopsis', '$alquiler', to_date('$year', 'DD/MM/yyyy'))";
						$salida = '<a href="http://ori/articulo.php?id_pelicula='.$id.'">'.$nombre.'<a>';
					}
					
					$res = $con->exec($sql2);
					
					if($res == 1){
						// echo "<p>La pelicula se ha añadido con el id: ".$id."</p>";
						copy($_FILES['imagen']['tmp_name'],$imagen);
						echo $salida;
					}else{
						echo "<p>La pelicula no se ha añadido</p>";
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