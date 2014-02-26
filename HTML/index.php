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
				<a href="index.php"><li>Inicio</li></a>
				<a href="peliculas.php"><li>Peliculas</li></a>
				<a href="juegos.php"><li>Juegos</li></a>
				<a href="comestibles.php"><li>Comestibles</li></a>
				<a href="informacion.html"><li>Informacion</li></a>
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
				<a href="alquileres.php"><li>Alquileres</li></a>
				<a href="devoluciones.php"><li>Devoluciones pendientes</li></a>
				<a href="amigos.php"><li>Amigos</li></a>
				<a href="pendientes.php"><li>Pendientes</li></a>
				<a href="favoritas.php"><li>Favoritas</li></a>
				<a href="vistas.php"><li>Vistas</li></a>
				<a href="puntuaciones.php"><li>Mis puntuaciones</li></a>
				<a href="perfil1.php"><li>Mi perfil</li></a>
			</ul>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>

