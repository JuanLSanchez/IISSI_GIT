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
	<link rel="stylesheet" href="css/perfil.css">
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
			
			<?php //Agregar Amigo
				
				if(isset($_SESSION)&& isset($_GET['agregar'])){
					
					$con = CrearConexionBD();
					if($con){
						$amigo1=$_SESSION['dni'];
						$amigo2=$_GET['dni'];
						$sql="insert into amigos values('$amigo1','$amigo2')";
						$res = $con->exec($sql);
						if($res){
							echo '<div class="correcto"><p>Se ha añadido correctamente.</p></div>';
						}else{
							echo '<div class="incorrecto"><p>No se ha añadido correctamente.</p></div>';
						}
						CerrarConexionBD($con);
					}
				}
			?>
			<?php //Cambiar email
				if(isset($_SESSION) && isset($_POST['email'])){
					$con = CrearConexionBD();
					if($con){
						$dni = $_SESSION['dni'];
						$emailN = $_POST['email'];
						$sql = "update socios set email = '$emailN'  where dni = '$dni'";
						$res = $con->exec($sql);
						if($res){
							echo '<div class="correcto"><p>Se ha modificado correctamente.</p></div>';
						}else{
							echo '<div class="incorrecto"><p>No se ha modificado correctamente.</p></div>';
							
						}
						CerrarConexionBD($con);
					}
					
				}
			?>
			<?php //Cambiar foto
				if(isset($_SESSION) && isset ($_POST['cambiarFoto'])){
					$dni=$_SESSION['dni'];
					$imagen="img_socios/".$dni;				
					if($_FILES['foto']['error']==0){
						
						copy($_FILES['foto']['tmp_name'],$imagen);
						echo '<div class = "correcto"><p>Se ha modificado la imagen.</p></div>';				
					
					}else{
						echo '<div class="incorrecto"><p>No se ha modificado la imagen.</p></div>';
					}						
				}						
			?>
			<?php //Quitar amigos
				if(isset($_POST['dejarDeSeguir'])){
					$con = CrearConexionBD();
					if($con){
						$amigo1=$_SESSION['dni'];
						$amigo2=$_GET['dni'];
						$sql = "delete from amigos where amigo1='$amigo1' and amigo2='$amigo2'";
						$res=$con->exec($sql);
						if(!$res){
							echo '<div class="incorrecto"><p> El usuario no se ha dejado de seguir correctamente</p></div>
								<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
						}
						CerrarConexionBD($con);
					}

				}
			?>
			<?php				
				$con = CrearConexionBD();
				if($con){
				//tu perfil
				if(isset($_SESSION['dni'])){ //si esta registrado y quiere ver su perfil
					$dniS = $_SESSION['dni'];
					$dni = $_GET['dni'];
					
					$sql = "select * from amigos where amigo1='$dniS' and amigo2='$dni'";
					$amigo = $con->query($sql)->fetch();
					$sql = "select dni,nombre,email, to_char(registrado, 'DD/MM/yyyy'), to_char(nacido, 'DD/MM/yyyy')  
								from socios 
								where dni = '$dni'";
					foreach($con->query($sql) as $fila){
						$dni=$fila[0];					
						$nombre=$fila[1];
						$email=$fila[2];											
						$registrado=$fila[3];
						$nacido = $fila[4];
					}
							
					if($_SESSION['dni']=='00000000A'){//modificar, eliminar solo lo ve el administrador
							echo '<article id="administracion">
									<ul>
										<li>
											<form METHOD="POST" ACTION="deluser.php?dni='.$dni.'&eliminar=">
												<input type="submit" value="Eliminar" id="eliminar"/>
											</form>
										</li>
										<li>
											<form METHOD="POST" ACTION="moduser.php?dni='.$dni.'">
												<input type="submit" value="Modificar" id="modificar"/>
											</form>
										</li>
									</ul>
								</article>';
					}

					if($dni==$dniS){//Tu perfil
						
						echo'<article id="iz">
								<img src="img_socios/'.$dni.'" />
								<form method="POST" action="perfil.php?dni='.$dni.'" enctype="multipart/form-data">
									
									<input type="file" name="foto" class="boton_examinar"/><br />
									<input type="submit" value="cambiar" name="cambiarFoto"/>
									
								</form>								
							</article>
							<article>
								<h3>Mi Perfil</h3>
								<table class="de">
									<tr><td>DNI: '.$dni.'</td></tr>
									<tr><td>Nombre: '.$nombre.'</td></tr>
									<tr><td>Nombre: '.$nacido.'</td></tr>
									<tr><td>E-mail: <form method = "POST"  action = "perfil.php?dni='.$dni.'">
											<input type="text"  name = "email"  value="'.$email.'"/>														
											<input type="submit" value="Modificar"/></form></td></tr>
														
									<tr><td>Registrado: '.$registrado.'</td></tr>
								</table>
							</article>';						
						
					}elseif($amigo){//Perfil de un amigo
						echo'<article>
								<form method = "POST"  action = "perfil.php?dni='.$dni.'">
								<input type="submit" name="dejarDeSeguir" value="Dejar de Seguir"/>
								</form>
						</article>
						<article id="iz">
								<img src="img_socios/'.$dni.'" />
							</article>
							<article>
								<h3>Perfil</h3>
								<table class="de">
									<tr><td>Nombre: '.$nombre.'</td></tr>
									<tr><td>E-mail: '.$email.'</td></tr>
									<tr><td>Registrado: '.$registrado.'</td></tr>
								</table>
							</article>';
					}else{//perfil de no amigo
							
						echo '<div class="incorrecto"><p>No eres amigo</p></div>';
						echo'<article id="iz">
							<img class="bl" src="img_socios/'.$dni.'" />					
						</article>';						
						echo'<h3>Perfil</h3>
							<table class="de">						
								<tr><td>Nombre: '.$nombre.'</td></tr>							
							</table>';									
						echo'<form METHOD="get" ACTION = "perfil.php">
								<input type="hidden" value="'.$dni.'" name="dni"/>
								<input type="hidden" value="yes" name="agregar"/>
								<input type="submit" value="Añadir como amigo">
						</form>';
					}

					if($dni==$dniS || $amigo){
						echo '<article id="acciones">
								<ul>
									<li onclick="location.href=\'amigos.php?dni='.$dni.'\'">Amigos</li>
									<li onclick="location.href=\'pendientes.php?dni='.$dni.'\'">Pendientes</li>
									<li onclick="location.href=\'favoritas.php?dni='.$dni.'\'">Favoritas</li>
									<li onclick="location.href=\'vistas.php?dni='.$dni.'\'">Vistas</li>
									<li onclick="location.href=\'puntuaciones.php?dni='.$dni.'\'">Puntuaciones</li>
								</ul>
						</article>';
						//comentarios peliculas
						$sql = "select id, nombre, fecha, texto from (
								select id_pelicula_a_nombre(id_pelicula) as nombre, fecha as fecha, 'id_pelicula='||id_pelicula as id , texto as texto
								from opiniones_peliculas 
								where dni='$dni'
								union all
								select id_juego_a_nombre(id_juego) as nombre, fecha as fecha, 'id_juego='||id_juego as id, texto as texto 
								from opiniones_juegos 
								where dni='$dni'
								) order by fecha desc";
 						echo '<article id="comentarios">
						 	   <h3>Comentarios</h3>';
						foreach ($con->query($sql) as $fila) {
							echo '<table>
									<tr><td class="nombre"><a href="articulo.php?'.$fila[0].'">'.$fila[1].'</a></td><td class="fecha">'.$fila[2].'</td></tr>
									<tr><td colspan="2" class="texto">'.$fila[3].'</td></tr>
								</table>';
						}
						echo '</article>';
						// $sql = "select id_pelicula_a_nombre(id_pelicula), fecha, id_pelicula, texto from opiniones_peliculas
					 //  	where dni='$dni'";
						// echo '<article id="comentarios">
						// 	   <h3>Comentarios</h3>';
						// foreach ($con->query($sql) as $fila) {
						// 	echo'
						// 		<table>
						// 			<tr class="fila1"><td><a href="articulo.php?id_pelicula='.$fila[2].'"><span> Película: '.$fila[0].' </span></a></td></tr>
						// 			<tr class="fila2"><td><span>Fecha del comentario: '.$fila[1].' </span></td></tr>
						// 			<tr class="fila3"><td>'.$fila[3].'</td></tr>
						// 		</table>';
						// }
						// echo'</article>
						// 	 <article id="comentarios">';//comentarios juegos
						// $sql = "select id_juego_a_nombre(id_juego), fecha, id_juego, texto from opiniones_juegos
					 //  	where dni='$dni'";
						// foreach ($con->query($sql) as $fila){
						// 	echo'
						// 		<table>
						// 			<tr class="fila1"><td><a href="articulo.php?id_juego='.$fila[2].'"><span> Juego: '.$fila[0].' </span></a></td></tr>
						// 			<tr class="fila2"><td><span>Fecha del comentario: '.$fila[1].' </span></td></tr>
						// 			<tr class="fila3"><td>'.$fila[3].'</td></tr>
						// 		</table>';
						// }
						// echo'</article>';
						
					}
				}
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