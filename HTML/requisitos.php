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
	<link rel="stylesheet" href="css/requisitos.css">
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
				<table>
					<h3>Requisitos.</h3>
					<tr><td>Descripción</td><td>Ejemplos</td></tr>
					<tr><td>Ausencia de errores de programación.</td><td>No hemos detectado ningun herror en la programación de ninguna nuestras paginas</td></tr>
					<tr><td>Usar marcado HTML estricto.</td><td>Todas nuestras paginas estan hecha en HTML5, con marcado estricto</td></tr>
					<tr><td>Usar hojas de estilo CSS en archivos externos.</td><td>Todas nuestras paginas tienen de uno a dos archivos css externos. Siempre tienen uno que es el general y pueden tener otro secundario que es especifico para ella.</td></tr>
					<tr><td>Maquetar con CSS todas las páginas.</td><td>Todas las paginas estan maquetadas con CSS</td></tr>
					<tr><td>Usar formularios.</td><td>Tenemos una gran variedad de formularios como pueden ser: <ul>
						<li><a href="add.php?articulo=pelicula">Añadir una pelicula.</a></li>
						<li><a href="add_usuario.php">Añadir un usuario.</a></li>
						<li><a href="add_comestible.php">Añadir un comestible.</a></li>
					</ul></td></tr>
					<tr><td>Validar todos los formularios en cliente (con JS y/o con HTML5).</td><td>Nuestros formularios estan validados con js y HTML5, ejemplos:<ul>
						<li><a href="add.php?articulo=pelicula">Añadir una pelicula.</a></li>
						<li><a href="add_usuario.php">Añadir un usuario.</a></li>
						<li><a href="add_comestible.php">Añadir un comestible.</a></li>
					</ul></td></tr>
					<tr><td>Validar todos los formularios en servidor.</td><td>Todos los formularios, son validados en el servidor, ejemplos: <ul>
						<li><a href="add.php?articulo=pelicula">Añadir una pelicula.</a></li>
						<li><a href="add_usuario.php">Añadir un usuario.</a></li>
						<li><a href="add_comestible.php">Añadir un comestible.</a></li>
					</ul></td></tr>
					<tr><td>Acceder a una base de datos en 3FN para inserción,actualización, borrado y consulta.</td><td>Accedemos de todas las formas posibles a la base de datos. Algunos ejemplos son:<ul>
							<li>Inserción: <a href="add.php?articulo=juego">Añadir un juego</a></li>
							<li>Actualización: Todas las peliculas, si eres administrador, te mostraran un boton de modificar</li>
							<li>Borrado: Todas las peliculas, si eres administrador, te mostraran un boton de modificar</li>
							<li>Consulta: <a href="peliculas.php?busqueda=&inicio_year=&fin_year=&genero=Ninguno&orden=Nombre&torden=asc&peliculas=5&visualizacion=extendida">Buscar peliculas</a></li>
					</ul></td></tr>
					<tr><td>Formatear el resultado de al menos una consulta a la base de datos en una tabla HTML.</td><td>Ejemplos:<ul>
						<li><a href="peliculas.php?busqueda=&inicio_year=&fin_year=&genero=Ninguno&orden=Nombre&torden=asc&peliculas=5&visualizacion=extendida">Buscar peliculas</a></li>
						<li><a href="comestibles.php">Comestibles</a></li>
					</ul></td></tr>
					<tr><td>Realizar tratamiento de excepciones de acceso a bases de datos en servidor manteniendo siempre el control de la aplicación</td>
						<td>Cuando la conexion o la base de datos produce un error nos saldra un mensaje de error</td></tr>
				</table>
				<h3>Extras.</h3>
				<table>					
					<tr><td>Descripción</td><td>Ejemplos</td></tr>
					<tr><td>Una página HTML de descripción de la aplicación.</td><td><a href="manual.php">Manual</a></td></tr>
					<tr><td>Uso avanzado de html5</td><td></td></tr>
					<tr><td>Uso avanzado de JavaScript en cliente (aparte de validación).</td><td>La puntuacion mediante estrellas de los articulos esta echa con javascript. Tambien el añadir mas articulos a un alquiler o compra</td></tr>
					<tr><td>Uso de expresiones regulares tanto en cliente (Javascript) como en servidor (PHP).</td><td>La validacion de los formularios incluye expresiones regulares tanto en javascript en el lado del cliente como en PHP en el lado del servidor. Ejemplos: <ul>
						<li><a href="add.php?articulo=pelicula">Añadir una pelicula.</a></li>
						<li><a href="add_usuario.php">Añadir un usuario.</a></li>
						<li><a href="add_comestible.php">Añadir un comestible.</a></li>
					</ul></td></tr>
					<tr><td>Facilidad de navegación por la aplicación web.</td><td>En nuestra aplicación web tenemos un menu(parte izquierda) y un navegador(parte superior) con el que podemos acceder a cualquier rincon de nuestro videoclub</td></tr>
					<tr><td>Usabilidad de la aplicación web.</td><td>Esta aplicación podría ser muy util para un videoclub y las personas que le gusten las peliculas y dar su opinion sobre ellas</td></tr>
					<tr><td>Modularidad de código PHP en servidor (uso de include y similares, reutilización de código, uso de buenas prácticas).</td>
						<td>Parte de nuestro codigo PHP esta modularizado para facilitar la modificación del mismo. Por ejemplo tenemos el menu y el navegador que estan en un fichero y que se cargan en todas las paginas. Tambien la conexion a la base de datos.</td></tr>
					<tr><td>Uso de la sesión en PHP ($_SESSION).</td><td>Para el manejo de usuarios utilizamos la variable $_SESSION</td></tr>
					<tr><td>Estar validada por los validadores del W3C</td><td>Gran parte de nuestras paginas estan validadas en HTML5 y CSS3 como por ejemplo: <ul>
						<li><a href="index.php">Inicio.</a></li>
						<li><a href="alquileres.php">Mis Alquileres</a></li>
					</ul></td></tr>
				</table>
			</article>			
		</section>
		<aside id="menu">
			<?php
				Menu();
			?>
		</aside>
		<footer id="pie">
			<p>
			    <img src="img_ori/vcss.gif" />
			    <img src="img_ori/valid-html5.png"/>
			</p>
		</footer>
	</div>
</body>
</html>

