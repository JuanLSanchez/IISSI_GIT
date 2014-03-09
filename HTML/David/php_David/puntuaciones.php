<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="../css_David/general.css">
	<link rel="stylesheet" href="../css_David/Mis_puntuaciones.css">
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
			
			<article>
				<h2> Mis Puntuaciones</h2>
				<ul>
					<li>
						<img src="imagen" />
						<figcaption class="nombre">Nombre</figcaption>
            			<p class = "punt"></p>
            		</li>
					
				</ul>
						
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
								
															
								$pagina_inicio = ($pagina-1)*$pelisPorPaginas;
								$pagina_fin = $pagina*$pelisPorPaginas;
								$sql = "select id_pelicula, imagen, nombre, year from peliculas where 
											upper(nombre) like upper('%".$cad."%')  
											order by ".$orden;
								$cont = 0;
								foreach ( $con->query($sql) as $fila) {
									if($cont>=$pagina_inicio&&$cont<$pagina_fin){
										echo '<ul>
										
												<li>
													<img src="imagen" />
													<figcaption class="nombre">Nombre</figcaption>
            										<p class = "punt"></p>
												</li>
												
												
											</ul>';
									}
									$cont++;
								}								
								echo '</table>';
								/*Paginacion*/
								$sql = "select count(*) from peliculas where upper(nombre) like upper('%".$cad."%')";
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

