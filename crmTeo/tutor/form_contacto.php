<?php
require_once("../configuracion.php");


$SiNo=array("S"=>"Si","N"=>"No");

if (isset($_SESSION['forms']['fcontacto']))
	$fcontacto=&$_SESSION['forms']['fcontacto'];
else {
	$fcontacto=array(
		"name"=>"fcontacto",
		"table"=>"fct_contacto",
		"filas"=>0, "indice"=>0, "query"=>"",
        "where"=>"", "errormsg"=>"", "statusmsg"=>"",
		"pre_update"=>"PreUpdate", //triger
        "acciones"=>"Actualizar,Insertar",
	"fields"=>array(
		"id"=>array("l"=>"id:", //Etiqueta
			"bd"=>true,
			"t"=>"TEXT",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"oferta_id"=>array("l"=>"oferta id:", //Etiqueta
			"bd"=>true,
			"t"=>"TEXT",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

          "fecha"=>array( "l"=>"Fecha :",
                        "t"=>"TEXT",
                        "de"=>"",//date('d/m/y'),
                        "s"=>20, "max"=>20,
                        "m"=>"/.+/",
                        "ac"=>true,
                        "co"=>false,
                        "r"=>false,
                        "err"=>false,
                        "bd"=>true,
                        "valor"=>""),
		"email_tutor"=>array("l"=>"Tutor:", //Etiqueta
			"t"=>"COMBO",
			"q"=>"select email as id, nombre from fct_tutor",
			"bd"=>true,
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"contenido"=>array(
			"bd"=>true,
			"t"=>"TEXTAREA",
			"htmlatt"=>"rows=3 cols=80",
			"l"=>"Contenido: ",
			"T"=>"Contacto, Seguimiento realizado",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>250,
			"ac"=>true,
			"err"=>false,
			"valor"=>"")
			)
		);
	$_SESSION['forms']['fcontacto']=&$fcontacto;
	} 

//Trigger preudate para el formulario de empresa
function PreUpdate(&$a){
	return true;
	}
?>
