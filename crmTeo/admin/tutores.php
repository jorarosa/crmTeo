<?php
require_once('cabecera.php');
if ($_SESSION['USER_T']!=$Config->administrador) die ("Necesita autorización");

require_once("../configuracion.php");
require_once("../tutor/form_tutor.php");




$SiNo=array("1"=>"Si","0"=>"No");
$SiNo[$Config->nullstring]="--Elegir";

		
if (isset($_SESSION['forms']['ftutores']))
        $ftutores=&$_SESSION['forms']['ftutores'];
else {
        $ftutores=array(
                "name"=>"ftutores",
                "table"=>"fct_tutor",
                "filas"=>0, "indice"=>0, "query"=>"",
                "where"=>"", "errormsg"=>"", "statusmsg"=>"",
               // "pre_update"=>"PreUpdate", //triger
                "acciones"=>"Actualizar,Insertar,Borrar,Consultar,Navegar,Numero,Limpiar",
        	"fields"=>array(
                "id"=>array("l"=>"id:", "bd"=>true, "sh"=>true,"t"=>"TEXT", "s"=>10, "max"=>25, "ac"=>false, "err"=>false, "r"=>false,"co"=>true, "valor"=>""),  
        		"nombre"=>array("l"=>"Nombre", "bd"=>true, "t"=>"TEXT", "s"=>20, "max"=>1900, "ac"=>true, "err"=>false, "r"=>false, "co"=>true,"valor"=>""),      			 
        		"usuario"=>array("l"=>"Usuario", "bd"=>true, "t"=>"TEXT", "s"=>20, "max"=>100, "ac"=>true, "err"=>false, "r"=>false,"co"=>true, "valor"=>""),  
                "clave"=>array("l"=>"Clave", "bd"=>true, "t"=>"TEXT", "s"=>20, "max"=>100, "ac"=>true, "err"=>false, "r"=>false,"co"=>true, "valor"=>""),  
                "email"=>array("l"=>"Email", "bd"=>true, "t"=>"TEXT", "s"=>20, "max"=>100, "ac"=>true, "err"=>false, "r"=>false,"co"=>true, "valor"=>""),  
                "nif"=>array("l"=>"Nif","bd"=>true,"sh"=>true,"t"=>"TEXT","s"=>10,"max"=>40,"ac"=>true,"err"=>false,"r"=>false,"co"=>true, "valor"=>""),  
                "movil"=>array("l"=>"Movil","bd"=>true,"sh"=>true,"t"=>"TEXT","s"=>10,"max"=>40,"ac"=>true,"err"=>false,"r"=>false,"co"=>true,"valor"=>""),  
                "fijo"=>array("l"=>"Fijo","bd"=>true,"sh"=>true,"t"=>"TEXT","s"=>10,"max"=>40,"ac"=>true,"err"=>false,"r"=>false,"co"=>true,"valor"=>""),  
                "activo"=>array("l"=>"Activo","bd"=>true, "t"=>"COMBO","qll"=>&$SiNo,"sh"=>true,"s"=>10,"max"=>50,"ac"=>true,"err"=>false,"r"=>false,"co"=>true,"de"=>"$Config->nullstring","valor"=>""),  
                ));
        $_SESSION['forms']['ftutores']=&$ftutores;
        }

$ftutores['acciones']="Actualizar,Insertar,Borrar,Consultar,Limpiar,Navegar,Numero";
$ftutores['order']='nombre';
$it=Form_iterator::factory("itutores",20);

if(!isset($_SESSION['vista'])) $_SESSION['vista']=false;
if (isset($_REQUEST['vista'])) $_SESSION['vista']=!($_SESSION['vista']) ;
$vista=$_SESSION['vista'];

echo "<div class=marco >";
        require_once "menu.php";
        echo "<div class=bloque>";
        if ($vista){ 
        	//$it->Show();
		 	TablaEdicion($ftutores,false);//,$it);
        	}
		else DoEveryThing($ftutores);
		//if ($vista) $it->Show();
        echo "</div>";
echo "</div>";

//DoEveryThing($ftutores);
//function PreUpdate($ftutores){
//	return true;
//	}
?>
<form method=post><input type=submit name=vista value='Cambiar la vista'></form>


