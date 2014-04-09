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
			$sql = "select id_alquiler, fecha, tiempo from 
					(select id_alquiler,fecha,tiempo from alquileres 
						where dni='$dni' order by fecha desc) 
					where rownum=1";
			
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

				<table>
					<tr class="primera">
							<td  class="fechaini">Fecha del Alquiler '.$fila[1].'</td>
							<td  class="nombre2">Nombre</td>
							<td  class="cantidad">Cantidad</td>
					</tr>
					<tr class="segunda">
							<td class="fechafinal">Duración: '.$duracion.' Horas</td>
							<td></td>
							<td></td>
					</tr>
			';
			$pelis = 'select id_pelicula, cantidad from lineas_alquileres_peliculas where id_alquiler='.$fila[0];
			foreach($con->query($pelis) as $fila2){
				$peli = 'select nombre, imagen from peliculas where id_pelicula='.$fila2[0];
				foreach ($con->query($peli) as $fila3){
					echo'
					<tr>
						<td><a href="articulo.php?id_pelicula='.$fila2[0].'"><img src="'.$fila3[1].'" /></a></td>
						<td><a href="articulo.php?id_pelicula='.$fila2[0].'"><span class="nombre">'.$fila3[0].'</span></a></td>
						<td><span>'.$fila2[1].'</span></td>
					</tr>
					';
				}
			}
			
			$juegos = 'select id_juego, cantidad from lineas_alquileres_juegos where id_alquiler='.$fila[0];			
			foreach($con->query($juegos) as $fila4){
				$juego = 'select nombre, imagen from juegos where id_juego='.$fila4[0];
				foreach ($con->query($juego) as $fila5){
					echo'
					<tr>
						<td><a href="articulo.php?id_pelicula='.$fila4[0].'"><img src="'.$fila5[1].'" /></a></td>
						<td><span class="nombre">'.$fila5[0].'</span></td>
						<td><span>'.$fila4[1].'</span></td>
					</tr>
					';
				}
			}
			
			
				echo'	
				</table>
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

