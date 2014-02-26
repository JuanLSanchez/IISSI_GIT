
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/add_pelicula.css">
</head>
<body>
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<ul>
				<li>Inicio</li>
				<li>Peliculas</li>
				<li>Juegos</li>
				<li>Comestibles</li>
				<li>Informacion</li>
			</ul>
		</nav>
		<section id="seccion">
			<article>

				
				<?php
					echo '<form METHOD="POST" ACTION="add2.php?articulo='.$_GET['articulo'].'" enctype="multipart/form-data">'
				?>
				
				<ul>
					<li><span>Seleccione la imagen: </span><input type="file" name="imagen" /></li>
					<li><span>Nombre: </span><input type="text" name="nombre"></li>
					<li><span>Año de lanzamiento(ej: 05/03/1999): </span><input type="text" name="year"/></li>
					<li><span>Edad restrictiva: </span><input type="text" name="edad"/></li>
					<li><span>Trailer(URL): </span><input type="text" name="trailer"/></li>
					<li><span>Sinopsis: </span><textarea id="sinopsis" name="sinopsis" cols="70" rows="15"></textarea></li>
					<li><span>Numero de peliculas de alquiler: </span><input type="number" name="alquiler"/></li>
					<li><span>Generos a los que pertenece: </span></li>
					<?php
						include "conexion.php";
						$con = CrearConexionBD();
						$cont = 0;
						$nombre = "genero";
						$sql = "select genero from generos_".$_GET['articulo']."s";
						echo '<li>';
						foreach ($con->query($sql) as $fila) {
							echo '<div class="check">
										<input type="checkbox" name="'.$nombre.$cont.'" value="'.$fila[0].'"/>
										<span>'.$fila[0].'</span>
									</div>';
							$cont++;
						}
						echo '</li>
								<li><span>Cantidades de peliculas para vender: </span></li>
								<li><span>Tipo </span><span>Cantidad </span><span>Precio </span>';
						if($_GET['articulo']=="juego"){
							$sql="select * from plataformas";
						}else{
							$sql = "select * from calidad_visual";
						}
						$cont=0;
						
						foreach ($con->query($sql) as $fila) {
							echo '<div class="venta">
									<input type="checkbox" value="'.urlencode($fila[0]).'" name="venta'.$cont.'"/>
									<span>'.$fila[0].'</span>
									<input type="text" size=5 name="cantidadventa'.$cont.'"/>
									<input type="text" size=5 name="precioventa'.$cont.'"/>
									</div>';
							$cont++;
						}
						echo '</li>';
					?>
					<li><input type="SUBMIT" value="Añadir"/></li>
				</ul>
			</form>
			</article>
		</section>
		<aside id="menu">
			<ul>
				<li>Alquileres</li>
				<li>Devoluciones pendientes</li>
				<li>Amigos</li>
				<li>Pendientes</li>
				<li>Favoritas</li>
				<li>Mis puntuaciones</li>
				<li>Mi perfil</li>
			</ul>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>