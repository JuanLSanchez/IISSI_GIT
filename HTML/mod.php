<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<?php 
		include "cabecera.php";
		Cabecera();
	?>
	<link rel="stylesheet" href="css/mod.css">
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

				<?php //Modificar articulo
				if(isset($_POST['nombre'])&&$_SESSION['dni'] == '00000000A'){
					
					$con = CrearConexionBD();
					//Inicializacion de las variables
					if(isset($_GET['id_pelicula'])){
						$id=$_GET['id_pelicula'];
						$articulo="pelicula";
					}elseif (isset($_GET['id_juego'])) {
						$articulo="juego";
						$id=$_GET['id_juego'];
					}//Obtener un ID
					$nombre = str_replace("'", "''", $_POST["nombre"]);
					$edad = $_POST["edad"];
					$trailer = str_replace("'", "''", $_POST["trailer"]);
					$sinopsis = str_replace("'", "''", $_POST["sinopsis"]);
					$year = $_POST["year"];
					$imagen = "img_".$articulo."s/".$id;
					//Definir el insert
					// $sql = "insert into ".$articulo."s values
					// 		('$id', '$nombre', '$edad', '$imagen', 
					// 		'$trailer', '$sinopsis', to_date('$year', 'DD/MM/yyyy'))";
					$sql = "update ".$articulo."s set 
							nombre='$nombre', 
							edad_restrictiva='$edad', 
							trailer='$trailer',
							sinopsis='$sinopsis',
							year=to_date('$year', 'DD/MM/yyyy') 
							where id_".$articulo."=".$id;
					$salida = '<a href="http://ori/articulo.php?id_'.$articulo.'='.$id.'">'.$nombre.'<a>';
					//Inserccion de la pelicula
					$res = $con->exec($sql);
					//$res=1==1;
					if($res == 1){
						$sql= "delete from relacion_".$articulo."s_genero where id_".$articulo."=".$id;
						$res= $con->exec($sql);						
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
						 	 	//echo $sql.'<br>';
						 	}
						}
						if ($articulo=="juego") {
						 	$sql="insert into relacion_juegos_plataforma values('";
						 	$sql2="select count(*) from plataformas";
						 	$sql3="delete from relacion_juegos_plataformas where id_juego=".$id;
						}else{
							$sql="insert into relacion_peliculas_calidad values('";
							$sql2="select count(*) from calidad_visual";
							$sql3="delete from relacion_peliculas_calidad where id_pelicula=".$id;
						}
						$res=$con->exec($sql3);
						foreach ($con->query($sql2) as $fila) {
							$cont=$fila[0];
						}
						while($cont>0){
							$cont--;
							if(isset($_POST['tipo'.$cont])){
								$res = $con->exec($sql.$id."','".$_POST['tipo'.$cont]."',".$_POST['precioventa'.$cont].",".$_POST['cantidadventa'.$cont].", ".$_POST['cantidadalquiler'.$cont].")");
								//echo $sql.$id."','".$_POST['tipo'.$cont]."',".$_POST['precioventa'.$cont].",".$_POST['cantidadventa'.$cont].", ".$_POST['cantidadalquiler'.$cont].")"."<br>";								
							}
						}
						if($_FILES['imagen']['error']==0){
							copy($_FILES['imagen']['tmp_name'],$imagen);	
						}						
						echo '<div class="correcto"><p>El articulo, '.$salida.' se ha modificado correctamente</p></div>';						
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
						}
					}else{
						echo '<div class="incorrecto"><p>Tienes que loguearte para que se guardaran los cambios</p></div>';
					}
					if(isset($_GET['id_pelicula'])){
						$articulo="pelicula";
						$id=$_GET['id_pelicula'];
					}elseif (isset($_GET['id_juego'])) {
						$articulo="juego";
						$id=$_GET['id_juego'];
					}
					
					$con = CrearConexionBD();
					$sql = "select nombre, edad_restrictiva, trailer, imagen, sinopsis, to_char(year, 'DD/MM/yyyy') 
							from ".$articulo."s 
							where id_".$articulo."=".$id;
					$res = $con->query($sql);
					foreach ($res as $fila) {
						$nombre=$fila[0];
						$edad=$fila[1];
						$trailer=$fila[2];
						$imagen=$fila[3];
						$sinopsis=$fila[4];
						$year=$fila[5];
					}
				echo '<form METHOD="POST" ACTION="mod.php?id_'.$articulo.'='.$id.'" enctype="multipart/form-data">
				<h2>Información General</h2>
				<table id="informacion">
					<tr><td colspan="2"><img src="'.$imagen.'" />
					<input type="file" name="imagen" /></td></tr>
					<tr><td class="span">Nombre: </td><td><input id="nombre" title="No puede tener mas de 50 caracteres." type="text" name="nombre" value="'.$nombre.'" pattern=".{1,50}" required/></td></tr>
					<tr><td class="span">Año de lanzamiento: </td><td><input  id="year" placeholder="ej: 05/03/1999" type="text" name="year" value="'.$year.'" pattern="(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/]\d{4}$"/></td></tr>
					<tr><td class="span">Edad restrictiva: </td><td><input id="edad" type="text" name="edad" value="'.$edad.'" pattern="[0-9]|1[0-8]" title="La edad tiene que estar entre 0 y 18." required/></td></tr>
					<tr><td class="span">Trailer(URL): </td><td><input id="trailer" type="text" name="trailer" value=\''.$trailer.'\' pattern=".{1,150}" title="Maximo 150 caracteres." /></td></tr>
					<tr><td class="span">Sinopsis: </td><td><textarea id="sinopsis" name="sinopsis" pattern=".{1,3500}" title="Maximo 3500 caracteres.">'.$sinopsis.'</textarea></td></tr>
				</table>
					<h2>Generos a los que pertenece: </h2>';
						//Genero
						$cont = 0;
						$nombre = "genero";
						$sql = "select genero from generos_".$articulo."s";
						$sql2 = "select genero from relacion_".$articulo."s_genero where id_".$articulo."=".$id." and genero='";
						echo '<table>';
						foreach ($con->query($sql) as $fila) {
							if($cont%3==0){	echo '<tr>';}
							if(($con->query($sql2.$fila[0]."'")->fetch())){
								echo '	<td>
											<input type="checkbox" name="'.$nombre.$cont.'" value="'.$fila[0].'" checked/>
											'.$fila[0].'
										</td>';
							}else{
								echo '<td>
										<input type="checkbox" name="'.$nombre.$cont.'" value="'.$fila[0].'"/>
										<span>'.$fila[0].'</span>
									</td>';	
							}
							if($cont%3==2){ echo '</tr>';}
							$cont++;
						}
						echo '</table>';
						
						echo '<h2>Cantidades de peliculas: </h2>
								<table id="cantidades">
								<tr><td></td>
								<td>Tipo</td>
								<td>Cantidad de alquiler</td>
								<td>Cantidad de venta</td>
								<td>Precio de venta</td></tr>';
						if($articulo=="juego"){
							$sql="select * from plataformas";
							$sql2="select * from relacion_juegos_plataforma where id_juego=".$id." and plataforma='";
						}else{
							$sql = "select * from calidad_visual";
							$sql2="select * from relacion_peliculas_calidad where id_pelicula=".$id." and calidad='";
						}
						$cont=0;
						foreach ($con->query($sql) as $fila) {
							$res=$con->query($sql2.$fila[0]."'")->fetch();
							if($res){
								echo '<tr>
									<td><input type="checkbox" name="tipo'.$cont.'" value="'.$fila[0].'" checked/></td>
									<td class="calidad">'.$fila[0].'</td>
									<td><input type="text" size=5 name="cantidadalquiler'.$cont.'" value="'.$res[4].'"/></td>
									<td><input type="text" size=5 name="cantidadventa'.$cont.'" value="'.$res[3].'"/></td>
									<td><input type="text" size=5 name="precioventa'.$cont.'" value="'.$res[2].'"/></td>
									</tr>';
							}else{
							echo '<tr>
									<td><input type="checkbox" name="tipo'.$cont.'" value="'.$fila[0].'"/></td>
									<td class="calidad">'.$fila[0].'</td>
									<td><input type="text" size=5 name="cantidadalquiler'.$cont.'"/></td>
									<td><input type="text" size=5 name="cantidadventa'.$cont.'"/></td>
									<td><input type="text" size=5 name="precioventa'.$cont.'"/></td>
									</tr>';	
							}							
							$cont++;
						}
						echo '</table>';
					?>
					<input type="SUBMIT" value="Modificar"/>
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