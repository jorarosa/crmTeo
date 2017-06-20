<?php
function pie(){
echo "<hline>";

}

function asigna_si_vacio(&$a,&$b){ if ($a=="") $a=$b; }

function boton($accion,$value,$innerhtml=""){
global $Config;
echo "<form method=get action=\"" . $Config->url_base."/". $accion . "\">";
echo "<input class=ordenselected type=submit value=\"$value\">";
echo $innerhtml;
echo "</form>";
}

function debug_sql() {
	global $Config;
	if (isset($Config->debug_sql))
		return $Config->debug_sql;
	return false;
	}
/*
function mysql_query_d($q){
	global $Config;
	if ($Config->debug_sql) echo "<br>$q<br>";
	$res=mysql_query($q);
	if ($res==null && $Config->debug_sql) echo mysql_error() ;
	return $res;
	}	

function conectar_bd($base) {
	global $Config;
	$db_conn=mysql_pconnect($Config->host, $Config->user, $Config->passwd);
	if (!$db_conn) {
		echo '<h2> No se ha podido conectar con la base de datos</h2>';
		exit;
	}
	mysql_select_db($base,$db_conn);
	mysql_set_charset('utf8');
	//mysql_query("SET NAMES 'UTF-8'");
	return $db_conn;
}
*/
 
function Parametros($p){
	return BuscaBd("select ValorTexto from fct_t_parametros where parametro='$p'");
	}

function error_msg($texto){
	echo "<p class='error_msg' > $texto </p>";
	}

function do_select_tabla($nombre_var,$sql,$valor_selecc=NULL,$requerido=1,$extra=NULL) {
	global $Config;
	$s="<select class=field name=\"$nombre_var\" $extra>\n";
	switch($requerido) {
	case 1: $s.="<option value='".$Config->nullstring."' selected='1'>".$Config->CBO_NOSELEC."</option>"; break;
	case 2: break;
	default: $s.='<option value="NULL" selected="1"></option>';
	}

	$result=mysql_query_d($sql);
	while($r=mysql_fetch_array($result)) {
		if ($valor_selecc == $r['id']) {
			$s.='<option value="'.$r['id'].'" selected>'.$r['nombre'].'</option>';
		} else {
			$s.='<option value="'.$r['id'].'">'.$r['nombre'].'</option>';
		}
	}
	$s.='</select>';
	return $s;
}

function show_select_tabla($nombre_var,$sql,$valor_selecc=NULL,$requerido=1) {
	$result=mysql_query_d($sql." WHERE id='$valor_selecc'");
	$r=mysql_fetch_array($result);
	return htmlspecialchars(stripslashes($r['nombre']));
}

function do_select_matriz($nombre_var,$matriz,$valor_selecc=NULL,$requerido=1) {
	global $Config;
	$s="<select class=field name=\"$nombre_var\">\n";
	switch($requerido) {
	case 1: $s.="<option value='".$Config->nullstring."' selected='1'>".$Config->CBO_NOSELEC."</option>"; break;
	case 2: break;
	default: $s.='<option value="" selected="1"></option>';
	}
	
	foreach($matriz as $valor) {
		if ($valor_selecc == $valor) {
			$s.="<option value='$valor' selected>$valor</option>";
		} else {
			$s.="<option value='$valor'>$valor</option>";
		}
	}
	$s.='</select>';
	return $s;
	
}

function do_select_matriz_ind($nombre_var,$matriz,$valor_selecc=NULL,$requerido=1) {
	global $Config;
	$s="<select name=\"$nombre_var\">\n";
	
	switch($requerido) {
	case 1: $s.="<option value='".$Config->nullstring."' selected='1'>".$Config->CBO_NOSELEC."</option>"; break;
	case 2: break;
	default: $s.='<option value="" selected="1"></option>';
	}	
	
	foreach($matriz as $clave => $valor) {
		if ($valor_selecc == $clave) {
			$s.="<option value='$clave' selected>$valor</option>";
		} else {
			$s.="<option value='$clave'>$valor</option>";
		}
	}
	$s.='</select>';
	return $s;
}


