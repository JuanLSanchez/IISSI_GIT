<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/principal.css">
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
			<div id="inicio">
				
					<?php

						include "conexion.php";
						$con = CrearConexionBD();
						// $res = $con->query("select nombre, imagen from peliculas order by year");
						 $sql = 'select nombre, imagen, id_pelicula from peliculas order by year desc';
						 $contador = 0;
						 echo '<article >
									<h2>Novedades Peliculas</h2>
									<ul>';
						foreach ($con->query($sql) as $fila){
							echo '<li>
							<img src='.$fila[1].' />
							<figcaption ><a href="articulo.php?id_pelicula='.$fila[2].'">'.$fila[0].'</a></figcaption>
							</li>';
							if($contador == 4){
								break;
							}
							$contador++;
						}
						echo '</ul>
							</article>
							<article>
								<h2>Novedades Juegs</h2>
								<ul>';
						$sql= 'select nombre, imagen, id_juego from juegos order by year desc';
						$contador = 0;
						foreach ($con->query($sql) as $fila){
							echo '<li>
							<img src='.$fila[1].' />
							<figcaption ><a href="articulo.php?id_juego='.$fila[2].'">'.$fila[0].'</a></figcaption>
							</li>';
							if($contador == 4){
								break;
							}
							$contador++;
						}
						echo '</ul>
							</article>
							<article>
								<h2> Películas mas Populares</h2>
								<ul>';

							CerrarConexionBD($con);
					?>
					
					</ul>
				</article>
				<article>
					<h2>Juegos mas Populares</h2>
					<ul>

					</ul>
				</article>
				<article>
					<h2> Películas mas Valoradas</h2>
					<ul>


					</ul>
				</article>
				<article>
					<h2>Juegos mas Valorados</h2>
					<ul>

					</ul>
				</article>
			</div>
		</section>
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

