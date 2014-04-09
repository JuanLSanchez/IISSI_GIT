<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add_alquiler.css">

	<script>
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
							<span>DNI usuario: </span><input type="text" name="search_dni" value="'.$search_dni.'" pattern="\w\d{1-8}?|\d{1-8}?\w|\w?\d{1-8}|\d{1-8}\w?" required/>
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
						foreach (array("",0,1,2,3,4,5,6,7,8) as $i) {
							if(isset($_POST['pelicula'.$i])){
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
							
						}
						foreach (array("",0,1,2,3,4,5,6,7,8) as $i) {
							if(isset($_POST['juego'.$i])){
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
						echo '<h3>Articulos</h3>
						<form METHOD="POST" ACTION="add_alquiler.php">
						<span>Peliculas: </span>
						<input type="button" onclick="add(\'.pelicula\', \'lineasPeliculas\')" value="+">
						<input type="button" onclick="del(\'.pelicula\', \'lineasPeliculas\')" value="-">
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
						
							echo '
							<div id="lineasPeliculas">
								<div class="pelicula">
									<span>id_pelicula</span>
									<input type="text" name="pelicula" class="pelicula"/>
									<span>Cantidad</span>
									<input type="text" size="5" name="pelicula_cantidad" class="cantidad"/>
									<select name="calidad" class="calidad">
									'.$calidad.'
									</select>
								</div>
								</div>';
						
						
							echo '<div id="lineasJuegos">

							<span>Juegos: </span>
							<input type="button" onclick="add(\'.juego\', \'lineasJuegos\')" value="+"/>
							<input type="button" onclick="del(\'.juego\', \'lineasJuegos\')" value="-"/>
							<div class="juego">
									<span>id_juego</span>
									<input type="text" name="juego" class="pelicula"/>
									<span>Cantidad</span>
									<input type="text" size="5" name="juego_cantidad" class="cantidad"/>
									<select name="plataforma" class="calidad">
									'.$plataforma.'
									</select>
								</div>
								</div>';
						
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
						<input type="text" name="tiempo"/></div>
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

