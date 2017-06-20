<?php
require_once("../configuracion.php");


$SiNo=array("S"=>"Si","N"=>"No");
$Periodo=array("SEP-DIC"=>"Septiembre-Diciembre","ABR-JUN"=>"Abril-Junio");
$Estado=array("SO"=>"Solicitud","EP"=>"En Preparacion","EV"=>"En Vigor","VE"=>"Aplazado","AP"=>"Apto","NA"=>"No Apto","VI"=>"Vencido con incidencia");
$Valoracion=array("0"=>"0", "1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5"=>"5", "6"=>"6", "7"=>"7", "8"=>"8", "9"=>"9","10"=>"10");

/*
        ); 
*/

if (isset($_SESSION['forms']['ffct']))
	//$ffct=$_SESSION['forms']['ffct'];
	$ffct=&$_SESSION['forms']['ffct'];
else {
	$ffct=array(
		"name"=>"ffct",
		"table"=>"fct_fct",
		"filas"=>0, "indice"=>0, "query"=>"",
                "where"=>"", "errormsg"=>"", "statusmsg"=>"",
		"pre_update"=>"PreUpdate", //triger
		"post_update"=>"PostUpdate", //triger
        "acciones"=>"Actualizar,Insertar",
	"fields"=>array(
		"id"=>array("l"=>"id:", //Etiqueta
			"bd"=>true,
			"t"=>"TEXT",//Tipo, TEXT default
			"s"=>10,	//Size del imput
			"max"=>25,	//sizelimit del campo
			"ac"=>false,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			//"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

		"empresa_email"=>array("l"=>"Email de la empresa:", //Etiqueta
			"bd"=>true,
			"s"=>20,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"valor"=>""),	//Valor del campo,viene del post o del row

		"alumno_email"=>array("l"=>"Email del alumno:", //Etiqueta
			"bd"=>true,
			"s"=>20,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"periodo"=>array("l"=>"Periodo :", //Etiqueta
			"T"=>"¿Periodo de ejecución de las prácticas?",
			"bd"=>true,
			"t"=>"COMBO",
			"qll"=>&$Periodo,
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

		"convenio"=>array(
                        "bd"=>true,
                        "l"=>"No de convenio:",
                        "T"=>"Número de convenio marco",
                        "m"=>"/.+/",
                        "s"=>4,
                        "max"=>4,
                        "ac"=>true,
                        "err"=>false,
                        "valor"=>""),

		"curso"=>array("l"=>"Curso :", //Etiqueta
			"T"=>"¿Curso de ejecución de las prácticas?",
			"bd"=>true,
			"t"=>"COMBO",
			"q"=>"select curso as id ,curso from fct_curso",
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"de"=>Parametros("CursoEnCurso"),
			"valor"=>Parametros("CursoEnCurso")),	//Valor del campo,viene del post o del row
		"grupo"=>array("l"=>"Grupo :", //Etiqueta
			"T"=>"Grupo en el que realizarás las prácticas",
			"bd"=>true,
			"t"=>"COMBO",
			"q"=>"select grupo as id, grupo from fct_grupo g, 
				fct_alumno a 
				where g.codigo=a.ciclo and 
				a.email='". $_SESSION['USER_B']."' and curso_escolar='".Parametros('CursoEnCurso')."'",
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row

		"fecha_inicio"=>array("l"=>"Fecha de Inicio:", //Etiqueta
			"t"=>"DATE",
			"bd"=>true,
			"s"=>10,	//Size del imput
			"max"=>10,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"valor"=>""),	//Valor del campo,viene del post o del row

		"fecha_fin"=>array("l"=>"Fecha de Finalización", //Etiqueta
			"t"=>"DATE",
			"bd"=>true,
			"s"=>10,	//Size del imput
			"max"=>10,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"valor"=>""),	//Valor del campo,viene del post o del row

		"horario"=>array("l"=>"Horario de asistencia:", //Etiqueta
			"bd"=>true,
			"s"=>15,	//Size del imput
			"max"=>15,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"valor"=>""),	//Valor del campo,viene del post o del row
		"tutor_nom"=>array("l"=>"Nombre del tutor de la empresa", //Etiqueta
			"bd"=>true,
			"s"=>15,	//Size del imput
			"max"=>15,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"valor"=>""),	//Valor del campo,viene del post o del row
		"tutor_ap1"=>array("l"=>"Apellido del tutor :", //Etiqueta
			"bd"=>true,
			"s"=>15,	//Size del imput
			"max"=>15,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"valor"=>""),	//Valor del campo,viene del post o del row

		"tutor_ap2"=>array("l"=>"2 Apellido del tutor :", //Etiqueta
			"bd"=>true,
			"s"=>15,	//Size del imput
			"max"=>15,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"valor"=>""),	//Valor del campo,viene del post o del row


		"telefono"=>array(
			"bd"=>true,
			"l"=>"Teléfono:",
			"m"=>"/.+/",
			"s"=>10,
			"max"=>15,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"direccion"=>array(
			"bd"=>true,
			"l"=>"Direcci&oacute;n:",
			"s"=>20,
			"max"=>60,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"cpostal"=>array(
			"bd"=>true,
			"l"=>"C&oacute;digo Postal:",
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
			"m"=>"/.+/",
			"ac"=>true,
			"err"=>false,
			"de"=>'28',
			"valor"=>"28"),

		"localidad"=>array(
			"bd"=>true,
			"l"=>"Localidad:",
			"m"=>"/.+/",
			"s"=>15,
			"max"=>40,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"estado"=>array("l"=>"Estado :", //Etiqueta
			"T"=>"¿Estado de las prácticas ?",
			"bd"=>true,
			"t"=>"COMBO",
			"qll"=>&$Estado,
			"s"=>30,	//Size del imput
			"max"=>50,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"r"=>true,	//Required
			"valor"=>""),	//Valor del campo,viene del post o del row
		"horas_p"=>array(
			"bd"=>true,
			"l"=>"Horas Previstas:",
			"m"=>"/.+/",
			"s"=>3,
			"max"=>3,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"horas_r"=>array(
			"bd"=>true,
			"l"=>"Horas Realizadas:",
			"m"=>"/.+/",
			"s"=>3,
			"max"=>3,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),
		"valoracion"=>array("l"=>"Valoracion :", //Etiqueta
			"T"=>"¿Valoracion del tutor sobre la calidad/conveniencia de las prácticas 0-10?",
			"bd"=>true,
			"t"=>"COMBO",
			"qll"=>&$Valoracion,
			"s"=>3,	//Size del imput
			"max"=>3,	//sizelimit del campo
			"m"=>"/.+/",  	//Picture del campo
			"ac"=>true,	//Actualizable
			"err"=>false,	//Flag de error unmatching de la mascara
			"valor"=>""),	//Valor del campo,viene del post o del row

		"instruc"=>array(
			"bd"=>true,
			"T"=>"Instrucciones adicionales para el alumno:",
			"l"=>"Instrucciones para el alumno:",
			"m"=>"/.+/",
			"s"=>60,
			"max"=>400,
			"ac"=>true,
			"err"=>false,
			"valor"=>""),

		"val_coment"=>array(
			"bd"=>true,
			"l"=>"Comentario:",
			"T"=>"Comentario adicional sobre la valoración",
			"m"=>"/.+/",
			"s"=>60,
			"max"=>100,
			"ac"=>true,
			"err"=>false,
			"valor"=>"")
			)
		);
	$_SESSION['forms']['ffct']=&$ffct;
	} 

function PostUpdate(&$a){
	//$re=FormQuery($a);
        //ResultToForm($a,$re);
	}

function PreUpdate(&$a){
	global $Config;
	//print_r($a);
	$error=false;
	$error_text="";

	//Actualizo el curso en curso
       if($a['fields']['curso']['valor']==$Config->nullstring) { 
			$a['fields']['curso']['valor']=Parametros("CursoEnCurso");
                        }

	if ($_SESSION['perfil']=='alumno'){
	 	$estado =BuscaBd("Select estado from $a[table] where id =". $a['fields']['id']['valor'] );
		if ($estado!='SO') {
			$error=true;
			$error_text="Ya no puede actualizar los datos";
			}
		}

	if ($error )
		{
		$a['errormsg']=$error_text;
		return false;
		}
	return true;
	}
?>
