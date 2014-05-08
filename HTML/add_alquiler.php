<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add_alquiler.css">
	<link rel="icon" href="favicon.png" sizes="32x32" type="image/png">

	<script>
		var juegos = 0;
		var peliculas = 0;
		function cloneRow(fila, tabla, tipo){
			var cont = 0;
			if(juegos+peliculas<10){
				if(tipo=='juego'){
					cont = juegos;
					juegos++;
				}else{
					cont = peliculas;
					peliculas++;
				}
				var row = document.querySelector(fila);
				var table = document.getElementById(tabla);
				var clone = row.cloneNode(true);
				clone.querySelector(".id").name=clone.querySelector(".id").name+cont;
				clone.querySelector(".cantidad").name=clone.querySelector(".cantidad").name+cont;
				clone.querySelector(".calidad").name=clone.querySelector(".calidad").name+cont;
				table.appendChild(clone);
			}
		}
		function deleteRow(tabla, tipo){
			if(tipo=='juego'){
				if(juegos>0){
					document.getElementById(tabla).deleteRow(document.getElementById(tabla).rows.length-1);
					juegos--;
				}				
			}else{
				if(peliculas>0){
					document.getElementById(tabla).deleteRow(document.getElementById(tabla).rows.length-1);
					peliculas--;	
				}				
			}
		}
		var cont=0;
		var pelicula=0;
		var juego=0;
		function add(clonado, lugar){
			if(pelicula+juego<9){
			if(clonado==".pelicula"){
				cont=pelicula;
			}else{
				cont=juego;
			}
			var itm=document.querySelector(clonado);
			var cln=itm.cloneNode(true);
			cln.querySelector(".pelicula").setAttribute("name",cln.querySelector(".pelicula").getAttribute("name")+cont);
			cln.querySelector(".cantidad").setAttribute("name",cln.querySelector(".cantidad").getAttribute("name")+cont);
			cln.querySelector(".calidad").setAttribute("name",cln.querySelector(".calidad").getAttribute("name")+cont);
			document.getElementById(lugar).appendChild(cln);
			if(clonado==".pelicula"){
				pelicula++;
			}else{
				juego++;
			}
			}
		};

		function del(clonado, lugar){
			var puntero=document.getElementById(lugar);
			if(clonado==".pelicula" && pelicula>0){
				puntero.removeChild(puntero.childNodes[puntero.childNodes.length-1]);
				pelicula--;
			}else if(clonado==".juego" && juego>0){
				puntero.removeChild(puntero.childNodes[puntero.childNodes.length-1]);
				juego--;
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
							<span>DNI usuario: </span><input type="text" title="Ningun dni se puede parecer a eso" name="search_dni" value="'.$search_dni.'" pattern="\d{0,8}\w?|\w?\d{0,8}" required/>
							<input type="SUBMIT" value="Buscar"/>
						</form>';	
					}					
					if($search_dni!=""){//Seleccionar el socio, mostrar la busqueda
						$sql= "select * from socios where upper(dni) like upper('%".$search_dni."%')";
						$res = $con->query($sql);
						echo '<form METHOD="POST" ACTION="add_alquiler.php">';
						echo "<table>";
						foreach ($res as $fila) {
							echo '<tr>
								<td><input type="radio" value="'.$fila[0].'" name="socio"/></td>
								<td><img src="img_socios/'.$fila[0].'"/></td>
								<td>'.$fila[0].'</td>
								<td>'.$fila[1].'</td>
							</tr>';
						}
						echo '</table>
						<input type="submit" value="Seleccionar"/>
						</form>';
					}elseif (isset($_POST['id_alquiler'])){//Confirmar el alquiler
						$cantidad_total=0;
						$cont = 0;
						echo '<form METHOD="POST" ACTION="add_alquiler.php">';
						$id_alquiler=$_POST['id_alquiler'];
						$horas=6*$_POST['tiempo'];
						$sql = "insert into alquileres values($id_alquiler, sysdate, '$horas', '".$_POST['dni']."')";
						echo '<input type="hidden" name="sql'.$cont.'" value="'.$sql.'"/>';
						echo '<table id="resultadoFinal">
						<tr>
						<td></td>
						<td>Nombre</td>
						<td>Cantidad</td>
						<td>Calidad/Plataforma</td>
						</tr>';
						foreach (array(0,1,2,3,4,5,6,7,8,9) as $i) {
							if(isset($_POST['pelicula'.$i]) && isset($_POST['pelicula_cantidad'.$i]) && isset($_POST['calidad'.$i])){
							if($_POST['pelicula'.$i]!="" && $_POST['pelicula_cantidad'.$i]!="" && $_POST['calidad'.$i]!=""){
								$sql = "select 
										cantidad_alquiler_pelicula('".$_POST['pelicula'.$i]."', '".$_POST['calidad'.$i]."'), 
										id_pelicula_a_nombre('".$_POST['pelicula'.$i]."') 
										from dual";
								foreach ($con->query($sql) as $fila) {
									$res = $fila[0];
									$nombre = $fila[1];
								}
								if($res != -1){
									if($res >= $_POST['pelicula_cantidad'.$i]){
										echo '<tr>
												<td class="timagen"><img src="img_peliculas/'.$_POST['pelicula'.$i].'"/></td>
												<td class="tnombre">'.$nombre.'</td>
												<td class="tcantidad">'.$_POST['pelicula_cantidad'.$i].'</td>
												<td class="tcalidad">'.$_POST['calidad'.$i];
										$cont++;
										$cantidad_total=$cantidad_total+$_POST['pelicula_cantidad'.$i] ;
										$sql = "insert into lineas_alquileres_peliculas values(id_lap.nextval,
										".$_POST['pelicula_cantidad'.$i].", ".$_POST['oferta'].", 
										'$id_alquiler', ".$_POST['pelicula'.$i].", '".$_POST['calidad'.$i]."' )";
										echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/></td>
											</tr>';
									}else{
										echo '<tr>
												<td class="timagen"><img src="img_peliculas/'.$_POST['pelicula'.$i].'"/></td>
												<td class="tnombre">'.$nombre.'</td>
												<td class="trcantidad">'.$res.'</td>
												<td class="tcalidad">'.$_POST['calidad'.$i];
										$cont++;
										$cantidad_total=$cantidad_total+$res ;
										$sql = "insert into lineas_alquileres_peliculas values(id_lap.nextval,
										".$res.", ".$_POST['oferta'].", 
										'$id_alquiler', ".$_POST['pelicula'.$i].", '".$_POST['calidad'.$i]."' )";
										echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/></td>
											</tr>';
									}
								}else{
									echo '<tr class="noExiste"><td colspan="4">No existe la pelicula con el identificador '.$_POST['pelicula'.$i].' y calidad '.$_POST['calidad'.$i].'</td></tr>';
								}
							}
							}
							
						}
						foreach (array(0,1,2,3,4,5,6,7,8,9) as $i) {
							if(isset($_POST['juego'.$i]) && isset($_POST['juego_cantidad'.$i]) && isset($_POST['plataforma'.$i])){
							if($_POST['juego'.$i]!="" && $_POST['juego_cantidad'.$i]!="" && $_POST['plataforma'.$i]!=""){
								$sql = "select 
										cantidad_alquiler_juego('".$_POST['juego'.$i]."', '".$_POST['plataforma'.$i]."'), 
										id_juego_a_nombre('".$_POST['juego'.$i]."') 
										from dual";
								foreach ($con->query($sql) as $fila) {
									$res = $fila[0];
									$nombre = $fila[1];
								}
								if($res != -1){
									if($res >= $_POST['juego_cantidad'.$i]){
										echo '<tr>
												<td class="timagen"><img src="img_juegos/'.$_POST['juego'.$i].'"/></td>
												<td class="tnombre">'.$nombre.'</td>
												<td class="tcantidad">'.$_POST['juego_cantidad'.$i].'</td>
												<td class="tcalidad">'.$_POST['plataforma'.$i];
										$cont++;
										$cantidad_total=$cantidad_total+$_POST['juego_cantidad'.$i] ;
										$sql = "insert into lineas_alquileres_juegos values(id_laj.nextval,
										".$_POST['juego_cantidad'.$i].", ".$_POST['oferta'].", 
										'$id_alquiler', ".$_POST['juego'.$i].", '".$_POST['plataforma'.$i]."' )";
										echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/></td>
										</tr>';
									}else{
										echo '<tr>
												<td class="timagen"><img src="img_juegos/'.$_POST['juego'.$i].'"/></td>
												<td class="tnombre">'.$nombre.'</td>
												<td class="trcantidad">'.$res.'</td>
												<td class="tcalidad">'.$_POST['plataforma'.$i];
										$cont++;
										$cantidad_total=$cantidad_total+$res ;
										$sql = "insert into lineas_alquileres_juegos values(id_laj.nextval,
										".$res.", ".$_POST['oferta'].", 
										'$id_alquiler', ".$_POST['juego'.$i].", '".$_POST['plataforma'.$i]."' )";
										echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/></td>
										</tr>';
									}
								}else{
									echo '<tr class="noExiste"><td colspan="4">No existe el juego con el identificador '.$_POST['juego'.$i].' y plataforma '.$_POST['plataforma'.$i].'</td></tr>';
								}
							}
							}
							
						}
						echo '</table>';
						$sql="select to_char(precio, '990.99') from ofertas where id_oferta=".$_POST['oferta'];
						$res = $con->query($sql);
						foreach ($res as $fila) {
							$precio=$fila[0];
						}
						$precio_total = $cantidad_total*$precio;
						echo '<span>Cantidad total: '.$cantidad_total.'   Precio total: '.$precio_total.'</span>';
						echo '<input type="submit" value="Confirmar alquiler"/>
						</form>';

					}elseif (isset($_POST['socio'])) {//Seleccionar articulos
						$socio = $_POST['socio'];
						$sql = "select articulos_para_devolver('$socio') from dual";
						foreach ($con->query($sql) as $fila) {
							$res = $fila[0];
						}
						if($res<1){
						echo '<h3>Articulos</h3>
						<form METHOD="POST" ACTION="add_alquiler.php">
						<span>Peliculas: </span>
						<input type="button" onclick="cloneRow(\'.filaPelicula\', \'tablaPeliculas\', \'pelicula\')" value="+"/>
						<input type="button" onclick="deleteRow(\'tablaPeliculas\', \'pelicula\')" value="-"/>
								<input type="hidden" value="'.$_POST['socio'].'" name="dni"/>';
						$sql="select calidad from calidad_visual";
						$res = $con->query($sql);
						$calidad="";
						foreach ($res as $fila) {
							$calidad= $calidad.'
									<option>'.$fila[0].'</option>';
						}
						$sql="select plataforma from plataformas";
						$res = $con->query($sql);
						$plataforma="";
						foreach ($res as $fila) {
							$plataforma= $plataforma.'
									<option>'.$fila[0].'</option>';
						}
							echo '<table id="tablaPeliculas">
							<tr class="filaPelicula">
							<td>ID Pelicula</td>
							<td><input type="text" name="pelicula" class="id" pattern="\d{1,20}"/></td>
							<td>Cantidad: </td>
							<td><input type="text" size="5" name="pelicula_cantidad" class="cantidad" pattern="\d|10"/></td>
							<td><select name="calidad" class="calidad">'.$calidad.'</select></td>
							</tr>
							</table>';
							// echo '
							// <div id="lineasPeliculas">
							// 	<div class="pelicula">
							// 		<span>id_pelicula</span>
							// 		<input type="text" name="pelicula" class="pelicula" pattern="\d{1,20}"/>
							// 		<span>Cantidad</span>
							// 		<input type="text" size="5" name="pelicula_cantidad" class="cantidad" pattern="\d|10"/>
							// 		<select name="calidad" class="calidad">
							// 		'.$calidad.'
							// 		</select>
							// 	</div>
							// 	</div>';
						
							echo '<div id="lineasJuegos">

							<span>Juegos: </span>
							<input type="button" onclick="cloneRow(\'.filaJuego\', \'tablaJuegos\', \'juego\')" value="+"/>
							<input type="button" onclick="deleteRow(\'tablaJuegos\', \'juego\')" value="-"/></div>
							<table id="tablaJuegos">
							<tr class="filaJuego">
								<td>ID Juego</td>
								<td><input type="text" name="juego" class="id" pattern="\d{1,20}"/></td>
								<td>Cantidad: </td>
								<td><input type="text" size="5" name="juego_cantidad" class="cantidad" pattern="\d|10"/></td>
								<td><select name="plataforma" class="calidad">'.$plataforma.'</select></td>
							</tr>
							</table>';
							// echo '<div id="lineasJuegos">

							// <span>Juegos: </span>
							// <input type="button" onclick="add(\'.juego\', \'lineasJuegos\')" value="+"/>
							// <input type="button" onclick="del(\'.juego\', \'lineasJuegos\')" value="-"/>
							// <div class="juego">
							// 		<span>id_juego</span>
							// 		<input type="text" name="juego" class="pelicula" pattern="\d{1,20}"/>
							// 		<span>Cantidad</span>
							// 		<input type="text" size="5" name="juego_cantidad" class="cantidad" pattern="\d|10"/>
							// 		<select name="plataforma" class="calidad">
							// 		'.$plataforma.'
							// 		</select>
							// 	</div>
							// 	</div>';
						
						$sql="select * from ofertas";
						echo "<h3>Ofertas</h3>";
						$i = 0;
						foreach ($con->query($sql) as $fila) {
							if($i==0){
								echo '<div class="oferta">
										<input type="radio" value="'.$fila[0].'" name="oferta" checked/>
										<span>'.$fila[1].'</span>
									</div>';
								$i++;
							}else{
								echo '<div class="oferta">
										<input type="radio" value="'.$fila[0].'" name="oferta"/>
										<span>'.$fila[1].'</span>
									</div>';
							}
						}
						$sql="select id_alquiler.nextval from dual";
						foreach ($con->query($sql) as $fila) {
							echo '<input type="hidden" name="id_alquiler" value="'.$fila[0].'"/>';
						}
						echo '<div><h3>Tiempo</h3>
						<span>Tiempo en 6 horas: </span>
						<input type="text" name="tiempo" pattern="\d{1,3}" required/></div>
						<input type="submit" value="Terminar alquiler"/>
						</form>';
						}else{
							echo '<div class="incorrecto"><p>Este socio todavia no ha devuelto todos los alquileres.</p></div>';
						}
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