function paginar($actual, $total, $por_pagina, $enlace1, $enlace2='') {
	$total_paginas = ceil($total/$por_pagina);
	$anterior = $actual - 1;
	$posterior = $actual + 1;
	if ($actual>1)
		$texto = "<a href=\"$enlace1$anterior$enlace2\">&lt;</a> ";
	else
 		$texto = "<b>&lt;</b> ";
	for ($i=1; $i<$actual; $i++)
	$texto .= "<a href=\"$enlace1$i$enlace2\">$i</a> ";
	$texto .= "<b>$actual</b> ";
	for ($i=$actual+1; $i<=$total_paginas; $i++)
 		$texto .= "<a href=\"$enlace1$i$enlace2\">$i</a> ";
	if ($actual<$total_paginas)
		$texto .= "<a href=\"$enlace1$posterior$enlace2\">&gt;</a>";
	else
		$texto .= "<b>&gt;</b>";
	return $texto;
}

//Crea un select con las dos primeras columnas de la consulta
//Para valor y texto de cada opcion
//name es el nombre del control
//selected es el value por defecto.

function HtmlSelect($sql,$name,$selected=" "){
	global $Config;
	$r=mysql_query_d($sql);
	echo "<select class=field name='$name' onchange='func_".$name."();' ><br>\n";
	$ro=mysql_fetch_row($r);
	echo "<option value='".$Config->nullstring."'>".$Config->CBO_NOSELEC."</option>";
	while ($ro){
		echo "<option value='".$ro[0];
		if($ro[0]==$selected) echo "' selected >";	
		else echo "'>";
		echo $ro[1]."</option><br>\n";
		$ro=mysql_fetch_row($r);
		}
	echo "</select>\n";
	}

//Crea un select con las claves, valores del array asociativo 
//name es el nombre del control
//selected es el value por defecto
/*
en forms_functions
function HtmlAsocArray($arr,$name,$selected=" "){
	global $Config;
	echo "<select class=field name='$name'><br>\n";
	echo "<option value='".$Config->nullstring."' >".$Config->CBO_NOSELEC."</option>";
	foreach($arr as $clave => $valor ){
		echo "<option value='".$clave;
		if($clave==$selected) echo "' selected >";	
		else echo "'>";
		echo $valor."</option><br>\n";
		}
	echo "</select>\n";
	}
*/
//Muestra una lista de checkboxes para seleccion multiple
//Mantiene los valores seleccionados enla session entre llamadas
function HtmlCheckboxes($sql,$name,$selectec=" "){
	global $Config;

	$r=mysql_query_d($sql);
	//echo "<select name='$name'><br>\n";
	$ro=mysql_fetch_row($r);
	//echo "<option >".$Config->CBO_NOSELEC."</option>";
	while ($ro){
		echo "<input class=field type=checkbox name='". $name ."[]'" ;
		if (isset($_REQUEST["$name"]) && in_array("$ro[0]",$_REQUEST["$name"])) echo " checked ";
		echo " value='".$ro[0]."'>";
		echo $ro[1].",\n";
		$ro=mysql_fetch_row($r);
		}
	//echo "</select>\n";

	}
function BuscaBd($sql){
	$r=mysqli_query_d($sql) or die ("Error en consulta $sql " . mysql_error()) ;
	$ro=mysqli_fetch_array($r);
	return($ro[0]);
	}
//Muestra una tabla con la opcion de eliminar en la columna izda
//Ver ejemplo en modulos/bembea.php

function HtmlDetailList($sql, 		//consulta
			$mostrar,	//Array con campos a mostrar campo=>cabecera
			$key,		//Campos a insertar en la query de la url campo_query=>columna de la sql
			$acc,		//Valor extra para la query pe. accion=ba_eliminar
			$ordentxt="Eliminar"
			){

	$r=mysql_query_d($sql) or die ("Error en consulta $sql" . mysql_error()) ;
	echo "<table class=frm border=1 cellspacing=0 cellpadding=4>";
	//Cabeceras
	echo "<tr><th>Acción</th>\n";

	foreach ($mostrar as $clave => $valor){
		echo "<th>$valor</th>";
		}

	echo "</tr>\n";


	while ($ro=mysql_fetch_array($r,MYSQL_ASSOC)){
		echo "<tr>\n";
		//La primera columna la acción
		echo "<td><a href=$SELF_PHP?";
		echo "$acc";
		foreach($key as $campo=>$valor){
			echo "&".$campo."=".$ro["$valor"];
			}
		echo ">$ordentxt</a></td>";		

		foreach ($mostrar as $clave => $valor ){
			echo "<td>".$ro["$clave"]."</td>";
			}
		echo "</tr>\n";

		}
	echo "</table>\n";
	}	

