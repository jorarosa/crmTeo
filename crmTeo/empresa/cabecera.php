<?php
session_start();
header( 'Content-type: text/html; charset=utf-8' );
//header('Cache-Control: no-cache');
//header('Pragma: no-cache');

require_once('../configuracion.php');
require_once('../sharedphp/funciones.php');
require_once('../sharedphp/forms_functions.php');

if ($Config->debug_sql) print_r($_REQUEST);
//Do not remove. Security issue
if ( !isset($_SESSION['USER_A'])){ //Estamos fuera
        die ("<p align=center class=msg><a href=login.php>$Config->noaccess_message</a></p>");
        }
$_SESSION['perfil']='empresa';
//Tratamos la opcion de menu salir

if ('f3'==getRequestSession('m1_option')) {
        unset ($_SESSION['USER_A']);
        session_destroy();
	echo ("<script> location.href='".$Config->url_base."'</script>");
        die();
        };

//$DATABASE=$Config->database;
//$conexion=conectar_bd($DATABASE) or die ("Base de datos no disponible, disculpe las molestias");

?>

<link rel='stylesheet' href=<?php echo $Config->css;?> >
<?
echo "<div class=cabecera>";
	echo $Config->welcome_message_empresa ;
if ($_SESSION['USER_A'])
	echo "<tr><td><p class='option'> Bienvenido  ". $_SESSION['USER_A']  . " <p></td></tr>";
echo "</div>";
?>
