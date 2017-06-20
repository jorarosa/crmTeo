<?php
session_start();
//require_once('cabecera.php');
header( 'Content-type: text/html; charset=utf-8' );
require_once("../configuracion.php");
require_once('../sharedphp/funciones.php');
require_once('../sharedphp/forms_functions.php');
$user_a=$_SESSION['USER_A'];	
echo $user_a;
if($user_a != $Config->administrador) die("Autorizacion");
?>
<link rel='stylesheet' href=<?php echo $Config->css;?> >
<?php
if (isset($_REQUEST['query'])){
	$query=$_REQUEST['query'];	
	query_to_table_i($Config->con,"Query",$query);
	}
?>
<form method=post >
<input name=query size=40 max=100>
<input type=submit>
</form>
