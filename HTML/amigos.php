<!DOCTYPE html>

<html lang="es">

<head>
	
<meta charset="utf-8">
	
<meta name="description" content="Videoclub ORI">
<meta name="keywords" content="videoclub, ori, peliculas">
<title>Videoclub ORI</title>
<link rel="stylesheet" href="css/general.css">
<link rel="stylesheet" href="css/amigos.css">

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
			
			<?php
			include "conexion.php";
			if(isset($_SESSION['dni'])){

			$con = CrearConexionBD();	
			$dni = $_SESSION['dni'];
			$sql = "select amigo2 from amigos where amigo1='$dni'";			
			echo'
			<article >					
				<h2>Tus Amigos</h2>
			</article>
			<article id="amigos">
			
				<ul>	
			';	
				foreach($con->query($sql) as $fila){
				$amigo = "select nombre from socios where dni='$fila[0]'";	
					foreach($con->query($amigo) as $fila2){
					echo'
					<a href="perfil.php?dni='.$fila[0].'"><li>
							
						<img src=img_socios/'.$fila[0].'>
								
						<figcaption class="nombre">'.$fila2[0].'</span>
					</li></a>
					';
					}
				}
			echo'
				</ul>
				
			</article>
			';
			CerrarConexionBD($con);
			
			}
			?>
			
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

