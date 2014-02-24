<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/peliculas.css">
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
				<article id="buscador">
					<form method="GET" action="peliculas.php" enctype="application/x-www-form-urlencoded">
						<?php
						if(isset($_GET['busqueda'])){
							$inicio_year="";
							$fin_year="";
							if($_GET['inicio_year']!=1){
								$inicio_year=$_GET['inicio_year'];
							}
							if($_GET['fin_year']!=9000){
								$fin_year=$_GET['fin_year'];
							}
							echo '
							<input type="search" name="busqueda" value="'.$_GET['busqueda'].'"/>
							<input type="submit" value="Buscar" />
							<br />
							<span>Desde: </span>
							<input type="number"  name="inicio_year" value="'.$inicio_year.'"/>
							<span>Hasta: </span>
							<input type="number" name="fin_year" value="'.$fin_year.'"/>
							<br />
							<span>Genero 1: </span>
							<input type="text" name="genero1" value="'.$_GET['genero1'].'"/>
							<span>Genero 2: </span>
							<input type="text" name="genero2" value="'.$_GET['genero2'].'"/>
							<p id="separador"> </p>	';
						}else{
							echo '<input type="search" name="busqueda"/>
							<input type="submit" value="Buscar" />
							<br />
							<span>Desde: </span>
							<input type="number"  name="inicio_year" />
							<span>Hasta: </span>
							<input type="number" name="fin_year" />
							<br />
							<span>Genero 1: </span>
							<input type="text" name="genero1" />
							<span>Genero 2: </span>
							<input type="text" name="genero2" />
							<p id="separador"> </p>	';
						}
						?>
					</form>
				</article>
				<article id="ordenar">
					<p class="espacio"> </p>
					<span class="nombre">Nombre</span>
					<span class="ano">Año</span>
					<span class="punt">Puntuacion</span>
					<span class="num">Alquileres</span>
				</article>
				<article id="resultado">
					<ul>
						<?php
							if(isset($_GET['busqueda'])){
								include "conexion.php";
								$con = CrearConexionBD();
								$cad = urldecode($_GET['busqueda']);

								$orden = "nombre";
								$pelisPorPaginas = "4";
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
								$genero1 = $_GET['genero1'];
								$genero2 = $_GET['genero2'];
								
								$pagina_inicio = ($pagina-1)*$pelisPorPaginas;
								$pagina_fin = $pagina*$pelisPorPaginas;
								$sql = "select id_pelicula, imagen, nombre, year from peliculas where upper(nombre) like upper('%".$cad."%') and year>=to_date('".$inicio_year."', 'yyyy') and year<=to_date('".($fin_year+1)."', 'yyyy') order by ".$orden;
								$cont = 0;
								foreach ( $con->query($sql) as $fila) {
									if($cont>=$pagina_inicio&&$cont<$pagina_fin){
										echo '<li>
												<img src="'.$fila[1].'" />
												<span class="nombre"><a href="articulo.php?id_pelicula='.$fila[0].'">'.$fila[2].'</a></span>
												<span class="ano">'.$fila[3].'</span>
												<span class="punt">3.2</span>
												<span class="num">230</span>
											</li>';
									}
									$cont++;
								}
								$sql = "select count(*) from peliculas where upper(nombre) like upper('%".$cad."%') and year>=to_date('".$inicio_year."', 'yyyy') and year<=to_date('".($fin_year+1)."', 'yyyy')";
								foreach ($con->query($sql) as $fila) {
									$cont = $fila['0']/$pelisPorPaginas;
								}
								echo '</ul>
									<ul id="paginacion">';
								if($pagina>1){
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero1='.$genero1.'&genero2='.$genero2.'&pagina=1"><<</a></li>
										<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero1='.$genero1.'&genero2='.$genero2.'&pagina='.($pagina-1).'"><</a></li>';
								}
								$i = 0;
								//$cont = $cont/$pagina;
								//echo $cont;	
								while ($cont>=$i) {
									$i=$i+1;
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero1='.$genero1.'&genero2='.$genero2.'&pagina='.$i.'">'.$i.'</a></li>';
										
								}
								if($pagina<$cont){
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero1='.$genero1.'&genero2='.$genero2.'&pagina='.($pagina+1).'">></a></li>
										<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero1='.$genero1.'&genero2='.$genero2.'&pagina='.ceil($cont).'">>></a></li>';
								}
								CerrarConexionBD($con);
							}
							
						?>
					</ul>
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

