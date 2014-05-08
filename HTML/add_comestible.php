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

	<script type="text/javascript">
		function procesaFormulario(){
			var nombre = document.getElementById("nombre").value;
			var cantidad = document.getElementById("cantidad").value;
			var patronCantidad = /\d{1,4}/;
			var precio = document.getElementById("precio").value;
			var patronPrecio = /\d{1,5}[\,]\d{1,2}/;
			var error = "";
			if(nombre==""){
				error += '<div class="incorrecto"><p>Introduzca un nombre valido.<div class="incorrecto"><p>';
			}
			if(patronCantidad.test(cantidad)==false){
				error += '<div class="incorrecto"><p>La cantidad tiene que ser mayor o igual a 0.<div class="incorrecto"><p>';
			}
			if(patronPrecio.test(precio)==false){
				error += '<div class="incorrecto"><p>Precio incorrecto, siga el ejemplo.<div class="incorrecto"><p>';
			}
			if(error==""){
				return true;
			}else{

				document.getElementById("error").innerHTML=error;
				return false;
			}
			
		}
	</script>
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
				<div id="error"></div>
				<?php
					if(isset($_POST['nombre'])&&$_SESSION['dni'] == '00000000A'){
						include "conexion.php";
						$con = CrearConexionBD();
						$res = $con->query("select id_comestible.nextval from dual");
						foreach ($res as $fila) {
							$id=$fila[0];
						}
						$nombre=str_replace("'", "''", $_POST['nombre']);
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
							echo "<p>No se ha añadido imagen</p>";
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
				<form METHOD="POST" onsubmit="return procesaFormulario()" ACTION="add_comestible.php" enctype="multipart/form-data">
					<table>
						<tr><td>Seleccione la imagen: </td><td><input type="file" name="imagen" /></td></tr>
						<tr><td>Nombre: </td><td><input type="text" id="nombre" name="nombre" required/></td></tr>
						<tr><td>Cantidad: </td><td><input type="number" id="cantidad" name="cantidad"  pattern="\d{1,4}"prequired/></td></tr>
						<tr><td>Precio: </td><td><input type="text" id="precio" name="precio" placeholder="Ej: 0,3" title="Siga el ejemplo." pattern="\d{1,5}[\,]\d{1,2}" required/></td></tr>
						<tr><td><input type="SUBMIT" value="Añadir"/></td><td></td></tr>
					</table>
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

