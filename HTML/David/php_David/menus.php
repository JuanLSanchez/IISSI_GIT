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
			<a href="alquileres.php"><li>Alquileres</li></a>
			<a href="devoluciones.php"><li>Devoluciones pendientes</li></a>
			<a href="amigos.php"><li>Amigos</li></a>
			<a href="pendientes.php"><li>Pendientes</li></a>
			<a href="favoritas.php"><li>Favoritas</li></a>
			<a href="vistas.php"><li>Vistas</li></a>
			<a href="puntuaciones.php"><li>Mis puntuaciones</li></a>
			<a href="perfil1.php"><li>Mi perfil</li></a>				
		</ul>';	
	}else{				
		echo '<form method="POST" action="index.php" enctype="application/x-www-form-urlencoded">
				<span>DNI: </span><input type="text" name="dni"/>
				<span>Contraseña: </span><input type="password" name="key"/>
				<input type="submit" value="Logear" class="boton"/>
			</form>';
	}
	if($dni=='00000000A'){
		echo'<p> </p>
			<ul>
				<a href="add.php?articulo=pelicula"><li>Añadir pelicula</li></a>
				<a href="add.php?articulo=juego"><li>Añadir juego</li></a>
				<a href="add_usuario.php"><li>Añadir usuario</li></a>
				<a href="add_comestible.php"><li>Añadir comestble</li></a>
				<a href=""><li>Alquiler</li></a>
				<a href=""><li>Devolucion</li></a>
			</ul>';
	}
}
function Navegador(){
	echo '<ul>
		<a href="index.php"><li>Inicio</li></a>
		<a href="peliculas.php"><li>Peliculas</li></a>
		<a href="juegos.php"><li>Juegos</li></a>
		<a href="comestibles.php"><li>Comestibles</li></a>
		<a href="informacion.html"><li>Informacion</li></a>
	</ul>';
}	
?>