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
		if(isset($_GET['dni']) && isset($_SESSION['dni'])){
			if($_SESSION['dni']==$_GET['dni'] || $_SESSION['dni']=="00000000A"){
				include "conexion.php";
				$con = CrearConexionBD();
				if($con){	
					$dni = $_GET['dni'];
					$sql = "select id_alquiler, fecha, tiempo from 
							(select id_alquiler,fecha,tiempo from alquileres 
								where dni='$dni' order by fecha desc) 
							where rownum=1";
					
					echo'<article>
								<h2>Devoluciones Pendientes</h2>
						</article>';
						foreach($con->query($sql) as $fila){
							$duracion = $fila[2];
							$pelis = 'select id_pelicula, cantidad from lineas_alquileres_peliculas where id_alquiler='.$fila[0];
							$juegos = 'select id_juego, cantidad from lineas_alquileres_juegos where id_alquiler='.$fila[0];
							$array;
							$cont = 0;
							foreach($con->query($pelis) as $f){
								$cont++;
							}
							foreach($con->query($juegos) as $fi){
								$cont++;
							}
							if($cont>=1){
							echo'
							<article>
			
								<table>
									<tr class="primera">
											<td  class="fechaini">Fecha del Alquiler '.$fila[1].'<br />Duración: '.$duracion.' Horas</td>
											<td  class="nombre2">Nombre</td>
											<td  class="cantidad">Cantidad</td>
									</tr>
							';
			
							foreach($con->query($pelis) as $fila2){
								$peli = 'select nombre, imagen from peliculas where id_pelicula='.$fila2[0];
								foreach ($con->query($peli) as $fila3){
									echo'
									<tr>
										<td><a href="articulo.php?id_pelicula='.$fila2[0].'"><img src="'.$fila3[1].'" alt="" /></a></td>
										<td><a href="articulo.php?id_pelicula='.$fila2[0].'"><span class="nombre">'.$fila3[0].'</span></a></td>
										<td><span>'.$fila2[1].'</span></td>
									</tr>
									';
								}
							}
							
									
							foreach($con->query($juegos) as $fila4){
								$juego = 'select nombre, imagen from juegos where id_juego='.$fila4[0];
								foreach ($con->query($juego) as $fila5){
									echo'
									<tr>
										<td><a href="articulo.php?id_juego='.$fila4[0].'"><img src="'.$fila5[1].'" alt="" /></a></td>
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
							}else{
							
							echo'<div class="correcto"><p>No tiene devoluciones Pendientes</p></div>';
							
						}
						}	
							CerrarConexionBD($con);
					}
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

