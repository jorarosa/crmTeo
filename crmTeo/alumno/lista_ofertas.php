<?php
session_start();

require_once('cabecera.php');
require_once('../empresa/form_oferta.php');
require_once('form_alumno.php');

$action="";if (isset($_POST['action'])) $action=$_POST['action'];
$caduca_col="(duracion - (TO_DAYS(NOW())-TO_DAYS(fecha)))";
//print_r($falumno);
$ciclo=$falumno['fields']['ciclo']['valor'];

$tablas = "fct_oferta o, fct_familia a, fct_empresa e, fct_ciclos c";
$where_clause = "o.area_id=a.codigo and 
                        e.email=o.email and 
                        tipo='OE' and 
                        a.codigo = c.familia_id  and 
                        c.codigo='$ciclo' and
                        $caduca_col > 0 and
                        estado_emp='EC' "; /*EN CURSO*/ 

$action="";if (isset($_REQUEST['action'])) $action=$_REQUEST['action'];
if($action=='buscar'){
        $texto=$_REQUEST['texto'];
        if(strlen($texto) > 0) $where_clause.= "and concat(e.email,e.telefono,a.nombre,e.razon,c.nombre,o.cont) like '%$texto%'";
        }

$qofertas="select 
		CONCAT('<form method=get action=oferta.php>
			<input type=hidden name=action value=oferta_look>
			<input type=hidden name=oferta_id value=',o.id,'>',o.id) as 'Indent.',
		o.email as Email,
		e.razon as Empresa,
		a.nombre as 'Área',
		$caduca_col as 'Expira(días)',
		CONCAT(MID(cont,1,120),'...') as 'Descripción Oferta',
		date_format(fecha,'%d/%m/%y') as Fecha,
		e.telefono as 'Tfono.',
		'<input type=image src=$Config->url_base/content/iconos/Text.png></form>' as Detalle
	    FROM $tablas
	    WHERE $where_clause
	    ORDER BY fecha desc limit 100";

echo "<div class=marco >";
	require_once "menu.php";
	echo "<div class=bloque>";
	query_to_table("<p class=cabecera > Solicitudes recientes </p>", $qofertas);
	//TablaEdicion($foferta,$edquery="",$edicion=true);
	echo "</div>";
echo "</div>";

mysqli_close($Config->con);
?>
<table class=ficha><tr> <td>
<form method=get>
<input type=hidden name=action value=buscar >
Buscar: <input name=texto >
<input align=top type=image src=<?php echo "$Config->url_base/content/iconos/Go.png"; ?> value=Buscar>
</form>
</tr></td>

</table>
<script>
f(solap,'f4');
</script>
