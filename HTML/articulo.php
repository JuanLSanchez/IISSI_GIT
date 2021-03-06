<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<?php
		include "conexion.php";
		$con = CrearConexionBD();
		if(isset($_GET['id_pelicula'])){
			$id=$_GET['id_pelicula'];
			$sql = "select nombre from peliculas where id_pelicula='$id'";
		}else if(isset($_GET['id_juego'])){
			$id=$_GET['id_juego'];
			$sql = "select nombre from juegos where id_juego='$id'";
		}
		foreach ($con->query($sql) as $fila) {
			$nom = $fila[0];
		}
		echo '<title>'.$nom.'</title>'	;
		CerrarConexionBD($con);
	?>
	
	
	<?php 
		include "cabecera.php";
		Cabecera();
	?>
	<link rel="stylesheet" href="css/articulo.css">
	<script type="text/javascript" src="/js/articulo.js"></script>
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
			<?php //Actualizar articulo
			if(isset($_SESSION['dni'])){
				
				if(isset($_GET['id_pelicula'])){
					$articulo = "pelicula";
				}else{
					$articulo = "juego";
				}
				$id=$_GET['id_'.$articulo];
				$dni=$_SESSION['dni'];
				$con = CrearConexionBD();
				if(isset($_POST['estado'])){
  					if($articulo=="pelicula"){
  						$sql="delete from peliculas_vistas where id_pelicula='$id' and dni='$dni'";
  					}elseif($articulo=="juego"){
  						$sql="delete from juegos_vistos where id_juego='$id' and dni='$dni'";
  					}
  					$estado=$_POST['estado'];
  					$sql2="delete from ".$articulo."s_favoritos where id_".$articulo."='$id' and dni='$dni'";
  					$sql3="delete from ".$articulo."s_pendientes where id_".$articulo."='$id' and dni='$dni'";
  					$res=$con->exec($sql);
  					$res=$con->exec($sql2);
  					$res=$con->exec($sql3);
  					if($estado=="Favorito"){
  						$sql="insert into ".$articulo."s_favoritos values('$dni', '$id')";
  					}elseif($estado=="Pendiente"){
  						$sql="insert into ".$articulo."s_pendientes values('$dni', '$id')";
  					}elseif($estado=="Visto"){
  						if($articulo=="pelicula"){
	  						$sql="insert into peliculas_vistas values('$dni', '$id')";
	  					}elseif($articulo=="juego"){
	  						$sql="insert into juegos_vistos values('$dni', '$id')";
	  					}
  					}
  					$res=$con->exec($sql);
				}
				if(isset($_POST['mipuntuacion'])){
					if($_POST['mipuntuacion']<=5&&$_POST['mipuntuacion']>=0){
						$sql="delete from puntuaciones_".$articulo."s 
							where id_".$articulo."=".$id." and dni='$dni'";
						$res = $con->exec($sql);
						$sql="insert into puntuaciones_".$articulo."s values 
							('$dni', '$id', ".$_POST['mipuntuacion'].")";
						$res = $con->exec($sql);
					}
				}
				if(isset($_POST['indicador'])){
					if(isset($_POST['calidad'])){
						$sql="insert into reservas_".$articulo."s values('$id', '$dni', '".$_POST['calidad']."', sysdate)"	;
					}else{
						$sql="delete from reservas_".$articulo."s where id_".$articulo."=$id and dni='$dni'";
					}
					$res = $con->exec($sql);
					if($res){
						echo '<div class="correcto"><p>Reservada</p></div>';
					}else{
						echo '<div class="incorrecto"><p>No se ha podido reservar, asegurese de no tener devoluciones pendientes</p></div>';
								//<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
					}

				}
				if(isset($_POST['comentario'])){
					$sql="insert into opiniones_".$articulo."s values
					 (id_opinion_".$articulo.".nextval, '".$_POST['comentario']."', sysdate, '$id', '$dni')";
					 $res=$con->exec($sql);
				}
				if(isset($_POST['eliminarComentario'])){
					$idComentario = $_POST['eliminarComentario'];
					$sql = "select dni from opiniones_".$articulo."s where id_opinion_".$articulo."='$idComentario'";
					foreach ($con->query($sql) as $fila) {
						$res = $fila[0];
					}
					if($res=$dni||$dni=='00000000A'){
						$sql = "delete from opiniones_".$articulo."s where id_opinion_".$articulo."='$idComentario'";
						$res = $con->exec($sql);
						if($res){
							echo '<div class="correcto"><p>Comentario eliminado.</p></div>';
						}else{
							echo '<div class="incorrecto"><p>No se ha podido eliminar el comentario.</p></div>
								<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
						}
					}
				}

				CerrarConexionBD($con);
				}
			?>

			<?php //Mostrar articulo
			$con = CrearConexionBD();
			if(isset($_GET['id_pelicula'])){
				$articulo = "pelicula";
			}else{
				$articulo = "juego";
			}
			$id=$_GET['id_'.$articulo];
			$sql = "select * from ".$articulo."s where id_".$articulo."=".$id;
			$res = $con->query($sql);
			//$genero = $con->query("select genero from relacion_".$articulo."s_genero where id_".$articulo."=".$id);
			foreach ($res as $fila){
				$nombre = $fila[1];
				$edad = $fila[2];
				$imagen = $fila[3];
				$trailer = $fila[4];
				$sinopsis = $fila[5];
				$year = $fila[6];
			}
			//$sql="select avg(estrellas) from puntuaciones_".$articulo."s where id_".$articulo."='$id'";
			$sql="select id_".$articulo."_a_puntuacion('$id') from dual";
			$puntuacion = "";
			foreach ($con->query($sql) as $fila) {
				$puntuacion=$fila[0];
			}
			if(isset($nombre)){
				if(isset($_SESSION['dni'])){
					if($_SESSION['dni']=="00000000A"){
						echo '<div id="administrador">
						<article>
							<div id="administracion">
							<ul>
							<li>
							<form METHOD="POST" ACTION="del.php?id_'.$articulo.'='.$id.'&eliminar=">
								<input type="submit" value="Eliminar" id="eliminar"/>
							</form>
							</li>
							<li>
							<form METHOD="POST" ACTION="mod.php?id_'.$articulo.'='.$id.'">
								<input type="submit" value="Modificar" id="modificar"/>
							</form>
							</li>
							</ul>
							</div>
						</article>
						</div>';
				}
			}
			echo '<div id="iz">
			<article>
				<img class="bl" src="'.$imagen.'" />
				<span class="bl" >Puntuacion: '.$puntuacion.'</span>';
			if(isset($_SESSION['dni'])){ //Si existe sesion
				$dni=$_SESSION['dni'];
				$sql="select estrellas from puntuaciones_".$articulo."s 
						where id_".$articulo."=".$id." and 
						dni='".$dni."'";
				$res=($con->query($sql));
				$mipuntuacion="";
				foreach ($res as $fila) {
					$mipuntuacion=$fila[0];
				}
				if($articulo=="pelicula"){
					$sql="select calidad from relacion_peliculas_calidad where id_pelicula='$id' and alquiler>0";
					$sql2="select dni from peliculas_vistas where id_pelicula='$id' and dni='$dni'";
				}else{
					$sql="select plataforma from relacion_juegos_plataforma where id_juego='$id' and alquiler>0"	;
					$sql2="select dni from juegos_vistos where id_juego='$id' and dni='$dni'";
				}
				$calidad=$con->query($sql);
				$sql="select * from reservas_".$articulo."s where dni='$dni' and id_".$articulo."='$id'";
				$reserva="Reservar";
				foreach ($con->query($sql) as $fila) {
					$reserva=$fila[2];
				}
				$estado="";
				$cont=0;
				$sql="select dni from ".$articulo."s_favoritos 
					where id_".$articulo."='$id' and dni='$dni'";
				$sql3="select dni from ".$articulo."s_pendientes 
					where id_".$articulo."='$id' and dni='$dni'";
				if($con->query($sql)->fetch()){
					$estado="Favorito";
				}elseif($con->query($sql2)->fetch()){
					$estado="Visto";
				}elseif($con->query($sql3)->fetch()){
					$estado="Pendiente";
				}

				echo '<span>Mi puntuacion:</span>
				<form METHOD="POST" ACTION="articulo.php?id_'.$articulo.'='.$id.'" enctype="multipart/form-data">';
				echo '<input type="hidden" value="'.$mipuntuacion.'" name="mipuntuacion" id="mipuntuacion"/>
				<div id="estrellas">
						<img src="img_ori/b.png" id="estrella0" onmouseover="estrellas(0)" onmouseout="normal()" onclick="guardar(0)"/>
						';
				foreach (array('1','2','3','4','5') as $i) {
					if($i<=$mipuntuacion){
						echo '<img src="img_ori/ed.png" id="estrella'.$i.'" onmouseover="estrellas('.$i.')" onmouseout="normal()" onclick="guardar('.$i.')"/>';
					}else{
						echo '<img src="img_ori/eg.png" id="estrella'.$i.'" onmouseover="estrellas('.$i.')" onmouseout="normal()" onclick="guardar('.$i.')"/>';
					}
				}
				//<input class="bl" type="text" size="2" value="'.$mipuntuacion.'" name="mipuntuacion"/>';

				echo '</div>
					<select class="bl" name="estado">
						<option selected>'.$estado.'</option>
						<option>Favorito</option>
						<option>Pendiente</option>
						<option>Visto</option>
					</select>
					<input class="bl" type="submit" value="Actualizar"/>
				</form>';
				echo '<form METHOD="POST" ACTION="articulo.php?id_'.$articulo.'='.$id.'" enctype="multipart/form-data">
				<input class="bl" type="submit" value="'.$reserva.'" />
				<input type="hidden" name="indicador" value="si">';
				if($reserva=="Reservar"){
					echo '<select name="calidad">';
					foreach ($calidad as $fila) {
						if($fila[0]==$reserva){
							echo "<option selected>$fila[0]</option>";
						}else{
							echo "<option>$fila[0]</option>";
						}
					}
					echo '</select>';	
				}
				echo '</form>';
			}				
			echo '</article>
			</div>
			<article id="de">
				<h3>'.$nombre.'</h3>
				<div id="sinopsis">
					<span>'.$sinopsis.'</span>
				</div>
				<div id="genero"><span>Genero: ';
				$sql = "select genero from relacion_".$articulo."s_genero where id_".$articulo."=".$id;
				$generos = $con->query($sql);
				$bandera = 1==1;
				foreach ($generos as $genero) {
					if($bandera){
						echo $genero[0];
						$bandera = 1==2;
					}else{
						echo ", ".$genero[0];
					}
					
				}
				echo '.</span></div>';
				if($trailer!=""){
					echo '<div class="trailer">'.$trailer.'</div>';
				}
					
				echo '</article>';
				 //Comentarios
				if(isset($_SESSION['dni'])){
					echo '
				<article id="comentarios">
						<form METHOD="POST" ACTION="articulo.php?id_'.$articulo.'='.$id.'" enctype="multipart/form-data">
							<textarea name="comentario" id="comente" placeholder="Comente algo..."></textarea>
							<input type="submit" value="Comentar" id="boton"/>
						</form>
							<h3>Comentarios</h3>';
						$sql = "select dni_a_nombre(dni), to_char(fecha, 'DD/MM/yyyy'), texto, id_opinion_".$articulo.", dni 
								from opiniones_".$articulo."s 
								where id_".$articulo."='$id'
								order by fecha desc";
						foreach ($con->query($sql) as $fila) {
							echo '<table class="tablacomentario">
									<tr class="fila1"><td class="autor">Autor: '.$fila[0].'</td><td class="fecha">Fecha: '.$fila[1].'</td></tr>
									<tr class="fila2"><td colspan="2" class="comentario">'.$fila[2].'</td></tr>
								</table>';
							if($dni==$fila[4]||$dni=="00000000A"){
									echo '<form METHOD="POST" ACTION="articulo.php?id_'.$articulo.'='.$id.'" enctype="multipart/form-data">
											<input type="hidden" value="'.$fila[3].'" name="eliminarComentario"/>
											<input type="submit" value="eliminar"/>
										</form>';
							}
							}
						
			echo'</article>';
				}
		}else{
			echo "<p>No existe esa pelicula</p>";
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