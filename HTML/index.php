<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<?php 
		include "cabecera.php";
		Cabecera();
	?>
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
			<article >
			<a href="peliculas.php?busqueda=&amp;inicio_year=&amp;fin_year=&amp;genero=Ninguno&amp;orden=Fecha&amp;torden=desc&amp;peliculas=5">
				<h2>Novedades Peliculas</h2>
			</a>
				
			<?php
				include "conexion.php";
				$con = CrearConexionBD();
				// $res = $con->query("select nombre, imagen from peliculas order by year");
				if($con){
					$sql = 'select nombre, imagen, id_pelicula from peliculas order by year desc';
					$contador = 0;
					echo '<ul>';
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
					echo '</ul>';
					?>

				</article>
				<article>
					<a href="juegos.php?busqueda=&amp;amp;inicio_year=&amp;amp;fin_year=&amp;amp;genero=Ninguno&amp;amp;orden=Fecha&amp;torden=desc&amp;juegos=5">
						<h2>Novedades Juegos</h2>
					</a>

					<?php
						
					$sql= 'select nombre, imagen, id_juego from juegos order by year desc';
					$contador = 0;
					echo'<ul>';
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
					echo '</ul>';
					?>
			</article>
			<article>
				<a href="peliculas.php?busqueda=&amp;inicio_year=&amp;fin_year=&amp;genero=Ninguno&amp;orden=Alquileres&amp;torden=desc&amp;peliculas=5">
					<h2> Películas mas Populares</h2>
				</a>
					<?php
						
					

						$sql = "select id_pelicula, imagen, nombre, 
							id_pelicula_a_alquileres(id_pelicula) alquileres
							from
								(select id_pelicula, imagen, nombre, 
								id_pelicula_a_alquileres(id_pelicula) alquileres
								from peliculas
								order by alquileres desc)
							where rownum<=5";
						echo'<ul>';
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
						echo '</ul>';
				}
			?>
					
					
				</article>
				<article>
					<a href="juegos.php?busqueda=&amp;inicio_year=&amp;fin_year=&amp;genero=Ninguno&amp;orden=Alquileres&amp;torden=desc&amp;juegos=5">
						<h2>Juegos mas Populares</h2>
					</a>
					<ul>
						<?php
							if($con){
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
							}
						?>

					</ul>
				</article>
				<article>
					<a href="peliculas.php?busqueda=&amp;inicio_year=&amp;fin_year=&amp;genero=Ninguno&amp;orden=Puntuacion&amp;torden=desc&amp;peliculas=5">
						<h2> Películas mas Valoradas</h2>
					</a>
					<ul>
						<?php
							if($con){
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
							}
						?>
					</ul>
				</article>
				<article>
					<a href="juegos.php?busqueda=&amp;inicio_year=&amp;fin_year=&amp;genero=Ninguno&amp;orden=Puntuacion&amp;torden=desc&amp;juegos=5">
						<h2>Juegos mas Valorados</h2>
					</a>
					<ul>
						<?php
						if($con){
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
							CerrarConexionBD($con);
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
				if($con){
					$dni = $_POST['dni'];
					$key = $_POST['key'];
					$sql = "select dni, nombre from socios where 
							upper(dni)=upper('$dni') and key='$key'";
					$query = $con->query($sql);
					if($res = $query->fetch()){
						$_SESSION['dni'] = $res['0'];
						$_SESSION['nombre'] = $res['1'];
					}else{
						echo '<div class="incorrecto"><p>Contraseña o usuario incorrectos</p></div>';
					}
					CerrarConexionBD($con);
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
			    <img src="img_ori/vcss.gif" alt=""/>
			    <img src="img_ori/valid-html5.png" alt=""/>
			</p>
		</footer>
	</div>
</body>
</html>

