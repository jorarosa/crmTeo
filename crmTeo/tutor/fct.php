<?php
	require_once('cabecera.php');
	require_once('../fct/form_fct.php');
	?>

	<script> check=true; </script>
	<body OnBeforeUnload='return alerta_salvar(document.forms.fct)'>

	<?php

	$user_a=$_SESSION['USER_T'];	

	$action="";if (isset($_POST['action'])) $action=$_POST['action'];
	//	echo "action es $action";
	//	print_r($_REQUEST);

	$ffct['acciones']="Actualizar,Navegar";
	$ffct['fields']['grupo']['t']='TEXT';

if($action=='VerDetalleFct'){ //Ligamos por id
	LimpiarForm($ffct);
	$fct_id=$_REQUEST['fct_id'];
	$ffct['fields']['id']['valor']=$fct_id;
	$ffct['fields']['id']['co']=true;

	$re=FormQuery($ffct);
       	ResultToForm($ffct,$re);
	}

//$ffct['fields']['estado']['de']="EP";


//Si el formulario esta vacio consultamos
if ($ffct['fields']['id']['valor']==""){
	$re=FormQuery($ffct);
       	ResultToForm($ffct,$re);
	};
//Valor de "En preparacion" para estdo
if($ffct['fields']['estado']['valor']=="") $ffct['fields']['estado']['valor']="EP";

//Numero de convenio es obligatorio
$ffct['fields']['convenio']['r']=true;
$ffct['fields']['convenio']['m']="/[0-9]*[1-9]/";


//echo "el pais es". $ffct['fields']['pais']['valor'];
if($ffct['fields']['pais']['valor']=="") $ffct['fields']['pais']['valor']="esp";
if($ffct['fields']['provincia']['valor']=="") $ffct['fields']['provincia']['valor']=28;
if($ffct['fields']['localidad']['valor']=="") $ffct['fields']['localidad']['valor']='Madrid';


//Motor del formulario
ManageForm($ffct); 
?>

<?php
echo "<div class=marco >";
	require_once "menu.php";

	echo "<div class=bloque>";
		echo "<tr><td><p class='errormsg'>";
		ShowErrorMsg($ffct);
		echo "</p><p class='msg' >";
		ShowStatusMsg($ffct);
		echo "</p></td></tr>";
		echo "</table>";
	echo "</div>";

	//Input($ffct,"id");

	echo "<div class=bloque>";
		echo "<form name=fct onSubmit='return check_submit(this)' method=post>";
		echo "<table align=center width=100% cols=4 class=ficha >";
		echo "<tr><td class=cabecera colspan=4>Datos del alumno</td></tr>\n";
	
		echo "<tr>";
		echo "<td align=right>";Input($ffct,"periodo");echo "</td>";
		echo "<td align=right>";Input($ffct,"curso");echo "</td>";
		//echo "<td align=right>";Show($ffct,"tutor_email");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";Show($ffct,"alumno_email");echo "</td>";
			$alumno_email=$ffct['fields']['alumno_email']['valor'];	
		echo "<td align=left> "; echo BuscaBd("SELECT concat(nombre,' ',apellidos) from fct_alumno where email='$alumno_email'");echo "</td>";
		echo "<td align=right>";Show($ffct,"grupo","");echo "</td>";
		echo "</tr>\n";

		echo "<tr><td class=cabecera colspan=4>Datos de las prácticas (Rellenar por el tutor del IES) </td></tr>\n";
		echo "<tr>";
		echo "<td align=right>";Input($ffct,"convenio");echo "</td>";
		echo "<td align=right>";Input($ffct,"empresa_email");echo "</td>";
		echo "</tr>\n";


		echo "<tr>";
		echo "<td align=right>";Input($ffct,"fecha_inicio");echo "</td>";
		echo "<td align=right>";Input($ffct,"fecha_fin");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";Input($ffct,"horario");echo "</td>";

		echo "<td align=right>";Input($ffct,"tutor_nom");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";Input($ffct,"tutor_ap1");echo "</td>";
		echo "<td align=right>";Input($ffct,"tutor_ap2");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";Input($ffct,"telefono");echo "</td>";
		echo "<td align=right>";Input($ffct,"direccion");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";Input($ffct,"cpostal");echo "</td>";
		echo "<td align=right>";Input($ffct,"localidad");echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td align=right>";Input($ffct,"provincia");echo "</td>";
		echo "<td align=right>";Input($ffct,"pais");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";Input($ffct,"horas_p");echo "</td>";
		echo "<td align=right>";Input($ffct,"horas_r");echo "</td>";
		echo "</tr>\n";


		echo "<tr>";
		echo "<td colspan=4 align=left>";Input($ffct,"instruc","");echo "</td>";

		echo "</tr>\n";

		echo "<tr><td class=cabecera colspan=4>Valoración de las  prácticas realizadas(llenar una vez concluidas)</td></tr>\n";
		echo "<tr>";
		echo "<td align=right>";Input($ffct,"valoracion","");echo "</td>";
		echo "<td align=left colspan=3 >";Input($ffct,"val_coment","");echo "</td>";
		echo "</tr>\n";
		
		echo "<tr>";
		echo "<td class=cabecera colspan=2 > Estado de las prácticas </td>";
		echo "<td align=right>";Input($ffct,"estado");echo "</td>";
		echo "</tr>\n";

		echo "</table>";

	echo "</div>";

//	echo "<input type=hidden name=action value='actualizar'>";

	echo "<div class=bloque>";
		echo "<table class=ficha><tr>";
			echo "<td align=right width=50% >";
			echo "<a  href=lista_alumnos.php >volver a la lista</a>";
			echo "</d>";
			echo "<td align=left>";
				InputNavegador($ffct);
			echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
	echo "</form>";
echo "</div>"; //marco
mysql_close($conexion);
?>
