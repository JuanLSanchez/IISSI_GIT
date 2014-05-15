<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<?php 
		include "cabecera.php";
		Cabecera();
	?>
	<link rel="stylesheet" href="css/comestibles.css">
</head>
<body>
	
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<?php
				include "menus.php";
				include "conexion.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<div id="inicio">
				<article >
					<h2>Comestibles</h2>
					<?php
						if(isset($_GET['eliminar']) && isset($_SESSION['dni']) && $_SESSION['dni'] == "00000000A"){
							$con = CrearConexionBD();
							if($con){
								$id = $_GET['eliminar'];
								$sql = "delete from comestibles where id_comestible=".$id;
								$res = $con->exec($sql);
								if($res==1){
									if(file_exists("img_comestibles/".$id)){
										unlink("img_comestibles/".$id);
									}
									echo '<div class="correcto"><p>Se ha eliminado el articulo</p></div>';
								}else{
									echo '<div class="incorrecto"><p>No se ha eliminado el articulo</p></div>
											<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
								}
								CerrarConexionBD($con);
							}
						}

					?>
				</article>
				<article>
					<table><tr>
						<td class="admin"></td>
						<td class="imagen"></td>
						<td class="nombre">Nombre</td>
						<td class="precio">Precio</td>
					</tr>
					<?php
						$con = CrearConexionBD();
						if($con){
							$res = $con->query("select id_comestible, nombre, to_char(precio, '990.99') from comestibles");
							$bandera = 0;
							if(isset($_SESSION['dni'])){
								if($_SESSION['dni'] == "00000000A"){
									$bandera = 1;
								}
							}
							$cont = 0;
							foreach ($res as $fila) {
								echo '<tr>';
								if($bandera){
									echo '<td class="admin">
											<input type="button" value="Eliminar" onClick=" window.location.href='."'comestibles.php?eliminar=".$fila[0]."'".'">
											<input type="button" value="Modificar" onClick=" window.location.href='."'mod_comestible.php?id_comestible=".$fila[0]."'".'">
											</td>';
								}else{
									echo '<td class="admin">
										</td>';
								}
								
								echo '		<td class="imagen"><img src="img_comestibles/'.$fila[0].'" /></td>
										<td class="nombre">'.$fila[1].'</td>
										<td class="precio">'.$fila[2].'€</td></tr>';

								$cont++;
									
							}
							CerrarConexionBD($con);
						}
						?>
					</table>
				</article>
			</div>
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

