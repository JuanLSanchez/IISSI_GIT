<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/ofertas.css">
</head>
<body>
		<header id="cabecera">
			<h1>Videoclub ORI</h1>
		</header>
		<div id="cuerpo">
		<nav id="navegador">
			<?php
				include "conexion.php";
				include "menus.php";
				Navegador();
			?>
		</nav>
		<section id="seccion">
			<article>
					<?php						
						if(isset($_SESSION['dni'])){
							//Añadir
							if($_SESSION['dni']=="00000000A"){
								$con = CrearConexionBD();
								if(isset($_POST['add'])){
									$_SESSION['oferta']['texto'] = $_POST['texto'];
									$_SESSION['oferta']['fechaInicio'] = $_POST['fechaInicio'];
									$_SESSION['oferta']['fechaFin'] = $_POST['fechaFin'];
									$_SESSION['oferta']['precio'] = $_POST['precio'];

									$texto = str_replace("'", "''", $_POST['texto']);
									$fechaInicio = $_POST['fechaInicio'];
									$fechaFin = $_POST['fechaFin'];
									$precio = $_POST['precio'];
									$error = "";

									
									if(strlen($texto)>200){
										$error = $error.'<div class="incorrecto"><p>La descripcion tiene que tener menos de 200 caracteres</p></div>';
									}
									if(preg_match("/^(0[1-9]|[12][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/]\d{4}$/",$fechaInicio)){
										list ($day1, $month1, $year1) = explode ("/", $fechaInicio);
										if(!checkdate($month1, $day1, $year1)){
											$error = $error.'<div class="incorrecto"><p>Fecha Inicio Incorrecta</p></div>';	
										}	
									}else{
										$error = $error.'<div class="incorrecto"><p>Fecha Inicio Incorrecta</p></div>';	
									}
									
									if(preg_match("/^(0[1-9]|[12][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/]\d{4}$/",$fechaFin)){
										list ($day2, $month2, $year2) = explode ("/", $fechaFin);
										if(!checkdate($month2, $day2, $year2)){
											$error = $error.'<div class="incorrecto"><p>Fecha Fin Incorrecta</p></div>';	
										}
									}else{
										$error = $error.'<div class="incorrecto"><p>Fecha Fin Incorrecta</p></div>';	
									}

									
									if(!preg_match("/^\d{1,6},\d{1,2}$/", $precio)){
										$error = $error.'<div class="incorrecto"><p>Precio Incorrecto</p></div>';	
									}
									if($error==""){
										$sql = "insert into ofertas values(id_oferta.nextval, '$texto', 
											to_date('$fechaInicio','dd/mm/yyyy'), to_date('$fechaFin','dd/mm/yyyy'), '$precio')";
										$res = $con->exec($sql);
										if($res){
											echo '<div class="correcto"><p>La oferta se ha añadido correctamente.</p></div>';
										}else{
											echo '<div class="incorrecto"><p>La oferta no se a añadido correctamente</p></div>
													<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
										}
									}else{
										echo $error;
									}
								}
								if(isset($_POST['del'])){
									$id = $_POST['id'];
									$sql = "delete from ofertas where id_oferta='$id'";
									$res = $con->exec($sql);
									if($res){
										echo '<div class="correcto"><p>La oferta se ha eliminado correctamente.</p></div>';
									}else{
										echo '<div class="incorrecto"><p>La oferta no se a eliminado correctamente</p></div>
												<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
									}
								}elseif(isset($_POST['mod'])){
									$id = $_POST['id'];
									$texto = str_replace("'", "''", $_POST['texto']);
									$inicio = $_POST['inicio'];
									$fin  = $_POST['fin'];
									$precio  = $_POST['precio'];

									$sql = "update ofertas set 
												texto='$texto', 
												fecha_inicio='$inicio', 
												fecha_fin='$fin', 
												precio='$precio'
												where id_oferta='$id'";
									$res = $con->exec($sql);
									if($res){
										echo '<div class="correcto"><p>La oferta se ha modificad correctamente.</p></div>';
									}else{
										echo '<div class="incorrecto"><p>La oferta no se a modificado correctamente</p></div>
												<div class="incorrecto"><p>'.$con->errorInfo()[2].'</p></div>';
									}
								}

								CerrarConexionBD($con);
						}
					}
					?>
					<?php
					if (isset($_SESSION['dni'])) {
						if(!($_SESSION['dni'] == '00000000A')){
							echo '<p>No eres el administrador, no se guardaran los cambios</p>';
						}else{
							if(!isset($_SESSION['oferta'])||isset($_POST['borrar'])){
								$_SESSION['oferta']['texto'] = "";
								$_SESSION['oferta']['fechaInicio'] = "";
								$_SESSION['oferta']['fechaFin'] = "";
								$_SESSION['oferta']['precio'] = "";
							}
							$formulario = $_SESSION['oferta'];
						}
					}else{
						echo '<p>Tienes que loguearte para que se guardaran los cambios</p>';
					}
				?>
				<form METHOD="POST" ACTION="ofertas.php" enctype="multipart/form-data">
					<input type="submit" value="Borrar formulario" name="borrar"/>
				</form>
				<form METHOD="POST" ACTION="ofertas.php" enctype="multipart/form-data">
					<fieldset>
						<legend> Añadir oferta.</legend>
						<table id="nuevo">
							<tr class="text">
								<td colspan="4">
									<label for="texto">Descripción: </label>
									<textarea id="texto" name="texto"><?php
										if($formulario['texto']){echo $formulario['texto'];};
									?></textarea>
								</td>
							</tr>
							<tr>
								<td>
									<label for="fechaInicio">Fecha Inicio: </label>
									<input type="text" name="fechaInicio" pattern="^(0[1-9]|[12][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/]\d{4}$" <?php
										if($formulario['fechaInicio']){echo 'value="'.$formulario['fechaInicio'].'"';};
									?> />
								</td>
								<td>
									<label for="fechaFin">Fecha Fin: </label>
									<input type="text" name="fechaFin" pattern="^(0[1-9]|[12][0-9]|3[0-1])[\/](0[1-9]|1[0-2])[\/]\d{4}$" <?php
										if($formulario['fechaFin']){echo 'value="'.$formulario['fechaFin'].'"';};
									?> />
								</td>
								<td>
									<label for="precio">Precio: </label>
									<input type="number" name="precio" pattern="\d{1,5},\d{1,2}"<?php
										if($formulario['precio']){echo 'value="'.$formulario['precio'].'"';};
									?> />
								</td>
							</tr>
						</table>
					</fieldset>
					<input type="submit" value="Añadir" name="add"/>
				</form>
			</article>
			<article>
				<?php
					if(isset($_SESSION['dni'])){
						if($_SESSION['dni']=="00000000A"){
							$con = CrearConexionBD();
							$sql = "select id_oferta, texto, fecha_inicio, fecha_fin, to_char(precio, '990.99') from ofertas";
							echo '<table id="ofertasActuales">
							<tr>
								<td>Descripcion</td>
								<td>Fecha Inicio</td>
								<td>Fecha Fin</td>
								<td>Precio</td>
							</tr>';
							$cont = 0;
							foreach ($con->query($sql) as $fila) {
								echo '
								<tr>
										<td class="des">
											<form METHOD="POST" ACTION="ofertas.php" enctype="multipart/form-data" id="modificar'.$cont.'">
												<textarea id="texto" name="texto">'.$fila[1].'</textarea>
												<input type="hidden" value="'.$fila[0].'" name="id"/> 
											</form>
										</td>
										<td class="inicio"><input type="text" value="'.$fila[2].'" name="inicio" form="modificar'.$cont.'" /></td>
										<td class="fin"><input type="text" value="'.$fila[3].'" name="fin" form="modificar'.$cont.'" /></td>
										<td class="precio"><input type="number" value="'.str_replace(".", ",",$fila[4]).'" name="precio" form="modificar'.$cont.'" /></td>
										<td class="mod">									
											<input type="submit" value="Modificar" name="mod" form="modificar'.$cont.'"/>
											<input type="submit" value="Eliminar" name="del" form="modificar'.$cont.'"/>
										</td>
								</tr>';
								$cont++;
							}
							echo '</table>';
							CerrarConexionBD($con);
						}
					}
				?>
			</article>
		</section>
		<aside id="menu">
			<?php
			if(isset($_POST['dni'])){
				$con = CrearConexionBD();
				$dni = $_POST['dni'];
				$key = $_POST['key'];
				$sql = "select dni, nombre from socios where 
						dni='$dni' and key='$key'";
				$query = $con->query($sql);
				if($res = $query->fetch()){
					$_SESSION['dni'] = $res['0'];
					$_SESSION['nombre'] = $res['1'];
				}else{
					echo '<div class="incorrecto"><p>Contraseña o usuario incorrectos</p></div>';
				}
			}
			if(isset($_GET['logout'])){
				$_SESSION = array();
				session_destroy();
			}
			Menu();
			?>
		</aside>
		<footer id="pie">
			<p>
			    <img src="img_ori/vcss.gif" />
			    <img src="img_ori/valid-html5.png"/>
			</p>
		</footer>
	</div>
</body>
</html>