<?php
session_start();
header( 'Content-type: text/html; charset=utf-8' );
require_once('../configuracion.php');
require_once('../sharedphp/funciones.php');
require_once('../sharedphp/forms_functions.php');


//Do not remove. Security issue
if ( !isset($_SESSION['USER_T']) or $_SESSION['USER_T']!=$Config->administrador){ //Estamos fuera
        die ("<p align=center class=msg><a href=$Config->url_base>$Config->noaccess_message</a></p>");
	}

//Tratamos la opcion de menu salir

if ('f3'==getRequestSession('m1_option')) {
        unset ($_SESSION['USER_T']);
        session_destroy();
	echo ("<script> location.href='".$Config->url_base."'</script>");
        //echo "<p align=center class=msg><a href=$Config->url_base>$Config->sesion_cerrada</a></p>";
        die();
        };

//$DATABASE=$Config->database;
//$conexion=conectar_bd($DATABASE) or die ("Base de datos no disponible, disculpe las molestias");

?>

<link rel='stylesheet' href=<?php echo $Config->css;?> >
<?
echo "<div class=cabecera>";
	echo $Config->welcome_message_tutor ;
if ($_SESSION['USER_T'])
	echo "<tr><td><p class='option'> Bienvenido  ". $_SESSION['USER_T']  . " <p></td></tr>";
echo "</div>";

//getRequestSession('action');
//getRequestSession('id');
//echo "la accion es ".  $_SESSION['action'] . "El id es " . $_SESSION['id']; 
?>
