<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add.css">
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
				<?php
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
							$sql = "select * from comestibles where id_comestible='$id'";
							
							$res = $con->query($sql);
							foreach ($res as $fila) {
								$nombre = $fila[1];
								$cantidad = $fila[2];
								$precio = $fila[3];
							}
							echo '<form METHOD="POST" ACTION="mod_comestible.php?id_comestible='.$id.'" enctype="multipart/form-data">
									<ul>
										<li><span>Seleccione la imagen: </span><input type="file" name="imagen" /></li>
										<li><span>Nombre: </span><input type="text" name="nombre" value="'.$nombre.'"/></li>
										<li><span>Cantidad: </span><input type="text" name="cantidad" value="'.$cantidad.'"/></li>
										<li><span>Precio: </span><input type="text" name="precio" value="'.$precio.'"/></li>
										<li><input type="SUBMIT" value="Añadir"/></li>
									</ul>
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

