<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/historial_compra.css">
</head>

<body>
	<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<?php
				include "menus.php";
				include "conexion.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<?php
				$con = CrearConexionBD();
				if(isset($_SESSION)){
					echo'<article>
							<h2>Historial de compras</h2>
							<h3>Peliculas</h3>';
					$dni = $_SESSION['dni'];
					$sql = "select id_pelicula, id_pelicula_a_nombre(id_pelicula),cantidad, calidad 
							from lineas_compras_peliculas natural join compras where dni = '$dni'
							order by fecha desc";
					foreach($con->query($sql) as $fila) {
						$id = $fila[0];
						$nombre = $fila[1];
						$cantidad = $fila[2];
						$calidad = $fila[3];
						echo '<ul class="iz">
										
								<li>
									<a href="articulo.php?id_pelicula='.$id.'">
									<img src="img_peliculas/'.$id.'" />
									<figcaption>'.$nombre.'</figcaption></a>
									<figcaption>'.$calidad.'</figcaption>
									<figcaption>'.$cantidad.'</figcaption>
								</li>
								
								
							</ul>';
					}
					echo'<h3>Juegos</h3>';
					$sql2 = "select id_juego, id_juego_a_nombre(id_juego),plataforma,cantidad
						 from lineas_compras_juegos natural join compras where dni = '$dni' order by fecha desc";
					foreach($con->query($sql2) as $fila) {
						$id = $fila[0];
						$nombre = $fila[1];
						$plataforma = $fila[2];
						$cantidad = $fila[3];
						echo '<ul class="iz">
										
								<li>
									<a href="articulo.php?id_juego='.$fila[0].'">
									<img src="img_juegos/'.$fila[0].'" />
									<figcaption>'.$fila[1].'</figcaption></a>
									<figcaption>'.$plataforma.'</figcaption>
									<figcaption>'.$cantidad.'</figcaption>
									
								</li>
								
								
							</ul>';
					
					}
					echo'<h3>Comestibles</h3>';
					$sql3 = "select id_comestible, id_comestible_a_nombre(id_comestible), cantidad
							 from lineas_compras_comestibles natural join compras where dni = '$dni'
							 order by fecha desc";
					foreach($con->query($sql3) as $fila){
						
						$id = $fila[0];
						$nombre = $fila[1];						
						$cantidad = $fila[2];
						echo '<ul class="iz">
										
								<li>
									<a href="articulo.php?id_juego='.$fila[0].'">
									<img src="img_juegos/'.$fila[0].'" />
									<figcaption>'.$fila[1].'</figcaption></a>									
									<figcaption>'.$cantidad.'</figcaption>
									
								</li>
								
								
							</ul>';
					}	
				
					echo'</article>';
					CerrarConexionBD($con);
				}else{
					echo'Usted no tiene permiso para ver esta sección';
				}
				
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