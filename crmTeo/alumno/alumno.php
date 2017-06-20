<?php
require_once('cabecera.php');
require_once('form_alumno.php');
$_SESSION['perfil']='alumno';
?>
<html>
<script> check=true; </script>
<!--body OnBeforeUnload='return alerta_salvar(document.forms.alumno)'-->

<?php
$user_a=$_SESSION['USER_B'];	

$action="";if (isset($_POST['action'])) $action=$_POST['action'];

//Borrado de la cuenta del usuario
if ($action == 'x' && isset($_SESSION['USER_B'])){
	//echo "<script>alert('Eliminando');</script>";
	$user_a=$_SESSION['USER_B'];	
	//Eliminando datos de candidato
	$q="delete from fct_alumno where email='".$user_a."'";
	echo "la query de borrado es $q";
	mysqli_query_d($q);
	//echo mysql_error();
	session_destroy();
	echo "redirecting ............";
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
	die();
	}

//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//Ligamos el formulario al usuario.
$falumno['fields']['email']['valor']=$user_a;
$falumno['fields']['email']['co']=true;

//Si el formulario esta vacio consultamos
if ($falumno['fields']['id']['valor']==""){
	$re=FormQuery($falumno);
       	ResultToForm($falumno,$re);
	};

//Asignamos los valores por defecto de pais y provincia si pais esta vacio
//echo "El pais es :".$falumno['fields']['pais']['valor'].":";
if ($falumno['fields']['pais']['valor']==""){
	$falumno['fields']['pais']['valor']='esp';
	$falumno['fields']['provincia']['valor']='28';
	$falumno['fields']['localidad']['valor']='Madrid';
	}

//Motor del formulario
ManageForm($falumno); 

//Visualizacion del formulario
		
echo "<div class=marco >";
	require_once "menu.php";

	echo "<div class=bloque>";
		echo "<table align=center class=ficha >";
		echo "<tr><td><p> Bienvenido  $user_a al portal de empresas del IES CLARA DEL REY<p></td></tr>";
		echo "<tr><td><p class='errormsg'>";
		ShowErrorMsg($falumno);
		echo "</p><p class='msg' >";
		ShowStatusMsg($falumno);
		echo "</p></td></tr>";
		echo "</table>";
	echo "</div>";

	//Input($falumno,"id");

	echo "<div class=bloque>";
	echo "<form name=alumno method=post onSubmit='return check_submit(this)'>";
	echo "<table align=center width=100% cols=4 class=ficha >";
	echo "<tr><td class=cabecera colspan=4>Datos de localizaci&oacute;n</td></tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($falumno,"nombre");echo "</td>";
	echo "<td align=right>";Input($falumno,"apellidos");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($falumno,"telefono");echo "</td>";
	echo "<td align=right>";Input($falumno,"movil");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($falumno,"direccion");echo "</td>";
	echo "<td align=right>";Input($falumno,"cpostal");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($falumno,"pais");echo "</td>";
	echo "<td align=right>";Input($falumno,"provincia");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($falumno,"localidad");echo "</td>";
    	echo "<td align=left>";;
                Input($falumno,"nac_dia");
                Input($falumno,"nac_mes");
                Input($falumno,"nac_ano");
        echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Input($falumno,"nif");echo "</td>";
	echo "<td align=right>";Input($falumno,"ciclo");echo "</td>";
	echo "</tr>\n";
	/* Profesional y estudios */
	echo "</table>";
	?>
	<p>Datos para bolsa de empleo <input id='otros_datos_cv_check' type=checkbox onClick="ocultar_mostrar('otros_datos_cv_check','otros_datos_cv')" name=otros_datos_cv_name <?php if (isset ($_REQUEST['otros_datos_cv_name'])) echo 'checked';?> ></p>
	<?php

	echo "<div id='otros_datos_cv' class=bloque> ";
		echo "<table align=center width=100% cols=4 class=ficha >";
		echo "<tr><td class=cabecera colspan=4>Datos académicos y profesionales</td></tr>\n";

		echo "<tr>";
		echo "<td align=right>";Input($falumno,"estudios");echo "</td>";
		echo "<td align=right>";Input($falumno,"experiencia");echo "</td>";
		echo "</tr>\n";
		echo "<tr><td class=cabecera colspan=4>CV</td></tr>\n";
		echo "<tr>\n";
		echo "<td colspan=4 align=left>";
		echo "Desarrolla aquí tu experiencia Laboral<br>";
		Input($falumno,"exp_laboral");
		echo "</td></tr>";
		echo "<tr>\n";
		echo "<td colspan=4 align=left>";
		echo "Desarrolla aquí tu formación<br>";
		Input($falumno,"formacion");
		echo "</td>";
		echo "</tr>\n";
		echo "<tr><td class=cabecera colspan=4>Idiomas</td></tr>\n";
		echo "<tr>";
		echo "<td colspan=2 align=right>";Input($falumno,"idioma1",""); Input($falumno,"nivel1","");echo "</td>";
		echo "<td colspan=2 align=right>";Input($falumno,"idioma2",""); Input($falumno,"nivel2","");echo "</td>";
		echo "</tr>\n";
		echo "<tr>";
		echo "</tr>\n";
