<?php
session_start();
header( 'Content-type: text/html; charset=utf-8' );
require_once('../configuracion.php');
require_once('../sharedphp/funciones.php');
require_once('../sharedphp/forms_functions.php');

//Do not remove. Security issue
if ( !isset($_SESSION['USER_B'])){ //Estamos fuera
        die ("<p align=center class=msg><a href=login.php>$Config->noaccess_message</a></p>");
	}
$_SESSION['perfil']='alumno';

//Tratamos la opcion de menu salir

if ('f3'==getRequestSession('m1_option')) {
        unset ($_SESSION['USER_B']);
        session_destroy();
	echo ("<script> location.href='".$Config->url_base."'</script>");
        //echo "<p align=center class=msg><a href=login.php>$Config->sesion_cerrada</a></p>";
        die();
        };

//$DATABASE=$Config->database;
//$conexion=conectar_bd($DATABASE) or die ("Base de datos no disponible, disculpe las molestias");

?>

<link rel='stylesheet' href=<?php echo $Config->css;?> >
<?
echo "<div class=cabecera>";
	echo $Config->welcome_message_alumno ;
if ($_SESSION['USER_B'])
	echo "<tr><td><p class='option'> Bienvenido  ". $_SESSION['USER_B']  . " <p></td></tr>";
echo "</div>";

//getRequestSession('action');
//getRequestSession('id');
//echo "la accion es ".  $_SESSION['action'] . "El id es " . $_SESSION['id']; 
?>
