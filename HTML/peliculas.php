<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/articulos.css">
</head>
<body>
	
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<?php
				include "menus.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
				<article >
					<form method="GET" action="peliculas.php" enctype="application/x-www-form-urlencoded" id="buscador">
						<?php
						include "conexion.php";
						$con = CrearConexionBD();
						$busqueda = "";
						$inicio_year = "";
						$fin_year = "";
						$genero = "Ninguno";
						if(isset($_GET['busqueda'])){
							$busqueda = $_GET['busqueda'];
							$genero = $_GET['genero'];
							if($_GET['inicio_year']!=1){
								$inicio_year=$_GET['inicio_year'];
							}
							if($_GET['fin_year']!=9000){
								$fin_year=$_GET['fin_year'];
							}
						}
						echo '
						<div class="search">
							<input type="search" id="busqueda" name="busqueda" value="'.$busqueda.'"/>
							<input type="submit" id="buscar" value="Buscar" />
						</div>
						<div>
							<span>Desde: </span>
							<input type="text"  size="4" name="inicio_year" value="'.$inicio_year.'"/>
							<span>Hasta: </span>
							<input type="text" size="4" name="fin_year" value="'.$fin_year.'"/>
							<span>Genero: </span>
							<select name="genero" value="Otro">';
												
						if($genero == "Ninguno"){
							echo '<option selected>Ninguno</option>';
						}else{
							echo '<option>Ninguno</option>';	
						}
						$sql = "select genero from generos_peliculas";
						foreach ($con->query($sql) as $fila) {
							if($genero == $fila[0]){
								echo '<option selected>'.$fila[0].'</option>';
							}else{
								echo '<option>'.$fila[0].'</option>';	
							}							
						}

						echo '</select>
						</div>
						<div>
							<span>Orden: </span>
							<select name="orden">';
						foreach (array('Nombre', 'Fecha', 'Puntuacion', 'Alquileres') as &$i) {
							if($_GET['orden']==$i){
								echo '<option selected>'.$i.'</option>';
							}else{
								echo '<option>'.$i.'</option>';
							}
						}
						echo '</select>
							<select name="torden">';
							foreach (array('asc', 'desc') as $i) {
								if($_GET['torden']==$i){
									echo '<option selected>'.$i.'</option>';
								}else{
									echo '<option>'.$i.'</option>';
								}
							}
						echo '</select>	
							<span>Peliculas por paginas: </span>
							<select name="peliculas">';
							$cont=5;
							while($cont<21){
								if($_GET["peliculas"]==$cont){
									echo "<option selected>".$cont."</option>";
								}else{
									echo "<option>".$cont."</option>";
								}
								$cont=$cont+5;
							}
						echo '</select>
						</div>						
						</form>
						<p id="separador"> </p>';
												
						CerrarConexionBD($con);
						?>
					
				</article>
				<article >
					<table>
						<tr>
							<td class="imagen"></td>
							<td class="nombre">Nombre</td>
							<td class="ano">Año</td>
							<td class="punt">Puntuacion</td>
							<td class="num">Alquileres</td>
						</tr>

						<?php
							if(isset($_GET['busqueda'])){
								//Iniciacion de variables
								$con = CrearConexionBD();
								$cad = urldecode($_GET['busqueda']);
								$orden = $_GET['orden'];
								$pelisPorPaginas = $_GET['peliculas'];
								if(isset($_GET['pagina'])){
									$pagina = $_GET["pagina"];	
								}else{
									$pagina = 1;
								}
								if($_GET['inicio_year']>0){
									$inicio_year = $_GET['inicio_year'];
								}else{
									$inicio_year = 1;
								}
								if($_GET['fin_year']>0){
									$fin_year = $_GET['fin_year'];
								}else{
									$fin_year = 9000;
								}
								$genero = $_GET['genero'];
															
								$pagina_inicio = ($pagina-1)*$pelisPorPaginas;
								$pagina_fin = $pagina*$pelisPorPaginas+1;

								if($genero=="Ninguno"){
									/*$sql = "select peliculas.id_pelicula, imagen, nombre, year, puntuacion 
											from peliculas, (select id_pelicula, avg(estrellas) puntuacion
												from puntuaciones_peliculas group by id_pelicula) punt
											where peliculas.id_pelicula=punt.id_pelicula and
											upper(nombre) like upper('%".$cad."%') and 
											year>=to_date('".$inicio_year."', 'yyyy') and 
											year<=to_date('".($fin_year+1)."', 'yyyy')";
									*/
									 $sql = "select id_pelicula, imagen, nombre, year, 
									 		id_pelicula_a_puntuacion(id_pelicula) puntuacion, 
									 		id_pelicula_a_alquileres(id_pelicula) alquileres 
									 		from peliculas where 
									 		upper(nombre) like upper('%".$cad."%') and 
									 		year>=to_date('".$inicio_year."', 'yyyy') and 
									 		year<=to_date('".($fin_year)."', 'yyyy')";
									
								}else{
									$sql = "select id_pelicula, imagen, nombre, year, 
											id_pelicula_a_puntuacion(id_pelicula) puntuacion, 
											id_pelicula_a_alquileres(id_pelicula) alquileres  
											from peliculas where 
											upper(nombre) like upper('%".$cad."%') and 
											year>to_date('".$inicio_year."', 'yyyy') and 
											year<to_date('".($fin_year)."', 'yyyy') and
											id_pelicula in (select id_pelicula from relacion_peliculas_genero 
															where genero='$genero') ";	
								}
								if($orden=="Nombre"){
									$sql= $sql."order by nombre";
								}elseif($orden=="Fecha"){
									$sql=$sql."order by year";
								}elseif($orden=="Puntuacion"){
									$sql=$sql."order by puntuacion";
								}elseif($orden=="Alquileres"){
									$sql=$sql."order by alquileres";
								}
								if($_GET["torden"]=="desc"){
									$sql=$sql." desc";
								}
								$sql2="select id_pelicula, imagen, nombre, year, puntuacion, alquileres from
											(select id_pelicula, imagen, nombre, year, puntuacion, alquileres, rownum rn from
											(".$sql.") 
											where rownum<".$pagina_fin.")
											where rn>".$pagina_inicio;
											//echo $sql2;
								foreach ( $con->query($sql2) as $fila) {
									//if($cont>=$pagina_inicio&&$cont<$pagina_fin){
										echo '<tr>
												<td class="imagen"><img src="'.$fila[1].'" /></td>
												<td class="nombre"><a href="articulo.php?id_pelicula='.$fila[0].'">'.$fila[2].'</a></td>
												<td class="ano">'.$fila[3].'</td>';
												if($fila[4]=="-"){
													$puntuacion="<span>-</span>";
												}else{
													$puntuacion='<img src="img_ori/'.round($fila[4]).'_estrellas.png"/>';
												}
										echo '<td class="punt">'.$puntuacion.'</td>
												<td class="num">'.$fila[5].'</td>
											</tr>';
									//}
									//$cont++;
								}								
								echo '</table>';
								/*Paginacion*/
								$sql = "select count(*) from (".$sql.")";
								foreach ($con->query($sql) as $fila) {
									$cont = $fila['0']/$pelisPorPaginas;
								}
								echo '<ul id="paginacion">';
								if($pagina>1){
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina=1&peliculas='.$pelisPorPaginas.'&orden='.$_GET['orden'].'&torden='.$_GET["torden"].'"><<</a></li>
										<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina='.($pagina-1).'&peliculas='.$pelisPorPaginas.'&orden='.$_GET['orden'].'&torden='.$_GET["torden"].'"><</a></li>';
								}
								$i = 0;
								while ($cont>$i) {
									$i=$i+1;
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina='.$i.'&peliculas='.$pelisPorPaginas.'&orden='.$_GET['orden'].'&torden='.$_GET["torden"].'">'.$i.'</a></li>';
										
								}
								if($pagina<$cont){
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina='.($pagina+1).'&peliculas='.$pelisPorPaginas.'&orden='.$_GET['orden'].'&torden='.$_GET["torden"].'">></a></li>
										<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina='.ceil($cont).'&peliculas='.$pelisPorPaginas.'&orden='.$_GET['orden'].'&torden='.$_GET["torden"].'">>></a></li>';
								}
								CerrarConexionBD($con);
							}else{
								echo '</table>';
							}
							
						?>
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

