<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/principal.css">
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
							<a href="articulo.php?id_pelicula='.$fila[2].'">
							<figure>
							<img src='.$fila[1].' />
							<figcaption >'.$fila[0].'</figcaption>
							</figure>
							</a>
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
							<a href="articulo.php?id_juego='.$fila[2].'">
							<figure>
							<img src='.$fila[1].' />
							<figcaption >'.$fila[0].'</figcaption>
							</figure>
							</a>
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

						$con = CrearConexionBD();
							$sql = "select id_pelicula, imagen, nombre, 
							id_pelicula_a_alquileres(id_pelicula) alquileres
							from peliculas
							where rownum<=5
							order by alquileres desc";
							foreach ($con->query($sql) as $fila) {
							 	echo '<li>
										<a href="articulo.php?id_pelicula='.$fila[0].'">
										<figure>
										<img src='.$fila[1].' />
										<figcaption >'.$fila[2].'</figcaption>
										</figure>
										</a>
									</li>';
							}

							CerrarConexionBD($con);
					?>
					
					</ul>
				</article>
				<article>
					<h2>Juegos mas Populares</h2>
					<ul>
						<?php
							$con = CrearConexionBD();
							$sql = "select id_juego, imagen, nombre, 
							id_juego_a_alquileres(id_juego) alquileres
							from juegos
							where rownum<=5
							order by alquileres desc";
							foreach ($con->query($sql) as $fila) {
							 	echo '<li>
										<a href="articulo.php?id_juego='.$fila[0].'">
										<figure>
										<img src='.$fila[1].' />
										<figcaption >'.$fila[2].'</figcaption>
										</figure>
										</a>
									</li>';
							}

							CerrarConexionBD($con);
						?>

					</ul>
				</article>
				<article>
					<h2> Películas mas Valoradas</h2>
					<ul>
						<?php
							$con = CrearConexionBD();
							$sql = "select id_pelicula, imagen, nombre, 
									id_pelicula_a_puntuacion(id_pelicula) puntuacion
									from peliculas
									where rownum<=5
									order by puntuacion desc";
							foreach ($con->query($sql) as $fila) {
							 	echo '<li>
							<a href="articulo.php?id_pelicula='.$fila[0].'">
							<figure>
							<img src='.$fila[1].' />
							<figcaption >'.$fila[2].'</figcaption>
							</figure>
							</a>
							</li>';
						}
						?>
					</ul>
				</article>
				<article>
					<h2>Juegos mas Valorados</h2>
					<ul>
						<?php
							$con = CrearConexionBD();
							$sql = "select id_juego, imagen, nombre, 
									id_juego_a_puntuacion(id_juego) puntuacion
									from juegos
									where rownum<=5
									order by puntuacion desc";
							foreach ($con->query($sql) as $fila) {
							 	echo '<li>
							<a href="articulo.php?id_juego='.$fila[0].'">
							<figure>
							<img src='.$fila[1].' />
							<figcaption >'.$fila[2].'</figcaption>
							</figure>
							</a>
							</li>';
						}
						?>
					</ul>
				</article>
			</div>
		</section>
		<aside id="menu">
			<?php
			if(isset($_POST['dni'])){
				$con = CrearConexionBD();
				$dni = $_POST['dni'];
				$key = $_POST['key'];
				$sql = "select dni, nombre from socios where 
						dni='$dni' and key='$key'";
				$query = $con->query($sql);
				if($res = $query->fetch()){
					$_SESSION['dni'] = $res['0'];
					$_SESSION['nombre'] = $res['1'];
				}else{
					echo '<div class="incorrecto"><p>Contraseña o usuario incorrectos</p></div>';
				}
			}
			if(isset($_GET['logout'])){
				$_SESSION = array();
				session_destroy();
			}
			Menu();
			?>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>

