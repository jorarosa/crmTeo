<?php
require_once('cabecera.php');
if ($_SESSION['USER_T']!=$Config->administrador) die ("Necesita autorización");
require_once("../configuracion.php");

$user_a=$_SESSION['USER_T'];	

$form_fct_ciclos = array(
		"name"=>"form_fct_ciclos",
		"table"=>"fct_ciclos",
		"filas"=>0, "indice"=>0, "query"=>"","where"=>"", "errormsg"=>"", "statusmsg"=>"",
		"acciones"=>"Actualizar,Insertar,Borrar,Cancelar",//Consultar,Limpiar,Navegar,Numero",
		"fields"=>array(

			"id"=>array("l"=>"id:",
				"bd"=>true,
				"co"=>false,
				"t"=>"TEXT",
				"s"=>11,
				"max"=>11,
				"ac"=>true,
				"err"=>false,
				"r"=>false,
				"sh"=>true,
				"valor"=>""),

			"CODIGO"=>array("l"=>"CODIGO:",
				"bd"=>true,
				"co"=>false,
				"t"=>"TEXT",
				"s"=>20,
				"max"=>45,
				"ac"=>true,
				"err"=>false,
				"r"=>false,
				"sh"=>true,
				"valor"=>""),

			"NOMBRE"=>array("l"=>"NOMBRE:",
				"bd"=>true,
				"co"=>false,
				"t"=>"TEXT",
				"s"=>20,
				"max"=>150,
				"ac"=>true,
				"err"=>false,
				"r"=>false,
				"sh"=>true,
				"valor"=>""),

			"FAMILIA_ID"=>array("l"=>"FAMILIA_ID:",
				"bd"=>true,
				"co"=>false,
				"t"=>"TEXT",
				"s"=>9,
				"max"=>9,
				"ac"=>true,
				"err"=>false,
				"r"=>false,
				"sh"=>true,
				"valor"=>""),

			"PERIODO"=>array("l"=>"PERIODO:",
				"bd"=>true,
				"co"=>false,
				"t"=>"TEXT",
				"s"=>20,
				"max"=>30,
				"ac"=>true,
				"err"=>false,
				"r"=>false,
				"sh"=>true,
				"valor"=>""),

			"HORAS_FCT"=>array("l"=>"HORAS_FCT:",
				"bd"=>true,
				"co"=>false,
				"t"=>"TEXT",
				"s"=>6,
				"max"=>6,
				"ac"=>true,
				"err"=>false,
				"r"=>false,
				"sh"=>true,
				"valor"=>"")
		)
	);

echo "<div class=marco >";
        require_once "menu.php";
        echo "<div class=bloque>";
	TablaEdicion($form_fct_ciclos,false);
        echo "</div>";
echo "</div>";
?>
