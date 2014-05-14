<!DOCTYPE html>

<html lang="es">

<head>
	
<meta charset="utf-8">
<meta name="description" content="Videoclub ORI">
<meta name="keywords" content="videoclub, ori, peliculas">
<title>Videoclub ORI</title>
<link rel="stylesheet" href="css/general.css">
<link rel="stylesheet" href="css/historial_compra.css">

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
					<h2>Compras Realizadas</h2>
			</article>
			
		<?php
		if(isset($_SESSION['dni'])&& isset($_GET['dni'])&& ($_SESSION['dni']=='00000000A' || $_SESSION['dni']==$_GET['dni'])){
			include "conexion.php";
			$con = CrearConexionBD();	
			$dni = $_GET['dni'];
			$sql = "select id_compra,fecha from compras where dni='$dni' order by fecha desc";
			echo'<article>';
			foreach ($con->query($sql) as $fila){
				echo'<table>
					<tr>
						<td class="imagen">Fecha: '.$fila[1].'</td>
						<td class="nombre">Nombre</td>
						<td class="cantidad">Cantidad</td>
					</tr>';
				$pelis = 'select id_pelicula, cantidad, id_pelicula_a_nombre(id_pelicula) 
							from lineas_compras_peliculas 
							where id_compra='.$fila[0];
				foreach ($con->query($pelis) as $pelicula){
					echo'<tr>
							<td class="imagen"><a href="articulo.php?id_pelicula='.$pelicula[0].'"><img src="img_peliculas/'.$pelicula[0].'" /></a></td>
							<td class="nombre"><a href="articulo.php?id_pelicula='.$pelicula[0].'">'.$pelicula[2].'</a></td>
							<td class="cantidad">'.$pelicula[1].'</td>
						</tr>';
				}				
				$juegos = 'select id_juego,cantidad, id_juego_a_nombre(id_juego) from lineas_compras_juegos where id_compra='.$fila[0];
				foreach ($con->query($juegos) as $juego){					
					
					echo'<tr>
							<td class="imagen"><a href="articulo.php?id_juego='.$juego[0].'"><img src="img_juegos/'.$juego[0].'" /></a></td>
							<td class="nombre"><a href="articulo.php?id_juego='.$juego[0].'"><span class="nombre">'.$juego[2].'</span></a></td>
							<td class="cantidad"><span>'.$juego[1].'</span></td>
						</tr>';
					
				}
				$comestibles = 'select id_comestible,cantidad, id_comestible_a_nombre(id_comestible) 
								from lineas_compras_comestibles 
								where id_compra='.$fila[0];
				foreach ($con->query($comestibles) as $comestible){					
					echo'<tr>
							<td class="imagen"><img src="img_comestibles/'.$comestible[0].'"/></td>
							<td class="nombre"><span class="nombre">'.$comestible[2].'</span></td>
							<td class="cantidad"><span>'.$comestible[1].'</span></td>
						</tr>';
					
				}					

		echo'</table>';
			}
			echo'</article>';
				CerrarConexionBD($con);
				}
			?>
		</section>		
	<aside id="menu">			
			<?php 			
			Menu(); ?>		
	</aside>		
	<footer id="pie">				
		Derechos Reservados &copy; 2013-2014			
	</footer>		
	</div>

</body>

</html>

