<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/del.css">
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
			<div>
				<article>
				<?php 
				if(isset($_SESSION)){
					if($_SESSION['dni']=='00000000A'){
						include "conexion.php";
						$con = CrearConexionBD();
						if(isset($_GET['id_pelicula'])){
							$articulo = "pelicula";
						}else{
							$articulo = "juego";
						}
						$id=$_GET['id_'.$articulo];
						if($_GET['eliminar']=="yes"){
							$sql="delete from ".$articulo."s where id_".$articulo."='$id'";
							$res=$con->exec($sql);
							if($res==1){
								echo '<div class="correcto"><p>La pelicula se ha eliminardo</p></div>';
							}else{
								echo '<div class="incorrecto"><p>La pelicula no se ha podido eliminar</p></div>';
							}
						}else{
							$sql="select nombre from ".$articulo."s where id_".$articulo."='$id'";
							foreach ($con->query($sql) as $fila) {
								$res=$fila[0];
							}
							echo '<div class="incorrecto"><p class="incorrecto">¿Seguro que desea eliminar la pelicula <a href="articulo.php?id_'.$articulo.'='.$id.'">'.$res.'</a>?</p></div>
							<form METHOD="POST" ACTION="del.php?id_'.$articulo.'='.$id.'&eliminar=yes">
								<input type="submit" value="Eliminar" id="eliminar"/>
							</form>';
						}
						CerrarConexionBD($con);
					}else{
						echo '<div class="incorrecto"><p class="incorrecto">Debe ser administrador para esta operacion.</p></div>';
					}
				}else{
					echo '<div class="incorrecto"><p class="incorrecto">Debe de estar logeado</p></div>';
				}
				?>	
				</article>
			</div>
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
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>

