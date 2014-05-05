<!DOCTYPE html>

<html lang="es">

<head>
	
<meta charset="utf-8">
<meta name="description" content="Videoclub ORI">
<meta name="keywords" content="videoclub, ori, peliculas">
<title>Videoclub ORI</title>
<link rel="stylesheet" href="css/general.css">
<link rel="stylesheet" href="css/favoritas.css">

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
		if(isset($_SESSION['dni']) && isset($_GET['dni'])){
			$con = CrearConexionBD();
			$dni = $_GET['dni'];
			$usuario = $_SESSION['dni'];
			$res = 0;
			$sql = "select dni_a_nombre(amigo2) from amigos where amigo1='$usuario' and amigo2='$dni'";
			foreach ($con->query($sql) as $fila) {
				$res = $fila[0];
			}
			
			if($res || $dni == $usuario){
				if($res){
					echo '<article>
								<h2>Favoritos de '.$res.'</h2>
						</article>
						<article>
							<ul>';
				}else{
					echo '<article>
								<h2>Favoritos</h2>
						</article>
						<article>
							<ul>';
				}
				$sql = "select id_pelicula, id_pelicula_a_nombre(id_pelicula) from peliculas_favoritos where dni='$dni'";

				foreach($con->query($sql) as $fila){			
					echo'<li>
							<a href="articulo.php?id_pelicula='.$fila[0].'">
								<figure>	
									<img src="img_peliculas/'.$fila[0].'" />
									<figcaption> '.$fila[1].' </figcaption>
								</figure>	
							</a>
						</li>';
				}

				$sql = "select id_juego, id_juego_a_nombre(id_juego) from juegos_favoritos where dni='$dni'";

				foreach($con->query($sql) as $fila){			
					echo'<li>
							<a href="articulo.php?id_juego='.$fila[0].'">
								<figure>	
									<img src="img_juegos/'.$fila[0].'" />
									<figcaption> '.$fila[1].' </figcaption>
								</figure>	
							</a>
						</li>';
				}
			}else{
				header('Location: perfil.php?dni='.$dni);
			}
			CerrarConexionBD($con);
		}
		?>
				</ul>
			</article>
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

