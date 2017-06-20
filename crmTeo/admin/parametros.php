<?php
require_once('cabecera.php');
if ($_SESSION['USER_T']!=$Config->administrador) die ("Necesita autorización");

require_once("../configuracion.php");




$SiNo=array("S"=>"Si","N"=>"No");
if (isset($_SESSION['forms']['fparametros']))
        $fparametros=&$_SESSION['forms']['fparametros'];
else {
        $fparametros=array(
                "name"=>"fparametros",
                "table"=>"fct_t_parametros",
                "filas"=>0, "indice"=>0, "query"=>"",
                "where"=>"", "errormsg"=>"", "statusmsg"=>"",
                "pre_update"=>"PreUpdate", //triger
                "acciones"=>"Actualizar,Insertar,Borrar,Consultar,Navegar,Numero,Limpiar",
        	"fields"=>array(
                "id"=>array("l"=>"id:", "bd"=>true, "sh"=>false,"t"=>"TEXT", "s"=>10, "max"=>25, "ac"=>false, "err"=>false, "r"=>false, "valor"=>""),  

                "parametro"=>array("l"=>"Parámetro", "bd"=>true, "t"=>"TEXT", "s"=>10, "max"=>25, "ac"=>true, "err"=>false, "r"=>true, "co"=>true,"valor"=>""),  
                "valortexto"=>array("l"=>"Valor", "bd"=>true, "t"=>"TEXT", "s"=>10, "max"=>25, "ac"=>true, "err"=>false, "r"=>true,"co"=>true, "valor"=>""),  
                "consulta"=>array("l"=>"Consulta", "bd"=>true, "sh"=>false,"t"=>"TEXT", "s"=>10, "max"=>40, "ac"=>true, "err"=>false, "r"=>false,"co"=>true, "valor"=>""),  
                "columna"=>array("l"=>"Columna", "bd"=>true, "t"=>"TEXT", "sh"=>false,"s"=>10, "max"=>50, "ac"=>true, "err"=>false, "r"=>false,"co"=>true, "valor"=>""),  
                "orden"=>array("l"=>"Orden", "bd"=>true, "sh"=>false,"t"=>"TEXT", "s"=>5, "max"=>5, "ac"=>true, "err"=>false, "r"=>false,"co"=>true, "valor"=>""),  
                ));
        $_SESSION['forms']['fparametros']=&$fparametros;
        }

$fparametros['acciones']="Actualizar,Insertar,Borrar,Consultar,Limpiar,Navegar,Numero";

echo "<div class=marco >";
        require_once "menu.php";
        echo "<div class=bloque>";
		TablaEdicion($fparametros);
		//DoEveryThing($fparametros);
        echo "</div>";
echo "</div";



//DoEveryThing($fparametros);
function PreUpdate($fparametros){
	return true;
	}
?>

