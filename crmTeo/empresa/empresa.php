<?php
require_once('cabecera.php');
require_once('form_empresa.php');
echo "<script> check=true; </script>\n";
echo "<body OnBeforeUnload='return alerta_salvar(document.forms.empresa)'>\n";
$user_a=$_SESSION['USER_A'];	
//Ligamos el formulario al usuario.
$fempresa['fields']['email']['valor']=$user_a;
$fempresa['fields']['email']['co']=true;

$action="";if (isset($_POST['action'])) $action=$_POST['action'];
if ($action=="x"){
	 //Borrado de ofertas
	 $q="DELETE FROM fct_oferta WHERE email='$user_a' ";
	 mysqli_query_d($q);

	 //Borrado del usuario
	 $q="DELETE FROM fct_empresa WHERE email='$user_a'";
	 mysqli_query_d($q);

	echo "redirecting ............";
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
	session_destroy();
	die();
	}

//Si el formulario esta vacio consultamos
if ($fempresa['fields']['id']['valor']==""){
	$re=FormQuery($fempresa);
	echo (mysql_error());
       	ResultToForm($fempresa,$re);
	};

//Asignamos los valores por defecto de pais y provincia si pais esta vacio
if ($fempresa['fields']['pais']['valor']==""){
	$fempresa['fields']['pais']['valor']='esp';
	$fempresa['fields']['provincia']['valor']='28';
	}


//Motor del formulario
ManageForm($fempresa); 
//Visualizacion del formulario
		
echo "<div class=marco >\n";
	require_once "menu.php";

	echo "<div class=bloque>\n";
		echo "<table align=center class=ficha >\n";
		echo "<tr><td><p> Bienvenido  $user_a al portal de empresas del IES CLARA DEL REY<p></td></tr>\n";
		echo "<tr><td><p class='errormsg'>";
		ShowErrorMsg($fempresa);
		echo "</p><p class='msg' >";
		ShowStatusMsg($fempresa);
		echo "</p></td></tr>";
		echo "</table>";
	echo "</div>";
	//print_r($fempresa);
	//Input($fempresa,"id");

	echo "<div class=bloque>";
	echo "<form name=empresa method=post onSubmit='return check_submit(this)'>";
	echo "<table align=center width=100% cols=4 class=ficha >";
	echo "<tr><td class=cabecera colspan=4>Datos de la entidad</td></tr>\n";
	echo "<tr>";
	echo "<td align=right>";Input($fempresa,"razon");echo "</td>";

	echo "<td align=right>";Input($fempresa,"telefono");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($fempresa,"cif");echo "</td>";
	echo "<td align=right>";Input($fempresa,"erasmus");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($fempresa,"direccion");echo "</td>";
	echo "<td align=right>";Input($fempresa,"cpostal");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($fempresa,"pais");echo "</td>";
	echo "<td align=right>";Input($fempresa,"provincia");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($fempresa,"localidad");echo "</td>";
	echo "<td align=right>";Input($fempresa,"convenio");echo "</td>";
	echo "</tr>\n";

	echo "<tr><td class=cabecera colspan=4>Datos de la persona de contacto</td></tr>\n";
	echo "<tr>";
	echo "<td align=right>";Input($fempresa,"cont_nom");echo "</td>";
	echo "<td align=right>";Input($fempresa,"cont_ape");echo "</td>";
	echo "</tr>\n";

	echo "<tr><td class=cabecera colspan=4>Datos del representante legal</td></tr>\n";
	echo "<tr>";
	echo "<td align=right>";Input($fempresa,"rep_nom");echo "</td>";
	echo "<td align=right>";Input($fempresa,"rep_nif");echo "</td>";
	echo "</tr>\n";
	echo "<tr>";
	echo "<td align=right>";Input($fempresa,"rep_ape");echo "</td>";
	echo "<td align=right>";;echo "</td>";
	echo "</tr>\n";
	echo "</table>";

	echo "</div>";
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
		echo"Clave Actual:";Input($fempresa,"claveac");
		echo "</td><td align=center>";
		echo"Clave nueva:";Input($fempresa,"nclave1");
		echo "</td><td align=center>";
		echo"Clave nueva:";Input($fempresa,"nclave2");
	echo "</td></tr>\n";
	echo "<tr><td>\n";
		echo "Cerrar mi cuenta y eliminar mis datos ";
		?>
		<input type=submit onclick="return confirm('Cerrará su cuenta y eliminara; sus datos. ¿Desea hacerlo?');" name=action value='x' >
		<?php
	echo "</td></tr>\n";
	echo "</table><br>\n";
	echo "</div>";

//	echo "<input type=hidden name=action value='actualizar'>";

	echo "<div class=bloque>";
		echo "<table class=ficha><tr>";
			echo "<td align=right width=80% >";
			echo "Aplicar los cambios";
			echo "</d>";
			echo "<td align=left>";
				InputNavegador($fempresa);
			echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";

	echo "</div>";
echo "</div>";
mysqli_close($Config->con);
?>
<script>
ocultar_mostrar('otros_datos_check','otros_datos_acceso' );
f(solap,'f1');
</script>
