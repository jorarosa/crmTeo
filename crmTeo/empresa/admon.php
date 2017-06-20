<?php
require_once('cabecera.php');
require_once('form_empresa.php');

$user_a=$_SESSION['USER_A'];	

$action="";if (isset($_POST['action'])) $action=$_POST['action'];

//Borrado de la cuenta del usuario
if ($action == 'x' && isset($_SESSION['USER_A'])){
	echo "<script>alert('Eliminando');</script>";
	$user_a=$_SESSION['USER_A'];	
	//Eliminando datos de candidato
	$q="delete from $TABLA_LOGIN where email='".$user_a."'";
	mysql_query($q);
	session_destroy();
	die ("<p align=center class=msg><a href=login.php>$Config->cuenta_cerrada</a></p>");
	}

$fempresa['acciones']='Insertar,Borrar,Consultar,Actualizar,Navegar,Numero,Limpiar';
//Limpiar($fempresa);
//Visualizacion del formulario
		
echo "<div class=marco >";
	require_once "menu.php";
//	DoEverything($fempresa);
        TablaEdicion($fempresa);
echo "</div>";

