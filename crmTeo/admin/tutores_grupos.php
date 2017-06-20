<?php
require_once('cabecera.php');
if ($_SESSION['USER_T']!=$Config->administrador) die ("Necesita autorización");

require_once("../configuracion.php");

$SiNo=array("S"=>"Si","N"=>"No");
/*
if (isset($_SESSION['forms']['fperiodotutor']))
        $fperiodotutor=&$_SESSION['forms']['fperiodotutor'];
else {*/
        $fperiodotutor=array(
                "name"=>"fperiodotutor",
                "table"=>"fct_periodo_tutor",
                "filas"=>0, "indice"=>0, "query"=>"",
                "where"=>"", "errormsg"=>"", "statusmsg"=>"",
                "pre_update"=>"PreUpdate", //triger
                "acciones"=>"Actualizar,Insertar,Borrar,Consultar,Navegar,Numero,Limpiar",
        	"fields"=>array(
                "id"=>array("l"=>"id:", "bd"=>true, "t"=>"TEXT", "s"=>10, "max"=>25, "ac"=>false, "err"=>false, "r"=>false, "valor"=>""),  
                "curso"=>array("l"=>"curso:", "bd"=>true, "t"=>"TEXT", "s"=>10, "max"=>25, "ac"=>true, "err"=>false, "r"=>true, "co"=>true,"valor"=>""),  
                "periodo"=>array("l"=>"periodo:", "bd"=>true, "t"=>"TEXT", "s"=>10, "max"=>25, "ac"=>true, "err"=>false, "r"=>true,"co"=>true, "valor"=>""),  
                "cod_grupo"=>array("l"=>"cod_grupo:", "bd"=>true, "t"=>"TEXT", "s"=>10, "max"=>25, "ac"=>true, "err"=>false, "r"=>true,"co"=>true, "valor"=>""),  
                "tutor_id"=>array("l"=>"tutor:", "bd"=>true, "t"=>"COMBO",
				"q"=>"select distinct id, nombre as Nombre from fct_tutor order by nombre", 
				"s"=>10, "max"=>25, "ac"=>true, "err"=>false, "r"=>true, "co"=>true,"valor"=>"")  
                ));
/*
        $_SESSION['forms']['fperiodotutor']=&$fperiodotutor;
        }
*/


$fperiodotutor['fields']['curso']['valor']=Parametros("CursoEnCurso");
$fperiodotutor['fields']['curso']['de']=Parametros("CursoEnCurso");
$fperiodotutor['fields']['curso']['co']=true;

$fperiodotutor['fields']['periodo']['valor']=Parametros("PeriodoEnCurso");
$fperiodotutor['fields']['periodo']['de']=Parametros("PeriodoEnCurso");
$fperiodotutor['fields']['periodo']['co']=true;

$fperiodotutor['fields']['id']['sh']=false;

$fperiodotutor['acciones']="Actualizar,Insertar,Borrar,Consultar,Limpiar,Navegar";
//$fperiodotutor['fields']['tutor_id']['q']="select id, tut_nom as nombre from fct_tutor ";
$fperiodotutor['order']="curso,cod_grupo";

$it= Form_iterator::factory('itptutor',6);

echo "<div class=marco >";
        require_once "menu.php";
        echo "<div class=bloque>";
		//DoEveryThing($fperiodotutor);
		TablaEdicion($fperiodotutor,false);//,$it);
		//$it->show();	
        echo "</div";
echo "</div";



//DoEveryThing($fparametros);
function PreUpdate($fperiodotutor){
        return true;
        }
?>