/*
	echo "<tr>";
		echo "<td colspan=4 align=left>";
			echo "Último trabajo, empresa, fecha de incorporación...<br>";
			Input($falumno,"ultimo_trabajo");
		echo "</td>";
	echo "</tr>\n";
*/

		echo "<tr><td class=cabecera colspan=4>Otros Conocimientos y habilidades</td></tr>\n";
		echo "<tr>\n";
			echo "<td colspan=4 align=left>";
				echo "Conocimientos de informática<br>";
				Input($falumno,"informatica");
			echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
			echo "<td colspan=4 align=left>";
				echo "Habilidades personales<br>";
				Input($falumno,"skills");
			echo "</td>";
		echo "</tr>\n";

		/* Datos complementarios */
		echo "<tr><td class=cabecera colspan=4>Datos complementarios </td></tr>\n";
		echo "<tr>";

		echo "<td align=right>";Input($falumno,"carnet");echo "</td>";
		echo "<td align=left>";Input($falumno,"viajar");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";Input($falumno,"movilidad");echo "</td>";
		echo "<td align=left>&nbsp;</td>";
		echo "</tr>\n";

		echo "<tr><td class=cabecera colspan=4>Visibilidad de mis datos para las empresas</td></tr>\n";
		echo "<tr>";
		echo "<td align=right colspan=1>";Input($falumno,"visibilidad","</td><td colspan=3>");echo "</td>";
		echo "</tr>\n";

		/* Curriculum en texto y otros */
		/*
		echo "<tr>";
			echo "<td colspan=4 align=left>";
				echo "Aquí puede introducir su curriculum completo.<br>";
				echo "Puede copiar y pegar en formato de texto.<br>";
				Input($falumno,"cv");
			echo "</td>";
		echo "</tr>\n";
	
		echo "<tr>";
			echo "<td colspan=4 align=left>";
				echo "Si lo desea, aquí puede introducir, su carta de presentación .<br>";
					Input($falumno,"carta");
			echo "</td>";
		echo "</tr>\n";
	
		echo "<tr>";
			echo "<td align=left>";Input($falumno,"tipo_trabajo");echo "</td>";
		echo "<td colspan=2 align=left>";
			echo "Áreas de interés<br>";
			echo "<table cellpading=0 cellspacing=0 border=0>";
			echo "<tr><td>";
			Input($falumno,"areas");
			echo "</td></tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr>\n";
	*/
		echo "</table>";
		echo "</div>" //Bloque de cv
	?>

	<p>
	Ver otros datos de acceso
	<input id='otros_datos_check' type=checkbox onClick="ocultar_mostrar('otros_datos_check','otros_datos_acceso')" name=otros_datos <?php if (isset ($_REQUEST['otros_datos'])) echo 'checked';?>>
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
		echo"Clave Actual:";Input($falumno,"claveac");
		echo "</td><td align=center>";
		echo"Clave nueva:";Input($falumno,"nclave1");
		echo "</td><td align=center>";
		echo"Clave nueva:";Input($falumno,"nclave2");
	echo "</td></tr>\n";
	echo "<tr><td>\n";
		echo "Cerrar mi cuenta y eliminar mis datos ";
		?>
		<input type=submit onclick="return confirm('Cerrará su cuenta y elinara sus datos. ¿Desea hacerlo?');" name=action value='x' >
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
				InputNavegador($falumno);

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
ocultar_mostrar('otros_datos_cv_check','otros_datos_cv');
f(solap,"f1");
</script>
</body>
</html>
