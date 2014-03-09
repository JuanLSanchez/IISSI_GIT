<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Videoclub ORI">
	<meta name="keywords" content="videoclub, ori, peliculas">
	<title>Videoclub ORI</title>
	<link rel="stylesheet" href="../css_David/general.css">
	<link rel="stylesheet" href="../css_David/informacion.css">
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
			<h2>Información</h2>
			<form id="formulario">
				<fieldset>
					<legend align="left"> <b>Datos de Contacto</b></legend>
					<span> Nombre: Dueño</span><br />
					<span> Apellidos: Apellidos del Dueño</span><br />
					<span> Telefono de contacto: 955999999</span><br />
					<span> E-mail: dueño@hotmail.es</span>
					
				</fieldset>
				<fieldset>
					<legend align="right"> <b>Ubicación</b></legend>
					<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
					src="https://maps.google.es/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Cazalla+de+la+Sierra,+Sevilla&amp;aq=1&amp;oq=cazalla&amp;sll=37.333351,-4.576501&amp;sspn=5.266266,10.821533&amp;ie=UTF8&amp;hq=&amp;hnear=Cazalla+de+la+Sierra,+Sevilla,+Andaluc%C3%ADa&amp;ll=37.930428,-5.758949&amp;spn=0.010205,0.021136&amp;t=m&amp;z=14&amp;output=embed">
					</iframe><br />
					<small><a href="https://maps.google.es/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=Cazalla+de+la+Sierra,+Sevilla&amp;aq=1&amp;oq=cazalla&amp;sll=37.333351,-4.576501&amp;sspn=5.266266,10.821533&amp;ie=UTF8&amp;hq=&amp;hnear=Cazalla+de+la+Sierra,+Sevilla,+Andaluc%C3%ADa&amp;ll=37.930428,-5.758949&amp;spn=0.010205,0.021136&amp;t=m&amp;z=14" 
						style="color:#0000FF;text-align:left">Ver mapa más grande</a></small><br />
					<span> Calle: Llana, 15</span><br />
					<span> Localidad: Cazalla de la Sierra</span><br />
					<span> Provincia: Sevilla</span><br />
					
				</fieldset>
			</form>
			
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