//La query en HtmlCheckList: c1 id, c2 label, c3 true si checked o false
function HtmlCheckList($sql,$prefix,$separator,$action=""){
	//echo "la query en checklist es : ".$sql."<br>";
	$r=mysql_query_d($sql);
	$ro=mysql_fetch_row($r);
	if ($action=="list"){
		while ($ro){
			if($ro[2]=='true') echo $ro[1];	
			echo "$separator";
			$ro=mysql_fetch_row($r);
			}

	}
	else{
		while ($ro){
			echo "<input type=checkbox  name='".$prefix.$ro[0]."'";
			if($ro[2]=='true') echo " checked ";	
			echo ">";
			echo "$ro[1]";
			echo "$separator";
			$ro=mysql_fetch_row($r);
			}
		}
	}

//Lo toma del request y refresca la session. si no viene lo toma de la session
function getRequestSession($name,$default=""){ 
	$valor=$default;
	if (isset ($_REQUEST[$name])){
		$valor=$_REQUEST[$name];
		$_SESSION[$name]=$valor;
		//echo "Estaba en la request lo pongo en la sesion";
		}
	else if (isset ($_SESSION[$name])){
		$valor=$_SESSION[$name];
		//echo "Estaba en la sesion";
		}
	//else echo "No ESTABA NI EN LA REQUEST NI EN LA SESSION";

	return $valor;
	}


function CalculadoraMd5(){
	echo "<form>";
	echo "<input name='frase_to_md5' size=40>";
	echo "<input type=submit value=md5>";
	echo "</form>";
	if (isset($_REQUEST['frase_to_md5'])) echo md5($_REQUEST['frase_to_md5']);
	}

//Resta la segunda a la primera
function resta_fechas($f1,$f2){
	$F1=explode("/",$f1,3);
	$F2=explode("/",$f2,3);
	$t1=mktime(0,0,0,$F1[1],$F1[0],$F1[2]);
	$t2=mktime(0,0,0,$F2[1],$F2[0],$F2[2]);

	//echo "t1 es $t1. t2 es  $t2" ;
	if ($t1 <= $t2) return "err";

	//echo (($t1-$t2)/60/60/24/30) . "meses";

	$D1=$F1[0]; $D2=$F2[0]; $M1=$F1[1]; $M2=$F2[1]; $Y1=$F1[2]; $Y2=$F2[2];


	if ($D1 < $D2 ){ //Restamos uno al mes y sumamos al dia los dias de dicho mes
       	 //Dias que tiene el mes de la fecha 1 M1
       	 //Si el mes fuera enero pasamos a diciembre del anño anterior
       	 $dias=strftime("%d",mktime(0,0,0,$M1+1,0,$Y1));
       	 $D1+=$dias;
       	 if (--$M1 == 0 ) {$M1=12;$Y1--;};
        }

	if ($M1	 < $M2 ){ $M1+=12; $Y1--; }

	$Y=$Y1-$Y2; $M=$M1-$M2; $D=$D1-$D2; 
	$diff="";
	if ($Y > 0 ) $diff.="$Y años.";
	if ($M > 0 ) $diff.="$M Meses.";
	if ($D > 0 ) $diff.="$D días.";
	return $diff;
	}

