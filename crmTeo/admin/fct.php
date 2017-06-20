<?php
require_once('cabecera.php');
if ($_SESSION['USER_T']!=$Config->administrador) die ("Necesita autorización");

require_once("../configuracion.php");
require_once("../fct/form_fct.php");

$it2= Form_iterator::factory('itfct',6);
$ffct['acciones']='Insertar,Actualizar,Consultar,Navegar,Numero,Limpiar,Borrar';
$ffct['fields']['grupo']['t']='TEXT';
$ffct['fields']['curso']['co']=true;
echo "<div class=marco >";
        require_once "menu.php";
        echo "<div class=bloque>";
		DoEveryThing($ffct);
		//TablaEdicion($ffct,false,$it2);
		//$it2->show();	
        echo "</div";
echo "</div";
?>

