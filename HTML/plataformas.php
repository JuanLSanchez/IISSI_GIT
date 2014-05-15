<html>
	
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Videoclub ORI">
		<meta name="keywords" content="videoclub, ori, peliculas">
		<title>Videoclub ORI</title>
	<?php 
		include "cabecera.php";
		Cabecera();
	?>
		<link rel="stylesheet" href="css/enumerados.css">
		
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
				if($_SESSION['dni'] == '00000000A' && isset($_POST['modificar'])){
					$con = CrearConexionBD();

					$anterior = $_POST['anterior'];
					$nuevo = $_POST['nuevo'];										
					$sql = "update plataformas set plataforma = '$nuevo' where plataforma = '$anterior'";
					$res = $con->exec($sql);
					if($res){
						echo '<div class="correcto"><p>Se ha modificado correctamente.</p></div>';
					}else{
						echo '<div class="incorrecto"><p>No se ha modificado correctamente.</p></div>';
						
					}
					CerrarConexionBD($con);	
				}
			?>
			<?php
				if($_SESSION['dni'] == '00000000A' && isset($_POST['borrar'])){
					$con = CrearConexionBD();
					
					$anterior = $_POST['anterior'];
					
					$sql = "delete from plataformas where plataforma = '$anterior'";
					$res = $con->exec($sql);
					if($res){
						echo '<div class="correcto"><p>Se ha borrado correctamente.</p></div>';
					}else{
						echo '<div class="incorrecto"><p>No se ha borrado correctamente.</p></div>';
						
					}
					CerrarConexionBD($con);
					
				}
			?>
			<?php
				if($_SESSION['dni'] == '00000000A' && isset($_POST['añadir'])){
					$con = CrearConexionBD();
					
					$plataformaN=$_POST['texto'];					
					$sql = "insert into plataformas values ('$plataformaN')";
					$res = $con->exec($sql);
					if($res){
						echo '<div class="correcto"><p>Se ha añadido correctamente.</p></div>';
					}else{
						echo '<div class="incorrecto"><p>No se ha añadido correctamente.</p></div>';
						
					}
					CerrarConexionBD($con);
					
				}
			?>
			
			<?php
				
				
				if($_SESSION['dni']=='00000000A'){
					$con = CrearConexionBD();
					
					echo'<table>';
					$sql = "select * from plataformas";
					echo'<tr>
						<td><form method="POST" action = "plataformas.php">
							<input type="text" name="texto"/>
							<input type="submit" name ="añadir" value="Añadir"/>
							</form>
						</td>
					</tr>';
					foreach ($con -> query($sql) as $fila) {						
						
						echo'<tr>								
							<td><form method="POST" action = "plataformas.php">
								<input type = "text" value = "'.$fila[0].'" name ="nuevo"/>								
								<input type = "submit" name ="borrar" value = "Borrar"/>
								<input type = "submit" name ="modificar" value ="Modificar"/>
								<input type = "hidden" name = "anterior" value = "'.$fila[0].'"/>
								</form>
							</td>							
						</tr>';						
						
					}						
					echo'</table>';	
					CerrarConexionBD($con);	
				}
				
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