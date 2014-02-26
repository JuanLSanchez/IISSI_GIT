<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/pelicula.css">
</head>
<body>
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<ul>
				<li>Inicio</li>
				<li>Peliculas</li>
				<li>Juegos</li>
				<li>Comestibles</li>
				<li>Informacion</li>
			</ul>
		</nav>
		<section id="seccion">
			<article>
				<?php
					include "conexion.php";
					$con = CrearConexionBD();
					//Inicializacion de las variables

					$articulo = $_GET['articulo'];
					$sql = "select id_".$articulo.".nextval from dual";
					//Obtener un ID
					$id_p = $con->query($sql);
					foreach ($id_p as $fila) {
						$id = $fila[0];
					}

					$nombre = $_POST["nombre"];
					$edad = $_POST["edad"];
					$trailer = $_POST["trailer"];
					$sinopsis = $_POST["sinopsis"];
					$alquiler = $_POST["alquiler"];
					$year = $_POST["year"];
					$sql = "select count(*) from generos_".$articulo."s";
					foreach ($con->query($sql) as $fila) {
					 	$cont = $fila[0];
					 }
					//Definir el insert
					$imagen = "img_".$articulo."s/" . $id;
					$sql = "insert into ".$articulo."s values('$id', '$nombre', '$edad', '$imagen', '$trailer', '$sinopsis', '$alquiler', to_date('$year', 'DD/MM/yyyy'))";
					$salida = '<a href="http://ori/articulo.php?id_'.$articulo.'='.$id.'">'.$nombre.'<a>';
					//Inserccion de la pelicula
					//$res = $con->exec($sql);
					$res=1==1;
					if($res == 1){
						// while($cont>0){
						// 	$cont--;
						// 	if(isset($_POST['genero'.$cont])){
						// 		$sql = "insert into relacion_".$articulo."s_genero (id_".$articulo.", genero) 
						// 	 		values ('".$id."', '".$_POST['genero'.$cont]."')";
						// 	 	$res = $con->exec($sql);
						// 	}
						// }
						if ($articulo=="juego") {
						 	$sql="insert into relacion_peliculas_calidad values('";
						 	$sql2="select count(*) from plataformas";
						}else{
							$sql="insert into relacion_juegos_plataforma values('";
							$sql2="select count(*) from calidad_visual";
						}
						foreach ($con->query($sql2) as $fila) {
							$cont=$fila[0];
						}
						echo $cont;
						while($cont>0){
							$cont--;
							if(isset($_POST['venta'.$cont])){
								//$res = $con->exec($sql.$id."','".$_POST['venta'.$cont]."','".$_POST['precioventa'.$cont]."','".$_POST['cantidadventa'.$cont]."'");
								//echo $sql.$id."','".$_POST['venta'.$cont]."','".$_POST['precioventa'.$cont]."','".$_POST['cantidadventa'.$cont]."'";
								echo $_POST['cantidadventa'.$cont].'<br>';
							}
						}
						//copy($_FILES['imagen']['tmp_name'],$imagen);
						echo $salida;
					}else{
						echo "<p>La pelicula no se ha añadido</p>";
					}
					CerrarConexionBD($con);

				?>
			</article>
		</section>
		<aside id="menu">
			<ul>
				<li>Alquileres</li>
				<li>Devoluciones pendientes</li>
				<li>Amigos</li>
				<li>Pendientes</li>
				<li>Favoritas</li>
				<li>Mis puntuaciones</li>
				<li>Mi perfil</li>
			</ul>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>