function enviar_correoX($destinatario, $asunto, $mensaje) {
	$mail_options['host']      = 'ssl://smtp.gmail.com';
	$mail_options['port']      = 465 ; // 587;
	$mail_options['auth']      = true;
	$mail_options['username']  = 'fct@iesclaradelrey.es';
	$mail_options['password']  = 'fct12345';
	
	$hdrs = array( 'From'    => 'FCT IES CLara Del Rey <fct@iesclaradelrey.es>',
	               'To'      => $destinatario,
	               'Subject' => $asunto);
	// Se usa Mail_mime() para construir un correo válido
	$mime = new Mail_mime();
	$mime->setTXTBody(strip_tags($mensaje));
	$body = $mime->get();
	$hdrs = $mime->headers($hdrs);
	$mail =& Mail::factory('smtp',$mail_options);
	$res = $mail->send($destinatario, $hdrs, $body);
	if (PEAR::isError($res)) {
		echo $res->getMessage();
		return false;
		}
	return true;
	}


function cabeceras_excel(){
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=archivo.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	}


//Pone como cabeceras los nombres de los campos
function query_to_table($titulo,$query){
	$result = mysqli_query_d($query);
	if (!$result) {
    		die(mysql_error());
		}

	$fields_num = mysqli_num_fields($result);

	echo "<table class=query_to_table><tr>";
	echo "<td colspan=$fields_num>$titulo</td>";
	//for($x=1;$x<$fields_num;$x++) echo "<td>&nbsp;</td>";
	echo "</tr><tr>";

	for($i=0; $i<$fields_num; $i++)
	{
    		$field = mysqli_fetch_field($result);
    		echo "<th>{$field->name}</th>";
		}
	echo "</tr>\n";
	// printing table rows
	while($row = mysqli_fetch_row($result))
		{
    		echo "<tr>";

    		// $row is array... foreach( .. ) puts every element
    		// of $row to $cell variable
    		foreach($row as $cell)
        		echo "<td>$cell</td>";

    		echo "</tr>\n";
		}
	echo "</table>";
	mysqli_free_result($result);
}

function check_nif_cif_nie($cif) {
 //Returns: 

 // 1 = NIF ok,

 // 2 = CIF ok,

 // 3 = NIE ok,

 //-1 = NIF bad,

 //-2 = CIF bad, 

 //-3 = NIE bad, 0 = ??? bad
 $cif = strtoupper($cif);
  
 for ($i = 0; $i < 9; $i ++){
       $num[$i] = substr($cif, $i, 1);
 }
 //si no tiene un formato valido devuelve error
 //if (!ereg('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)', $cif)){
 if (!preg_match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)', $cif)){
	//echo "El formato de $cif es incorrecto";
       return 0;
 }
 //comprobacion de NIFs estandar
 //if (ereg('(^[0-9]{8}[A-Z]{1}$)', $cif)){
 if (preg_match('(^[0-9]{8}[A-Z]{1}$)', $cif)){
// echo "La letra del nif es <b>".$num[8]."</b>";
  if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE',substr($cif, 0, 8) % 23, 1)){
   return 1;
  }else {
   return -1;
  }
 }
 //algoritmo para comprobacion de codigos tipo CIF
 $suma = $num[2] + $num[4] + $num[6];
 for ($i = 1; $i < 8; $i += 2){
       $suma += substr((2 * $num[$i]),0,1) + 
                substr((2 * $num[$i]),1,1);
 	}
 $n = 10 - substr($suma, strlen($suma) - 1, 1);
 //comprobacion de NIFs especiales (se calculan como CIFs)
 if (ereg('^[KLM]{1}', $cif)){
  if ($num[8] == chr(64 + $n)){
          return 1;
  }else{
          return -1;
  }
 }
 //comprobacion de CIFs
 if (ereg('^[ABCDEFGHJNPQRSUVW]{1}', $cif)){
  if ($num[8] == chr(64 + $n) || $num[8] == 

      substr($n, strlen($n) - 1, 1)){
   return 2;
  }else{
   return -2;
  }
 }
 //comprobacion de NIEs
 //T
 if (ereg('^[T]{1}', $cif)){
  if ($num[8] == ereg('^[T]{1}[A-Z0-9]{8}$', $cif)){
   return 3;
  }else{
   return -3;
  }
 }
 //XYZ
 if (ereg('^[XYZ]{1}', $cif)){
  if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', 

      substr(str_replace(array('X','Y','Z'), 

      array('0','1','2'), $cif), 0, 8) % 23, 1)){
   return 3;
  }else{
   return -3;
  }
 }
 //si todavia no se ha verificado devuelve error
 return 0;
} 



?>
