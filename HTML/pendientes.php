<!DOCTYPE html>

<html lang="es">

<head>
	
<meta charset="utf-8">
<meta name="description" content="Videoclub ORI">
<meta name="keywords" content="videoclub, ori, peliculas">
<title>Videoclub ORI</title>
<link rel="stylesheet" href="css/general.css">
<link rel="stylesheet" href="css/pendientes.css">

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
			$sql = "select id_pelicula, id_pelicula_a_nombre(id_pelicula) from peliculas_pendientes where dni='$dni'";
			echo'
		<div id="inicio">
				
			<article>
					<h2>Películas Pendientes</h2>
			</article>
			<article>
			<ul>
			';
			foreach($con->query($sql) as $fila){
			
				echo'
			
					
				
						
					<li>
						<figure>	
					<a href="articulo.php?id_pelicula='.$fila[0].'"><img src="img_peliculas/'.$fila[0].'" /></a>

					<figcaption> '.$fila[1].' </figcaption>
						</figure>	
					</li>

				
				
			
			';
			}
		echo'
		</ul>
		</article>
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

