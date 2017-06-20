<?php
require_once("../configuracion.php");

$SiNo=array("S"=>"Si","N"=>"No");
$UnoDos=array("1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5"=>"5", "6"=>"6");
$TipoOferta=array("FC"=>"Prácticas FCT","OE"=>"Oferta de Empleo"); //, "ER"=>"Erasmus");
$EstadoOferta=array("LI"=>"Sin Asignar", "AS"=>"Asignada", "RE"=>"Resuelta");
$EstadoOfertaEmp=array("EC"=>"En Curso", "CE"=>"Cerrada");

if (isset($_SESSION['forms']['foferta']))
	$foferta=&$_SESSION['forms']['foferta'];
	else {
	$foferta=array(
	"name"=>"foferta","table"=>$Config->database.".fct_oferta","filas"=>0, 
	"indice"=>0, "query"=>"","pre_update"=>"OfertaPreUpdate",
	"post_insert"=>"ofertaPostInsert",
        "where"=>"", "errormsg"=>"", "statusmsg"=>"",
                "acciones"=>"Insertar,Actualizar",
	"fields"=>array(
		"id"=>array("l"=>"Identificador :", //Etiqueta
			"bd"=>true,
			"ro"=>true,
			"sh"=>true,
			"t"=>"TEXT",//Tipo, TEXT default
			"s"=>3,	//Size del imput
			"max"=>12,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

		"email"=>array("l"=>"Email :", //Etiqueta
			"bd"=>true,
			"sh"=>false,
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

 		"fecha"=>array( "l"=>"Fecha :", 
			"t"=>"DATE", 
			"ro"=>true, //De asignacion automatica, no
			"de"=>"",//date('d/m/y'),
			"s"=>10, "max"=>10, 
			"m"=>"/.+/", 
			"ac"=>true,
                        "co"=>false, 
			"r"=>true, 
			"err"=>false, 
			"bd"=>true, 
			"valor"=>""),

 		"duracion"=>array( "l"=>"Días", 
			"T"=>"Duracion de la oferta en días", 
			"t"=>"TEXT", 
			"de"=>'90', //90 días de duración
			"s"=>3, "max"=>3, 
			"m"=>"/^[[:digit:]]{1,3}$/", 
			"ac"=>true,
                        "co"=>false, 
			"r"=>true, 
			"err"=>false, 
			"bd"=>true, 
			"valor"=>"90"),

 		"num"=>array( "l"=>"Nº De Alumnos :", 
			"t"=>"COMBO",
			"de"=>1,
			"qll"=>&$UnoDos,
			"de"=>1,
			"s"=>2, "max"=>2, 
			"m"=>"/.+/", 
			"ac"=>true,
                        "co"=>false, 
			"r"=>true, 
			"err"=>false, 
			"bd"=>true, 
			"valor"=>1),
		"area_id"=>array(
			"bd"=>true,
			"l"=>"Perfil :",
			"T"=>"perfil al que va dirigida la oferta",
			"t"=>"COMBO",//Tipo, TEXT default
			"q"=>"select codigo as id, nombre from fct_familia", //Query el primer campo debe llamarse "id"
			"m"=>"/.+/",
			"r"=>true,	
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"tipo"=>array("l"=>"Tipo :", //Etiqueta
			"T"=>"Objeto de la oferta",
			"bd"=>true,
			"t"=>"COMBO",
			"qll"=>&$TipoOferta,
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"de"=>"OE",
			"valor"=>"OE"),	//Valor del campo,viene del post o del row
		"direccion"=>array(
                        "bd"=>true,
                        "l"=>"Direcci&oacute;n:",
                        "T"=>"Direcci&oacute;n del centro de trabajo",
                        "r"=>true,
                        "s"=>20,
                        "max"=>60,
                        "ac"=>true,
                        "err"=>false,
                        "valor"=>""),
                "cpostal"=>array(
                        "bd"=>true,
                        "l"=>"C&oacute;d Postal:",
                        "T"=>"C&oacute;digo Postal del centro de trabajo",
                        "r"=>false,
                        "s"=>6,
                        "max"=>5,
                        "ac"=>true,
                        "err"=>false,
                        "valor"=>""),
                "pais"=>array(
                        "bd"=>true,
			"de"=>"esp",
                        "l"=>"País:",
                        "T"=>"País del centro de trabajo",
                        "t"=>"COMBO",//Tipo, TEXT default
                       // "q"=>"select id, nombre from fct_pais", //Query el primer campo debe llamarse "id"
			"qj"=>"paises", //Funcion Javascrip
                        "m"=>"/.+/",
                        "r"=>true,
                        "ac"=>true,
                        "err"=>false,
                        "valor"=>"esp"),
               "provincia"=>array(
                        "bd"=>true,
                        "l"=>"Provincia:",
                        "t"=>"COMBO",
                        //"q"=>"select id, nombre from fct_provincia",
			"qj"=>"provincias", 
                        "r"=>false,
                        "m"=>"/.+/",
                        "ac"=>true,
                        "err"=>false,
			"de"=>"28",
                        "valor"=>"28"),
                "localidad"=>array(
                        "bd"=>true,
                        "l"=>"Localidad:",
                        "r"=>true,
                        "m"=>"/.+/",
                        "s"=>12,
                        "max"=>40,
                        "ac"=>true,
                        "err"=>false,
                        "valor"=>""),
		"cont"=>array(
			"l"=>"Datos Adicionales :",//Ultimo trabajo, funciones, tareas etc.:
			"T"=>"Descripción opcional de la oferta",
			"bd"=>true,
			"t"=>"TEXTAREA",
			"htmlatt"=>"cols=80 rows=4",
			"max"=>8192,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
			
		"estado"=>array("l"=>"Estado :", //Etiqueta
			"T"=>"Estado Sin Asigar, Asignada, Resuelta",
			"bd"=>true,
			"t"=>"COMBO",
			"qll"=>&$EstadoOferta,
			"s"=>20,	//Size del imput
			"max"=>20,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>"LI", //Valor del campo,viene del post o del row
			"de"=>"LI"),	

		"estado_emp"=>array("l"=>"Estado :", //Etiqueta
			"T"=>"En Vigor, Cerrada",
			"bd"=>true,
			"t"=>"COMBO",
			"qll"=>&$EstadoOfertaEmp,
			"s"=>20,	//Size del imput
			"max"=>20,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>"EC", //Valor del campo,viene del post o del row
			"de"=>"EC"),	

		"tutor"=>array(
			"l"=>"Tutor :",//Ultimo trabajo, funciones, tareas etc.:
			"T"=>"Tutor que tiene bloqueada la oferta",
			"bd"=>true,
			"t"=>"TEXT",
			"s"=>15,	//Size del imput
			"max"=>15,
			"ac"=>true,
			"err"=>false,
			"valor"=>"")
			)	
		);
	$_SESSION['forms']['foferta']=&$foferta;
	}

//Trigger preudate para el formulario de empresa
function ofertaPreUpdate(&$a){
	return true;
	}
function ofertaPostInsert(&$a){
	//Tras insertar la oferta con exito,mandamos un correo, limpiamos el formulario y damos el mensaje de oferta insertada
	//LimpiarForm($a);
	$a['statusmsg']="Solicitud aceptada";
	return true;
	}
?>
