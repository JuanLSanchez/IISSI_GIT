<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/add_compra.css">

	<script>
		var cont=0;
		var pelicula=0;
		var juego=0;
		var comestible=0;
		function getNumPeliculas(){
			return pelicula;
		}
		function getNumJuegos(){
			return juego;
		}
		function getNumComestible(){
			return comestible;
		}
		function addComestible(clonado, lugar){
			var aux=0;
			cont=comestible;
			var itm=document.querySelector(clonado);
			var cln=itm.cloneNode(true);
			cln.querySelector(".pelicula").setAttribute("name",cln.querySelector(".pelicula").getAttribute("name")+cont);
			cln.querySelector(".cantidad").setAttribute("name",cln.querySelector(".cantidad").getAttribute("name")+cont);
			document.getElementById(lugar).appendChild(cln);
			comestible++;
			document.compra.elements["numcomestibles"].value = comestible;
		};
		function add(clonado, lugar){
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
				document.compra.elements["numcomestibles"].value = pelicula;
			}else{
				juego++;
				document.compra.elements["numcomestibles"].value = juego;
			}
		};

		function del(clonado, lugar){
			var puntero=document.getElementById(lugar);
			if(clonado==".pelicula" && pelicula>0){
				puntero.removeChild(puntero.childNodes[puntero.childNodes.length-1]);
				pelicula--;
				document.compra.elements["numcomestibles"].value = pelicula;
			}else if(clonado==".juego" && juego>0){
				puntero.removeChild(puntero.childNodes[puntero.childNodes.length-1]);
				juego--;
				document.compra.elements["numcomestibles"].value = juego;
			}else if(clonado==".comestible" && comestible>0){
				puntero.removeChild(puntero.childNodes[puntero.childNodes.length-1]);
				comestible--;
				document.compra.elements["numcomestibles"].value = comestible;
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
							echo '<div class="incorrecto"><p>Tienes que ser administrador para hacer una compra</p></div>';
						}						
					}else{
						echo '<div class="incorrecto"><p>Tienes que estar logueado para hacer una compra</p></div>';
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
						echo '<form METHOD="GET" ACTION="add_compra.php">
							<span>DNI usuario: </span><input type="text" title="Ningun dni se puede parecer a eso" name="search_dni" value="'.$search_dni.'" pattern="\d{0,8}\w?|\w?\d{0,8}" required/>
							<input type="SUBMIT" value="Buscar"/>
						</form>';	
					}					
					if($search_dni!=""){//Seleccionar el socio, mostrar la busqueda
						$sql= "select * from socios where upper(dni) like upper('%".$search_dni."%')";
						$res = $con->query($sql);
						echo '<form METHOD="POST" ACTION="add_compra.php">';
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
					}elseif (isset($_POST['id_compra'])){//Confirmar la compra
						$cantidad_total=0;
						$cont = 0;
						echo '<form METHOD="POST" ACTION="add_compra.php">';
						$id_compras=$_POST['id_compra'];
						$sql = "insert into compras values($id_compras, sysdate, '".$_POST['dni']."')";
						echo '<input type="hidden" name="sql'.$cont.'" value="'.$sql.'"/>';
						$array1 = array("");
						for($i=0;$i<$_POST['numjuegos'];$i++){
							$array1[$i+1] = $i;
						}
						foreach ($array1 as $i) {
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
										<span>'.$_POST['calidad'.$i].'</span>
									</div>';
								$cont++;
								$cantidad_total=$cantidad_total+$_POST['pelicula_cantidad'.$i] ;
								$sql = "insert into lineas_compras_peliculas values(".$res[0].",'$id_compras', ".$_POST['pelicula_cantidad'.$i].", '".$_POST['calidad'.$i]."' )";
								echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/>';
							}
							}
							
						}
						$array2 = array("");
						for($i=0;$i<$_POST['numjuegos'];$i++){
							$array2[$i+1] = $i;
						}
						foreach ($array2 as $i) {
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
										<span>'.$_POST['plataforma'.$i].'</span>
									</div>';
								$cont++;
								$cantidad_total=$cantidad_total+$_POST['juego_cantidad'.$i] ;
								$sql = "insert into lineas_compras_juegos values(".$res[0].", '$id_compras',".$_POST['juego_cantidad'.$i].",'".$_POST['plataforma'.$i]."')";
								echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/>';
							}
							}
						}
						$array3 = array("");
						for($i=0;$i<$_POST['numjuegos'];$i++){
							$array3[$i+1] = $i;
						}
						foreach ($array3 as $i) {
							if(isset($_POST['comestible'.$i])){
							if($_POST['comestible'.$i]!=""){
								$sql = "select id_comestible, nombre from comestibles where id_comestible=".$_POST['comestible'.$i];
								$res = $con->query($sql);
								foreach ($res as $fila) {
									$res = $fila;
								}
								echo '<div>
										<img src="img_comestibles/'.$res[0].'"/>
										<span>'.$res[1].'</span>
										<span>'.$_POST['comestible_cantidad'.$i].'</span>
									</div>';
								$cont++;
								$cantidad_total=$cantidad_total+$_POST['comestible_cantidad'.$i] ;
								$sql = "insert into lineas_compras_comestibles values(".$_POST['comestible_cantidad'.$i].",".$res[0].",'$id_compras')";
								echo '<input type="hidden" value="'.$sql.'" name="sql'.$cont.'"/>';
							}
							}
							
						}
						echo '<input type="submit" value="Confirmar compra"/>
						</form>';

					}elseif (isset($_POST['socio'])) {//Completar la compra
						echo '<h3>Articulos</h3>
						<form name="compra" METHOD="POST" ACTION="add_compra.php">
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
									<input type="text" name="pelicula" class="pelicula" pattern="\d{1,20}"/>
									<span>Cantidad</span>
									<input type="text" size="5" name="pelicula_cantidad" class="cantidad" pattern="\d|10"/>
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
									<input type="text" name="juego" class="pelicula" pattern="\d{1,20}"/>
									<span>Cantidad</span>
									<input type="text" size="5" name="juego_cantidad" class="cantidad" pattern="\d|10"/>
									<select name="plataforma" class="calidad">
									'.$plataforma.'
									</select>
								</div>
								</div>';
							echo '<div id="lineasComestibles">

							<span>Juegos: </span>
							<input type="button" onclick="addComestible(\'.comestible\', \'lineasComestibles\')" value="+"/>
							<input type="button" onclick="del(\'.comestible\', \'lineasComestibles\')" value="-"/>
							<div class="comestible">
									<span>id_comestible</span>
									<input type="text" name="comestible" class="pelicula" pattern="\d{1,20}"/>
									<span>Cantidad</span>
									<input type="text" size="5" name="comestible_cantidad" class="cantidad"/>
								</div>
								</div>';
						$sql="select id_compra.nextval from dual";
						foreach ($con->query($sql) as $fila) {
							echo '<input type="hidden" name="id_compra" value="'.$fila[0].'"/>';
						}
						echo '
						<input type="hidden" value="1" name="numpeliculas" id="np"/>
						<input type="hidden" value="1" name="numcomestibles" id="nc"/>
						<input type="hidden" value="1" name="numjuegos" id="nj"/>
						<input type="submit" value="Terminar Compra"/>
						</form>';

					}elseif(isset($_POST['sql0'])){//Insertando Compra
						$i=0;
						$res = 1==1;
						while (isset($_POST['sql'.$i]) && $res ==1) { 
							$res = ($con->exec($_POST['sql'.$i]));
							$i++;
						}
						if($res){
							echo '<div class="correcto"><p>Se ha añadido la compra correctamente</p></div>';
						}else{
							echo '<div class="incorrecto"><p>No se ha añadido la compra correctamente</p></div>';
							echo '<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
						}
					}
				}
				}else{
					echo '<div class="incorrecto"><p>Tienes que ser administrador para hacer una compra</p></div>';
				}						
			}else{
				echo '<div class="incorrecto"><p>Tienes que estar logueado para hacer una compra</p></div>';
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

