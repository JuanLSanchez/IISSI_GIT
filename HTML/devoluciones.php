<!DOCTYPE html>

<html lang="es">

<head>
	
<meta charset="utf-8">	
<meta name="description" content="Videoclub ORI">	
<meta name="keywords" content="videoclub, ori, peliculas">	
<title>Videoclub ORI</title>
<link rel="stylesheet" href="css/general.css">	
<link rel="stylesheet" href="css/devoluciones.css">

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
		if(isset($_SESSION['dni'])){
			include "conexion.php";
			$con = CrearConexionBD();	
			$dni = $_SESSION['dni'];
			$sql = "select id_alquiler,fecha,tiempo from alquileres where dni='$dni' and rownum=1 order by fecha desc";
			
		echo'
		<div id="devolucion">
				
			<article>
					<h2>Devoluciones Pendientes</h2>
			</article>
		';
		foreach($con->query($sql) as $fila){
			$duracion = $fila[2]*6;
			echo'
			<article>

				<ul>
					<li class="ordenar">
							<p class="espacio"></p>
							<span class="fechaini">Fecha del Alquiler '.$fila[1].'</span>
							<span class="fechafinal">Duración: '.$duracion.' Horas</span>
							<span class="nombre2">Nombre</span>
							<span class="cantidad">Cantidad</span>
					</li>
			';
			$pelis = 'select id_pelicula, cantidad from lineas_alquileres_peliculas where id_alquiler='.$fila[0];
			foreach($con->query($pelis) as $fila2){
				$peli = 'select nombre, imagen from peliculas where id_pelicula='.$fila2[0];
				foreach ($con->query($peli) as $fila3){
					echo'
					<li>
						<a href="articulo.php?id_pelicula='.$fila2[0].'"><img src="'.$fila3[1].'" /></a>
						<a href="articulo.php?id_pelicula='.$fila2[0].'"><span class="nombre">'.$fila3[0].'</span></a>
						<span>'.$fila2[1].'</span>
					</li>
					';
				}
			}
			
			$juegos = 'select id_juego, cantidad from lineas_alquileres_juegos where id_alquiler='.$fila[0];			
			foreach($con->query($juegos) as $fila4){
				$juego = 'select nombre, imagen from juegos where id_juego='.$fila2[0];
				foreach ($con->query($juego) as $fila5){
					echo'
					<li>
						<a href="articulo.php?id_pelicula='.$fila4[0].'"><img src="'.$fila5[1].'" /></a>
						<span class="nombre">'.$fila5[0].'</span>
						<span>'.$fila4[1].'</span>
					</li>
					';
				}
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
			}
		?>
		
		</section>

		
	<aside id="menu">
			
			<?php 
			
			Menu(); ?>
		
	</aside>
		
<footer id="pie">
			
Derechos Reservados &copy; 2013-2014
		
</footer>
	
</div>

</body>

</html>

