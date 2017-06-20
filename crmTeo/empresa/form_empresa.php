<?php
require_once("../configuracion.php");


$SiNo=array("S"=>"Si","N"=>"No");

if (isset($_SESSION['forms']['fempresa']))
	$fempresa=&$_SESSION['forms']['fempresa'];
else {
	$fempresa=array(
		"name"=>"fempresa",
		"table"=>"fct_empresa",
		"filas"=>0, "indice"=>0, "query"=>"",
                "where"=>"", "errormsg"=>"", "statusmsg"=>"",
		//"post_update"=>"PostUpdate", //triger
		"pre_update"=>"PreUpdate", //triger
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
			"t"=>"PASSWORD",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"nclave1"=>array("l"=>"", //Etiqueta
			"t"=>"PASSWORD",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"nclave2"=>array("l"=>"", //Etiqueta
			"t"=>"PASSWORD",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>false,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"cif"=>array("l"=>"Cif :", //Etiqueta
			"bd"=>true,
			"s"=>10,	//Size del imput
			"max"=>10,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

		"email"=>array("l"=>"Email :", //Etiqueta
			"bd"=>true,
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"erasmus"=>array("l"=>"Acoge Erasmus :", //Etiqueta
			"T"=>"¿Acogería a alumnos en prácticas de otros paises europeos?",
			"bd"=>true,
			"t"=>"COMBO",
			"qll"=>&$SiNo,
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"razon"=>array("l"=>"Razón Social:", //Etiqueta
			"bd"=>true,
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

		"telefono"=>array(
			"bd"=>true,
			"l"=>"Teléfono:",
			"m"=>"/.+/",
			"s"=>10,
			"max"=>15,
			"ac"=>true,
			"err"=>false,
			"r"=>true,	//Required
			"valor"=>""),
		"direccion"=>array(
			"bd"=>true,
			"l"=>"Direcci&oacute;n:",
			"r"=>true,
			"s"=>20,
			"max"=>60,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"cpostal"=>array(
			"bd"=>true,
			"l"=>"C&oacute;digo Postal:",
			"r"=>false,
			"s"=>6,
			"max"=>15,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"pais"=>array(
			"bd"=>true,
			"l"=>"País:",
			"t"=>"COMBO",//Tipo, TEXT default
			//"q"=>"select iso as id, nombre from fct_pais", //Query el primer campo debe llamarse "id"
			"qj"=>"paises", //Funcion Javascrip
			"m"=>"/.+/",
			"r"=>true,	
			"ac"=>true,
			"err"=>false,
			"de"=>'esp',
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
			"de"=>'28',
			"valor"=>"28"),

		"localidad"=>array(
			"bd"=>true,
			"l"=>"Localidad:",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"convenio"=>array(
			"bd"=>true,
			"l"=>"No de convenio:",
			"T"=>"Si su entidad tiene convenio de colaboración con el centro informe aquí el número",
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"rep_nom"=>array(
			"bd"=>true,
			"l"=>"Nombre :",
			"T"=>"Nombre del representante legal",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"rep_ape"=>array(
			"bd"=>true,
			"l"=>"Apellidos :",
			"T"=>"Apellidos del representante legal",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"rep_nif"=>array(
			"bd"=>true,
			"l"=>"Nif:",
			"T"=>"Nif del representante legal de la entidad",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"cont_nom"=>array(
			"bd"=>true,
			"l"=>"Nombre :",
			"T"=>"Nombre de la persona de contacto",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"cont_ape"=>array(
			"bd"=>true,
			"l"=>"Apellidos :",
			"T"=>"Apellidos de la persona de contacto",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>"")

			)
		);
	$_SESSION['forms']['fempresa']=&$fempresa;
	//$fempresa=&$_SESSION['forms']['fempresa'];
	} 

//Trigger preudate para el formulario de empresa
function PreUpdate(&$a){
	global $Config;
	//print_r($a);
	$error=false;
	$error_text="";


	/* ¿Es buena la combinaci&oacute;n pais provicia? */
       if($a['fields']['pais']['valor']!='esp') { //El pais no es España
                        if (!strstr($a['fields']['provincia']['valor'],$Config->nullstring)){
                                $error=true;
                                $a['fields']['provincia']['err']=true;
                                $error_text="El pais no es España ";
                                $error_text.="no seleccione provincia.";
                                }
                        }
	else { //El pais es españa, se requiere provincia
                        if (strstr($a['fields']['provincia']['valor'],$Config->nullstring)){
                                $error=true;
                                $a['fields']['provincia']['err']=true;
                                $error_text=" Debe elegir una provincia";
                                }
		}


	/*Si el pais es españa comprobamos cif y nif ?? */
       if($a['fields']['pais']['valor']=='esp') { //El pais es España
		$cif=$a['fields']['cif']['valor'];
		//if( 2!=check_nif_cif_nie($a['fields']['cif']['valor']) ) {
		if( !in_array(check_nif_cif_nie($a['fields']['cif']['valor']),array(1,2,3)) ) {
			$error=true;
			$a['fields']['cif']['err']=true;
                	$error_text.="El Cif/Nif/Nie $cif  no es válido. Por favor introduzca un Cif/Nif/Nie correcto.";
			}
		/* Es bueno el nif del representante */
		$nif=$a['fields']['rep_nif']['valor'];
		if( !in_array(check_nif_cif_nie($nif),array(1,3)) ) {
			$error=true;
			$a['fields']['rep_nif']['err']=true;
                	$error_text.="El nif del representante de la entidad  no es válido. Por favor introduzca un nif correcto.";
			}
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
			$email=$_SESSION['USER_A'];
			$clave=buscaBd("select clave from fct_empresa where email='$email'");
			if($claveac != $clave){
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
				$user=$_SESSION['USER_A'];
				$q="update ". $a['table']. " set clave='".$nuevaclave."' where email='".$user."'";
				//echo $q;
				if (mysqli_query_d($q)) $a['errormsg']='Clave actualizada';
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

function PostUpdate(&$f){
	//Enviamos un correo a 
	//print_r($f);
	global $Config;
	$empresa=$f['fields']['razon']['valor'];
	$correo=$f['fields']['email']['valor'];
	$asunto= "Aviso Actualización Empresa";
	$mensaje= "La empresa $empresa con usuario $correo ha actualizado sus datos";
	//echo "<script> alert('".$mensaje."'); </script>";
	if (mail($Config->mailto, $asunto, $mensaje,
			'From: bolsatrabajo@iesclaradelrey.es'))
		echo "<!--Correo enviado Correctamente-->";
	else echo "<!--Error enviando correo-->";
	}
?>
