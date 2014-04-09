
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add.css">

	<script type="text/javascript">
		function procesaFormulario(){
			var nombre = document.getElementById("nombre").value;
			var year = document.getElementById("year").value;
			var patronYear = /^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/]\d{4}$/;
			var edad = document.getElementById("edad").value;
			var patronEdad = /^\d|1[0-8]$/;
			var trailer = document.getElementById("trailer").value;
			var sinopsis = document.getElementById("sinopsis").value;
			var error = "";
			if(nombre==""){
				error += '<div class="incorrecto"><p>Introduzca un nombre.</p></div>';
			}
			if(patronYear.test(year)==false){
				error += '<div class="incorrecto"><p>La fecha no es correcta.</p></div>';
			}
			if(patronEdad.test(edad)==false){
				error += '<div class="incorrecto"><p>La edad no es correcta.</p></div>';
			}
			if(error!=""){
				//document.getElementById("error").innerHTML=error;
				alert(error);
				return false;
			}else{
				return true;
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
				include "conexion.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<article>
				<div id="error"></div>
				<?php //Añadir articulo
				if(isset($_POST['nombre'])&&$_SESSION['dni'] == '00000000A'){
					$con = CrearConexionBD();
					//Inicializacion de las variables
					$error = "";
					$articulo = $_GET['articulo'];
					$nombre = $_POST["nombre"];
					$edad = $_POST["edad"];
					$trailer = $_POST["trailer"];
					$sinopsis = $_POST["sinopsis"];
					$year = $_POST["year"];
					if ($articulo==""){
						$error += '<div class="incorrecto"><p>Define el articulo.</p></div>';
					}
					if($nombre==""){
						$error += '<div class="incorrecto"><p>Introduzca un nombre.</p></div>';
					}
					if(!($edad<=18&&$edad>=0)){
						$error += '<div class="incorrecto"><p>Edad restrictiva incorrecta.</p></div>';
					}
					if($error==""){
						//Obtener un ID
						$sql = "select id_".$articulo.".nextval from dual";
						$res = $con->query($sql);
						foreach ($res as $fila) {
							$id = $fila[0];
						}
						
						$imagen = "img_".$articulo."s/" . $id;
						//Definir el insert
						$sql = "insert into ".$articulo."s values
								('$id', '$nombre', '$edad', '$imagen', 
								'$trailer', '$sinopsis', to_date('$year', 'DD/MM/yyyy'))";
						$salida = '<a href="http://ori/articulo.php?id_'.$articulo.'='.$id.'">'.$nombre.'<a>';
						//Inserccion de la pelicula

						$res = $con->exec($sql);
						if($res == 1){						
							$sql = "select count(*) from generos_".$articulo."s";
							foreach ($con->query($sql) as $fila) {
							 	$cont = $fila[0];
							}					
							while($cont>0){
							 	$cont--;
							 	if(isset($_POST['genero'.$cont])){
							 		$sql = "insert into relacion_".$articulo."s_genero (id_".$articulo.", genero) 
							 	 		values ('".$id."', '".$_POST['genero'.$cont]."')";
							 	 	$res = $con->exec($sql);
							 	 	if(!$res){
							 	 		echo '<div class="incorrecto"><p>Fallo al añadir los generos.</p></div>
										<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
							 	 	}
							 	}
							}
							if ($articulo=="juego") {
							 	$sql="insert into relacion_juegos_plataforma values('";
							 	$sql2="select count(*) from plataformas";
							}else{
								$sql="insert into relacion_peliculas_calidad values('";
								$sql2="select count(*) from calidad_visual";
							}
							foreach ($con->query($sql2) as $fila) {
								$cont=$fila[0];
							}
							while($cont>0){
								$cont--;
								if(isset($_POST['tipo'.$cont])){
									$res = $con->exec($sql.$id."','".$_POST['tipo'.$cont]."',".$_POST['precioventa'.$cont].",".$_POST['cantidadventa'.$cont].", ".$_POST['cantidadalquiler'.$cont].")");
									if(!$res){
										echo '<div class="incorrecto"><p>Fallo al añadir los precios.</p></div>
										<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
									}
								}
							}
							if($_FILES['imagen']['error']==0){
								copy($_FILES['imagen']['tmp_name'],$imagen);	
							}						
							echo '<div class="correcto"><p>El articulo, '.$salida.' se ha añadido correctamente</p></div>';						
						}else{
							echo '<div class="incorrecto"><p>El articulo no se ha añadido</p></div>
							<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
						}
					}else{
						echo $error;
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
						}
					}else{
						echo '<div class="incorrecto"><p>Tienes que loguearte para que se guardaran los cambios</p></div>';
					}
					echo '<form METHOD="POST" onsubmit="return procesaFormulario()" ACTION="add.php?articulo='.$_GET['articulo'].'" enctype="multipart/form-data">'
				?>
				
				<ul>
					<li><span>Seleccione la imagen: </span><input type="file" name="imagen" /></li>
					<li><span>Nombre: </span><input type="text" name="nombre" id="nombre" required/></li>
					<li><span>Año de lanzamiento: </span><input placeholder="ej: 15/03/1999" type="date"  title="Siga el ejemplo de la fecha" pattern="^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/]\d{4}$" id="year" name="year"/></li>
					<li><span>Edad restrictiva: </span><input type="number" title="La edad esta entre 0 y 18" pattern="^\d|1[0-8]$" name="edad" id="edad" required/></li>
					<li><span>Trailer(URL): </span><input type="text" id="trailer" name="trailer"/></li>
					<li><span>Sinopsis: </span><textarea id="sinopsis" name="sinopsis" cols="70" rows="15"></textarea></li>
					<li><span>Generos a los que pertenece: </span></li>
					<?php
						$con = CrearConexionBD();
						$cont = 0;
						$nombre = "genero";
						$sql = "select genero from generos_".$_GET['articulo']."s";
						echo '<li>';
						foreach ($con->query($sql) as $fila) {
							echo '<div class="check">
										<input type="checkbox" name="'.$nombre.$cont.'" value="'.$fila[0].'"/>
										<span>'.$fila[0].'</span>
									</div>';
							$cont++;
						}
						echo '<span>Cantidades de peliculas:</span>
							<table>
								<tr>
								<td> </td>
								<td>Tipo</td>
								<td>Cantidad de alquiler</td>
								<td>Cantidad de venta</td>
								<td>Precio de venta</td>
								</tr>';
						if($_GET['articulo']=="juego"){
							$sql="select * from plataformas";
						}else{
							$sql = "select * from calidad_visual";
						}
						$cont=0;
						foreach ($con->query($sql) as $fila) {
							echo '<tr>
									<td><input type="checkbox" name="tipo'.$cont.'" value="'.$fila[0].'"/></td>
									<td>'.$fila[0].'</td>
									<td><input type="number" size=5 name="cantidadalquiler'.$cont.'"/></td>
									<td><input type="number" size=5 name="cantidadventa'.$cont.'"/></td>
									<td><input type="number" size=5 name="precioventa'.$cont.'"/></td>
									</tr>';
							$cont++;
						}
						echo '</table>';
					?>
					<li><input type="SUBMIT" value="Añadir"/></li>
				</ul>
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