<!DOCTYPE html>

<html lang="es">

<head>
	
<meta charset="utf-8">
<meta name="description" content="Videoclub ORI">
<meta name="keywords" content="videoclub, ori, peliculas">
<title>Videoclub ORI</title>
<link rel="stylesheet" href="css/general.css">
<link rel="stylesheet" href="css/alquileres.css">

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
			
		<?php
			include "conexion.php";
			$con = CrearConexionBD();	
			$sql = 'select id_alquiler, fecha from alquileres order by fecha desc';
			echo'
		<div id="alquileres">
				
			<article>
					<h2>Alquileres Realizados</h2>
			</article>
			';
			foreach ($con->query($sql) as $fila){
			$alquiler = $fila[0];
			echo'
			<article>

				<ul>
					<li class="ordenar">
						<p class="espacio"></p>
						<span class="fecha">Fecha: '.$fila[1].'</span>
						<span class="nombre2">Nombre</span>
						<span>Cantidad</span>
					</li>
					';
					$pelis = 'select id_pelicula, cantidad from lineas_alquileres_peliculas where id_alquiler='.$alquiler;
					foreach ($con->query($pelis) as $fila2){
					$peli = 'select id_pelicula, nombre, imagen from peliculas where id_pelicula='.$fila2[0];
					echo'
					<li>
						<img src="img_peliculas/'.$peli[2].'" />
						<span class="nombre"><a href="articulo.php?id_pelicula='.$peli[0].'">'.$peli[1].'</a></span>
						<span>'.$fila2[1].'</span>
					</li>
					';
					}
					$juegos = 'select id_juego, cantidad from lineas_alquileres_juegos where id_alquiler='.$alquiler;
					foreach ($con->query($pelis) as $fila3){
					$juego = 'select id_juego, nombre, imagen from juegoss where id_pelicula='.$fila3[0];
					echo'
					<li>
						<img src="img_peliculas/'.$juego[2].'" />
						<span class="nombre"><a href="articulo.php?id_juego='.$juego[0].'">'.$juego[1].'</a></span>
						<span>'.$fila3[1].'</span>
					</li>
					';
					}
			echo'
				</ul>
			</article>
			';
			}
			echo'				
		</div>
		';
				CerrarConexionBD($con);
			?>
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

