<?php
function Menu(){
	$dni="";

	if(isset($_SESSION['nombre'])){
		$nombre = $_SESSION['nombre'];
		$dni = $_SESSION['dni'];
		echo '<div><h4>Usuario: </h4></div>
		<h4>'.$nombre.'</h4>
		<form method="POST" action="index.php?logout=" enctype="application/x-www-form-urlencoded">
			<input type="submit" value="Logout" class="boton"/>
		</form>
		<ul>
			<li onclick="location.href=\'perfil.php?dni='.$_SESSION['dni'].'\'">Mi Perfil</li>				
			<li onclick="location.href=\'alquileres.php\'">Mis Alquileres</li>
			<li onclick="location.href=\'mis_reservas.php?dni='.$_SESSION['dni'].'\'">Mis Reservas</li>
			<li onclick="location.href=\'puntuaciones.php?dni='.$_SESSION['dni'].'\'">Mis Puntuaciones</li>
			<li onclick="location.href=\'amigos.php?dni='.$_SESSION['dni'].'\'">Mis Amigos</li>
			<li onclick="location.href=\'historial_compra.php?dni='.$_SESSION['dni'].'\'">Mis Compras</li>
			<li onclick="location.href=\'devoluciones.php?dni='.$_SESSION['dni'].'\'">Devoluciones Pendientes</li>
			<li onclick="location.href=\'pendientes.php?dni='.$_SESSION['dni'].'\'">Pendientes Por Ver</li>
			<li onclick="location.href=\'favoritas.php?dni='.$_SESSION['dni'].'\'">Favoritas</li>
			<li onclick="location.href=\'vistas.php?dni='.$_SESSION['dni'].'\'">Vistas</li>
			<li onclick="location.href=\'buscasocio.php\'">Buscar Socio</li>
		</ul>';	
	}else{				
		echo '<form method="POST" action="index.php" enctype="application/x-www-form-urlencoded">
				<div id="login">				
				<div><span>DNI: </span></div>
				<div><input type="text" name="dni"/></div>
				<div><span>Contraseña: </span></div>
				<div><input type="password" name="key"/></div>
				<input type="submit" value="Logear" class="boton"/>				
				</div>
			</form>';
	}
	if($dni=='00000000A'){
		echo'<p class="separador"> </p>
			<ul>
				<li onclick="location.href=\'add.php?articulo=pelicula\'">Añadir pelicula</li>
				<li onclick="location.href=\'add.php?articulo=juego\'">Añadir juego</li>
				<li onclick="location.href=\'add_usuario.php\'">Añadir usuario</li>
				<li onclick="location.href=\'add_comestible.php\'">Añadir comestible</li>
				<li onclick="location.href=\'usuario_con_devoluciones.php\'">Usuarios con devoluciones pendientes</li>
				<li onclick="location.href=\'add_alquiler.php\'">Alquiler</li>
				<li onclick="location.href=\'add_devolucion.php?buscar=\'">Devolucion</li>
				<li onclick="location.href=\'add_compra.php\'">Compras</li>
				<li onclick="location.href=\'ofertas.php\'">Ofertas</li>
				<li onclick="location.href=\'generos_juegos.php\'">Generos Juegos</li>
				<li onclick="location.href=\'plataformas.php\'">Plataformas</li>
				<li onclick="location.href=\'generos_peliculas.php\'">Generos Peliculas</li>
				<li onclick="location.href=\'calidad.php\'">Calidades</li>

			</ul>';
	}
}
function Navegador(){
	echo '<ul>
		<li onclick="location.href=\'index.php\'">Inicio</li>
		<li onclick="location.href=\'peliculas.php\'">Peliculas</li>
		<li onclick="location.href=\'juegos.php\'">Juegos</li>
		<li onclick="location.href=\'comestibles.php\'">Comestibles</li>
		<li onclick="location.href=\'informacion.php\'">Informacion</li>
		<li onclick="location.href=\'manual.php\'">Manual</li>
		<li onclick="location.href=\'requisitos.php\'">Requisitos y Extras</li>
	</ul>';
}	
?>