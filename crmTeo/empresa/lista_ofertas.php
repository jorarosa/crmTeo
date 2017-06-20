<?php
require_once('cabecera.php');
require_once('form_oferta.php');
require_once('form_empresa.php');
//echo $fempresa['fields']['cif']['valor'];
$user_a=$_SESSION['USER_A'];	

require_once("menu.php");
if (trim($fempresa['fields']['cif']['valor'])=="")die("<br>Debe completar los datos de la entidad");
?>
<table class=ficha><tr><td>
<p>En esta página puede:  </p>
<ul>
<li> ver la lista de las solicitudes de alumnos en prácticas y ofertas de empleo  en curso y/o cerradas.  </li>
<li> Añadir nuevas solicitudes y ofertas</li>
<li> Cerrar ofertas y solicitudes en curso</li>
<li> Abrir ofertas y solicitudes cerradas</li>
<li> Acceder a los detalles de una oferta para verlos y modificarlos</li>
</ul>
</td></tr>
</table>
<?php 
$caduca_col="(duracion - (TO_DAYS(NOW())-TO_DAYS(fecha)))";
$where_clause="o.area_id=a.codigo and o.email='$user_a' ";
$tc=false;
if (isset($_REQUEST["tambien_cerradas"])) $tc=$_REQUEST["tambien_cerradas"];

if(!$tc){
	$where_clause.=" and $caduca_col > 0 and estado_emp='EC' " ;
	}
	
if (isset($_REQUEST['cerrar_x'])){
	$ofertaid=$_REQUEST['oferta_id'];
	$q="UPDATE fct_oferta set estado_emp='CE' WHERE id='$ofertaid'";
	mysqli_query_d($q);
	}

if (isset($_REQUEST['abrir_x'])){
	$ofertaid=$_REQUEST['oferta_id'];
	$q="UPDATE fct_oferta set estado_emp='EC' WHERE id='$ofertaid'";
	mysqli_query_d($q);
	}
$cerrar="CONCAT('<form method=post ><input type=hidden name=oferta_id value=',
					o.id,'><br><input title=Cerrar type=image src=$Config->url_base/content/iconos/Unlock.png name=cerrar value=C></form>')";

$abrir="CONCAT('<form method=post ><input type=hidden name=oferta_id value=',
o.id,'><br><input type=image title=Abrir src=$Config->url_base/content/iconos/Lock.png alt=abrir name=abrir value=C></form>')";

$detalle="'<span class=detalle><input type=image src=$Config->url_base/content/iconos/Text.png value=Detalle></span></form>' as Detalle";
$qofertas="SELECT 
			CONCAT('<form method=post action=oferta.php><input type=hidden name=action value=oferta_look><br> <input type=hidden name=oferta_id value=',o.id,'>',o.id) as 'Indent.',
			CASE tipo WHEN 'FC' THEN 'Practicas FCT' 
				WHEN 'OE' THEN 'Oferta de Empleo' 
				WHEN 'ER' THEN 'Erasmus europeos' END As tipo,
			num as '#Personas',
			a.nombre as 'Area',
			CONCAT(MID(cont,1,30),'...') as 'Oferta',
			DATE_FORMAT(fecha,'%d/%c/%y') as Fecha,
			$caduca_col as Expira,
			/*CASE estado_emp WHEN 'EC' THEN 'En Curso' WHEN 'CE' THEN 'Cerrada' END as Estado,*/
			$detalle ,
			IF(estado_emp<>'CE',$cerrar,$abrir) as 'Estado'
			
			
	    FROM 	fct_oferta o, fct_familia a
	    WHERE 	$where_clause  
	    ORDER 	by fecha desc limit 20";
//echo "<br>";
query_to_table("<p class=cabecera >Mis solicitudes en curso </p>", $qofertas);
//echo $qofertas;

mysqli_close($Config->con);
?>

	
	<table class=ficha><tr> <td>
	<form action=oferta.php method=post>
		<input type=hidden name=action value=oferta_new>
		<p>Añadir nueva oferta de Prácticas o Empleo <input type=image src=<?php echo $Config->url_base;?>/content/iconos/New.png value='Añadir nueva oferta de Prácticas o Empleo'></p>
	</form>
	<form method=post>
	<p>Mostrar también las cerradas y /o caducadas<input type=checkbox name=tambien_cerradas <?php if ($tc) echo " checked "?> >
	<input type=image src=<?php echo $Config->url_base;?>/content/iconos/Go.png value='Ver'></p></form>
	</td> </table>
	
	
	<script>f(solap,'f2');</script>
