<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add_alquiler.css">
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
					if(isset($_SESSION)){
						if($_SESSION['dni']=="00000000A"){
							$con = CrearConexionBD();
							CerrarConexionBD($con);		
						}else{
							echo '<div class="incorrecto"><p>Tines que seer administrador para hacer un alquiler</p></div>';
						}						
					}else{
						echo '<div class="incorrecto"><p>Tines que estar logueado para hacer un alquiler</p></div>';
					}
					
				?>
			</article>
			<article>
			<?php
			if(isset($_SESSION)){
				if($_SESSION['dni']=="00000000A"){
				$con = CrearConexionBD();
				if(!isset($_GET['dni'])){
					$search_dni="";
					if (isset($_GET['search_dni'])) {
						$search_dni=$_GET['search_dni'];
					}
					if((!isset($_POST['socio']))&&(!isset($_POST['dni']))){//Buscador del socio
						echo '<form METHOD="GET" ACTION="add_alquiler.php">
							<span>DNI usuario: </span><input type="text" name="search_dni" value="'.$search_dni.'"/>
							<input type="SUBMIT" value="Buscar"/>
						</form>';	
					}					
					if($search_dni!=""){//Seleccionar el socio
						$sql= "select * from socios where upper(dni) like upper('%".$search_dni."%')";
						$res = $con->query($sql);
						echo '<form METHOD="POST" ACTION="add_alquiler.php">';
						foreach ($res as $fila) {
							echo '<div class="usuario">
								<input type="radio" value="'.$fila[0].'" name="socio"/>
								<img src="img_socios/'.$fila[0].'"/>
								<span>'.$fila[0].'</span>
								<span>'.$fila[1].'</span>
							</div>';
						}
						echo '<input type="submit" value="Seleccionar"/>
						</form>';
					}elseif (isset($_POST['id_alquiler'])){//Confirmar el alquiler
						$cantidad_total=0;
						$cont = 0;
						echo '<form METHOD="POST" ACTION="add_alquiler.php">';
						$id_alquiler=$_POST['id_alquiler'];
						$horas=6*$_POST['tiempo'];
						$sql = "insert into alquileres values($id_alquiler, sysdate, '$horas', '".$_POST['dni']."')";
						echo '<input type="hidden" name="sql'.$cont.'" value="'.$sql.'"/>';
						foreach (array(1,2,3,4,5,6,7,8,9,10) as $i) {
							if($_POST['pelicula'.$i]!=""){
								$sql = "select id_pelicula, nombre from peliculas where id_pelicula=".$_POST['pelicula'.$i];
								$res = $con->query($sql);
								foreach ($res as $fila) {
									$res = $fila;
								}
								echo '<div>
										<img src="img_peliculas/'.$res[0].'"/>
										<span>'.$res[1].'</span>
										<span>'.$_POST['pelicula_cantidad'.$i].'</span>
										<span>'.$_POST['calidad'.$i].'</sapn>
									</div>';
								$cont++;
								$cantidad_total=$cantidad_total+$_POST['pelicula_cantidad'.$i] ;
								$sql = "insert into lineas_alquileres_peliculas values(id_lap.nextval,
								".$_POST['pelicula_cantidad'.$i].", ".$_POST['oferta'].", 
								'$id_alquiler', ".$res[0].", '".$_POST['calidad'.$i]."' )";
								echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/>';
							}
							
						}
						foreach (array(1,2,3,4,5,6,7,8,9,10) as $i) {
							if($_POST['juego'.$i]!=""){
								$sql = "select id_juego, nombre from juegos where id_juego=".$_POST['juego'.$i];
								$res = $con->query($sql);
								foreach ($res as $fila) {
									$res = $fila;
								}
								echo '<div>
										<img src="img_juegos/'.$res[0].'"/>
										<span>'.$res[1].'</span>
										<span>'.$_POST['juego_cantidad'.$i].'</span>
										<span>'.$_POST['plataforma'.$i].'</sapn>
									</div>';
								$cont++;
								$cantidad_total=$cantidad_total+$_POST['pelicula_cantidad'.$i] ;
								$sql = "insert into lineas_alquileres_juegos values(id_laj.nextval,
								".$_POST['juego_cantidad'.$i].", ".$_POST['oferta'].", 
								'$id_alquiler', ".$res[0].", '".$_POST['plataforma'.$i]."' )";
								echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/>';
							}
							
						}
						$sql="select to_char(precio, '990.99') from ofertas where id_oferta=".$_POST['oferta'];
						$res = $con->query($sql);
						foreach ($res as $fila) {
							$precio=$fila[0];
						}
						$precio_total = $cantidad_total*$precio;
						echo '<span>Cantidad total: '.$cantidad_total.'   Precio total: '.$precio_total;
						echo '<input type="submit" value="Confirmar alquiler"/>
						</form>';

					}elseif (isset($_POST['socio'])) {//Completar el alquiler
						echo '<form METHOD="POST" ACTION="add_alquiler.php">
								<input type="hidden" value="'.$_POST['socio'].'" name="dni"/>';
						$sql="select calidad from calidad_visual";
						$res = $con->query($sql);
						$calidad="";
						foreach ($res as $fila) {
							$calidad= $calidad.'
									<option>'.$fila[0].'</otpion>';
						}
						$sql="select plataforma from plataformas";
						$res = $con->query($sql);
						$plataforma="";
						foreach ($res as $fila) {
							$plataforma= $plataforma.'
									<option>'.$fila[0].'</otpion>';
						}
						foreach (array(1,2,3,4,5,6,7,8,9,10) as $i) {
							echo '<div class="pelicula">
									<span>id_pelicula</span>
									<input type="text" name="pelicula'.$i.'"/>
									<span>Cantidad</span>
									<input type="text" size="5" name="pelicula_cantidad'.$i.'"/>
									<select name="calidad'.$i.'">
									'.$calidad.'
									</select>
								</div>';
						}
						foreach (array(1,2,3,4,5,6,7,8,9,10) as $i) {
							echo '<div class="juego">
									<span>id_juego</span>
									<input type="text" name="juego'.$i.'"/>
									<span>Cantidad</span>
									<input type="text" size="5" name="juego_cantidad'.$i.'"/>
									<select name="plataforma'.$i.'">
									'.$plataforma.'
									</select>
								</div>';
						}
						$sql="select * from ofertas";
						foreach ($con->query($sql) as $fila) {
							echo '<div class="oferta">
									<input type="radio" value="'.$fila[0].'" name="oferta"/>
									<span>'.$fila[1].'</span>
							</div>';
						}
						$sql="select id_alquiler.nextval from dual";
						foreach ($con->query($sql) as $fila) {
							echo '<input type="hidden" name="id_alquiler" value="'.$fila[0].'"/>';
						}
						echo '<span>Tiempo en 6 horas: </p>
						<input type="text" name="tiempo"/>
						<input type="submit" value="Terminar alquiler"/>
						</form>';

					}elseif(isset($_POST['sql0'])){//Insertando alquiler
						$i=0;
						$res = 1==1;
						while (isset($_POST['sql'.$i]) && $res ==1) { 
							$res = ($con->exec($_POST['sql'.$i]));
							$i++;
						}
						if($res){
							echo '<div class="correcto"><p>Se ha añadido el alquiler correctamente</p></div>';
						}else{
							echo '<div class="incorrecto"><p>No se ha añadido el alquiler correctamente</p></div>';
							echo '<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
						}
					}
				}
				}else{
					echo '<div class="incorrecto"><p>Tines que seer administrador para hacer un alquiler</p></div>';
				}						
			}else{
				echo '<div class="incorrecto"><p>Tines que estar logueado para hacer un alquiler</p></div>';
			}
				CerrarConexionBD($con);
			?>				
			</article>
				
		</section>
		<aside id="menu">
			<?php
				Menu();
			?>
		</aside>
		<footer id="pie">
			Derechos Reservados &copy; 2013-2014
		</footer>
	</div>
</body>
</html>

