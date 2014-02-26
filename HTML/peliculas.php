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
						include "conexion.php";
						$con = CrearConexionBD();
						$sql = "select genero from generos_peliculas";
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
							<input type="search" name="busqueda" value="'.$busqueda.'"/>
							<input type="submit" value="Buscar" />
						</div>
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
						foreach ($con->query($sql) as $fila) {
							if($genero == $fila[0]){
								echo '<option selected>'.$fila[0].'</option>';
							}else{
								echo '<option>'.$fila[0].'</option>';	
							}							
						}

						echo '</select>';
						// <input type="text" name="genero" value="'.$_GET['genero'].'"/>
						// <p id="separador"> </p>	';
						
						CerrarConexionBD($con);
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
								//Iniciacion de variables
								$con = CrearConexionBD();
								$cad = urldecode($_GET['busqueda']);
								$orden = "nombre";
								$pelisPorPaginas = "10";
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
								$pagina_fin = $pagina*$pelisPorPaginas;
								$sql = "select id_pelicula, imagen, nombre, year from peliculas where 
											upper(nombre) like upper('%".$cad."%') and 
											year>=to_date('".$inicio_year."', 'yyyy') and 
											year<=to_date('".($fin_year+1)."', 'yyyy') 
											order by ".$orden;
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
								/*Paginacion*/
								$sql = "select count(*) from peliculas where upper(nombre) like upper('%".$cad."%') and year>=to_date('".$inicio_year."', 'yyyy') and year<=to_date('".($fin_year+1)."', 'yyyy')";
								foreach ($con->query($sql) as $fila) {
									$cont = $fila['0']/$pelisPorPaginas;
								}
								echo '</ul>
									<ul id="paginacion">';
								if($pagina>1){
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina=1"><<</a></li>
										<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina='.($pagina-1).'"><</a></li>';
								}
								$i = 0;
								while ($cont>=$i) {
									$i=$i+1;
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina='.$i.'">'.$i.'</a></li>';
										
								}
								if($pagina<$cont){
									echo '<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina='.($pagina+1).'">></a></li>
										<li><a href="peliculas.php?busqueda='.$cad.'&inicio_year='.$inicio_year.'&fin_year='.$fin_year.'&genero='.$genero.'&pagina='.ceil($cont).'">>></a></li>';
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

