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
				document.getElementById("error").innerHTML=error;
				//alert(error);
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
					//Variables de sesion
					$_SESSION['addPelicula']['imagen'] = $_FILES['imagen'];
					$_SESSION['addPelicula']['nombre'] = $_POST["nombre"];
					$_SESSION['addPelicula']['year'] = $_POST["year"];
					$_SESSION['addPelicula']['edad'] = $_POST["edad"];
					$_SESSION['addPelicula']['trailer'] =  $_POST["trailer"];
					$_SESSION['addPelicula']['sinopsis'] = $_POST["sinopsis"];
					//Inicializacion de las variables
					$error = "";
					$articulo = $_GET['articulo'];
					$nombre = str_replace("'", "''", $_POST["nombre"]);
					$edad = $_POST["edad"];
					$trailer = str_replace("'", "''", $_POST["trailer"]);
					$sinopsis = str_replace("'", "''", $_POST["sinopsis"]);
					$year = $_POST["year"];
					list ($month1, $day1, $year1) = explode ("/", $year);
					if(!checkdate($day1, $month1, $year1)){
						echo '<div class="incorrecto"><p>Fecha incorrecta.</p></div>';
					}
					if ($articulo==""){
						$error = $error.'<div class="incorrecto"><p>Define el articulo.</p></div>';
					}
					if($nombre==""||strlen($nombre)>50){
						$error = $error.'<div class="incorrecto"><p>Introduzca un nombre que contenga menos de 50 caracteres.</p></div>';
					}
					if(!($edad<=18&&$edad>=0)){
						$error = $error.'<div class="incorrecto"><p>Edad restrictiva incorrecta, introduzca una edad entre 0 y 18 años.</p></div>';
					}
					if(strlen($sinopsis)>3500){
						$error = $error.'<div class="incorrecto"><p>Sinopsis demasiado grande, debe tener menos de 3500 caracteres.</p></div>';	
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
						}else{
							if(!isset($_SESSION['addPelicula'])||isset($_POST['borrar'])){
								$_SESSION['addPelicula']['imagen'] = "";
								$_SESSION['addPelicula']['nombre'] = "";
								$_SESSION['addPelicula']['year'] = "";
								$_SESSION['addPelicula']['edad'] = "";
								$_SESSION['addPelicula']['trailer'] = "" ;
								$_SESSION['addPelicula']['sinopsis'] = "";
							}
							$formulario =$_SESSION['addPelicula'];
						}
					}else{
						echo '<div class="incorrecto"><p>Tienes que loguearte para que se guardaran los cambios</p></div>';
					}
					echo '<form METHOD="POST" ACTION="add.php?articulo='.$_GET['articulo'].'" enctype="multipart/form-data">
							<input type="SUBMIT" value="Borrar formulario" name="borrar"/>
						</form>
					<form METHOD="POST" onsubmit="return procesaFormulario()" ACTION="add.php?articulo='.$_GET['articulo'].'" enctype="multipart/form-data">'
				?>
				<div id="error"></div>
				<table id= "informacion">
					<tr><td>Seleccione la imagen: </td><td><input type="file" name="imagen" <?php
						if($formulario['imagen']!=""){ echo ' value="'.$formulario['imagen']['name'].'" ';}
					?> /></td></tr>
					<tr><td>Nombre: </td><td><input type="text" name="nombre" id="nombre" required <?php
						if($formulario['nombre']!=""){ echo ' value="'.$formulario['nombre'].'" ';}
					?> /></td></tr>
					<tr><td>Año de lanzamiento: </td><td><input placeholder="ej: 15/03/1999" type="date"  title="Siga el ejemplo de la fecha" pattern="^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/]\d{4}$" id="year" name="year" <?php
						if($formulario['year']!=""){ echo ' value="'.$formulario['year'].'" ';}
					?>/></td></tr>
					<tr><td>Edad restrictiva: </td><td><input type="number" title="La edad esta entre 0 y 18" pattern="^\d|1[0-8]$" name="edad" id="edad" required <?php
						if($formulario['edad']!=""){ echo ' value="'.$formulario['edad'].'" ';}
					?>/></td></tr>
					<tr><td>Trailer(URL): </td><td><input type="text" id="trailer" name="trailer" <?php
						if($formulario['trailer']!=""){ echo ' value="'.$formulario['trailer'].'" ';}
					?>/></td></tr>
					<tr><td>Sinopsis: </td><td><textarea id="sinopsis" name="sinopsis" cols="60" rows="15"><?php
						if($formulario['sinopsis']!=""){ echo $formulario['sinopsis'];}
					?></textarea></td></tr>
				</table>
				

				<h3>Generos a los que pertenece: </h3>
					<?php
						$con = CrearConexionBD();
						$cont = 0;
						$nombre = "genero";
						$sql = "select genero from generos_".$_GET['articulo']."s";
						echo '<table id="generos">';
						$i = 0;
						foreach ($con->query($sql) as $fila) {
							if($i%3==0){
								echo "<tr>";
							}
							echo '	<td><input type="checkbox" name="'.$nombre.$cont.'" value="'.$fila[0].'"/>
										<span>'.$fila[0].'</span></td>';
							$cont++;
							if($i%3==2){
								echo "</tr>";
							}
							$i++;
						}
						echo '</table>
						<h3>Cantidades de peliculas:</h3>
							<table id="cantidades">
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
									<td class="tipo">'.$fila[0].'</td>
									<td><input type="number" size=5 name="cantidadalquiler'.$cont.'"/></td>
									<td><input type="number" size=5 name="cantidadventa'.$cont.'"/></td>
									<td><input type="number" size=5 name="precioventa'.$cont.'"/></td>
									</tr>';
							$cont++;
						}
						echo '</table>';
					?>
					<input type="SUBMIT" value="Añadir"/>
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