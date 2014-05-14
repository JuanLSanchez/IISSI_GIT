<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
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
				<p>En esta página, podemos encontrar una barra superior de navegación en la que disponemos de diferentes sitios (Inicio, Peliculas, Juegos...). Esta barra la llamaremos a partir de ahora Navegador.</p>	
				<p>Una vez identificados, aparece a la derecha una serie de opciones como Alquileres, Devoluciones pendientes, Amigos... Esto lo identificaremos a partir de ahora como	Menu.</p>
				<h3>Navegador.</h3>
				<img src="img_manual/navegador.png"/>
				<p>Esta barra nos permiter ir a diferentes sitios, todos públicos.</p>
				<h4>Inicio.</h4>
				<p>Esta es la página que nos encontraremos por defecto al entrar. Podemos ver diferentes listas de peliculas y videojuegos:</p>
				<ul>
					<li>Novedades Peliculas/Juegos: Listado de los artículos que menos tiempo hacen que han salido en los cines(peliculas) o a la venta(juegos).</li>
					<li>Peliculas/Juegos más Populares: Artículos con más alquileres en el videoclub.</li>
					<li>Peliculas/Juegos más Valorados: Artículos con más puntuación en el videoclub.</li>
				</ul>
				<h4>Peliculas/Juegos</h4>
				<h3>Menú - Usuario</h3>
				<p>Cada usuario tendrá este menú en el que podrá ver la información sobre sus películas favoritas, puntuaciones realizadas, etc.</p>
				<img src="img_manual/menu.png"/>
				<h4>Mis Alquileres</h4>
				<p>En esta página podemos encontrar el historial de los alquileres realizados en el videoclub ORI. Cada alquiler realizado contendrá la fecha en la que se realizó y la información sobre los nombres de las películas y videojuegos, así como su cantidad alquilada.</p>
				<h4>Devoluciones Pendientes</h4>
				<p>Esta sección contendrá la información sobre los alquileres que tenemos aún por devolver. Al igual que en mis alquileres, contendrá información sobre la fecha y la duración en la que se realizó el alquiler, así como los artículos y su cantidad.</p>
				<h4>Favoritas, Vistas y Pendientes.</h4>
				<p>Cada una de estas páginas guarda los artículos que tenemos, respectivamente como favoritos, vistos o pendientes, tanto de ver si se trata de películas, como de jugar si se tratan de juegos.</p>
				<h4>Mis Reservas.</h4>
				<p>Contiene la información sobre los artículos reservados por el usuario. Para reservar un artículo solo tenemos que darle al botón |Reservar|, que se encuentra en la página del artículo en cuestión. Como se ve a continuación:</p>
				<img src="img_manual/reservar.png"/>
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

