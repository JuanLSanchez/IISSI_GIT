<?php
function CrearConexionBD(){
	$host='oci:dbname=localhost/XE;charset=UTF8';
	$usuario='juanlu';
	$password='juanlu';
	$conexion=null;
	
	try{
		$conexion=new PDO($host,$usuario,$password);
		// $conexion->setAttribute(constant("PDO:ATTR_ERRMODE,PDO:ERRMODE_EXCEPTION"));
	}
	catch(PDOException $e){
		echo $e;
	}
	
	return $conexion;
}

function CerrarConexionBD($conexion){
	$conexion=null;
}
?>