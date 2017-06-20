<?php
require_once('cabecera.php');
require_once('form_oferta.php');
require_once('form_empresa.php');

$user_a=$_SESSION['USER_A'];	

$action="na";
if (isset($_REQUEST['action'])) $action=$_REQUEST['action'];


require_once("menu.php");

if (trim($fempresa['fields']['cif']['valor'])=="")die("<br>Debe completar los datos de la entidad");

$tablas = "fct_alumno a left join  fct_idioma i on (a.idioma1=i.cod_iso) left join fct_ciclos c on (a.ciclo=c.codigo) ";
//$where_clause = " a.visibilidad <> 'ND' "; //ND No mostrar ningun dato
$where_clause = " a.visibilidad = 'TD' "; //TD Todos mis datos

if($action=='buscar'){
	$texto=$_REQUEST['texto'];
	if(strlen($texto) > 0) $where_clause.= " and concat(a.email,a.telefono,a.nombre,ifnull(c.nombre,''),a.formacion) like '%$texto%'";
	}


$qcandidatos="SELECT 	
			CONCAT('<form method=get action=alumno.php>
				<input type=hidden name=action value=alumno_look>
				<input type=hidden name=alumno_email value=',a.email,'>',a.email) as 'Email.',
			a.telefono as 'Teléfono',
			MID(a.formacion,1,100) as Formacion,
			c.nombre as Ciclo,
			i.nombre as Idioma,
			a.nivel1 as nivel,
			concat(if(visibilidad='TD','<input type=image src=$Config->url_base/content/iconos/Text.png value=Detalle>','Detalle'),'</form>') as 'Ver CV'
	    FROM 	$tablas
	    WHERE 	$where_clause  ";

?>
<br>
<form method=get>
<table class=ficha><tr> <td>
<input type=hidden name=action value=buscar >
Buscador. Introduzca una palabra clave.P.e. "Comercio" : <input align=center name=texto >
<input align=top type=image src=<?php echo "$Config->url_base/content/iconos/Go.png"; ?> value=Buscar>
</tr></td> 
</table>
</form>


<?php
//query_to_table("<p class=cabecera >Candidatos</p>", $qcandidatos);
query_to_table_i($Config->con,"<p class=cabecera >Candidatos</p>", $qcandidatos);

mysqli_close($Config->con);
?>

<script>f(solap,'f4');</script>
