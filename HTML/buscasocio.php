<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="../css/general.css">
	<link rel="stylesheet" href="../css/buscasocio.css">
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
			<h2> Usuarios</h2>
			<form id="formulario" method="get" action="buscasocio.php" enctype="application/x-www-form-urlencoded">
				
				<?php
						
						$busqueda = "";						
						if(isset($_GET['busqueda'])){
							$busqueda = $_GET['busqueda'];
							
						}
						echo '
						<div class="search">
							<input type="search" name="busqueda" value="'.$busqueda.'"/>
							<input type="submit" value="Buscar" />
						</div>';						
						
				?>
					
			</form>
			</article>
			<article>
				<?php
							if(isset($_GET['busqueda'])){
								//Iniciacion de variables
								$con = CrearConexionBD();
								$cad = urldecode($_GET['busqueda']);											
																
								$sql = "select dni, nombre from socios where 
											upper(nombre) like upper('%".$cad."%')";
								
								echo '<ul>';
								foreach ( $con->query($sql) as $fila) {
										echo '<li>
													<a href="perfil.php?dni='.$fila[0].'"><figure><img src="../img_socios/'.$fila[0].'" />
													<figcaption class="nombre">'.$fila[1].'</figcaption></figure></a>
													
												</li>';
								}
								echo '</ul>';	
																
								CerrarConexionBD($con);
							}
							
						?>
				
			</article>	
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