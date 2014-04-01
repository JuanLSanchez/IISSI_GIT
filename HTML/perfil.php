<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="../css/general.css">
	<link rel="stylesheet" href="../css/perfil1.css">
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
				
				if(isset($_SESSION)&&isset($_GET['agregar'])){
					$con = CrearConexionBD();
					$amigo1=$_SESSION['dni'];
					$amigo2=$_GET['dni'];
					$sql="insert into amigos values('$amigo1','$amigo2')";
					$res = $con->exec($sql);
					CerrarConexionBD($con);
				}
			?>
				
				<?php				
				$con = CrearConexionBD();
				
										
				if(isset($_SESSION['dni'])){ //si esta registrado y quiere ver su perfil
					$dniS = $_SESSION['dni'];
					$dni = $_GET['dni'];
					$sql = "select * from amigos where amigo1='$dniS' and amigo2='$dni'";
					$amigo = $con->query($sql)->fetch();
					$sql = "select dni,nombre,email,registrado from socios where dni = '$dni'";
					foreach($con->query($sql) as $fila){
						$dni=$fila[0];					
						$nombre=$fila[1];
						$email=$fila[2];
						$registrado=$fila[3];
					}
				if($dni==$dniS){//Tu perfil
					echo'<article id="iz">
						<img src="../img_socios/'.$dni.'" />
						<form method="POST" action="perfil.php?dni='.$dni.'">
							
							<input type="file" name="foto"/><br />
							<input type="submit" value="cambiar" name="cambiar"/>
							
						</form>
						
						</article>';
						if(isset($_POST['foto'])){
							echo "hola";
							$imagen = "img_socioss/" . $dni;
							
						}	
				}
						
					
					echo'<article id="de">
							<h3>Mi Perfil</h3>
					
							<ul>
								<li><span>Nombre: '.$nombre.'</span></li><br />							
								<li><span>E-mail: '.$email.'</span></li><br />
								<li><span>Registrado: '.$registrado.'</span></li>
							</ul>
						</article>';
					
					// comentarios
					$sql = "select id_pelicula_a_nombre(id_pelicula), fecha, texto
					 	from opiniones_peliculas
					  	where dni='$dni'";
					echo '<article id="comentarios">';
					foreach ($con->query($sql) as $fila) {
						echo'
							<ul>
								<li>
									<h3>Comentarios</h3>
								</li>
								<li>
									<table>
										<tr class="fila1"><td></span> <span class="Película"> Película: '.$fila[0].' </span></td></tr>
										<tr class="fila2"><td><span class="Fecha">Fecha del comentario: '.$fila[1].' </span></td></tr>
										<tr class="fila3"><td>'.$fila[2].'</td></tr>
									</table>
								</li>
							</ul>';	
					}
					
					echo "</article>";
				}elseif($amigo){//Perfil de un amigo
					
					echo "Eres amigo";
					foreach ($con->query($sql) as $fila) {
						echo'<article id="iz">
						<img src="../img_socios/'.$fila[0].'" />
						</article>';
					
					echo'<article id="de">
							<h3>Perfil</h3>
					
							<ul>
								<li><span class="salta">Nombre: '.$nombre.'</span></li>							
								<li><span class="salta">E-mail: '.$email.'</span></li>	
								<li><span class="salta">Registrado: '.$registrado.'</span></li>
							</ul>
						</article>';
					}
					
					
					// comentarios
					$sql = "select id_pelicula_a_nombre(id_pelicula), fecha, texto
					 	from opiniones_peliculas
					  	where dni='$dni'";
					echo '<article id="comentarios">';
					foreach ($con->query($sql) as $fila) {
						echo'
							<ul>
								<li>
									<h3>Comentarios</h3>
								</li>
								<li>
									<table>
										<tr class="fila1"><td></span> <span class="Película"> Película: '.$fila[0].' </span></td></tr>
										<tr class="fila2"><td><span class="Fecha">Fecha del comentario: '.$fila[1].' </span></td></tr>
										<tr class="fila3"><td>'.$fila[2].'</td></tr>
									</table>
								</li>
							</ul>';	
					}
					
					echo "</article>";
					}else{//perfil de no amigo
						echo "no eres amigo";
						foreach ($con->query($sql) as $fila) {
						echo'<article id="iz">
							<img class="bl" src="../img_socios/'.$dni.'" />
				
						</article>';
						echo'<article id="de">
							<h3>Perfil</h3>
				
							<ul>
								<li>Nombre: '.$nombre.'</li></br>
								<li>No eres amigo de '.$nombre.'</li></br>					
								
					
							</ul>';							
												
							echo'<form METHOD="get" ACTION = "perfil.php">
									<input type="hidden" value="'.$dni.'" name="dni"/>
									<input type="hidden" value="yes" name="agregar"/>
									<input type="submit" value="Añadir como amigo">
							</form>';
							
							
						}//foreach
					echo'</article>';
						
						
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

