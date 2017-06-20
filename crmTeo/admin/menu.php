<?php 

require_once("cabecera.php"); 
require_once("../sharedphp/funciones.php"); 
require_once("../configuracion.php"); 
global $Config;
?>

<script type='text/javascript' src=../scripts/funciones.js></script>
<script> 
var solap=new Array("f1","f2","f3","f4","f5","f6","f7");

function set_solapa(solap,nextpage){
	document.foption.m1_option.value=solap;
	document.foption.action=nextpage;
	document.foption.submit();
	}
</script>

<form name=foption method=post>
<input type=hidden name=m1_option>
</form>

<div class=menu>
<input id=option_f1 class=orden type=button value='Asignacion de Tutores' OnClick="f(solap,'f1');set_solapa('f1','tutores_grupos.php');">
<input id=option_f2 class=orden type=button value='Parámetros' OnClick="f(solap,'f2');set_solapa('f2','parametros.php');">
<input id=option_f4 class=orden type=button value='Volver a tutores' OnClick="f(solap,'f4');set_solapa('f4','../tutor/tutor.php');">
<input id=option_f5 class=orden type=button value='Fct' OnClick="f(solap,'f5');set_solapa('f5','fct.php');">
<input id=option_f6 class=orden type=button value='Tutores' OnClick="f(solap,'f6');set_solapa('f6','tutores.php');">
<input id=option_f7 class=orden type=button value='Ciclos' OnClick="f(solap,'f7');set_solapa('f7','ciclos.php');">
<input id=option_f3 class=orden type=button value='Salir' OnClick="f(solap,'f3');set_solapa('f3','tutores_grupos.php');">
</div>
<?php
if (! isset($_SESSION['m1_option'])) $_SESSION['m1_option']='f1';

//Tratamos la opcion de menu salir
if ('f3'==getRequestSession('m1_option')) {
        unset ($_SESSION['USER_T']);
        session_destroy();
        echo "<p align=center class=msg><a href=login.php>$Config->sesion_cerrada</a></p>";
        die();
        };
?>


<script>
opcion="<?php echo getRequestSession('m1_option');?>";
if (opcion!="") {
	f(solap,opcion.substring(0,2));
	}
</script>
