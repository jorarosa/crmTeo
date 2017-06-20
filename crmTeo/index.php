<?php
require_once('configuracion.php');
header( 'Content-type: text/html; charset=utf-8' );
?>
<link rel='stylesheet' href=scripts/estilos.css >
<div class=cabecera>
	<a style="background:transparent;color:white;text-decoration:none;" href="http://ies.claradelrey.madrid.educa.madrid.org/" title="P&aacute;gina principal del IES Clara del Rey">
	<img style="float:left;height:55px;" alt="Formaci&oacute;n Profesional" title="Formaci&oacute;n Profesional" src="http://ies.claradelrey.madrid.educa.madrid.org/aulavirtual/theme/formal_white/logo_fp.jpg" />
	<span style="font-family:Verdana,Arial;font-size:10pt;">&nbsp;Formación&nbsp;en&nbsp;centros&nbsp;de&nbsp;trabajo&nbsp;y&nbsp;empleo&nbsp;</span>&nbsp;del&nbsp;<span style="font-family:Trebuchet MS,Arial;font-size:22pt;">&nbsp;IES</span><span style="font-family:Tahoma,Arial;font-size:22pt;font-weight:bold;">&nbsp;Clara&nbsp;del&nbsp;Rey&nbsp;</span>
	</a>                
</div>
<table class=ficha align=center cellpadding=10 >
<tr><td align=center>
<form action=empresa/login.php method=post><input type=image src=content/empresa.jpg></form>
<p class=titular>Somos una entidad empleadora y/o colaboradora</p>
</td></tr>
<tr><td align=center>
<form action=alumno/login.php method=post><input type=image src=content/alumno.jpg></form>
<p class=titular>Soy un alumno del IES Clara Del Rey</p></form>
</td></tr>
<tr><td align=center>
<form action=tutor/login.php method=post> <input type=image src=content/tutor.jpg></form>
<p class=titular>Soy Tutor de FCT en el IES Clara Del Rey</p>
</td></tr>
</table>
