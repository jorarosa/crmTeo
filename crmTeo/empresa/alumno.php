<?php

require_once('cabecera.php');
require_once('../alumno/form_alumno.php');
$_SESSION['perfil']='alumno';
?>
<script> check=true; </script>
<body OnBeforeUnload='return alerta_salvar(document.forms.alumno)'>

<?php

//$user_a=$_SESSION['USER_B'];	

$action="";if (isset($_REQUEST['action'])) $action=$_REQUEST['action'];

if ($action=='alumno_look'){
	//Ligamos el formulario al usuario.
	LimpiarForm($falumno);
	$email=$_REQUEST['alumno_email'];
	$falumno['fields']['email']['valor']=$email;
	$falumno['fields']['email']['co']=true;
	}

//Si el formulario esta vacio consultamos
if ($falumno['fields']['id']['valor']==""){
	$re=FormQuery($falumno);
       	ResultToForm($falumno,$re);
	};
//Comprobamos ls visibilidad
($falumno['fields']['visibilidad']['valor'] == 'TD') or die ('El candidato desea ser contactado previamente');

$falumno['fields']['exp_laboral']['htmlatt'].=' disabled ';
$falumno['fields']['formacion']['htmlatt'].=' disabled ';
//ManageForm($falumno); 

//Visualizacion del formulario
		
echo "<div class=marco >";
	require_once "menu.php";

	//Input($falumno,"id");

	echo "<div class=bloque>";
//	echo "<form name=alumno method=post onSubmit='return check_submit(this)'>";
	echo "<table align=center width=100% cols=4 class=ficha >";
	echo "<tr><td class=cabecera colspan=4>Datos de localizaci&oacute;n</td></tr>\n";

	echo "<tr>";
	echo "<td align=right>";Show($falumno,"nombre");echo "</td>";
	echo "<td align=right>";Show($falumno,"apellidos");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Show($falumno,"telefono");echo "</td>";
	echo "<td align=right>";Show($falumno,"movil");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Show($falumno,"direccion");echo "</td>";
	echo "<td align=right>";Show($falumno,"cpostal");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Show($falumno,"pais");echo "</td>";
	echo "<td align=right>";Show($falumno,"provincia");echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Show($falumno,"localidad");echo "</td>";
    	echo "<td align=left>";;
                Show($falumno,"nac_dia");
                Show($falumno,"nac_mes");
                Show($falumno,"nac_ano");
        echo "</td>";
	echo "</tr>\n";

	echo "<tr>";
	echo "<td align=right>";Show($falumno,"nif");echo "</td>";
	echo "<td align=right>";Show($falumno,"ciclo");echo "</td>";
	echo "</tr>\n";
	/* Profesional y estudios */
	echo "</table>";

	echo "<div id='otros_datos_cv' class=bloque> ";
		echo "<table align=center width=100% cols=4 class=ficha >";
		echo "<tr><td class=cabecera colspan=4>Datos académicos y profesionales</td></tr>\n";

		echo "<tr>";
		echo "<td align=right>";Show($falumno,"estudios");echo "</td>";
		echo "<td align=right>";Show($falumno,"experiencia");echo "</td>";
		echo "</tr>\n";
		echo "<tr><td class=cabecera colspan=4>CV</td></tr>\n";
		echo "<tr>\n";
		echo "<td colspan=4 align=left>";
		echo "Curriculum. Experiencia Laboral<br>";
		Input($falumno,"exp_laboral");
		echo "</td>";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td colspan=4 align=left>";
		echo "Curriculum. Experiencia Laboral<br>";
		Input($falumno,"formacion");
		echo "</td>";
		echo "</tr>\n";
		echo "<tr><td class=cabecera colspan=4>Idiomas</td></tr>\n";
		echo "<tr>";
		echo "<td colspan=2 align=right>";Show($falumno,"idioma1",""); Show($falumno,"nivel1","");echo "</td>";
		echo "<td colspan=2 align=right>";Show($falumno,"idioma2",""); Show($falumno,"nivel2","");echo "</td>";
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
				Show($falumno,"informatica");
			echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
			echo "<td colspan=4 align=left>";
				echo "Habilidades personales<br>";
				Show($falumno,"skills");
			echo "</td>";
		echo "</tr>\n";

		/* Datos complementarios */
		echo "<tr><td class=cabecera colspan=4>Datos complementarios </td></tr>\n";
		echo "<tr>";

		echo "<td align=right>";Show($falumno,"carnet");echo "</td>";
		echo "<td align=left>";Show($falumno,"viajar");echo "</td>";
		echo "</tr>\n";

		echo "<tr>";
		echo "<td align=right>";Show($falumno,"movilidad");echo "</td>";
		echo "<td align=left>&nbsp;</td>";
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
		echo "</div>" ;//Bloque de cv
mysqli_close($Config->con);


	echo "<div class=bloque>";
                echo "<table class=ficha><tr>";
                        echo "<td apan=4 ign=right >";
                        echo "<a  href=lista_candidatos.php >volver a la lista de candidatos</a>";
                        echo "</td>";
                        echo "</tr>";
                echo "</table>";
        echo "</div>";
?>
