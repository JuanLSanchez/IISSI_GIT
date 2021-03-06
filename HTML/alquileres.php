﻿<!DOCTYPE html>

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
		if(isset($_SESSION['dni'])){
			include "conexion.php";
			$con = CrearConexionBD();
			if($con){	
				$dni = $_SESSION['dni'];
				$sql = "select id_devolucion,fecha from devoluciones where dni='$dni' order by fecha desc";
				echo'
				<article>
						<h2>Alquileres Realizados</h2>
				</article>
				<article>
				';
				foreach ($con->query($sql) as $fila){
				echo'
				

					<table>
						<tr>
							<td class="imagen">Fecha: '.$fila[1].'</td>
							<td class="nombre">Nombre</td>
							<td class="cantidad">Cantidad</td>
						</tr>
						';
						$pelis = 'select id_pelicula, cantidad from lineas_devoluciones_peliculas where id_devolucion='.$fila[0];
						foreach ($con->query($pelis) as $fila2){
						$peli = 'select nombre, imagen from peliculas where id_pelicula='.$fila2[0];
						foreach ($con->query($peli) as $fila3){
						echo'
						<tr>
							<td class="imagen"><a href="articulo.php?id_pelicula='.$fila2[0].'"><img src="'.$fila3[1].'" alt="" /></a></td>
							<td class="nombre"><a href="articulo.php?id_pelicula='.$fila2[0].'">'.$fila3[0].'</a></td>
							<td class="cantidad">'.$fila2[1].'</td>
						</tr>
						';
						}
						}
						

						$juegos = 'select id_juego,cantidad from lineas_devoluciones_juegos where id_devolucion='.$fila[0];
						foreach ($con->query($juegos) as $fila4){
						$juego = 'select nombre, imagen from juegos where id_juego='.$fila4[0];
						foreach ($con->query($juego) as $fila5){
						echo'
						<tr>
							<td class="imagen"><a href="articulo.php?id_juego='.$fila4[0].'"><img src="'.$fila5[1].'" alt="" /></a></td>
							<td class="nombre"><a href="articulo.php?id_juego='.$fila4[0].'"><span class="nombre">'.$fila5[0].'</span></a></td>
							<td class="cantidad"><span>'.$fila4[1].'</span></td>
						</tr>
						';
						}
						}
						

				echo'
					</table>
				
				';

				}
				echo'</article>	';
				CerrarConexionBD($con);
			}
				}
			?>
		</section>

		
	<aside id="menu">
			
			<?php 
			
			Menu(); ?>
		
	</aside>
		
<footer id="pie">
			
<img src="img_ori/valid-html5.png" alt="" />
<img src="img_ori/vcss.gif" alt="" />
		
</footer>
	
</div>

</body>

</html>

