<html>
	
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Videoclub ORI">
		<meta name="keywords" content="videoclub, ori, peliculas">
		<title>Videoclub ORI</title>
		<link rel="stylesheet" href="css/general.css">
		<!--<link rel="stylesheet" href="css/perfil1.css">-->
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
			
			<?php
				
				$con = CrearConexionBD();
				if($_SESSION['dni'] == '00000000A' && isset($_POST['modificar'])){
					$seleccion = $_POST['seleccion'];
					$plataforma=$_POST['anterior'.$seleccion.''];
					
					$plataformaN = $_POST['plataforma'.$seleccion.''];
					
					$sql = "update plataformas set plataforma = '$plataformaN' where plataforma = '$plataforma'";
					$res = $con->exec($sql);
					if($res){
						echo '<div class="correcto"><p>Se ha modificado correctamente.</p></div>';
					}else{
						echo '<div class="incorrecto"><p>No se ha modificado correctamente.</p></div>
						<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
					}
					CerrarConexionBD($con);
					
				}
			?>
			<?php
				$con = CrearConexionBD();
				if($_SESSION['dni'] == '00000000A' && isset($_POST['borrar'])){
					$seleccion = $_POST['seleccion'];			
										
					$plataforma=$_POST['anterior'.$seleccion.''];				
					
					$sql = "delete from plataformas where plataforma = '$plataforma'";
					$res = $con->exec($sql);
					if($res){
						echo '<div class="correcto"><p>Se ha borrado correctamente.</p></div>';
					}else{
						echo '<div class="incorrecto"><p>No se ha borrado correctamente.</p></div>
						<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
					}
					CerrarConexionBD($con);
					
				}
			?>
			<?php
				$con = CrearConexionBD();
				if($_SESSION['dni'] == '00000000A' && isset($_POST['añadir'])){
					
					$plataformaN=$_POST['texto'];					
					$sql = "insert into plataformas values ('$plataformaN')";
					$res = $con->exec($sql);
					if($res){
						echo '<div class="correcto"><p>Se ha añadido correctamente.</p></div>';
					}else{
						echo '<div class="incorrecto"><p>No se ha añadido correctamente.</p></div>
						<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
					}
					CerrarConexionBD($con);
					
				}
			?>
			
			<?php
				$con = CrearConexionBD();
				
				if($_SESSION['dni']=='00000000A'){
					
					echo'<form method="POST" action = "plataformas.php">
					
						<table>
						';
						$sql = "select * from plataformas";
						echo'<tr>
							<td><input type="text" name="texto"/>
								<input type="submit" name ="añadir" value="Añadir"/></td>
						</tr>';
						$i = 0;
						foreach ($con -> query($sql) as $fila) {
						
							echo'<tr>
								
								<td><input type = "radio" value = "'.$i.'" name ="seleccion"/>
									<input type = "text" value = "'.$fila[0].'" name ="plataforma'.$i.'"/>								
									<input type = "submit" name ="borrar" value = "Borrar"/>
									<input type = "submit" name ="modificar" value ="Modificar"/></td>
								<td><input type = "hidden" name="anterior'.$i.'" value = "'.$fila[0].'" /></td>
								
							
							</tr>';
							
							
							$i++;
							
							
						}
						
						echo'</table>
						
					
					</form>';
					
					
				}
				CerrarConexionBD($con);
			?>
			
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