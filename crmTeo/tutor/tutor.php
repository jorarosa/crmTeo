<?php
require_once('cabecera.php');
require_once('form_tutor.php');
?>
<script> check=true; </script>
<body OnBeforeUnload='return alerta_salvar(document.forms.tutor)'>

<?php
$user_a=$_SESSION['USER_T'];	

$action="";if (isset($_POST['action'])) $action=$_POST['action'];

//Ligamos el formulario al usuario. En el CRM el identificador del 
//usuario es su correp electrónico.No se podrá cambiar tras el alta

//$ftutor['fields']['email']['valor']=$user_a;
//$ftutor['fields']['email']['co']=true;

//Ligamos tambien por usuario de ies
$ftutor['fields']['usuario']['valor']=$_SESSION['USER_IES'];
$ftutor['fields']['usuario']['co']=true;
$ftutor['fields']['usuario']['ro']=true;
$ftutor['fields']['email']['ro']=true;


$ftutor['acciones']='Actualizar,Insertar';

//Si el formulario esta vacio consultamos
if ($ftutor['fields']['id']['valor']==""){
	$re=FormQuery($ftutor);
       ResultToForm($ftutor,$re);
    };

 //Si el formulario sigue vacio, el usuario necesita ser dado de alta por el admin
 if ($ftutor['fields']['id']['valor']==""){
 	die("<p class=errormsg>Aún no está autorizado para la utilización de esta aplicacion. 
 			Debe solicitar su alta al administrador fct@iesclaradelrey.es</p>");
 	//$ftutor['fields']['usuario']['valor']=$_SESSION['USER_IES'];
 	//$ftutor['fields']['nombre']['valor']=$_SESSION['NOMBRE_IES'];
 }
    
//Motor del formulario
ManageForm($ftutor); 

//Visualizacion del formulario
		
echo "<div class=marco >";
	require_once "menu.php";

	echo "<div class=bloque>";
		echo "<table align=center class=ficha >";
		echo "<tr><td><p class='errormsg'>";
		ShowErrorMsg($ftutor);
		//echo "</p><p class='msg' >";
		//ShowStatusMsg($ftutor);
		//echo "</p>
		echo "</td></tr>";
		echo "</table>";
	echo "</div>";

	//Input($fempresa,"id");

	echo "<div class=bloque>";

	echo "<form name=tutor method=post onSubmit='return check_submit(this)'>";
	echo "<table align=center width=100% cols=4 class=ficha >";

	echo "<tr><td colspan=4><h2>Mis Datos</h2></td></tr>";
	echo "<tr>";
	echo "<td align=right>";Input($ftutor,"usuario");echo "</td>";
	echo "<td align=right>";Input($ftutor,"email");echo "</td>";
	echo "</tr>\n";


	echo "<tr>";
	echo "<td align=right>";Input($ftutor,"nombre");echo "</td>";
	echo "<td align=right>";Input($ftutor,"fijo");echo "</td>";
	echo "</tr>\n";
	
	echo "<tr>";
	echo "<td align=right>";Input($ftutor,"movil");echo "</td>";
	echo "<td align=right>&nbsp;</td>";
	echo "</tr>\n";

	echo "</table>";

	echo "</div>";
/*	
	?>

	<p>
	Ver otros datos de acceso
	<input id='otros_datos_check' type=checkbox onClick="ocultar_mostrar('otros_datos_check','otros_datos_acceso')" name=otros_datos>
	</p>

	<?php
	echo "<div id=otros_datos_acceso class=bloque> ";
	echo "<table align=center width=100% cols=3 class=ficha >";
	echo "<tr><td class=cabecera colspan=3>";
	echo "Datos de acceso. Si desea cambiar su clave de acceso,"; 
	echo "introduzca aquí la clave actual y la clave nueva por duplicado.";
	echo "Para eliminar su cuenta utilice el botón 'X'";
	echo "</td></tr>";
	echo "<tr><td align=center>";
		echo"Clave Actual:";Input($ftutor,"claveac");
		echo "</td><td align=center>";
		echo"Clave nueva:";Input($ftutor,"nclave1");
		echo "</td><td align=center>";
		echo"Clave nueva:";Input($ftutor,"nclave2");
	echo "</td></tr>\n";
	echo "<tr><td>\n";
		echo "Cerrar mi cuenta y eliminar mis datos ";
		?>
		<input type=submit onclick="return confirm('Cerrará su cuenta y elinara sus datos. ¿Desea hacerlo?');" name=action value='x' >
		<?php
	echo "</td></tr>\n";
	echo "</table><br>\n";
	echo "</div>";
*/
//	echo "<input type=hidden name=action value='actualizar'>";

	echo "<div class=bloque>";
		echo "<table class=ficha><tr>";
			echo "<td align=right width=80% >";
			echo "Aplicar los cambios";
			echo "</d>";
			echo "<td align=left>";
				InputNavegador($ftutor);
			echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";
	echo "</div>";
echo "</div>";
echo "<br>";
$curso=Parametros("CursoEnCurso");
query_to_table("<h2>Periodos de Fct Asignados</h2>","select periodo as Periodo,cod_grupo as Grupo, curso as Curso from fct_periodo_tutor p,
fct_tutor t where p.tutor_id=t.id and t.email='$user_a' and curso='$curso'");

mysqli_close($Config->con);
?>
<script>ocultar_mostrar('otros_datos_check','otros_datos_acceso' );</script>
