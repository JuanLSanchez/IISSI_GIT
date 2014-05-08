<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
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
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<article>
				<h2>Manual de uso del videoclub</h2>
			</article>
			<article>
				<h3>Controles principales.</h3>
				<p>En esta pagina, podemos encontrar una barra superior de navigación en la que disponemos de diferentes sitios(Inicios, Peliculas, Juegos...). Esta barra la llamaremos a partir de ahora Navegador.</p>	
				<p>Otra de las opciones que nos permiter navegar una vez identificados es una serie de opciones que nos apareceran a la derecha (Alquileres, Devoluciones pendientes, Amigos...). Esto lo identificaremos a partir de ahora como el Menu.</p>
				<h3>Navegador.</h3>
				<img src="img_manual/navegador.png"/>
				<p>Esta barra nos permiter ir ha diferentes sitios, todos publicos.</p>
				<h4>Inicio.</h4>
				<p>Esta es la primera pagina que nos encontraremos por defecto al entrar. Podemos ver diferentes listas de peliculas y videojuegos:</p>
				<ul>
					<li>Novedades Peliculas/Juegos: Listado de los articulos que menos tiempo hacen que han salido en los cines(peliculas) o a la venta(juegos).</li>
					<li>Peliculas/Juegos mas Populares: Articulos con más alquileres en el videoclub.</li>
					<li>Peliculas/Juegos mas Valorados: Articulos con más puntuación en el videoclub.</li>
				</ul>
				<h4>Peliculas/Juegos</h4>
			</article>
		</section>
		<aside id="menu">
			<?php
				Menu();
			?>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>

