<?php
require_once('cabecera.php');
require_once('../empresa/form_oferta.php');

$action="";if (isset($_POST['action'])) $action=$_POST['action'];

//Ligamos el formulario al usuario.
/*
$foferta['fields']['email']['valor']=$user_a;
$foferta['fields']['email']['de']=$user_a; //Valor por defecto
$foferta['fields']['email']['co']=true;

$foferta['fields']['fecha']['valor']=date('d/m/y');
*/



$qofertas="select concat('<form method=post action=oferta.php > <input type=hidden name=oferta_id value=', o.id , '>',o.id ) as 'Id.',
		o.email as Email,
		e.razon as Empresa,
		e.convenio as Convenio,
		CASE tipo WHEN 'FC' THEN 'Prácticas FCT' WHEN 'OE' THEN 'Oferta de Empleo' WHEN 'ER' THEN 'Erasmus europeos' END As tipo,
		num as 'Número personas',
		a.nombre as 'Área',
		CONCAT(MID(cont,1,60),'...') as 'Oferta',
		fecha as Fecha,
		e.telefono as 'Tfono.',
		'<input type=hidden name=action value=oferta_look><input type=image src=$Config->url_base/content/iconos/Text.png></form>' as Detalle,
		concat('<a href=contacto.php?of_id=',o.id,'><img border=0 src=$Config->url_base/content/iconos/Mobile.png></a>') as Contacto
		
	    FROM fct_oferta o, fct_familia a, fct_empresa e
	    WHERE o.area_id=a.codigo and e.email=o.email and tipo='FC' and o.estado_emp <> 'CE' order by fecha desc limit 100";
echo "<div class=marco >";
	require_once "menu.php";
	echo "<div class=bloque>";
	query_to_table("<h2 > Solicitudes recientes </h2>", $qofertas);
	//TablaEdicion($foferta,$edquery="",$edicion=true);
	echo "</div>";
echo "</div>";

mysqli_close($Config->con);
?>
