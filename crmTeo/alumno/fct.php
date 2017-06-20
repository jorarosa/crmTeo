<?php

require_once('cabecera.php');
require_once('../fct/form_fct.php');
?>

<script> check=true; </script>
<body OnBeforeUnload='return alerta_salvar(document.forms.empresa)'>

<?php
$user_a=$_SESSION['USER_B'];	

$action="";if (isset($_POST['action'])) $action=$_POST['action'];

//El alumno no actualiza ninguno de estos campos
$ffct['fields']['tutor_email']['ac']=false;
$ffct['fields']['empresa_email']['ac']=false;
$ffct['fields']['convenio']['ac']=false;
$ffct['fields']['fecha_inicio']['ac']=false;
$ffct['fields']['fecha_fin']['ac']=false;
$ffct['fields']['horario']['ac']=false;
$ffct['fields']['tutor_nom']['ac']=false;
$ffct['fields']['tutor_ap1']['ac']=false;
$ffct['fields']['tutor_ap2']['ac']=false;
$ffct['fields']['direccion']['ac']=false;
$ffct['fields']['localidad']['ac']=false;
$ffct['fields']['cpostal']['ac']=false;
$ffct['fields']['provincia']['ac']=false;
$ffct['fields']['telefono']['ac']=false;
$ffct['fields']['pais']['ac']=false;
$ffct['fields']['horas_p']['ac']=false;
$ffct['fields']['horas_r']['ac']=false;
$ffct['fields']['valoracion']['ac']=false;
$ffct['fields']['val_coment']['ac']=false;
$ffct['fields']['estado']['ac']=true;
$ffct['fields']['instruc']['ac']=false;



//Ligamos el formulario al usuario.
$ffct['fields']['alumno_email']['valor']=$user_a;
$ffct['fields']['alumno_email']['de']=$user_a;
$ffct['fields']['alumno_email']['co']=true;

//$ffct['fields']['estado']['de']="SO";
$cursoencurso=Parametros("CursoEnCurso");
$ffct['fields']['curso']['valor']=$cursoencurso;
$ffct['fields']['curso']['de']=$cursoencurso;
$ffct['fields']['curso']['co']=true;
$ffct['fields']['curso']['t']="TEXT";


//Si el formulario esta vacio consultamos
if ($ffct['fields']['id']['valor']=="" or isset($_REQUEST['m1_option'])){
	LimpiarForm($ffct);
	$re=FormQuery($ffct);
       	ResultToForm($ffct,$re);
	};

if($ffct['fields']['estado']['valor']=="")
	$ffct['fields']['estado']['valor']="SO";

//echo "el pais es". $ffct['fields']['pais']['valor'];

//Motor del formulario
ManageForm($ffct); 

//Visualizacion del formulario
		
echo "<div class=marco >";
	require_once "menu.php";

	echo "<div class=bloque>";
		echo "<table align=center class=ficha >";
		echo "<tr><td><p> Bienvenido  $user_a al portal de empresas del IES CLARA DEL REY<p></td></tr>";
		echo "<tr><td><p class='errormsg'>";
		ShowErrorMsg($ffct);
		echo "</p><p class='msg' >";
		ShowStatusMsg($ffct);
		echo "</p></td></tr>";
		echo "</table>";
	echo "</div>";

	//Input($ffct,"id");
	if (in_array($ffct['fields']['estado']['valor'], array('','SO'))) {
		$bloquear_campos=false;
		$ffct['acciones']="Actualizar,Insertar";
		}
	else {
		$bloquear_campos=true;
		$ffct['acciones']="";
		}

	echo "<div class=bloque>";
		echo "<form name=empresa method=post onSubmit='return check_submit(this)'>";
		echo "<table align=center width=100% cols=4 class=ficha >";
		echo "<tr><td class=cabecera colspan=4>Registro para hacer las prácticas</td></tr>\n";
	
		echo "<tr>";
		echo "<td align=right>";InputOrShow(!$bloquear_campos,$ffct,"periodo");echo "</td>";
		echo "<td align=right>";Show($ffct,"curso");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";InputOrShow(!$bloquear_campos,$ffct,"grupo");echo "</td>";
		echo "<td align=right>";
				if ($ffct['fields']['estado']['valor'] != 'SO' ){
					echo "Tutor IES </td><td>". BuscaBd("select concat(t.email,' ',t.nombre) 
						from fct_periodo_tutor p,fct_tutor t 
						where p.tutor_id=t.id and p.curso='".$ffct['fields']['curso']['valor']."' and 
							p.periodo='".$ffct['fields']['periodo']['valor'] ."' and
							p.cod_grupo='".$ffct['fields']['grupo']['valor'] ."'");
				}
			echo "</td>";
		echo "</tr>\n";

		echo "<tr><td class=cabecera colspan=4>Datos de las prácticas (Tutor) </td></tr>\n";
		echo "<tr>";
		echo "<td align=right>";show($ffct,"convenio");echo "</td>";
		echo "<td align=right>";show($ffct,"empresa_email");echo "</td>";
		echo "</tr>\n";


		echo "<tr>";
		echo "<td align=right>";show($ffct,"fecha_inicio");echo "</td>";
		echo "<td align=right>";show($ffct,"fecha_fin");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";show($ffct,"horario");echo "</td>";

		echo "<td align=right>";show($ffct,"tutor_nom");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";show($ffct,"tutor_ap1");echo "</td>";
		echo "<td align=right>";show($ffct,"tutor_ap2");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";show($ffct,"direccion");echo "</td>";
		echo "<td align=right>";show($ffct,"localidad");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";show($ffct,"cpostal");echo "</td>";
		echo "<td align=right>";show($ffct,"provincia");echo "</td>";
		echo "</tr>\n";
		echo "<tr>";
		echo "<td align=right>";show($ffct,"telefono");echo "</td>";
		echo "<td align=right>";show($ffct,"estado");echo "</td>";
		echo "</tr>\n";
		echo "<tr>";
		echo "<td colspan=4 align=left>";show($ffct,"instruc","");echo "</td>";
		echo "</tr>\n";
		echo "</table>";

	echo "</div>";

//	echo "<input type=hidden name=action value='actualizar'>";

	echo "<div class=bloque>";
		echo "<table class=ficha><tr>";
			echo "<td align=right width=80% >";
			echo "Registrarse para hacer la FCT:";
			echo "</d>";
			echo "<td align=left>";
				InputNavegador($ffct);
			echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";

	echo "</div>";
echo "</div>"; //marco

mysql_close($conexion);
?>
<script>
ocultar_mostrar('otros_datos_check','otros_datos_acceso' );
ocultar_mostrar('otros_datos_cv_check','otros_datos_cv');
f(solap,'f2');
</script>


