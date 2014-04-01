<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="../css/general.css">
	<link rel="stylesheet" href="../css/puntuaciones.css">
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
			
			<article>
				<h2> Mis Puntuaciones</h2>
				
						
						<?php
								if(isset($_SESSION['dni'])){
								include "conexion.php";
								$con = CrearConexionBD();
								
								$dni = $_SESSION['dni'];
								
								$sql="select id_pelicula,id_pelicula_a_nombre(id_pelicula),estrellas from puntuaciones_peliculas where dni = '$dni'";
								
								foreach ($con->query($sql) as $fila) {
									
										echo '<ul class="iz">
										
												<li>
													<img src="../img_peliculas/'.$fila[0].'" />
													<figcaption class="nombre">'.$fila[1].'</figcaption>
            										<img class="estrellas" src="../img_ori/'.$fila[2].'_estrellas.png"/>
            										
												</li>
												
												
											</ul>';
									
								}								
								echo '</table>';
								
								CerrarConexionBD($con);
							
								}else{
									
									echo'<p class="incorrecto">No tiene permiso para ver las puntuaciones</p>';
								}
						?>
			</article>	
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

