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
				include "menus.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<article>
				<?php
					if(isset($_POST['nombre'])&&$_SESSION['dni'] == '00000000A'){
						include "conexion.php";
						$con = CrearConexionBD();
						$res = $con->query("select id_comestible.nextval from dual");
						foreach ($res as $fila) {
							$id=$fila[0];
						}
						$nombre=$_POST['nombre'];
						if(isset($_POST['cantidad'])){
							$cantidad=$_POST['cantidad'];
						}else{
							echo "<p>No se ha añadido cantidad</p>";
						}
						if(isset($_POST['precio'])){
							$precio=$_POST['precio'];
						}else{
							echo "<p>No se ha añadido precio</p>";
						}
						$imagen="img_comestibles/".$id;
						if($_FILES['imagen']['error']==0){
							copy($_FILES['imagen']['tmp_name'],$imagen);
						}else{
							echo "<p>No se h añadido imagen</p>";
						}
						$res = $con->exec("insert into comestibles values('$id', '$nombre', '$cantidad', '$precio')");
						if($res==1){
							echo '<div class="correcto"><p>El articulo se ha añadido correctamente</p></div>';
						}else{
							echo '<div class="incorrecto"><p>El articulo no se ha añadido</p></div>';
						}
						CerrarConexionBD($con);
					}					
				?>
			</article>
			<article>
				<?php
				if (isset($_SESSION['dni'])) {
						if(!($_SESSION['dni'] == '00000000A')){
							echo '<p>No eres el administrador, no se guardaran los cambios</p>';
						}
					}else{
						echo '<p>Tienes que loguearte para que se guardaran los cambios</p>';
					}
				?>
				<form METHOD="POST" ACTION="add_comestible.php" enctype="multipart/form-data">
					<ul>
						<li><span>Seleccione la imagen: </span><input type="file" name="imagen" /></li>
						<li><span>Nombre: </span><input type="text" name="nombre"/></li>
						<li><span>Cantidad: </span><input type="text" name="cantidad"/></li>
						<li><span>Precio: </span><input type="text" name="precio"/></li>
						<li><input type="SUBMIT" value="Añadir"/></li>
					</ul>
				</form>
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

