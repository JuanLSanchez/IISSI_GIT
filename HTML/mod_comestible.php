<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add.css">
	<link rel="icon" href="favicon.png" sizes="32x32" type="image/png">
</head>
<body>
	
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<?php
				include "conexion.php";
				include "menus.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<article>
				<?php //Modificar
					if(isset($_POST['nombre'])&&$_SESSION['dni'] == '00000000A'){
						$con = CrearConexionBD();

						$id=$_GET['id_comestible'];
						$nombre=$_POST['nombre'];
						$cantidad=$_POST['cantidad'];
						$precio=$_POST['precio'];
						
						$imagen="img_comestibles/".$id;
						if($_FILES['imagen']['error']==0){
							copy($_FILES['imagen']['tmp_name'],$imagen);
						}
						$sql = "update comestibles set nombre='$nombre', 
											cantidad='$cantidad',
											precio = '$precio' 
											where id_comestible='$id'";
						
						$res = $con->exec($sql);
						if($res==1){
							echo '<div class="correcto"><p>El articulo se ha modificado correctamente</p></div>';
						}else{
							echo '<div class="incorrecto"><p>El articulo no se ha modificado</p></div>';
						}
						CerrarConexionBD($con);
					}					
				?>
			</article>
			<article>
				<?php
				if (isset($_SESSION['dni'])) {
						if(!($_SESSION['dni'] == '00000000A')){
							echo '<div class="incorrecto"><p>No eres el administrador, no se guardaran los cambios</p></div>';
						}else{
							$con = CrearConexionBD();
							$id = $_GET['id_comestible'];
							$sql = "select nombre, cantidad, to_char(precio, '990.99') from comestibles where id_comestible='$id'";
							
							$res = $con->query($sql);
							foreach ($res as $fila) {
								$nombre = $fila[0];
								$cantidad = $fila[1];
								$precio = str_replace(".", ",",$fila[2]);
							}
							echo '<form METHOD="POST" ACTION="mod_comestible.php?id_comestible='.$id.'" enctype="multipart/form-data">
									<table>
										<tr><td>Seleccione la imagen: </td><td><input type="file" name="imagen" /></td></tr>
										<tr><td>Nombre: </td><td><input type="text" name="nombre" value="'.$nombre.'"/></td></tr>
										<tr><td>Cantidad: </td><td><input type="text" name="cantidad" value="'.$cantidad.'"/></td></tr>
										<tr><td>Precio: </td><td><input type="text" name="precio" value="'.$precio.'"/></td></tr>
										<tr><td><input type="SUBMIT" value="Añadir"/></td><td></td></tr>
									</table>
								</form>';
							CerrarConexionBD($con);
						}
					}else{
						echo '<div class="incorrecto"><p>Tienes que loguearte para que se guardaran los cambios</p></div>';
					}
				?>
				
			</article>
		</section>
		<aside id="menu">
			<?php Menu();	?>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>

