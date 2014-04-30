<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/usuarios_con_devoluciones.css">
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
				
					<?php
						$con = CrearConexionBD();
						$sql = "select dni, dni_a_nombre(dni) from alquileres where 
						id_alquiler in 
							(select id_alquiler from lineas_alquileres_peliculas)
						or
						id_alquiler in 
							(select id_alquiler from lineas_alquileres_juegos)";
						echo '<ul>';
						foreach ($con->query($sql) as $fila) {
							echo '<li>
							<a href="devoluciones.php?dni='.$fila[0].'">
								<figure title="'.$fila[1].'">
									<img src="img_socios/'.$fila[0].'"/>
									<figcaption>'.$fila[0].'</figcaption>
								</figure>
								</a>
							</li>';
						}
						echo '</ul>';
						
					?>
			</article>
		</section>
		<aside id="menu">
			<?php
			if(isset($_POST['dni'])){
				$con = CrearConexionBD();
				$dni = $_POST['dni'];
				$key = $_POST['key'];
				$sql = "select dni, nombre from socios where 
						dni='$dni' and key='$key'";
				$query = $con->query($sql);
				if($res = $query->fetch()){
					$_SESSION['dni'] = $res['0'];
					$_SESSION['nombre'] = $res['1'];
				}else{
					echo '<div class="incorrecto"><p>Contraseña o usuario incorrectos</p></div>';
				}
			}
			if(isset($_GET['logout'])){
				$_SESSION = array();
				session_destroy();
			}
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

