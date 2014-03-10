<?php
function Menu(){
	$dni="";

	if(isset($_SESSION['nombre'])){
		$nombre = $_SESSION['nombre'];
		$dni = $_SESSION['dni'];
		echo '<h4>Usuario: </h4>
		<h4>'.$nombre.'</h4>
		<form method="POST" action="index.php?logout=" enctype="application/x-www-form-urlencoded">
			<input type="submit" value="Logout" class="boton"/>
		</form>
		<ul>				
			<li><a href="alquileres.php">Alquileres</a></li>
			<li><a href="devoluciones.php">Devoluciones pendientes</a></li>
			<li><a href="amigos.php">Amigos</a></li>
			<li><a href="pendientes.php">Pendientes</a></li>
			<li><a href="favoritas.php">Favoritas</a></li>
			<li><a href="vistas.php">Vistas</a></li>
			<li><a href="puntuaciones.php">Mis puntuaciones</a></li>
			<li><a href="perfil.php'.$_SESSION['dni'].'">Mi perfil</a></li>
		</ul>';	
	}else{				
		echo '<form method="POST" action="index.php" enctype="application/x-www-form-urlencoded">
				<div id="login">
					<span>DNI: </span><input type="text" name="dni"/>
					<span>Contraseña: </span><input type="password" name="key"/>
					<input type="submit" value="Logear" class="boton"/>
				</div>
			</form>';
	}
	if($dni=='00000000A'){
		echo'<p> </p>
			<ul>
				<li><a href="add.php?articulo=pelicula">Añadir pelicula</a></li>
				<li><a href="add.php?articulo=juego">Añadir juego</a></li>
				<li><a href="add_usuario.php">Añadir usuario</a></li>
				<li><a href="add_comestible.php">Añadir comestble</a></li>
				<li><a href="add_alquiler.php">Alquiler</a></li>
				<li><a href="">Devolucion</a></li>
				<li><a href="">Compras</a></li>
				<li><a href="">Ofertas</a></li>
				<li><a href="">Generos</a></li>
				<li><a href="">Plataformas</a></li>
				<li><a href="">Calidades</a></li>

			</ul>';
	}
}
function Navegador(){
	echo '<ul>
		<li><a href="index.php">Inicio</a></li>
		<li><a href="peliculas.php">Peliculas</a></li>
		<li><a href="juegos.php">Juegos</a></li>
		<li><a href="comestibles.php">Comestibles</a></li>
		<li><a href="informacion.html">Informacion</a></li>
	</ul>';
}	
?>