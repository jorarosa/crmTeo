<?php
require_once('cabecera.php');

$user_a=$_SESSION['USER_T'];	

$curso=Parametros("CursoEnCurso");

$qalumnos="select 
		
		concat('<form action=fct.php method=post> <input type=hidden name=fct_id value=', f.id,'>',a.email) as Email, 
		a.telefono as 'Teléfono',
		a.nombre as Nombre,
		a.apellidos as Apellidos,
		f.grupo as Grupo,
		f.curso as Curso,
		f.periodo as Periodo,
		'<input  type=hidden name=action value=VerDetalleFct><input type=image src=$Config->url_base/content/iconos/Text.png value=VerDetalleFct></form>' As 'Det.' 
	    FROM 
		fct_fct f, 
		fct_periodo_tutor p,
		fct_tutor t,
		fct_alumno a 

	    WHERE 
		t.email = '$user_a' and
		f.curso=p.curso and
		f.periodo=p.periodo and
		f.alumno_email = a.email and 
		p.cod_grupo=f.grupo and
		p.tutor_id=t.id and
		f.curso='$curso'
";
/*
		'<input name=action type=submit value=Cerrar>' as Cerrar,
		'<input name=action type=submit value=Abrir>' as Abrir ,
		'<input name=action type=submit value=Eliminar></form>' As Eliminar 
*/
//echo $qalumnos ;

echo "<div class=marco >";
	require_once "menu.php";
	echo "<div class=bloque>";
	query_to_table("<p class=cabecera > Alumnos en FCT </p>", $qalumnos);
	//TablaEdicion($foferta,$edquery="",$edicion=true);
	echo "</div>";
echo "</div>";

mysqli_close($Config->con);
?>
