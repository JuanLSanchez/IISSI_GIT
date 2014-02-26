<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/pelicula.css">
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
			<?php
			include "conexion.php";
			$con = CrearConexionBD();
			if(isset($_GET['id_pelicula'])){
				$articulo = "pelicula";
			}else{
				$articulo = "juego";
			}
			$id=$_GET['id_'.$articulo];
			$sql = "select * from ".$articulo."s where id_".$articulo."=".$id;
			$res = $con->query($sql);
			//$genero = $con->query("select genero from relacion_".$articulo."s_genero where id_".$articulo."=".$id);
			foreach ($res as $fila){
				$nombre = $fila[1];
				$edad = $fila[2];
				$imagen = $fila[3];
				$trailer = $fila[4];
				$sinopsis = $fila[5];
				$alquiler = $fila[6];
				$year = $fila[7];
				$puntuacion = "3.4";
				$estado = "Pendiente";
				$reserva = "Reservar";
			}
			if(isset($nombre)){
			echo '<article id="iz">
				<img class="bl" src="'.$imagen.'" />
				<input class="bl" type="button" value="'.$reserva.'" />
				<span class="bl" >Puntuacion: '.$puntuacion.'</span>
				<div class="menu-bar">
					<ul class="desplegable">
						<li>
							<input class="menu-nav" type="button" value="'.$estado.'"  class="estado"/>
							<ul>
								<li><input type="button" value="Pendiente" class="estado"/></li>
								<li><input type="button" value="Vista"  class="estado"/></li>
								<li><input type="button" value="Favorita"  class="estado"/></li>
							</ul>
						</li>
					</ul>
				</div>
			</article>
			<article id="de">
				<h3>'.$nombre.'</h3>
				<div id="sinopsis">
					<span>'.$sinopsis.'</span>
				</div>
				<div id="genero"><span>Genero: ';
				$sql = "select genero from relacion_".$articulo."s_genero where id_".$articulo."=".$id;
				$generos = $con->query($sql);
				$bandera = 1==1;
				foreach ($generos as $genero) {
					if($bandera){
						echo $genero[0];
						$bandera = 1==2;
					}else{
						echo ", ".$genero[0];
					}
					
				}

				echo '.</span></div>
				<textarea name="comentario" id="comente" cols="60" rows="6" placeholder="Comente algo..."/></textarea>
				<input type="button" value="Comentar" id="boton"/>
			</article>
			<article id="comentarios">
				<ul>
					<li>
						<h3>Comentarios</h3>
					</li>
					<li>
						<table>
							<tr class="fila1"><td><spam class="autor">Autor: Juan Luis</spam> <spam class="fecha"> Fecha: 22/3/2012</spam></td></tr>
							<tr class="fila2"><td>Esto es el comentario de una pelicula me tengo que enrrollar para ver si puedo ocupar mas de una linea, la pelicula es 2 Guns, a mi me gusto no se a ustedes asi que le dare buena puntuación</td></tr>
						</table>
					</li>
					<li>
						<table>
							<tr class="fila1"><td><spam class="autor">Autor: Juan Luis</spam> <spam class="fecha"> Fecha: 22/3/2012</spam></td></tr>
							<tr class="fila2"><td>Esto es el comentario de una pelicula me tengo que enrrollar para ver si puedo ocupar mas de una linea, la pelicula es 2 Guns, a mi me gusto no se a ustedes asi que le dare buena puntuación</td></tr>
						</table>
					</li>
				</ul>
			</article>';
		}else{
			echo "<p>No existe esa pelicula</p>";
		}
			CerrarConexionBD($con);
			?>
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
