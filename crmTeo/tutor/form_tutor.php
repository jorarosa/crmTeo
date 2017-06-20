<?php
require_once("../configuracion.php");

if (isset($_SESSION['forms']['ftutor']))
	$ftutor=&$_SESSION['forms']['ftutor'];
else {
	$ftutor=array(
		"name"=>"ftutor",
		"table"=>"fct_tutor",
		"filas"=>0, "indice"=>0, "query"=>"",
        "where"=>"", "errormsg"=>"", "statusmsg"=>"",
		//"pre_update"=>"PreUpdate", //triger
        "acciones"=>"Actualizar",
	"fields"=>array(
		"id"=>array("l"=>"id:", //Etiqueta
			"bd"=>true,
			"t"=>"TEXT",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"claveac"=>array("l"=>"", //Etiqueta
			"bd"=>false,
			"sh"=>false,
			"t"=>"PASSWORD",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"nclave1"=>array("l"=>"", //Etiqueta
			"bd"=>false,
			"sh"=>false,
			"t"=>"PASSWORD",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"nclave2"=>array("l"=>"", //Etiqueta
			"bd"=>false,
			"sh"=>false,	
			"t"=>"PASSWORD",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

		"email"=>array("l"=>"Email :", //Etiqueta
			"bd"=>true,
			"s"=>30,	//Size del imput
			"max"=>100,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

		"nombre"=>array(
			"bd"=>true,
			"l"=>"Apellidos y Nombre :",
			"T"=>"Apelliudos y Nombre",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>40,
			"max"=>100,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"usuario"=>array(
			"bd"=>true,
			"l"=>"Usuario :",
			"T"=>"Usuario",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>100,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"nif"=>array(
			"bd"=>true,
			"l"=>"Nif:",
			"T"=>"Nif del representante legal de la entidad",
			"r"=>false,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"fijo"=>array(
                        "bd"=>true,
                        "l"=>"Teléfono:",
                        "m"=>"/.+/",
                        "s"=>10,
                        "max"=>15,
                        "ac"=>true,
                        "err"=>false,
                        "valor"=>""),
		"movil"=>array(
                        "bd"=>true,
                        "l"=>"Móvil:",
                        "m"=>"/.+/",
                        "s"=>10,
                        "max"=>15,
                        "ac"=>true,
                        "err"=>false,
						"de"=>"",
                        "valor"=>""),
		"activo"=>array("l"=>"Puede acceder al sistema", //Etiqueta
                        "T"=>"Activar o desactivar la cuenta ",
                        "bd"=>true,
                        "t"=>"COMBO",
                        "qll"=>array("1"=>"Si","0"=>"No"),
                        "s"=>30,        //Size del imput
                        "max"=>50,      //sizelimit del campo
                        "m"=>"/.+/",    //Picture del campo
                        "ac"=>true,     //Actualizable
                        "err"=>false,   //Flag de error unmatching de la mascara
						"de"=>'N',
                        "valor"=>"N")
			)
		);
	$_SESSION['forms']['ftutor']=&$ftutor;
	} 

//Troigger preudate para el formulario de empresa
/*
function PreUpdate(&$a){
	global $Config;
	//print_r($a);
	$error=false;
	$error_text="";
	
	$nif=$a['fields']['nif']['valor'];
	if( 1!=check_nif_cif_nie($nif) ) {
	$error=true;
		$a['fields']['rep_nif']['err']=true;
               	$error_text.="El nif del tutor de no es válido. Por favor introduzca un nif correcto.";
	}
	
	$nuevaclave="";
	if (strlen($a['fields']['claveac']['valor'])>0){
		//A cambiar tocan
		$claveac=$a['fields']['claveac']['valor'];
		$nclave1=$a['fields']['nclave1']['valor'];
		$nclave2=$a['fields']['nclave2']['valor'];
		if( strlen($nclave1)==0 ||
			strlen($nclave2)==0 ){
			$error=true;
			$error_text.="Error: Para cambiar su clave ";
			$error_text.="Debe introducir los tres campos";
			$a['fields']['nclave1']['err']=true;
			$a['fields']['nclave2']['err']=true;
			}
		else{
			//¿La clave actual es la buena?
			if($claveac != $_SESSION['CLAVE']){
				$error=true;
				$error_text.="La clave actual no es correcta";
				$a['fields']['claveac']['err']=true;
			}
			else if ($nclave1 != $nclave2){
				$error=true;
				$error_text.="Las claves nuevas no coinciden";
				$a['fields']['nclave1']['err']=true;
				$a['fields']['nclave2']['err']=true;
				}
			else {//Todo bien la nueva clave sera $nclave2
				$nuevaclave=$nclave2;
				$user=$_SESSION['USER_T'];
				$q="update ". $a['table']. " set clave='".$nuevaclave."' where email='".$user."'";
				echo $q;
				if (mysql_query($q)) $a['errormsg']='Clave actualizada';
				else {$error=true;$error_text.='Clave NO actualizada.';}
				//$_SESSION['CLAVE']=$nuevaclave;
				
				}
			}
			$a['fields']['claveac']['valor']="";
			$a['fields']['nclave1']['valor']="";
			$a['fields']['nclave2']['valor']="";
                       }
	if ($error){
		$a['errormsg']=$error_text;
		return false;
		}
	else return true;
	}
	*/
?>
