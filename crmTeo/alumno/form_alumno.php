<?php
require_once("../configuracion.php");


$SiNo=array("S"=>"Si","N"=>"No");
$AltoMedioBajo=Array("AL"=>"Alto","BA"=>"Bajo","ME"=>"Medio","BI"=>"Bilingue");
$Visibilidad=Array("SC"=>"Solo datos de contacto, nombre, email y teléfono",
			"TD"=>"Todos los datos de mi CV",
			"ND"=>"Ninguno de mis datos");

if (isset($_SESSION['forms']['falumno']))
	$falumno=&$_SESSION['forms']['falumno'];
else {
	$falumno=array(
		"name"=>"falumno",
		"table"=>"fct_alumno",
		"filas"=>0, "indice"=>0, "query"=>"",
                "where"=>"", "errormsg"=>"", "statusmsg"=>"",
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

		"nombre"=>array("l"=>"Nombre:", //Etiqueta
			"bd"=>true,
			"s"=>15,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"apellidos"=>array(
			"bd"=>true,
			"l"=>"Apellidos:",
			"s"=>15,"m"=>"/.+/",
			"max"=>50,
			"ac"=>true,
			"err"=>false,
			"r"=>true,	//Required
			"valor"=>""),
		"telefono"=>array(
			"bd"=>true,
			"l"=>"Telefono:",
			"m"=>"/.+/",
			"s"=>10,
			"max"=>15,
			"ac"=>true,
			"err"=>false,
			"r"=>true,	//Required
			"valor"=>""),
		"movil"=>array( 
			"bd"=>true,
			"l"=>"Móvil:",
			"s"=>10,
			"max"=>15,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"direccion"=>array(
			"bd"=>true,
			"l"=>"Dirección:",
			"s"=>20,
			"max"=>60,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"cpostal"=>array(
			"bd"=>true,
			"l"=>"Código Postal:",
			"s"=>6,
			"max"=>15,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"pais"=>array(
			"bd"=>true,
			"l"=>"País:",
			"t"=>"COMBO",//Tipo, TEXT default
			//"q"=>"select id, nombre from fct_pais", //Query
			"qj"=>"paises", //Query
			"m"=>"/.+/",
			"r"=>true,	
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"provincia"=>array(
			"bd"=>true,
			"l"=>"Provincia:",
			"t"=>"COMBO",
			"q"=>"select cod_post as id, nombre from fct_provincia", 
			"m"=>"/.+/",
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
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
		"estudios"=>array(
			"bd"=>true,
			"l"=>"Estudios:",
			"t"=>"COMBO",
			"q"=>"select id, nombre from fct_estudios", 
			"m"=>"/[1-9]+/",
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"ciclo"=>array(
			"bd"=>true,
			"l"=>"Estudios en el IES Clara Del Rey",
			"T"=>"Estudios en el IES Clara Del Rey",
			"t"=>"COMBO",//Tipo, TEXT default
			"q"=>"select codigo as id, nombre from fct_ciclos", //Query el primer campo debe llamarse "id"
			"m"=>"/.+/",
			"r"=>true,	
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"idioma1"=>array(
			"bd"=>true,
			"l"=>"Idioma",
			"t"=>"COMBO",//Tipo, TEXT default
			"qj"=>"idiomas", //funcion javascript que muestra la lista
			"m"=>"/.+/",
			"s"=>20,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"nivel1"=>array(
			"bd"=>true,
			"l"=>"Nivel",
			"m"=>"/.+/",
			"t"=>"COMBO",//Tipo, TEXT default
			"qll"=>$AltoMedioBajo, //funcion javascript que muestra la lista
			"s"=>10,
			"max"=>10,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"idioma2"=>array(
			"bd"=>true,
			"l"=>"Idioma2",
			"m"=>"/.+/",
			"t"=>"COMBO",//Tipo, TEXT default
			"qj"=>"idiomas", //funcion javascript que muestra la lista
			"s"=>20,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"nivel2"=>array(
			"bd"=>true,
			"l"=>"Nivel",
			"m"=>"/.+/",
			"t"=>"COMBO",//Tipo, TEXT default
			"qll"=>$AltoMedioBajo, //funcion javascript que muestra la lista
			"s"=>10,
			"max"=>10,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"idioma3"=>array(
			"bd"=>true,
			"l"=>"Idioma3",
			"m"=>"/.+/",
			"t"=>"COMBO",//Tipo, TEXT default
			"qj"=>"idiomas", //funcion javascript que muestra la lista
			"s"=>20,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"nivel3"=>array(
			"bd"=>true,
			"l"=>"Nivel",
			"m"=>"/.+/",
			"t"=>"COMBO",//Tipo, TEXT default
			"qll"=>$AltoMedioBajo, //funcion javascript que muestra la lista
			"s"=>10,
			"max"=>10,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"profesion"=>array(
			"bd"=>true,
			"l"=>"Profesión:",
			"t"=>"COMBO",
			"q"=>"select id, nombre from fct_profesion", 
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"experiencia"=>array(
			"bd"=>true,
			"l"=>"Experiencia laboral:",
			"t"=>"COMBO",
			"ql"=>array('menos de un año',
					'un año', 
					'dos años', 
					'tres años', 
					'cuatro años',
					'cinco años',
					'más de cinco años'), 
			"m"=>"/[a-zA-Z]+/",
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"ultimo_trabajo"=>array(
			"bd"=>true,
			"l"=>"",//Ultimo trabajo, funciones, tareas etc.:
			"t"=>"TEXTAREA",
			"htmlatt"=>"cols=80 rows=3",
			"max"=>255,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"informatica"=>array(
			"bd"=>true,
			"l"=>"", //Conocimientos de informática,
			"t"=>"TEXTAREA",
			"htmlatt"=>"cols=80 rows=3",
			"max"=>255,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"skills"=>array("l"=>"",//Habilidades personales:",
			"bd"=>true,
			"t"=>"TEXTAREA",
			"htmlatt"=>"cols=80 rows=3",
			"max"=>255,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"nac_ano"=>array(
			"bd"=>true,
			"l"=>"",
			"s"=>4,
			"max"=>4,
			"m"=>"/.+/",
			"r"=>true,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"nac_mes"=>array(
			"bd"=>true,
			"l"=>"",
			"s"=>2,
			"max"=>2,
			//"m"=>"^1$|^2$|^3$|^4$|^5$|^6$|^7$|^8$|^9$|^10$|^11$|^12$",
			"m"=>"/.+/",
			"r"=>true,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"nac_dia"=>array(
			"bd"=>true,
			"l"=>"Fecha de nacimiento (dd/mm/aaaa):",
			"s"=>2,
			"max"=>2,
			"m"=>"/.+/",
			"r"=>true,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"carnet"=>array("l"=>"Carnet de conducir:",
			"bd"=>true,
			"t"=>"COMBO",
			"ql"=>array("SI","NO"),
			"s"=>2,
			"m"=>"/^SI$|^NO$/",
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"movilidad"=>array(
			"bd"=>true,
			"l"=>"Movilidad geográfica:",
			"t"=>"COMBO",
			"ql"=>array("SI","NO"),
			"m"=>"/^SI$|^NO$/",
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"viajar"=>array("l"=>"Disponibilidad para viajar:",
			"bd"=>true,
			"t"=>"COMBO",
			"ql"=>array("SI","NO"),
			"m"=>"/^SI$|^NO$/",
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"visibilidad"=>array(
			"bd"=>true,
			"l"=>"Visibilidad de mi cv:",
			"T"=>"Datos que verán las empresas cuando busquen candidatos en la bolsa de empleo",
			"t"=>"COMBO",
			"qll"=>&$Visibilidad,
			"m"=>"/^SC$|^ND$|^TD$/",
			"r"=>true,
			"ac"=>true,
			"de"=>'ND',
			"co"=>false,
			"err"=>false,
			"valor"=>'ND'),
		"exp_laboral"=>array(	"l"=>"",//"Carta de Presentación",
			"bd"=>true,
			"t"=>"TEXTAREA",
			"htmlatt"=>"cols=80 rows=5",
			"max"=>4096,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"formacion"=>array(	"l"=>"",//"Carta de Presentación",
				"bd"=>true,
				"t"=>"TEXTAREA",
				"htmlatt"=>"cols=80 rows=5",
				"max"=>4096,
				"ac"=>true,
				"err"=>false,
				"valor"=>""),
		"nif"=>array(
			"bd"=>true,
			"l"=>"Nif/Nie:",
			"r"=>true,
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>"")
			)
		);
	$_SESSION['forms']['falumno']=&$falumno;
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
		/* Es bueno el nif del alumno */
		$nif=$a['fields']['nif']['valor'];
		if( !in_array(check_nif_cif_nie($nif),array(1,3)) ) { //1 nif correcto, 3 nie correcto
			$error=true;
			$a['fields']['nif']['err']=true;
                	$error_text.="El nif/nie no es válido. Por favor introduzca un nif/nie correcto.";
			}
		}


	/* Es buena la fecha de nacimiento */
	
	$dia=$a['fields']['nac_dia']['valor'];
	$mes=$a['fields']['nac_mes']['valor'];
	$ano=$a['fields']['nac_ano']['valor'];


	if (!checkdate($mes,$dia,$ano)){
		$error=true;
		$a['fields']['nac_ano']['err']=true;
                $error_text.="La fecha de nacimiento no es válida. Por favor introduzca una fecha correcta.";
		}
	else { //La fecha es correcta pero es lógica => pasado con menos de  100 años
		$time=time() - mktime(0,0,0,$mes,$dia,$ano) ; //Time está en segundos
		//echo "time vale $time";
		$edad_anos=$time / 3600 / 24 / 365 ;
		if ($edad_anos < 12 || $edad_anos > 100 ){ //Mas de 100 años o menos de doce
			$error=true;
			$a['fields']['nac_ano']['err']=true;
                	$error_text.="La fecha de nacimiento no es válida. Por favor introduzca una fecha correcta.";
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
			$email=$_SESSION['USER_B'];
			$clave=buscaBd("select clave from fct_alumno where email='$email'");
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
				$user=$_SESSION['USER_B'];
				$q="update ". $a['table']. " set clave='".$nuevaclave."' where email='".$user."'";
				//echo $q;
				if (mysql_query_d($q)) $a['errormsg']='Clave actualizada';
				else {$error=true;$error_text.='Clave NO actualizada.';}
				//$_SESSION['CLAVE']=$nuevaclave;
				
				}
			}
			$a['fields']['claveac']['valor']="";
			$a['fields']['nclave1']['valor']="";
			$a['fields']['nclave2']['valor']="";
                       }

		//Ponemos el valor por defecto de la visibilidad
			//echo "La visibilidad vale" . $a['fields']['visibilidad']['valor'] ;
			if ($a['fields']['visibilidad']['valor']==$Config->nullstring)
					$a['fields']['visibilidad']['valor']=$a['fields']['visibilidad']['de'];
	if ($error){
		$a['errormsg']=$error_text;
		return false;
		}
	else return true;
	}
?>
