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
									<a href="peliculas.php?busqueda=&inicio_year=&fin_year=&genero=Ninguno&orden=Fecha&torden=desc&peliculas=5">
										<h2>Novedades Peliculas</h2>
									</a>
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
								<a href="juegos.php?busqueda=&inicio_year=&fin_year=&genero=Ninguno&orden=Fecha&torden=desc&juegos=5">
									<h2>Novedades Juegos</h2>
								</a>
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
								<a href="peliculas.php?busqueda=&inicio_year=&fin_year=&genero=Ninguno&orden=Alquileres&torden=desc&peliculas=5">
									<h2> Películas mas Populares</h2>
								</a>
								<ul>';

						$con = CrearConexionBD();
							$sql = "select id_pelicula, imagen, nombre, 
								id_pelicula_a_alquileres(id_pelicula) alquileres
								from
									(select id_pelicula, imagen, nombre, 
									id_pelicula_a_alquileres(id_pelicula) alquileres
									from peliculas
									order by alquileres desc)
								where rownum<=5";
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
					<a href="juegos.php?busqueda=&inicio_year=&fin_year=&genero=Ninguno&orden=Alquileres&torden=desc&juegos=5">
						<h2>Juegos mas Populares</h2>
					</a>
					<ul>
						<?php
							$con = CrearConexionBD();
							$sql = "select id_juego, imagen, nombre, 
							id_juego_a_alquileres(id_juego) alquileres
							from
								(select id_juego, imagen, nombre, 
								id_juego_a_alquileres(id_juego) alquileres
								from juegos
								order by alquileres desc)
							where rownum<=5";
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
					<a href="peliculas.php?busqueda=&inicio_year=&fin_year=&genero=Ninguno&orden=Puntuacion&torden=desc&peliculas=5">
						<h2> Películas mas Valoradas</h2>
					</a>
					<ul>
						<?php
							$con = CrearConexionBD();
							$sql = "select id_pelicula, imagen, nombre, 
									id_pelicula_a_puntuacion(id_pelicula) puntuacion
									from
										(select id_pelicula, imagen, nombre, 
										id_pelicula_a_puntuacion(id_pelicula) puntuacion
										from peliculas
										order by puntuacion desc)
									where rownum<=5";
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
					<a href="juegos.php?busqueda=&inicio_year=&fin_year=&genero=Ninguno&orden=Puntuacion&torden=desc&juegos=5">
						<h2>Juegos mas Valorados</h2>
					</a>
					<ul>
						<?php
							$con = CrearConexionBD();
							$sql = "select id_juego, imagen, nombre, 
									id_juego_a_puntuacion(id_juego) puntuacion
									from
										(select id_juego, imagen, nombre, 
										id_juego_a_puntuacion(id_juego) puntuacion
										from juegos 
										order by puntuacion desc)
									where rownum<=5";
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
			<p>
			    <img src="img_ori/vcss.gif" />
			    <img src="img_ori/valid-html5.png"/>
			</p>
		</footer>
	</div>
</body>
</html>

