<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="C:/xampp/htdocs/general.css">
	<link rel="stylesheet" href="C:/xampp/htdocs/BuscaAmigos.css">
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
			<h2> Usuarios</h2>
			<form id="formulario" method="get" action="perfil.php" enctype="application/x-www-form-urlencoded">
				
				<?php
						include "conexion.php";
						$con = CrearConexionBD();
						$sql = "select nombre from socios";
						$busqueda = "";
						
						if(isset($_GET['busqueda'])){
							$busqueda = $_GET['busqueda'];
							
						}
						echo '
						<div class="search">
							<input type="search" name="busqueda" value="'.$busqueda.'"/>
							<input type="submit" value="Buscar" />
						</div>';
						
						CerrarConexionBD($con);
				?>
					
				
				
			</form>
			
			<article>
				
				<ul>
						<li>
							
							<img src="imagen" />
							<figcaption class="nombre"> Nombre </figcaption>
							
							
						</li>
				
				</ul>
				
				<?php
							if(isset($_GET['busqueda'])){
								//Iniciacion de variables
								$con = CrearConexionBD();
								$cad = urldecode($_GET['busqueda']);
								$orden = "nombre";
								$usersPorPaginas = "10";
								if(isset($_GET['pagina'])){
									$pagina = $_GET["pagina"];	
								}else{
									$pagina = 1;
								}
								
															
								$pagina_inicio = ($pagina-1)*$usersPorPaginas;
								$pagina_fin = $pagina*$usersPorPaginas;
								$sql = "select id_socio,  nombre, from socios where 
											upper(nombre) like upper('%".$cad."%')  
											order by ".$orden;
								$cont = 0;
								foreach ( $con->query($sql) as $fila) {
									if($cont>=$pagina_inicio&&$cont<$pagina_fin){
										echo '<ul>
												
												<li>
													<img src="'.$fila[0].'" />
													<figcaption class="nombre"><a href="perfil.php?id_socio='.$fila[1].'">'.'</a></figcaption>
													
												</li>
												
												
												
											</ul>';
									}
									$cont++;
								}								
								echo '</table>';
								/*Paginacion*/
								$sql = "select count(*) from socios where upper(nombre) like upper('%".$cad."%')";
								foreach ($con->query($sql) as $fila) {
									$cont = $fila['0']/$usersPorPaginas;
								}
								echo '</ul>
									<ul id="paginacion">';
								if($pagina>1){
									echo '<li><a href="perfil.php?busqueda='.$cad.'&pagina=1"><<</a></li>
										<li><a href="perfil.php?busqueda='.$cad.'&pagina='.($pagina-1).'"><</a></li>';
								}
								$i = 0;
								while ($cont>=$i) {
									$i=$i+1;
									echo '<li><a href="perfil.php?busqueda='.$cad.'&pagina='.$i.'">'.$i.'</a></li>';
										
								}
								if($pagina<$cont){
									echo '<li><a href="perfil.php?busqueda='.'&pagina='.($pagina+1).'">></a></li>
										<li><a href="perfil.php?busqueda='.$cad.'&pagina='.ceil($cont).'">>></a></li>';
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