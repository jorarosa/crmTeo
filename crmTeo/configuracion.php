<?php

class Configuration {
        var $CBO_NOSELEC = '--Elegir';
        var $CBO_INDICA = '--Otro (indica)';
        var $CBO_TODOS = '--Indistinto';
        var $CBO_TODAS = '--Indistinta';
	var $url_base = '/crm/' ; //Raiz de la aplicacion
        var $dbtype = 'mysql';
        var $host = 'localhost';
        var $database = 'crm'; //'crm_empresa';
        // var $user = 'crm'; //'fct';
		var $user = 'crm'; //'fct';
        // var $passwd = 'crm'; //'fct';
		var $passwd = 'crm2017'; //'fct';
        var $mailfrom = 'bolsatrabajo@iesclaradelrey.es';
        var $mailto = 'bolsatrabajo@iesclaradelrey.es';
        var $session_timeout = 1200;
        var $timeout_message = 'La session ha caducado por inactividad. Debe identificarse de nuevo.';
        var $sesion_cerrada = 'Session cerrada a petición suya.';
        var $cuenta_cerrada = 'Su cuenta ha sido cerrada  y sus datos eliminados de nuestros archivos.';
        var $db_message = 'La base de datos se encuentra inoperativa. Disculpe las molestias';
        var $noaccess_message = 'Necesita autorización';
        var $offline_message = 'El sitio está desactivado por tareas de mantenimiento  Por favor, vuelva más tarde.';
        var $welcome_message_empresa = '<h1>IES CLARA DEL REY. FCT y BOLSA DE EMPLEO. EMPRESAS</h1>';
        var $welcome_message_alumno = '<h1>IES CLARA DEL REY. FCT y BOLSA DE EMPLEO. ALUMNOS</h1>';
        var $welcome_message_tutor = '<h1>IES CLARA DEL REY. FCT y BOLSA DE EMPLEO. TUTORES</h1>';
	var $nullstring = 'º';
	var $documentos = '';
	var $debug_sql = false ;
	var $css = '../scripts/estilos.css' ;
	var $administrador = 'tgonzale1@gmail.com' ;
	var $con=null;
	
}
$Config = new Configuration() ; 

date_default_timezone_set("Europe/Madrid") ;

$Config->con=mysqli_connect($Config->host,
	$Config->user,
	$Config->passwd,
	$Config->database);
mysqli_set_charset($Config->con,'utf8');
require_once("jq.php");
?>
