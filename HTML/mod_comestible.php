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
			<?php
				include "menus.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<article>
				<?php
					include "conexion.php";
					if(isset($_POST['nombre'])){
						
						$con = CrearConexionBD();
						$id=$_GET['id_comestible'];
						$nombre=$_POST['nombre'];
						$cantidad=$_POST['cantidad'];
						$precio=$_POST['precio'];
						$imagen="img_comestibles/".$id;
						$res = $con->exec("update comestibles set 
							nombre='$nombre', cantidad='$cantidad', precio='$precio' 
							where id_comestible='$id'");
						if($_FILES['imagen']['error']==0 && $res==1){
							copy($_FILES['imagen']['tmp_name'],$imagen);
						}
						if($res==1){
							echo "<p>El articulo se ha modificado correctamente</p>";
						}else{
							echo "<p>El articulo no se ha modificado</p>";
						}
						CerrarConexionBD($con);
					}					
				?>
			</article>
			<article>
				<?php
					$id = $_GET['id_comestible'];
					echo '<form METHOD="POST" ACTION="mod_comestible.php?id_comestible='.$id.'" enctype="multipart/form-data">';
					$con = CrearConexionBD();
					$res = $con->query("select * from comestibles where id_comestible='$id'");
					foreach ($res as $fila) {
						$nombre=$fila[1];
						$cantidad=$fila[2];
						$precio=$fila[3];
					}
					if(isset($nombre)){
						echo '<ul>
								<li><span>Seleccione la imagen: </span><input type="file" name="imagen" /></li>
								<li><span>Nombre: </span><input type="text" name="nombre" value="'.$nombre.'"/></li>
								<li><span>Cantidad: </span><input type="text" name="cantidad" value="'.$cantidad.'"/></li>
								<li><span>Precio: </span><input type="text" name="precio" value="'.$precio.'"/></li>
								<li><input type="SUBMIT" value="Añadir"/></li>
							</ul>';	
					}else{
						echo "<p>No existe dicho comestible</p>";
					}
					CerrarConexionBD($con);					
				?>
				</form>
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

