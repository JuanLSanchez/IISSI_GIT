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
				if(isset($_POST['efectuar'])){//Realizar devolucion
					$cont = $_POST['efectuar'];
					$peliculas = $_POST['peliculas'];
					$id_alquiler = $_POST['id_alquiler'];
					$dni = $_POST['socio'];
					if($cont>0){
						$sql = "select id_devolucion.nextval from dual";
						foreach ($con->query($sql) as $fila) {
							$id_devolucion = $fila[0];
						}
						$sql = "insert into devoluciones values('$id_devolucion', '$id_alquiler', sysdate, '$dni')";
						$res = $con->exec($sql);
					}
					$res = "";
					while ($cont > $peliculas) {
						$cantidad = $_POST['cantidad'.$cont];
						$defectuosos = $_POST['defectuoso'.$cont];
						$id = $_POST['id'.$cont];
						$calidad = $_POST['calidad'.$cont];
						$correcto = $cantidad - $defectuosos;
						if($cantidad>0){
							if(($cantidad-$defectuosos)>0){
								$sql = "insert into lineas_devoluciones_juegos values(id_ldj.nextval, '$correcto', 0, '$id', '$id_devolucion', '$calidad')";
								$res = $con->exec($sql);	
							}
							if($defectuosos>0){
								$sql = "insert into lineas_devoluciones_juegos values(id_ldj.nextval, '$defectuosos', 1, '$id', '$id_devolucion', '$calidad')";
								$res = $con->exec($sql);
							}							
						}
						$cont--;
					}
					while ($cont > 0){
						$cantidad = $_POST['cantidad'.$cont];
						$defectuosos = $_POST['defectuoso'.$cont];
						$id = $_POST['id'.$cont];
						$calidad = $_POST['calidad'.$cont];
						$correcto = $cantidad - $defectuosos;
						if($cantidad>0){
							if(($cantidad-$defectuosos)>0){
								$sql = "insert into lineas_devoluciones_peliculas values(id_ldp.nextval, '$correcto', 0, '$id', '$id_devolucion', '$calidad')";
								$res = $con->exec($sql);	
							}							
							if($defectuosos>0){
								$sql = "insert into lineas_devoluciones_peliculas values(id_ldp.nextval, '$defectuosos', 1, '$id', '$id_devolucion', '$calidad')";
								$res = $con->exec($sql);
							}							
						}
						$cont--;
					}
					if($res!=""&&$res){
						echo '<div class="correcto"><p>Se ha añadido la devolucion correctamente</p></div>';
					}elseif(!$res&&$res!=""){
						echo '<div class="incorrecto"><p>No se ha añadido la devolucion correctamente</p></div>';
						echo '<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
					}
					echo '<form METHOD="GET" ACTION="add_devolucion.php?buscar=">
							<input type="hidden" value="" name="buscar">
							<input type="SUBMIT" value="Continuar haciendo devoluciones."/>
						</form>';
				}
				if(isset($_GET['buscar'])){ //Busqueda y seleccion de usuarios
					$buscar=$_GET['buscar'];
					echo '<form METHOD="GET" ACTION="add_devolucion.php">
							<span>DNI usuario: </span><input type="text" name="buscar" value="'.$buscar.'"/>
							<input type="SUBMIT" value="Buscar"/>
						</form>';
					if($buscar!=""){
						$sql = "select dni, nombre from socios 
						where upper(dni) like upper('%".$buscar."%') and
						articulos_para_devolver(dni)>0";
						echo '<form METHOD="GET" ACTION="add_devolucion.php">';
						foreach ($con->query($sql) as $fila) {
							echo '<div class="usuario">
									<input type="radio" value="'.$fila[0].'" name="socio"/>
									<img src="img_socios/'.$fila[0].'"/>
									<span>'.$fila[0].'</span>
									<span>'.$fila[1].'</span>
								</div>';
						}
						echo '<input type="SUBMIT" value="Seleccionar"/>
						</form>';
					}
				}
				if(isset($_GET['socio'])){//Mostrar articulos por devolver.
					$dni = $_GET['socio'];
					$sql = "select id_alquiler from (select id_alquiler from alquileres 
														where dni='$dni' 
														order by fecha desc)
							where rownum=1";
					$id_alquiler ="";
					$cont = 0;
					$peliculas = 0;
					foreach ($con->query($sql) as $fila) {
						$id_alquiler=$fila[0];
					}
					$sql = "select id_lap, cantidad, id_oferta, id_pelicula, calidad, id_pelicula_a_nombre(id_pelicula) 
							from lineas_alquileres_peliculas 
							where id_alquiler='$id_alquiler'";

					$sql2 = "select id_laj, cantidad, id_oferta, id_juego, plataforma, id_juego_a_nombre(id_juego) 
							from lineas_alquileres_juegos 
							where id_alquiler='$id_alquiler'";

					echo '<form METHOD="POST" ACTION="add_devolucion.php">
					<table>
					<tr>
						<td></td>
						<td>Pelicula</td>
						<td>Calidad</td>
						<td>Cantidad alquilada</td>
						<td>Cantidad devuelta</td>
						<td>Defectuosas</td>
						<td></td></tr>';
					foreach ($con->query($sql) as $fila) {
						$cont++;
						$peliculas++;
						echo '	<tr>
								<td><img src="img_peliculas/'.$fila[3].'" /></td>
								<td><span>'.$fila[5].'</span></td>
								<td><span>'.$fila[4].'</span></td>
								<td><span>x '.$fila[1].'</span></td>
								<td><input type="text" name="cantidad'.$cont.'" size="4" value="0"/></td>
								<td><input type="text" name="defectuoso'.$cont.'" size="4" value="0"/></td>
								<td><input type="hidden" name="id'.$cont.'" value="'.$fila[3].'"/>
								<input type="hidden" name="calidad'.$cont.'" value="'.$fila[4].'"/></td>
								</tr>';
					}
					foreach ($con->query($sql2) as $fila) {
						$cont++;
						echo '	<tr>
								<td><img src="img_juegos/'.$fila[3].'" /></td>
								<td><span>'.$fila[5].'</span></td>
								<td><span>'.$fila[4].'</span></td>
								<td><span>x '.$fila[1].'</span></td>
								<td><input type="text" name="cantidad'.$cont.'" size="4" value="0"/></td>
								<td><input type="text" name="defectuoso'.$cont.'" size="4" value="0"/></td>
								<td><input type="hidden" name="id'.$cont.'" value="'.$fila[3].'"/>
								<input type="hidden" name="calidad'.$cont.'" value="'.$fila[4].'"/></td>
								</tr>';
					}

					echo '</table>
					<input type="hidden" name="socio" value="'.$dni.'"/>
					<input type="hidden" name="id_alquiler" value="'.$id_alquiler.'"/>
					<input type="hidden" name="efectuar" value="'.$cont.'"/>
					<input type="hidden" name="peliculas" value="'.$peliculas.'"/>
					<input type="SUBMIT" value="Siguiente"/>
					</form>';
				}
				CerrarConexionBD($con);
				}else{
					echo '<div class="incorrecto"><p>Tines que seer administrador para hacer un alquiler</p></div>';
				}						
			}else{
				echo '<div class="incorrecto"><p>Tines que estar logueado para hacer un alquiler</p></div>';
			}
				
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

