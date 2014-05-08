<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/mis_reservas.css">
	<link rel="icon" href="favicon.png" sizes="32x32" type="image/png">

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
			<article>
				<h2>Mis Reservas</h2>
				<?php
					if(isset($_SESSION['dni']) && isset($_GET['dni'])){
						$dni = $_GET['dni'];
						if($dni==$_SESSION['dni'] || $_SESSION['dni'] == "00000000A"){
							$con = CrearConexionBD();
							$sql = "select id_pelicula, id_pelicula_a_nombre(id_pelicula) 
										from reservas_peliculas 
										where dni='$dni'";
							echo '<ul>';
							foreach ($con->query($sql) as $fila) {
								echo '<li><a href="articulo.php?id_pelicula='.$fila[0].'"><img title="'.$fila[1].'" src="img_peliculas/'.$fila[0].'"/></a></li>';
							}
							$sql = "select id_juego, id_juego_a_nombre(id_juego) from reservas_juegos";
							foreach ($con->query($sql) as $fila) {
								echo '<li><a href="articulo.php?id_juego='.$fila[0].'"><img title="'.$fila[1].'" src="img_juegos/'.$fila[0].'"/></a></li>';
							}
							echo '</ul>';
							CerrarConexionBD($con);
						}							
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