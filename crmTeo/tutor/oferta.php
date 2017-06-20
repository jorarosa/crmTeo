<?php
require_once("cabecera.php");
require_once('../empresa/form_oferta.php');
?>
<script> check=true; </script>
<body OnBeforeUnload='return alerta_salvar(document.forms.oferta)'>

<?php
$user_a=$_SESSION['USER_T'];	

//Ligamos el formulario al usuario.

//$foferta['fields']['email']['valor']=$user_a;
//$foferta['fields']['email']['de']=$user_a; //Valor por defecto
//$foferta['fields']['email']['co']=true;

$action="";if (isset($_REQUEST['action'])) $action=$_REQUEST['action'];

//echo "LA ACCION ES $action y la oferta id es " .  $_REQUEST['oferta_id'];
if($action=='oferta_look'){
	$oferta_id=$_REQUEST['oferta_id'];
	$foferta['fields']['id']['valor']=$oferta_id;
	$foferta['fields']['id']['co']=true;
	$re=FormQuery($foferta);
       	ResultToForm($foferta,$re);
	}

/*
if($action=='oferta_new'){
	LimpiarForm($foferta);
	//Ponemos valores por defecto en la direccion del centro de trabajo y fecha de hoy
	asigna_si_vacio($foferta['fields']['direccion']['valor'],$fempresa['fields']['direccion']['valor']);
	asigna_si_vacio($foferta['fields']['localidad']['valor'],$fempresa['fields']['localidad']['valor']);;
	asigna_si_vacio($foferta['fields']['provincia']['valor'],$fempresa['fields']['provincia']['valor']);;
	asigna_si_vacio($foferta['fields']['pais']['valor'],$fempresa['fields']['pais']['valor']);
	asigna_si_vacio($foferta['fields']['cpostal']['valor'],$fempresa['fields']['cpostal']['valor']);
	$foferta['fields']['direccion']['co']=false;
	$foferta['fields']['provincia']['co']=false;
	$foferta['fields']['cpostal']['co']=false;
	$foferta['fields']['fecha']['valor']=date('d/m/y');
	$foferta['fields']['fecha']['co']=false;
	}
*/
//si ya tuvieramos ID reconsultamos por el y punto
/*
if ($foferta['fields']['id']['valor']!=""){
	echo "reconsulto";
	$foferta['fields']['id']['co']=true;
	$re=FormQuery($foferta);
       	ResultToForm($foferta,$re);
	}
*/


//Visualizacon del formulario
ManageForm($foferta); 
		
echo "<div class=marco >";

require_once "menu.php";
	echo "<div class=bloque>";
		echo "<table align=center class=ficha >";
		echo "<tr><td><p> Bienvenido  $user_a al portal de empresas del IES CLARA DEL REY<p></td></tr>";
		echo "<tr><td><p class='errormsg'>";
		ShowErrorMsg($foferta);
		echo "</p><p class='msg' >";
		ShowStatusMsg($foferta);
		echo "</p></td></tr>";
		echo "</table>";
	echo "</div>";

	//Input($fempresa,"id");
	//Cabecera, datos de la empresa
	$email=$foferta['fields']['email']['valor'];
	echo"<br>";
	query_to_table("","select email as Correo,razon as Entidad,telefono as Telefono,convenio As NoConvenio from fct_empresa where email='$email'");
	echo "<br>";

	echo "<div class=bloque>";
	echo "<form name=oferta method=post onSubmit='return check_submit(this)'>";
	echo "<table align=center width=50% cols=4 class=ficha >";
	echo "<tr><td class=cabecera colspan=4>Solicitud de Alumnos en Prácticas y/o oferta de empleo</td></tr>\n";
	echo "<tr><td class=cabecera colspan=4>Datos generales de la oferta ";Show($foferta,'id','',false);echo  "</td></tr>\n";
	echo "<tr>";
	echo "<td align=right>";Show($foferta,"fecha");Show($foferta,"duracion","") ;echo "</td>";
	echo "<td align=right>";Show($foferta,"tipo");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Show($foferta,"num");echo "</td>";
	echo "<td align=right>";Show($foferta,"area_id");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Show($foferta,"cont","</td><td colspan=3>");echo "</td>";
	//echo "<td align=center>";Input($foferta,"area_id","");echo "</td>";
	echo "</tr>\n";

	echo "<tr><td class=cabecera colspan=4>Dirección del centro de trabajo</td></tr>";
	echo "<tr>";
	echo "<td align=right>";Show($foferta,"direccion");echo "</td>";
	echo "<td align=right>";Show($foferta,"localidad");Show($foferta,"cpostal","");echo "</td>";
	echo "</tr>\n";


	echo "<tr>";
	echo "<td align=right>";Show($foferta,"provincia");echo "</td>";
	echo "<td align=right>";Show($foferta,"pais");echo "</td>";
	echo "</tr>\n";

	echo "<tr><td class=cabecera colspan=4>Estado de la oferta</td></tr>";
	echo "<tr>";
	echo "<td align=right>";Show($foferta,"estado_emp");echo "</td>";
	echo "<td align=right>"; Input($foferta,"estado"); echo "</td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td align=right>";Show($foferta,"tutor");echo "</td>";
	echo "<td align=right></td>";
	echo "</tr>\n";

	//echo "<tr><td colspan=4 >"; InputNavegador($foferta); echo "</td></tr>\n";

	echo "</table>";
	echo "</div>";
	echo "<div class=bloque>";
                echo "<table class=ficha><tr>";
                        echo "<td align=right width=50% >";
                        echo "<a  href=lista_ofertas.php >volver a la lista de ofertas</a>";
                        echo "</d>";
                        echo "<td align=left>";
                                InputNavegador($foferta);
                        echo "</td>";
                        echo "</tr>";
                echo "</table>";
        echo "</div>";

	echo "</form>";

	echo "</div>";
echo "</div>";

mysql_close($conexion);
?>
