<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/comestibles.css">
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
			<div id="inicio">
				<article >
					<h2>Comestibles</h2>
				</article>
				<article id="ordenar">
					<p id="espacio"></p>
					<span id="nombre">Nombre</span>
					<span>Precio</span>
				</article>
				<article>
					<ul>
						<?php
						include "conexion.php";
						$con = CrearConexionBD();
						$res = $con->query("select id_comestible, nombre, to_char(precio, '990.99') from comestibles");
						foreach ($res as $fila) {
							echo '<li>
									<img src="img_comestibles/'.$fila[0].'" />
									<span class="nombre">'.$fila[1].'</span>
									<span>'.$fila[2].'€</span>
								</li>';
						}
						CerrarConexionBD($con);
						?>
					</ul>
				</article>
			</div>
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

