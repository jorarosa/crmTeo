<?php
require_once('cabecera.php');
require_once('form_contacto.php');
?>
<script> check=true; </script>
<body OnBeforeUnload='return alerta_salvar(document.forms.tutor)'>


<?php
$user_a=$_SESSION['USER_T'];	
$of_id=getRequestSession('of_id');


//Mostramos una cabecera con los datos de la empresa
$q="select 
		o.id as 'Num. Oferta',
		o.email as Email,
		e.razon as Empresa,
		e.convenio as Convenio,
		CASE tipo WHEN 'FC' THEN 'Prácticas FCT' WHEN 'OE' THEN 'Oferta de Empleo' WHEN 'ER' THEN 'Erasmus europeos' END As tipo,
		num as 'Número personas',
		a.nombre as 'Área',
		CONCAT(MID(cont,1,60),'...') as 'Oferta',
		fecha as Fecha,
		e.telefono as 'Tfono.'

	    FROM fct_oferta o, fct_familia a, fct_empresa e

	    WHERE o.id=$of_id and o.area_id=a.codigo and e.email=o.email";

$fcontacto['acciones']="Insertar,";


$fcontacto['fields']['email_tutor']['valor']=$user_a;
$fcontacto['fields']['email_tutor']['de']=$user_a;
$fcontacto['fields']['email_tutor']['ro']=true;
$fcontacto['fields']['email_tutor']['s']=10;

$fcontacto['fields']['fecha']['valor']=date('Y-m-d H:i:s');//('d/m/y');//('Y-m-d H:i:s');
$fcontacto['fields']['fecha']['de']=date('Y-m-d H:i:s');//('d/m/y');
$fcontacto['fields']['fecha']['ro']=true;
$fcontacto['fields']['fecha']['s']=10;

$fcontacto['fields']['oferta_id']['valor']=$of_id;
$fcontacto['fields']['oferta_id']['de']=$of_id;
$fcontacto['fields']['oferta_id']['ro']=true;
$fcontacto['fields']['oferta_id']['sh']=false;
$fcontacto['fields']['oferta_id']['co']=true;

$fcontacto['fields']['id']['sh']=false;

$fcontacto['fields']['contenido']['htmlatt']="rows=3 cols=60";

$fcontacto['order']="fecha desc";


//ManageForm($fcontacto); 

echo "<div class=marco >";
	require_once "menu.php";
	echo "<div class=bloque>";
	query_to_table("<p class=titular > datos de la oferta </p>", $q);
	//TablaEdicion($foferta,$edicion=true);
	echo "</div>";


/*
	echo "<div class=bloque>";
		echo "<table align=center class=ficha >";
		echo "<tr><td><p class='errormsg'>";
		ShowErrorMsg($fcontacto);
		//echo "</p><p class='msg' >";
		//ShowStatusMsg($ftutor);
		//echo "</p>
		echo "</td></tr>";
		echo "</table>";
	echo "</div>";
*/
	$it = Form_iterator::factory('itcontactos',5);
	echo "<div class=bloque>";
	echo "<p class=titular>Contactos</p>";
	TablaEdicion($fcontacto,true,$it);
	echo "</div>";
	echo "<table class=ficha>";
	echo "<tr><td align=center>";
	echo "<a href=lista_ofertas.php>Volver a la lista de ofertas</a>";
	echo "</td><td>";
	$it->show();
	echo "</td></tr>";
	echo "</table>";
echo "</div>";
?>
