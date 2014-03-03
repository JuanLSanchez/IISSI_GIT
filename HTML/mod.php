<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
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
					}elseif ($_GET['id_juego']) {
						$articulo="juego";
						$id=$_GET['id_juego'];
					}//Obtener un ID
					$nombre = $_POST["nombre"];
					$edad = $_POST["edad"];
					$trailer = $_POST["trailer"];
					$sinopsis = $_POST["sinopsis"];
					$year = $_POST["year"];//Definir el insert
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
						echo "<span>El articulo, </span>".$salida."<span> se ha modificado correctamente</span>";						
					}else{
						echo "<p>El articulo no se ha modificado</p>";
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
					}elseif ($_GET['id_juego']) {
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
				<ul>
					<li><span>Seleccione la imagen: </span><input type="file" name="imagen" /></li>
					<li><img src="'.$imagen.'" /></li>
					<li><span>Nombre: </span><input type="text" name="nombre" value="'.$nombre.'"/></li>
					<li><span>Año de lanzamiento(ej: 05/03/1999): </span><input type="text" name="year" value="'.$year.'"/></li>
					<li><span>Edad restrictiva: </span><input type="text" name="edad" value="'.$edad.'"/></li>
					<li><span>Trailer(URL): </span><input type="text" name="trailer" value="'.$trailer.'"/></li>
					<li><span>Sinopsis: </span><textarea id="sinopsis" name="sinopsis" cols="70" rows="15">'.$sinopsis.'</textarea></li>
					<li><span>Generos a los que pertenece: </span></li>';
						//Genero
						$cont = 0;
						$nombre = "genero";
						$sql = "select genero from generos_".$articulo."s";
						echo '<li>';
						$sql2 = "select genero from relacion_".$articulo."s_genero where id_".$articulo."=".$id." and genero='";
						foreach ($con->query($sql) as $fila) {
							if(($con->query($sql2.$fila[0]."'")->fetch())){
								echo '<div class="check">
										<input type="checkbox" name="'.$nombre.$cont.'" value="'.$fila[0].'" checked/>
										<span>'.$fila[0].'</span>
									</div>';
							}else{
								echo '<div class="check">
										<input type="checkbox" name="'.$nombre.$cont.'" value="'.$fila[0].'"/>
										<span>'.$fila[0].'</span>
									</div>';	
							}
							
							$cont++;
						}
						echo '</li>
								<li><span>Cantidades de peliculas: </span></li>
								<li>
								<span>Tipo </span>
								<span>Cantidad de alquiler</span>
								<span>Cantidad de venta </span>								
								<span>Precio de venta</span>';
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
								echo '<div class="tipo">
									<input type="checkbox" name="tipo'.$cont.'" value="'.$fila[0].'" checked/>
									<span>'.$fila[0].'</span>
									<input type="text" size=5 name="cantidadalquiler'.$cont.'" value="'.$res[4].'"/>
									<input type="text" size=5 name="cantidadventa'.$cont.'" value="'.$res[3].'"/>
									<input type="text" size=5 name="precioventa'.$cont.'" value="'.$res[2].'"/>
									</div>';
							}else{
							echo '<div class="tipo">
									<input type="checkbox" name="tipo'.$cont.'" value="'.$fila[0].'"/>
									<span>'.$fila[0].'</span>
									<input type="text" size=5 name="cantidadalquiler'.$cont.'"/>
									<input type="text" size=5 name="cantidadventa'.$cont.'"/>
									<input type="text" size=5 name="precioventa'.$cont.'"/>
									</div>';	
							}							
							$cont++;
						}
						echo '</li>';
					?>
					<li><input type="SUBMIT" value="Modificar"/></li>
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