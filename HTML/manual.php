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
				<img src="img_manual/navegador.png"alt=""/>
				<p>Esta barra nos permiter ir a diferentes sitios, todos públicos.</p>
				<h4>Inicio.</h4>
				<p>Esta es la página que nos encontraremos por defecto al entrar. Podemos ver diferentes listas de peliculas y videojuegos:</p>
				<ul>
					<li>Novedades Peliculas/Juegos: Listado de los artículos que menos tiempo hacen que han salido en los cines(peliculas) o a la venta(juegos).</li>
					<li>Peliculas/Juegos más Populares: Artículos con más alquileres en el videoclub.</li>
					<li>Peliculas/Juegos más Valorados: Artículos con más puntuación en el videoclub.</li>
				</ul>
				<h4>Peliculas/Juegos</h4>
				<p>Aquí podremos buscar tanto juegos y películas. Disponemos también de diversos filtros para una mejor visualización de la búsqueda.</p>
				<h4>Comestibles</h4>
				<p>Se nos muestra una lista de los comestibles disponibles para los clientes en el videoclub. El administrador dispondrá de dos botones auxiliares para modificar o eliminar el comestible.</p>
				<h4>Información</h4>
				<p>Información sobre el dueño del videoclub, además de la localización del mismo mediante una dirección y un mapa</p>
				<h4>Manual</h4>
				<p>Breve explicación sobre el uso de los recursos que ofrece esta página web.</p>
				<h4>Requisitos y Extras</h4>
				<p>Breve tabla explicativa sobre los requisitos mínimos y extras para el proyecto de IISSI</p>
				<h3>Menú - Usuario</h3>
				<p>Cada usuario tendrá este menú en el que podrá ver la información sobre sus películas favoritas, puntuaciones realizadas, etc.</p>
				<img src="img_manual/menu.png"alt=""/>
				<h4>Mis Alquileres</h4>
				<p>En esta página podemos encontrar el historial de los alquileres realizados en el videoclub ORI. Cada alquiler realizado contendrá la fecha en la que se realizó y la información sobre los nombres de las películas y videojuegos, así como su cantidad alquilada.</p>
				<h4>Devoluciones Pendientes</h4>
				<p>Esta sección contendrá la información sobre los alquileres que tenemos aún por devolver. Al igual que en mis alquileres, contendrá información sobre la fecha y la duración en la que se realizó el alquiler, así como los artículos y su cantidad.</p>
				<h4>Favoritas, Vistas y Pendientes.</h4>
				<p>Cada una de estas páginas guarda los artículos que tenemos, respectivamente como favoritos, vistos o pendientes, tanto de ver si se trata de películas, como de jugar si se tratan de juegos.</p>
				<h4>Mis Reservas.</h4>
				<p>Contiene la información sobre los artículos reservados por el usuario. Para reservar un artículo solo tenemos que darle al botón |Reservar|, que se encuentra en la página del artículo en cuestión. Como se ve a continuación:</p>
				<img src="img_manual/reservar.png" alt=""/>
				<h4>Mi perfil</h4>
				<p>En este apartado encontraremos toda la información sobre nuestro perfil, es decir nuestro DNI, nombre, apellidos, email, etc. Además podemos ver todos los comentarios realizados, tanto de películas como de videojuegos.</p>
				<h4>Mis Puntuaciones</h4>
				<p>En esta página, encontramos todos los artículos, tanto películas como videojuegos, puntuados por nosotros.</p>
				<img src="img_manual/mispuntuaciones.png" alt=""/>
				<h4>Mis Amigos</h4>
				<p>Muestra todos los usuarios que son tus amigos.</p>
				<h4>Mis Compras</h4>
				<p>Muestra las compras realizadas. Cada compra incluye las películas, videojuegos y comestibles que compraste en el videoclub desde la fecha del registro.</p>
				<h4>Buscar Socio</h4>
				<p>En esta página puedes buscar usuarios y acceder a sus páginas de perfiles en la que se encuentra toda su información.</p>
				<h3>Menú - Administrador</h3>
				<p>Este menú sólo estará disponible para el administrador, y en él se podrá tanto añadir, como modificar artículos, usuarios, comestibles...</p>
				<img src="img_manual/menu_ad.png" alt="">
				<h4>Añadir Película</h4>
				<p>En este apartado podremos, sólo si somos administrador, añadir una película a nuestra web.</p>
				<h4>Añadir Juego</h4>
				<p>Análogo a "Añadir Película"pero añadiendo juegos en vez de películas"</p>
				<h4>Añadir Usuario</h4>
				<p>Podremos añadir un usuario a la web, introduciendo la información personal sobre el usuario, como el DNI, nombre, email, dirección...</p>
				<h4>Añadir Comestible</h4>
				<p>Podremos añadir comestibles a la web:</p>
				<img src="img_manual/add_comestible.png" alt="">
				<h4>Usuarios con Devoluciones Pendientes</h4>
				<p>Aquí podremos ver a aquellos usuarios que tienen devoluciones pendientes. Si se clickea en el usuario se muestran los artículos que quedan por devolver.</p>
				<h4>Alquiler, Devolución, Compras y Ofertas</h4>
				<p>En estas páginas podremos, respectivamentes, añadir alquileres, devoluciones, compras y ofertas a la web.</p>
				<img src="img_manual/oferta.png" alt="">
				<h4>Géneros Juegos y Géneros Películas.</h4>
				<p>En esta página podremos añadir y eliminar los géneros de los videojuegos y películas disponibles en nuestra web.</p>
				<h4>Plataformas y Calidades.</h4>
				<p>Aquí, al igual que en las páginas de géneros, podremos añadir o eliminar plataformas y calidades.</p>
				<img src="img_manual/calidades.png" alt="">
				<h3>Páginas Secundarias</h3>
				<h4>Películas y Juegos</h4>
				<p>Esta página muestra la información sobre un artículo. Podemos encontrar El tíyulo, una descripción, una imagen, calidades disponibles, puntuacion media, comentarios...</p>
				<p>El administrador dispondrá de botones auxiliares para modificar o eliminar el artículo en cuestión.</p>
				<h4>Usuario</h4>
				<p>Para ser amigo de alguien, debemos entrar en su perfil y darle al botón de añadir como amigo. Él no te agregará pero tú lo seguirás, similar a Twitter.</p>
				<p>Una vez accedido al perfil de un amigo, se nos mostrará su información pública, como nombre, email, sus películas pendientes...</p>
				<p>El administrador dispondrá de dos botones auxiliares para modificar la información del usuario o para eliminarlo.</p>
				<img src="img_manual/amigo.png" alt="">
			</article>
		</section>
		<aside id="menu">
			<?php
				Menu();
			?>
		</aside>
		<footer id="pie">
			<img src="img_ori/valid-html5.png" alt="" />
			<img src="img_ori/vcss.gif" alt="" />
		</footer>
	</div>
</body>
</html>

