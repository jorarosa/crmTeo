<?php
function RequestToForm(&$fo){
	$form=&$fo['fields'];
	$error=false;
	$error_text="";
	//if debug() print_r($fo);
	//if debug() print_r($_REQUEST);
	foreach ( $form as $campo=>$valor ) {
		//Aqui pasaremos el validador
		$field_name=$fo['name']."_".$campo;
		
		if (isset($_REQUEST[$field_name])){
			$valor = $_REQUEST[$field_name];

			if(isset($form[$campo]['t']) and $form[$campo]['t']=='CHECKBOX'){ 
				if (strstr("OnonyesYesYES",$valor)) $valor=1;
				else $valor=0;
				$form[$campo]['valor']=$valor;
				}	
			if(isset($form[$campo]['max'])){ //Recorte
				//$form[$campo]['valor']=htmlentities(stripslashes(substr($_REQUEST[$campo],0,$form[$campo]['max'])));
				$form[$campo]['valor']=substr($valor,0,$form[$campo]['max']);
				//echo ($_REQUEST[$campo]. "STRIP<br>");
			}
			else{
				$form[$campo]['valor']=$valor;
				//echo ($_REQUEST[$campo]. "<br>");
			}
			//echo "Asigno $campo " . $_REQUEST[$campo] ;
		}
	}
	//print_r($form);

	return (!$error);
}


//Chequea las expresiones regulares y marca los campos errÃ³neos
//Devuelve cierto si todo esta bien
function CheckValues(&$fo){
	global $Config;
	$form=&$fo['fields'];
	$error=false;
	$error_text="";

	foreach ( $form as $campo=>$valor ) {

		//Si el campo es requerido y no esta, error
		if (isset($form[$campo]['r']) && $form[$campo]['r'] &&
				(trim($form[$campo]['valor']) =="" || $form[$campo]['valor']==$Config->nullstring))
		{
			$error=true;
			$form[$campo]['err']=true;
		}
		else if (isset($form[$campo]['m']) &&
				$form[$campo]['valor']!="" &&
				$form[$campo]['valor']!=$Config->nullstring){//Mascara puesta y valor dado
			if(!preg_match($form[$campo]['m'],
					$form[$campo]['valor'])){
				$error=true;
				$form[$campo]['err']=true;
			}
		}

		//Comprobacion adicional sobre fechas
		if(isset($form[$campo]['t']) and  $form[$campo]['t']=="DATE" && strlen($form[$campo]['valor']) > 0) {
			$s=explode("/",$form[$campo]['valor'],3);
			/*
			 if ($s[0]!=2 || $s[1]!=2 || $s[2]!=4){
			$error=true;
			$form[$campo]['err']=true;
			}
			*/
			if (!checkdate($s[1],$s[0],$s[2])){
				$error=true;
				$form[$campo]['err']=true;
			}
		}
	}
	//print_r($form);
	if($error){
		$fo['errormsg'].="Hay campos obligatorios que se han omitido,";
		$fo['errormsg'].=" o tienen valores no válidos : ";
		foreach ($form as $campo => $value) {
			if ( $form[$campo]['err'] ){
				if (isset( $form[$campo]['l']))
				$fo['errormsg'].=(", ".$form[$campo]['l']);
				else $fo['errormsg'].=(", ".$campo);
				}
		}
	}
	return (!$error);
}

function LimpiarForm(&$fo,$clear=false){
	global $Config;
	if($Config->debug_sql) echo "Entrando en Limpiar ". $fo['name'] ."<br>";
	$form=&$fo['fields'];
	foreach ( $form as $campo=>$valor ) {
		if (isset($form[$campo]['de']) and !$clear){//Valor por defecto puesto
			$form[$campo]['valor']= $form[$campo]['de'];
		}
		else {
			$form[$campo]['valor']="";
		}
	}
	$fo['filas']=0;
	$fo['query']="";
	$fo['where']="";
	$fo['errormsg']="";
	$fo['statusmsg']="";
//	$fo['resultset']=false;
}

function ShowErrorMsg(&$fo){
	if (isset($fo['errormsg'])) echo $fo['errormsg'];
	}

function ShowStatusMsg(&$fo){
	echo $fo['statusmsg'];
}

function InputOrShow($edit,&$fo,$campo,$separador="</td><td>",$label=true){
	$f=&$fo['fields'];
	$readonly=false;

	if (isset($f[$campo]['ro'])) $readonly=$f[$campo]['ro'];

	if ($edit & !$readonly) Input($fo,$campo,$separador,$label);
	else Show($fo,$campo,$separador,$label);
}

//MUestra el valor del campo como Input pero sin edicion
function Show(&$fo,$campo,$separador="</td><td>",$label=true){
	global $Config;
	$f=&$fo['fields'];
	$field_name=$fo['name']."_".$campo ;
	//$con=$fo['con'];
	if ($label){
		$title="";
		if (isset($f[$campo]['T'])) $title=" title='".$f[$campo]['T']."'";
		echo "<span class='label'".$title.">".$f[$campo]['l']."</span>"; //Etiqueta
	}
	if(strlen($f[$campo]['l'])>0) echo $separador;

	if(!isset($f[$campo]['t']) || ($f[$campo]['t']=='TEXT') || ($f[$campo]['t']=='DATE')){
		echo "<span name='$campo' class='tedtext'> ";
		if (isset($f[$campo]['max']))
			echo stripslashes(substr($f[$campo]['valor'],0,$f[$campo]['max']));
		else echo $f[$campo]['valor'];
		echo "</span>";
	}

	else if($f[$campo]['t']=='HTML' ){
		echo $f[$campo]['html_show'];
	}

	else if ($f[$campo]['t']=='TEXTAREA'){
		echo "<span name='$campo' class='textarea'> ";
		//echo nl2br($f[$campo]['valor']);
		//echo stripslashes(substr($f[$campo]['valor'],0,$f[$campo]['max']));
		echo htmlentities(stripslashes(substr($f[$campo]['valor'],0,$f[$campo]['max'])),0,'UTF-8');
		echo "</span>";
	}

	else if ($f[$campo]['t']=='HIDDEN'){
	}

	else if ($f[$campo]['t']=='COMBO'){

		if (isset($f[$campo]['ql'])){
			echo  "<span name='$campo' class='tedtext'>".stripslashes($f[$campo]['valor'])."</span>"; //valor selected
		}

		else if (isset($f[$campo]['qll'])){
			$clave=$f[$campo]['valor'];
			echo   "<span name='$campo' value='$clave' class='tedtext'>".$f[$campo]['qll'][$clave]. "</span>"; //valor selected
		}

		else if(isset($f[$campo]['qs'])){ //Query para mostrar (Show)
			$id_key=$f[$campo]['valor'];
			$q="select *  from (".$f[$campo]['qs'].") t where t.id=$id_key"; 
			//echo "La query es $q";
			$fila=NULL;
			if ($r=mysqli_query_d($q))
				$fila=mysqli_fetch_row($r);
			if ($fila[0]==$id_key) echo  "<span value='$id_key' class='tedtext'>".$fila[1]."</span>";
			else echo  "<span name='$campo' value='$Config->nullstring' class='tedtext'></span>";
			}

		else if(isset($f[$campo]['q'])){ //Si no hay query para mostrar usamos la de elegir
			$q=$f[$campo]['q'];
			//echo "La query es $q";
			$r=mysqli_query_d($q);
			$encuentra=false;
			while ($fila=mysqli_fetch_row($r)){
				if ($fila[0]==$f[$campo]['valor']) {
						echo  "<span name='$campo' value='".$fila[0]."' class='tedtext'>".$fila[1]."</span>";
						$encuentra=true;
						}
			if(!$encuentra)  echo  "<span name='$campo' value='$Config->nullstring' class='tedtext'></span>";
			}
		}

		else if (isset($f[$campo]['qj'])){ //Se trata del nombre de una funcion javascript
			echo "<script>".$f[$campo]['qj']."('".$f[$campo]['valor']."','".$campo."',false);</script>" ; //pasando como parametro el valor y el nombre. Combo de paises
		}
		else {
			echo "Error, COMBO".$campo."q ni ql ni qll";
			return;
		}
	}

	else if ($f[$campo]['t']=='CHECKLIST'){
		HtmlCheckList($f[$campo]['q'],$campo,$f[$campo]['sep'],"list");
	}

	else if ($f[$campo]['t']=='CHECKBOX'){
		if ($f[$campo]['valor'] == 1 ) $valor= "Si" ;
		else if ($f[$campo]['valor'] == 0 ) $valor="No" ;
		else $valor= "X" ;
		echo "<span name='$campo' class='tedtext'>$valor</span> ";
		}

	else {
		echo "Tipo no conocido"; //Tipo de campo no conocido
	}

}






//$fo es la descripcion de un formulario y $campo es el nombre campo
function Input(&$fo,$campo,$separador="</td><td>",$label=true){

	$f=&$fo['fields'];
	$field_name=$fo['name']."_".$campo ;

	//Calculo la clase del campo field field_r field_consultable field_error
	$clase="field";
	//$clase_c="field";

	if (isset($f[$campo]['r']) and $f[$campo]['r']){//Required
		$clase="field_r";
		//$clase_c="combo_r";
	}

	if (isset($f[$campo]['co']) and $f[$campo]['co']){//Consultable
		$clase="field_c";
		//$clase_c="combo_c";
	}

	if (isset($f[$campo]['err']) and $f[$campo]['err']){
		$f[$campo]['err']=false;
		$clase="field_e";
		//$clase_c="combo_e";
	}

	if(isset($f[$campo]['Pre_Show'])){
		eval($f[$campo]['Pre_Show']);;
	}

	if ($label) {
		$title="";
		if (isset($f[$campo]['T'])) $title=" title='".$f[$campo]['T']."'";
		echo "<span class='label'".$title.">".$f[$campo]['l']."</span>"; //Etiqueta
	}

	if(strlen($f[$campo]['l'])>0) echo $separador;


	if(!isset($f[$campo]['t']) || ($f[$campo]['t']=='TEXT') || ($f[$campo]['t']=='DATE' )){

		echo "<input name='".$field_name."' class=$clase ";
		echo " id=\"".$field_name."_".$f[$campo]['t']."\" ";
		echo " value=\"".$f[$campo]['valor']."\" ";
		if (isset($f[$campo]['s'])){ //Atributo size
			echo "size='".$f[$campo]['s']."' ";
		}
		if (isset($f[$campo]['max'])){ //atributo maxlengt
			echo "maxlength='".$f[$campo]['max']."' ";
		}

		if (isset($f[$campo]['ro'])){ //atributo read only
			echo " disabled ";
		}
		echo ">\n";
	}

	if(isset($f[$campo]['t']) and $f[$campo]['t']=='HTML'){
		echo $f[$campo]['html_input'];
	}

	if(isset($f[$campo]['t']) and $f[$campo]['t']=='PASSWORD'){
		echo "<input class=field type=password name='".$field_name."' class=$clase ";
		echo "value=\"".$f[$campo]['valor']."\" ";
		if (isset($f[$campo]['s'])){ //Atributo size
			echo "size='".$f[$campo]['s']."' ";
		}
		if (isset($f[$campo]['max'])){ //atributo maxlengt
			echo "maxlength='".$f[$campo]['max']."' ";
		}
		echo ">\n";
	}

	if(isset($f[$campo]['t']) and $f[$campo]['t']=='HIDDEN'){
		echo "<input type=hidden name='".$field_name."' ";
		echo " id=\"".$field_name."_".$f[$campo]['t']."\" ";
		echo "value=\"".$f[$campo]['valor']."\" ";
		echo ">\n";
	}

	else if (isset($f[$campo]['t']) and $f[$campo]['t']=='COMBO'){
		//echo "<div class=$clase_c > ";


		$htmlatt="";
		if (isset($f[$campo]['htmlatt'])) $htmlatt=$f[$campo]['htmlatt'];

		if(isset($f[$campo]['q'])){
			HtmlSelecti($f[$campo]['q'], 	//query
			$field_name,		//nombre
			$f[$campo]['valor'],
			"class=$clase $htmlatt"); //Valor selected
		}
		else if (isset($f[$campo]['ql'])){
			HtmlArray( $f[$campo]['ql'], //lista valores
					$field_name,
					$f[$campo]['valor'],
					"class=$clase $htmlatt"); //valor selected
		}
		else if (isset($f[$campo]['qll'])){ //Se trata de un array asociativo
			//echo "Con HtmlAsocArray";
			HtmlAsocArray($f[$campo]['qll'], //Array asociativo
			$field_name, //Nombre del control
			$f[$campo]['valor'],"class=$clase $htmlatt"); //Valor selected
		}
		else if (isset($f[$campo]['qj'])){ //Se trata del nombre de una funcion javascript
			echo "<script>".$f[$campo]['qj']."('".$f[$campo]['valor']."','".$field_name."',true);</script>" ; //pasando como parametro el valor y el nombre. Combo de paises, y la opcion de edicion
		}
		else {
			echo "Error, COMBO".$campo."q ni ql ni qll ni qj";
			return;
		}
		//echo "</div>";
	}
	else if (isset($f[$campo]['t']) and $f[$campo]['t']=='TEXTAREA'){
		echo "<textarea ".$f[$campo]['htmlatt']." name='".$field_name."' class=$clase onKeyUp='return ismaxlength(this)' " ;

		if (isset($f[$campo]['max'])){ //atributo maxlengt
			echo "maxlength='".$f[$campo]['max']."' ";
		}

		echo " >";
		//echo $f[$campo]['valor'];
		echo htmlentities(stripslashes(substr($f[$campo]['valor'],0,$f[$campo]['max'])),0,'UTF-8');
		//echo stripslashes(substr($f[$campo]['valor'],0,$f[$campo]['max']));
		echo "</textarea>\n";
	}

	else if (isset($f[$campo]['t']) and $f[$campo]['t']=='CHECKLIST'){
		HtmlCheckList($f[$campo]['q'],$field_name,$f[$campo]['sep']);
	}

	else if (isset($f[$campo]['t']) and $f[$campo]['t']=='CHECKBOX'){
		echo "<input type=checkbox name='".$field_name."' class=$clase ";
		if ($f[$campo]['valor'] == 1 ) echo "checked" ;
		if (isset($f[$campo]['ro'])){ //atributo read only
			echo " disabled ";
		}
		echo ">\n";
		}


}

//Crea y ejecuta la insert con los datos del formulario
//Devuelve cierto si va bien o falso si mal

function FormToBdAlta(&$fo){
	global $Config;
	$form=&$fo['fields'];
	$tabla=$fo['table'];
	$q="insert into $tabla (";
	$x=0;
	foreach ($form as $clave=>$valor){
		if(isset($form[$clave]['ac']) and $form[$clave]['ac']){ //Solo si el campo es act
			if ($x++>0) $q.=",";
			$q.=$clave;
		}
	}
	$q.=") values (";
	$x=0;
	foreach ($form as $clave=>$valor){
		if(isset($form[$clave]['ac']) and $form[$clave]['ac']){ //Solo si el campo es act
			if ($x++>0) $q.=",";
			if (isset($form[$clave]['t']) and $form[$clave]['t'] == "DATE" && $valor['valor']!=""){//Convertir a YYYY-MM-DD
				$s=explode("/",$valor['valor'],3);
				$am_date=$s[2]."-".$s[1]."-".$s[0];
				$q.="'".$am_date."'";
			}
			else { //Caso general
				if ($Config->nullstring == $valor['valor'] || $valor['valor']=="") $q.="NULL";
				else $q.="'".addslashes(html_entity_decode($valor['valor'])) . "'";
			}
		}
	}
	$q.=") ";
	//echo "LA insert es $q <br>";
	//echo "<script> alert('La query es ". addslashes($q) ."')</script>" ;

	if (! mysqli_query_d($q)) {
		$fo['errormsg']="Error realizando la inserción. Contacte con el técnico (". mysqli_error($Config->con).")";
	}
	else { //Recogemos el lastid y lo ponemos en el formulario campo id. Registramos el acceso
		$re=mysqli_query_d("select last_insert_id();");
		$row=mysqli_fetch_row($re);
		$form['id']['valor']=$row[0];
		//echo "El last id es $row[0]";
		$fo['statusmsg']="Registros insertados : ". mysqli_affected_rows($Config->con);
		//registra_acceso($tabla,$row[0],"IN"); //Registro del acceso
	}
}

//Construye la query en base a los campos consultables del formulario y efectua la consulta
function FormQuery(&$fo,Form_iterator &$it=null){
	global $Config;
	if ($Config->debug_sql ) echo "Entrando en FormQuery ".$fo['name']."<br>\n";
	$form=&$fo['fields'];
	$name=$fo['name'];
	$tabla=$fo['table'];
	global $Config;
	$q="select ";
	$x=0;

	$campos_query="";
	foreach ($form as $clave=>$valor){
		//if(isset($form[$clave]['co']) && $form[$clave]['co'] ){ //Solo si el campo es co
		if((isset($form[$clave]['bd']) and $form[$clave]['bd'] ) || isset($form[$clave]['calc']) ){ //Solo si el campo tiene reflejo en la bd
			if ($x++>0) $campos_query.=",";
			//if ($form[$clave]['t']=='DATE'){ $campos_query.="DATE_FORMAT($clave,'%d/%c/%y')"; }else
			$t=$tabla; //Por defecto el campo es de la tabla principal
			if (isset($form[$clave]['tabla'])) $t=$form[$clave]['tabla'] ;
			if(isset($form[$clave]['calc']))$campos_query.=$form[$clave]['calc'];
			else $campos_query.="$t.$clave";
		}
		
	}

	if (strlen ($campos_query) > 0 ) $q.=$campos_query ;
	else{ //Error ningun campo del formulario tiene bd a true
		echo "Error formando la query. ningun campo del formulario tiene el atributo bd a true";
		//return null;
	}

	$q.=" from " . $tabla ;
	if ( isset($fo['joins']) and strlen ($fo['joins']) > 0 )
 		$q.=" ". $fo['joins'] ." "; 

	$query=$q;

	$where="";
	$x=0;
	foreach ($form as $clave=>$valor){
		if(isset($form[$clave]['co']) && $form[$clave]['co'] && strlen($valor['valor'])>0 && $valor['valor'] != $Config->nullstring){ //Solo si el campo es co y tiene algo en valor
			if ($x++>0) $where.=" and ";


			if (isset($form[$clave]['t']) and $form[$clave]['t']=='DATE'){
				//echo $valor;
				$s=explode("/",$valor['valor'],3);
				$f_am=$s[2]."-".$s[1]."-".$s[0];
				$where.=$clave." like '".addslashes(html_entity_decode($f_am)) . "'";
			}
			else {if ( strstr($valor['valor'],"%") ||  strstr($valor['valor'],"?"))
				$where.=$clave." like '".addslashes(html_entity_decode($valor['valor'])) . "'";
			else
				$where.=$clave."='".addslashes(html_entity_decode($valor['valor'])) . "'";
			}
		}
	}

	//where2 es un filtro adicional que puede ponerse por programa
	if(isset($fo['where2']) and strlen($fo['where2']) > 0 ) {
		//echo "HAY WHERE 2";
		if (strlen($where) > 0 ) $where.= " and ";
		$where.= $fo['where2'];
	}

	if(strlen($where)>0) $q.=" where " . $where ;


	if(isset($fo['order']) and strlen($fo['order']) > 0 ) {
		//echo "HAY ORDER";
		$q.=" order by " . $fo['order'] ;
	}
	/*
	 if(strlen($fo['offset'])>0 && strlen($fo['limit'])>0){ //Debemos paginar
	$q.= " limit ". $fo['offset'] . "," . $fo['limit'] ;
	}
	*/
	//echo "<script> alert('La query es ". addslashes($q) ."')</script>" ;

	$re=mysqli_query_d ($q); //Consultamos

	
	//debug_print_backtrace();

	if ($re){
		//$_SESSION[$name.'query']=$q;
		$fo['query']=$q;
		$fo['lastquery']=$q;
		$fo['where']=$where;
		$fo['filas']=mysqli_num_rows($re);
		$fo['statusmsg']=$fo['filas'] . " registros encontrados";
		$fo['indice']=0;
		if($it){
			//echo "LA QUERY ES $q";
			//echo "ACTUALIZANDO ITERADOR*****************+";
			$it->query=$q;//Actualizo el iterador si se ha dado
			//$it->indice=0;
			$it->filas=$fo['filas'];
			mysqli_free_result($re);
			$re=mysqli_query_d($it->query. " limit ".$it->indice.",".$it->length);
		}
		
	}
	else{
		$fo['errormsg']="Error realizando la consulta.";
		echo "<!-- ERROR ". mysqli_error($Config->con) . "--> ";
	}
	//Asignamos valores de la primera fila al formulario
	//$fo['resultset']=&$re;
	return $re;
}



function Primero(&$fo){
	$fo['indice']=0;
	return (Siguiente($fo,0));
}

function Ultimo(&$fo){
	$fo['indice']=$fo['filas'];
	return Siguiente($fo,0);
}

function Siguiente(&$fo,$salto){
	$name=$fo['name'];
	//$q=$_SESSION[$name.'query'];
	$q=$fo['query'];
	if ($q=="") return false;
	if (isset($fo['limit'])) $limit=$fo['limit'];
	else $limit=1;

	//echo "<br>LA query recuperada $name $q <br>";
	//$fila = $_SESSION[$name.'numrow'] + $salto;
	$fila=$fo['indice']+$salto;
	if ($fila > $fo['filas']-1) $fila= $fo['filas']-1;
	if ($fila < 0 ) $fila=0 ;
	$q.=" limit ".$fila .",".$limit ;
	//echo "LA query es $q ";
	$re = mysqli_query_d($q);
	if (mysqli_num_rows($re) > 0 ) {
		//$_SESSION[$name.'numrow']+=$salto;
		$fo['indice']=$fila;
		$fo['offset']=$fila; //Para tabla edicion
		return $re;
	}
	return false;
}

function RefrescaNumero(&$fo){
	if ($fo['query']=="") return; //Si no hay query no hay nada que hacer
	$q="select count(*) from ". $fo['table'];
	if(strlen($fo['where']) > 0 )
		$q.="where " . $fo['where'] ;

	//echo "La query es "  . $q ;
	$re=mysqli_query_d($q);
	if ($re) $row=mysqli_fetch_row($re);
	$fo['filas']=$row[0];
}


//Toma un array dinamico del resultado y lo pone en el formulario
function ResultToForm(&$form,$re){
	$row=mysqli_fetch_assoc($re);
	RowToForm($form,$row);
}

//Toma una fila de resultado  y lo pone en el formulario
function RowToForm(&$form,$row){
	if($row){
		//print_r($row);
		foreach($row as $clave=>$valor){
			if (isset($form['fields'][$clave]['t']) and $form['fields'][$clave]['t']=='DATE'){
				$s=explode("-",substr($valor,0,10),3);
				if(count($s)>2 and $s[0].$s[1].$s[2]!='00000000' && ! is_null($valor)){
					$f_esp=$s[2]."/".$s[1]."/".$s[0];
					$form['fields'][$clave]['valor']=$f_esp;
				}
				else $form['fields'][$clave]['valor']="";
			}
			else{
				$form['fields'][$clave]['valor']=$valor;
			}
		}
		//print_r($row);
		//registra_acceso($form['table'],$row['id'],"SE");
	}
}

//El formulario debe contar con el campo id, no modificable
function FormToBdBorrar(&$fo){
	global $Config;
	$error=false;
	$form=&$fo['fields'];
	$tabla=$fo['table'];
	$fo['statusmsg']="";
	$fo['errormsg']="";
	$q="delete from $tabla where id='".$form['id']['valor']."' limit 1";
	//echo "!LA QUERY ES ". $q ."<br>";
	if (! mysqli_query_d($q)) {
		$fo['errormsg']="No se puede borrar el registro. (". mysqli_error($Config->con).")";
		//print_r($fo);
		$error=true;
		}
	if ($fo['query']=="") LimpiarForm($fo);
	else $fo['statusmsg']="Registros borrados: ". mysqli_affected_rows($Config->con);
	if ($Config->con->affected_rows > 0 ){
		//registra_acceso($tabla,$form['id']['valor'],"DE");
	}
	return $error;
}

function Invoca($callback,&$form){
	return ($callback($form));
}

//El formulario debe contar con el campo id, no modificable
function FormToBdModif(&$fo){
	global $Config;
	$form=&$fo['fields'];
	$tabla=$fo['table'];
	//$fo['statusmsg']="";
	//$fo['errormsg']="";
	$q="update $tabla set ";
	$x=0;
	foreach ($form as $clave=>$valor){
		if(isset($form[$clave]['ac']) and $form[$clave]['ac'] ) {
			if ($x++>0) $q.=",";

			if ($valor['valor']!=$Config->nullstring){

				if (isset($form[$clave]['t']) and $form[$clave]['t'] == "DATE"){//Convertir a YYYY-MM-DD
					$s=explode("/",$valor['valor'],3);
					if ($s[2]){
						$am_date=$s[2]."-".$s[1]."-".$s[0];
						$q.=$clave."='".$am_date."'";
					}
					else $q.=$clave."=NULL";
				}
				else
					$q.=$clave."='".addslashes(html_entity_decode($valor['valor'])) . "'";
			}
			else  $q.=$clave."=NULL "; //Es un nulo
		}
	}
	$q.=" where id='".$form['id']['valor']."'";

	//echo "!LA QUERY ES ". $q ."<br>";
	//echo "<script> alert('La query es ". addslashes($q) ."')</script>" ;

	if (! mysqli_query_d($q)) {
		$fo['errormsg']="Error realizando la modificacion. Contacte con el técnico (". mysqli_error($Config->con).")";
		return false;
	}
	else{
		$fo['statusmsg'].="Registros modificados ".mysqli_affected_rows($Config->con);
		//registra_acceso($tabla,$form['id']['valor'],"UP"); //Registro del acceso
		return true;
	}
}

function InputNavegador(&$fo)
{
	global $Config;
	$name=$fo['name']."_action"; //nombre del formulario
	$acciones=$fo['acciones'];
	echo "<center>";
	if($fo['fields']['id']['valor'] == ""  && strstr ($acciones,"Insertar")){
		echo "<span title='Añadir el registro.Primero introduzca los valores y después pulse'><input Alt='Añadir' type=image src='".$Config->url_base."content/iconos/Add.png' class=ordenb name='".$name."_Insertar' ></span> ";
	}
	if($fo['fields']['id']['valor'] == ""  && strstr ($acciones,"Consulta")){
		echo "<span title='Consultar registros'><input type=image alt=Consultar src='".$Config->url_base."content/iconos/Refresh.png' class=ordenb name='".$name."_Consultar' ></span>";
	}

	if($fo['fields']['id']['valor'] != "" && strstr($acciones,"Actualizar")){
		echo "<span title='Salvar los cambios.Primero realice los cambios y después pulse'><input alt='Actualizar' type=image src='".$Config->url_base."content/iconos/Yes.png' class=ordenb name='".$name."_Actualizar' > </span>";
	}

	if($fo['fields']['id']['valor'] != "" && strstr($acciones,"Borrar")){
		echo "<span title='Borrar el registro'><input Alt='Eliminar' type=image src='".$Config->url_base."content/iconos/Delete.png' class=ordenb name='".$name."_Borrar' > </span>";
	}
	if (strstr($acciones,"Limpiar")){
		echo "<span title='Vacíar el formulario'><input alt='Limpiar' type=image src='".$Config->url_base."content/iconos/New.png' class=ordenb name='".$name."_Limpiar' > </span>";
	}
	if (strstr($acciones,"Cancelar")){
		echo "<span title='Cancelar la acción'><input alt='Cancelar' type=image src='".$Config->url_base."content/iconos/exclamation_green.png' class=ordenb name='".$name."_Cancelar' > </span>";
	}

	if (strstr($acciones,"Navegar")){
		if($fo['filas'] > 1 ){
		echo "<input alt='Primero' type=image src='".$Config->url_base."content/iconos/First.png' class=ordenb name='".$name."_Primero' > ";
		}

		if($fo['filas'] > 2 ){
			echo "<input alt='Anterior' type=image src='".$Config->url_base."content/iconos/Back.png' class=ordenb name='".$name."_Anterior' > ";
			echo "<input alt='Siguiente' type=image src='".$Config->url_base."content/iconos/Forward.png' class=ordenb name='".$name."_Siguiente' > ";
		}
		if($fo['filas'] > 1 ){
			echo "<input alt='Último' type=image src='".$Config->url_base."content/iconos/Last.png' class=ordenb name='".$name."_Ultimo' > ";
		}

		if ( $fo['filas'] > 0 )
			echo ($fo['indice']+1)." de ".$fo['filas'];
	}
	echo "</center>";
		}

function ManageForm(&$fo,Form_iterator $it=null){
	global $Config;
	if ($Config->debug_sql) echo "Entrando ManageForm : " . $fo['name']."</br>";
	$acciones=explode(",",$fo['acciones']);
	if(strstr($fo['acciones'],"Navegar")){ //Expandimos la mata-accion Navegar
			$acciones[]='Anterior';
			$acciones[]='Siguiente';
			$acciones[]='Primero';
			$acciones[]='Ultimo';
			}
	$action="";
	$fname=$fo['name'];
	$fo['statusmsg']="";
	$fo['errormsg']="";


	//print_r($_REQUEST);
	foreach($acciones as $acc){

		if ( isset($_REQUEST[$fname."_action_".$acc]) ||
				isset($_REQUEST[$fname."_action_".$acc."_x"])
		) {
			$_SESSION['CURRENT_MANAGED_FORM']=$fname;
			$action=$acc; break;
		}
	}

	//echo "LAccion es ". $action;

	if ($Config->debug_sql) echo "ManageForm La accion es $action";

	if( $action == 'Insertar'){
		if($it)$it->query=''; //Refresca las filas del iterador
		RequestToForm($fo);
		if (isset($fo['pre_insert'])){
			if(!call_user_func_array($fo['pre_insert'],array(&$fo))){
				$fo['error']=true;
				$fo['errormsg'].='Falla pre_insert';
				return $action;
				}
			}

		if (CheckValues($fo)){
			FormToBdAlta($fo);
			if (isset($fo['post_insert'])){
				call_user_func_array($fo['post_insert'],array(&$fo));
			}
		}
	}

	else if( $action == 'Actualizar' ){
		RequestToForm($fo);
		if (isset($fo['pre_update'])){
			if (!call_user_func_array($fo['pre_update'],array(&$fo))){
				$fo['error']=true;
				$fo['errormsg'].='Falla pre_update';
				return $action;
			}
		}

		if (CheckValues($fo))
			if (FormToBdModif($fo)){ //La actualizaciÃ³n ha funcionado,refresco el form
			if (isset($fo['post_update'])){
				call_user_func_array($fo['post_update'],array(&$fo));
			}
		}
		else { //La modificacion ha fallado
			$fo['error']=true;
			$fo['errormsg'].='No se puede modificar';
			}
	}

		

	else if( $action == 'Borrar' ){
		//RequestToForm($fo);
		if($it)$it->query=''; //Refresca las filas del iterador
		if (isset($fo['pre_delete'])){
			if (!call_user_func_array($fo['pre_delete'],array(&$fo))){
				return $action;
			}
		}

		if (! FormToBdBorrar($fo)){
			if (isset($fo['post_delete'])){
				if (!call_user_func_array($fo['post_delete'],array(&$fo))){
					return $action;
				}
			}
		}
		else { //El borrado ha fallado
			$fo['error']=true;
			$fo['errormsg'].='No se puede borrar';
			}

		RefrescaNumero($fo);
		$re=Siguiente($fo,0);
		if ($re) ResultToForm($fo,$re);

		//LimpiarForm($fo);
	}

	else if( $action == 'Consultar' ){
		RequestToForm($fo);
		$re=FormQuery($fo,$it);
		if ($re) {
			ResultToForm($fo,$re);
		}
	}

	else if( $action == 'Primero' ){
		//RequestToForm($fo);
		$re=Primero($fo);
		if ($re) ResultToForm($fo,$re);
	}

	else if( $action == 'Anterior' ){
		//RequestToForm($fo);
		$re=Siguiente($fo,-1);
		if ($re) ResultToForm($fo,$re);
	}
	else if( $action == 'Siguiente' ){
		//RequestToForm($fo);
		$re=Siguiente($fo,1);
		if ($re) ResultToForm($fo,$re);
	}
	else if( $action == 'Ultimo' ){
		//RequestToForm($fo);
		$re=Ultimo($fo);
		if ($re) ResultToForm($fo,$re);
	}
	else if( $action == 'Limpiar' ){
		LimpiarForm($fo);
	}
	if ($Config->debug_sql) echo "Finalizando ManageForm : " . $fo['name'] ." $action</br>";
	return $action;

}
//Muestra los valores del formulario, para editar o no
function OnlyShow(&$fo, $edit=true){
	global $Config;
	/*Detección de grupos atributo g de los campos*/
	if ($Config->debug_sql) echo "Entrando OnlyShow : " . $fo['name']."</br>";
	$grupos=array();	
	foreach($fo['fields'] as $campo=>$value){
		if (isset($fo['fields'][$campo]['g'])){
			$grupo=$fo['fields'][$campo]['g'];
			//Los pongo en un array asociativo para quedarme con los grupos distintos
			$grupos[$grupo]=1;
			}
		else $fo['fields'][$campo]['g']=' '; //Ausencia de grupo
		}

	$grupos[' ']=1; //Campos con ausencia de grupo
	//Las claves de grupos son los diferentes grupos que hay.
	foreach($grupos as $grupo=>$value){
		echo "<b>$grupo</b>";
		echo "<table class=ficha >\n";
		$x=1;
		foreach($fo['fields'] as $campo=>$value){
			if (isset( $fo['fields'][$campo]['g']) and $fo['fields'][$campo]['g']==$grupo )
			if (!isset($fo['fields'][$campo]['sh']) || $fo['fields'][$campo]['sh']){
				if ($x%2) echo "<tr><td align=right>";
				else echo "</td><td align=right>";
				$actu=$fo['fields'][$campo]['ac'];
				$ro= isset($fo['fields'][$campo]['ro']);
				if ($edit and $actu and !$ro) Input($fo,$campo); //Si no es actualizable o es ro no dejo editar
				else Show($fo,$campo);
				if($x%2)echo "</td><td align=right>";
				else echo "</td></tr>\n";
				$x++;
			}
		}
		echo "</table>";
	}
}

//Muestra y maneja el formulario
function DoEverything(&$fo, $form_attr=""){
	ManageForm($fo);
	echo "<form method=post $form_attr>";
	OnlyShow($fo);
	//echo "</table>";
	InputNavegador($fo);
	echo "</form>";

	echo "<table align=center>";
	echo "<tr>";
	echo "<td colspan=4 bgcolor=indianred align=center>";ShowErrorMsg($fo);echo "</td>";
	echo "</tr><tr>";
	echo "<td colspan=4 bgcolor=LightGreen  align=center>";ShowStatusMsg($fo);echo "</td>";
	echo "</tr>\n";
	echo "</table>";
}

//Si edicion es false solo muestra. no permite editar
function TablaEdicion(&$fs,$invert=false, Form_iterator $iterador=null,$edquery=null){
	global $Config;
	$form_name=$fs['name'];
	$id_editar=-1; //No se edita ningun registro
	//Form para editar el registro
	$altas=strstr($fs['acciones'],'Insertar') || strstr($f['acciones'],'Borrar');
	$edicion=$altas || strstr($fs['acciones'],'Borrar') || strstr($fs['acciones'],'Actualizar');
	//echo $fs['acciones'];
	$accion_editar=$fs['name']."_editarid";
	$key=array("id"=>$accion_editar);

	if (isset($_REQUEST[$accion_editar])){
		$id_editar=$_REQUEST[$accion_editar];
	}

	$modificar_id=$fs['name']."_insid";
	if (isset($_REQUEST[$modificar_id])){//Actualizar la edicion
		LimpiarForm($fs); //Pone los valores que corresponden (matricula)
		$fs['fields']['id']['valor']=$_REQUEST[$modificar_id];
		ManageForm($fs,$iterador);
		//if($fs['error']) return false;
		$id_editar=-1; //Apagamos la edicion, hasta que pulsen editar de nuevo
	}

	if($iterador!= null){
		if ($iterador->query!=''){//Usamos el iterador
			$r=mysqli_query_d($iterador->query. " limit ".$iterador->indice.",".$iterador->length);
		}
		else {
			$r=FormQuery($fs,$iterador);
			
		}
	}
	//Tratamiento sin iterador
	else if(isset($fs['lastquery']) and strlen($fs['lastquery'])>0) $r=mysqli_query_d($fs['lastquery']);//. " limit ".$fs['offset'].",".$fs['limit']);
	else $r=FormQuery($fs);

	//Status y error
	echo "<table id='$form_name' ><tr>";
	echo "<td colspan=4 bgcolor=indianred align=center>";ShowErrorMsg($fs);echo "</td>";
	echo "</tr><tr>";
	echo "<td colspan=4 bgcolor=LightGreen  align=center>";ShowStatusMsg($fs);echo "</td>";
	echo "</tr></table>\n";
	$action=$_SERVER['PHP_SELF']; if($edquery) $action.="?".$edquery ;
	echo "<form name='$form_name' id='$form_name' method=post action=$action OnSubmit='return check_$form_name()'>";
	if($r){
		echo "<table border=0 class=ficha align=center >";

		//Cabeceras. Si no se permite la edicion, no hay acciÃ³n
		if ($edicion)echo "<tr><th><span class=labelhead>Acción</span></th>\n";
		else echo "<tr><th><span class=labelhead></span></th>\n";

		foreach($fs['fields'] as $name=>$value){
			if ((!isset($value['sh']) || $value['sh']) and ( !isset($value['t']) or $value['t']!='HIDDEN')){
				$title="";if (isset($fs['fields'][$name]['T'])) $title="title='".$fs['fields'][$name]['T']."'" ;
				echo "<th><span class=labelhead $title >".$fs['fields'][$name]['l']."</span></th>"; //Muestro la etiqueta
			}
		}

		echo "</tr>\n";
		if ($invert){ //EL alta delante
			/* Formulario para alta */
			if ($id_editar==-1 && $altas ){ //no estamos editando
				LimpiarForm($fs);
				echo "<td>"; InputNavegador($fs); echo "</td>";

				foreach($fs['fields'] as $name=>$value){
					if (!isset($value['sh']) || $value['sh']){
						if  ($value['t']!= 'HIDDEN' ) echo "<td>";
						InputOrShow(true,$fs,$name,"",false);
						if  ($value['t']!= 'HIDDEN' ) echo "</td>";
					}
				}
				echo "</tr>\n";
			}
		}
		//Filas
		while ($ro=mysqli_fetch_array($r,MYSQL_ASSOC)){
			$editar=false;
			$ro_id=$ro['id'];
			if($ro['id']==$id_editar) {
				$editar=true;
				}
			RowToForm($fs,$ro);
			echo "<tr id='$ro_id' >\n";
			//La primera columna la acciÃ³n

			echo "<td align=center>";
			if($edicion){
				if($editar){
					InputNavegador($fs);
				}
				//Solo saco el lapiz si el formulario permite la modificacion o baja
				else  if(strstr($fs['acciones'],'Actualizar') || strstr($fs['acciones'],'Borrar')){
					echo "<a href='".$_SERVER['PHP_SELF']."?";
					foreach($key as $campo=>$valor){
						echo "&".$valor."=".$ro["$campo"];
					}
					if (strlen($edquery) > 0 ) echo "&".$edquery; //Campos adicionales al pulsar editar ?
					//echo "#$form_name"; //Esto hace cosas raras. No repite la peticion
					echo "'><img alt=Editar src='".$Config->url_base."content/iconos/Modify.png' border=0 width=24></a>";
					echo "<input type=button value='".$ro_id."' OnClick='editar(".$ro_id.");'>";
				}
			}
			echo "</td>";

			foreach($fs['fields'] as $name=>$value){
				if (!isset($value['sh']) || $value['sh']) {
					//echo "<td>".$ro[$name]."</td>";
					if  (!isset($value['t']) or $value['t']!= 'HIDDEN' ) echo "<td style='max-width:500px' >";

					if ($editar and $edicion and (!isset($value['ro']) or  !$value['ro'])) {
						Input($fs,$name,"",false);
					}
					else Show($fs,$name,"",false);
					 if  (!isset($value['t']) or $value['t']!= 'HIDDEN' ) echo "</td>";
				}
			}

			echo "</tr>\n";
		}//End While

		if (!$invert) {//Alta al final
			if ($id_editar==-1 && $altas ){ //no estamos editando
				LimpiarForm($fs);
				echo "<td>"; InputNavegador($fs); echo "</td>";
				 
				foreach($fs['fields'] as $name=>$value){
					if (!isset($value['sh']) || $value['sh']){
						if  (!isset($value['t']) or $value['t']!= 'HIDDEN' ) echo "<td>";
						InputOrShow(true,$fs,$name,"",false);
						if  (!isset($value['t']) or $value['t']!= 'HIDDEN' ) echo "</td>";
					}
				}
				echo "</tr>\n";
			}
		}
		echo "</table>\n";

		echo "<input type=hidden name='".$modificar_id."' value='".$id_editar."'>";
		echo "</form>\n";
	}
}

function SetAllFieldsProperty(&$f,$prop,$value){
	foreach($f['fields'] as $campo=>$valor){
		$f['fields'][$campo][$prop]=$value;
	}
}


//FUNCIONES UTILIZADAS EN INFORMES; LISTADOD Y FORMULARIOS
//Presenta una lista multieleccion de los campos de un formulario dado como parametro.

function form_fields_select(&$fo,array $excluir,$cab=true){
	$form=&$fo['fields'];
	$name=$fo['name'];
	$tabla=$fo['table'];
	global $Config;
	$q="select ";
	$x=0;
	//echo "<form name=$name id=$name >";
	if($cab) echo "<select class=field multiple name=$name id=$name size=8>";
	foreach ($form as $clave=>$valor){
		if(($form[$clave]['bd'] || $form[$clave]['calc'])&& !in_array($clave,$excluir)){ //Solo si el campo tiene reflejo en la bd o es calculado
			echo "<option value='".$name.".".$clave."'>".$valor['l']."</option>\n";
		}
	}
	if ($cab) echo "</select>\n";
	//echo "</form>";
}

//Dada una query sql la presenta como una tabla con cabeceras
//Si $resuelve, resuelve los valores a valores amigables utilizando el
//formulario correspondiente.
//PAra resolver cada campo pertencecera a una tabla con elmismo nombre del formulario pej festancia
//El nombre del campo en la query debe coincidir con del nombre del campo en la query. En otro caso
//No hay resoluciÃ³n.

function show_query($s,$titulo="",$resuelve=false, array $cabeceras_extra=NULL){
	$re=mysqli_query_d($s);
	//Si no hay filas no pintamos nada
	if (mysqli_num_rows($re) == 0 ) return;

	//Si hay titulo lo sacamos
	if(strlen($titulo)> 0)echo "<span class=rep2>$titulo<br></span>";
	/*
	$num_fields=mysqli_num_fields($re);

	//Creo dos arrays tabla y campo para aligerar la resolucion
	$tabla=array();$campo=array();
	for ($x=0;$x<$num_fields;$x++){
		$tabla[$x]=mysql_field_table($re,$x);
		$campo[$x]=mysql_field_name($re,$x);
	}
	*/
	$info=$re->fetch_fields();
	$x=0;
	foreach ($finfo as $val) {
		$tabla[$x]=$val->table;
		$campo[$x]=$val->name;
		$x++;
    		}



	echo "<table class=subreport border=0>\n";
	if($cabeceras_extra){
		echo "<tr bgcolor=gray >\n";
		foreach($cabeceras_extra as $key=>$value){
			echo "<th colspan='".$value."'>".$key."</th>\n";
		}
		echo "</tr>\n";
	}

	echo "<tr bgcolor=gray>";
	for ($x=0;$x<$num_fields;$x++){
		if ($resuelve){
			$fieldname=$campo[$x];
			$formulario=$tabla[$x];
			$f=&$_SESSION['forms'][$formulario];
			if($f) echo "<th class=rhfield >&nbsp;" . $f['fields'][$fieldname]['l'] . "</th>";
			else echo "<th class=rhfield >&nbsp;$fieldname</th>";
		}
		else
			echo "<th class=rhfield >&nbsp;".$campo($x)."</th>";
			//echo "<th class=rhfield >&nbsp;".mysql_field_name($re,$x)."</th>";
	}
	echo "</tr>\n";
	$count=0;
	while ($fila = mysqli_fetch_array($re)){

		$clase='class=reprow';if ($count++ % 2) $clase='class=reprowalt';
		echo "<tr $clase >";
		for ($x=0;$x<$num_fields;$x++){
			if ($resuelve){
				if (strstr($campo[$x],"@")){ //Introducido por la vista de estadisticas
					$a=explode('@',$campo[$x]);
					$fieldname=$a[1];
					$formulario=$a[0];
				}
				else{
					$fieldname=$campo[$x];
					$formulario=$tabla[$x];
				}
				$f=&$_SESSION['forms'][$formulario];
				echo "<td class=rfield >&nbsp;" . Resuelve($formulario,$fieldname,$fila[$x])  . "</td>";
			}
			else{
				echo "<td class=rfield >&nbsp;$fila[$x]</td>";
			}
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
	return $re;
}

//Crea un formulario con una checkbox por cada campo de un formulario dado
function form_fields_choose(&$fo){
	$form=&$fo['fields'];
	$name=$fo['name'];
	$tabla=$fo['table'];
	global $Config;
	$q="select ";
	$x=0;
	echo "<form name=$name id=$name >";
	echo "<table border=0>";
	foreach ($form as $clave=>$valor){
		echo "<tr>";
		if($form[$clave]['bd']){ //Solo si el campo tiene reflejo en la bd
			echo "<td align=right>";
			echo $valor['l'] ;
			echo "</td><td>";
			echo "<input type=checkbox name='".$clave."'>\n";
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	echo "</form>";
}

//Crea y devuelve una query sql con todos los campos de un formulario
//Ejemplo: crea una query basada en elformulario estancia y muestra el resultado
//$sql=form_fields($festancia);
//show_query($sql);
//El ultimo parametro se usa para obtener solamente la lista de campos
function form_fields(&$fo,array $excluir,$selectfrom=true,$alias=false){
	$form=&$fo['fields'];
	$name=$fo['name'];
	$tabla=$fo['table'];
	global $Config;
	$q="";
	if($selectfrom) $q.="select ";
	$x=0;
	foreach ($form as $clave=>$valor){
		//Solo si el campo tiene reflejo en la bd o es calculado
		if(($form[$clave]['bd'] || $form[$clave]['calc']) && !in_array($clave,$excluir)){
			if ($x++>0) $q.=",";
			if ($form[$clave]['calc']) $q.=$form[$clave]['calc'];
			else $q.=$name.".".$clave;
			//if ($alias) $q.=" as '". $form[$clave]['l']."'";
			if ($alias) $q.=" as '". $name."@".$clave."'";
		}
	}
	if($selectfrom) $q.=" from " . $tabla ." ".$name;
	return $q;
}

//Muestra el valor amigable dado un valor y un campo de formulario
//Los parametros son el nombre del formulario, el nombre del campo y el valor.
//Utilizado por show_query
function Resuelve($f_name,$campo,$valor){
	if (!isset($_SESSION['forms'][$f_name] )) return $valor;
	if (!isset($_SESSION['forms'][$f_name]['fields'][$campo] )) return $valor;
	$fo=$_SESSION['forms'][$f_name];
	$f=&$fo['fields'];

	if(!isset($f[$campo]['t']) || ($f[$campo]['t']=='TEXT') || ($f[$campo]['t']=='DATE')){
		if ($valor[4]=='-' && $valor[7]=='-'){
			$arrd=explode('-',$valor);
			return $arrd[2]."/".$arrd[1]."/".$arrd[0] ;
		}
		else return $valor;
	}

	else if ($f[$campo]['t']=='TEXTAREA'){
		return $valor;
	}
	else if ($f[$campo]['t']=='HIDDEN'){
		return "**";
	}

	else if ($f[$campo]['t']=='COMBO'){

		if (isset($f[$campo]['ql'])){
			return  $valor; //valor selected
		}

		else if (isset($f[$campo]['qll'])){
			$clave=$f[$campo]['valor'];
			return   $f[$campo]['qll'][$valor]; //valor selected
		}

		else if(isset($f[$campo]['q'])){
			$q=$f[$campo]['q'];
			//echo "La query es $q";
			$r=mysqli_query_d($q);
			while ($fila=mysqli_fetch_row($r)){
				if ($fila[0]==$valor) return  $fila[1];
			}
		}

		else if (isset($f[$campo]['qs'])){ //Se trata del nombre de una funcion javascript
			return "<script>".$f[$campo]['qs']."('".$valor."','".$campo."',false);</script>" ; //pasando como parametro el valor y el nombre. Combo de paises
		}
		else {
			echo "<!--Error, COMBO".$campo."q ni ql ni qll-->";
			return $valor ;
		}
	}

	else if ($f[$campo]['t']=='CHECKLIST'){
		//HtmlCheckList($f[$campo]['q'],$campo,$f[$campo]['sep'],"list");
		return $valor ;
		echo "<!--Tipo no visualizable-->"; //Tipo de campo no conocido
	}

	else {
		return $valor;
		echo "<!--Tipo no conocido-->"; //Tipo de campo no conocido
	}
}


//Crea los campos para el cuerpo del select basado en la lista
//de atributos basado en los formularios.LA lista debe contener
//los elementos con el formato nombre_de_formulario.nombre_de_campo
//Observa los campos calculados 'calc'. Ver form_estancia.php

function lista_to_select(array $lista){
	$q="";
	for ($i=0; $i<count($lista); $i++){
		$ff=explode(".",$lista[$i]);
		$formulario=$ff[0];
		$campo=$ff[1];
		//echo "Formulario $formulario campo $campo " ;
		$formu=&$_SESSION['forms'][$formulario];
		$etiqueta=$formu['fields'][$campo]['l'];
		//$q.= $lista[$i] . " as '".$etiqueta."'";
		if ($formu['fields'][$campo]['calc']){ //Es calculado como la estancia en meses
			if($i>0) $q.=",";
			$exp=$formu['fields'][$campo]['calc'];
			$q.= $exp;
			if (!strpos($exp,' as ')) $q.= " as '". $formu['fields'][$campo]['l']."'";
		}
		else{
			if($i>0) $q.=",";
			$q.= $lista[$i];
		}
	}
	return $q;
}


//Obtiene las columnas que ocupa el atributo y el nombre amigable para pasarlo a show query
//Devuelve un array asociativo ("Sexo"=>3, "Castellano"=>4 ) con el numero de cols que ocupa para la tabla

function cab_tabla_est($f_name,$campo){
	$cabt=array();
	if (!isset($_SESSION['forms'][$f_name] )) {
		echo "<!-- cab_estadistica Error el formulario $f_name no existe -->";
		return $cabt;
	}

	if (!isset($_SESSION['forms'][$f_name]['fields'][$campo] )){
		echo "<!-- cab_estadistica Error el campo $campo del formulario $f_name no existe -->";
		return $cabt;
	}

	$fo=$_SESSION['forms'][$f_name];
	$f=&$fo['fields'];

	if (isset($f[$campo]['l'])) $nombre_amigo=$f[$campo]['l'];
	else $nombre_amigo=$campo;


	if (isset($f[$campo]['ql'])){//Un array simple
		$arr=$f[$campo]['ql'];
		//AÃ±adimos el numero de entradas del array mas el defecto NE
		$cabt[$nombre_amigo]=count($arr) + 1 ;
	}

	else if (isset($f[$campo]['qll'])){
		$arr=$f[$campo]['qll'];
		$cabt[$nombre_amigo]=count($arr) + 1 ;
	}

	else if(isset($f[$campo]['q'])){
		$q=$f[$campo]['q'];
		$cab="";
		$valores="";
		//echo "La query es $q";
		$r=mysqli_query_d($q);
		$count=mysqli_num_rows($r);
		$cabt[$nombre_amigo]=$count+1;
	}
	return($cabt);
}

//Obtienen las cabeceras para la query SQL estadistica, dado un campo codificado
//Usado desde report
function cab_estadistica($f_name,$campo){
	$cab="";
	if (!isset($_SESSION['forms'][$f_name] )) {
		echo "<!-- cab_estadistica Error el formulario $f_name no existe -->";
		return "";
	}

	if (!isset($_SESSION['forms'][$f_name]['fields'][$campo] )){
		echo "<!-- cab_estadistica Error el campo $campo del formulario $f_name no existe -->";
		return "";
	}

	$fo=$_SESSION['forms'][$f_name];
	$f=&$fo['fields'];


	if (isset($f[$campo]['ql'])){//Un array simple
		$arr=$f[$campo]['ql'];
		$valores="";
		$ind=0;
		foreach($arr as $value){
			if($ind++ > 0){
				$cab.=","; $valores.=",";
			}
			//$cab.=" sum(if (".$f_name.".".$campo."='".$value."',1,0)) as '".$value."' ";
			$cab.=" concat(sum(if (`".$f_name."@".$campo."`='".$value."',1,0)),'(',  ";
			$cab.=" concat(round((sum(if (`".$f_name."@".$campo."`='".$value."',1,0)))/count(*)*100,1),'%)') ) as '".$value."' ";
			$valores.="'".$value."'";
		}
		//AÃ±adimos el caso default NE
		//$cab.=", sum(if (".$f_name.".".$campo." not in (".$valores.") or ".$f_name.".".$campo." is null ,1,0)) as NE ";
		$cab.=", concat(sum(if (`".$f_name."@".$campo."` not in (".$valores.") or `".$f_name."@".$campo."` is null ,1,0)),'(',concat(round((sum(if (`".$f_name."@".$campo."` not in (".$valores.") or `".$f_name."@".$campo."` is null ,1,0)))/count(*)*100,1),'%)')) as NE ";
	}

	else if (isset($f[$campo]['qll'])){
		$arr=$f[$campo]['qll'];
		$valores="";
		$ind=0;
		foreach($arr as $key => $value){
			if($ind++ > 0){
				$cab.=","; $valores.=",";
			}
			//$cab.=" sum(if (".$f_name.".".$campo."='".$key."',1,0)) as '".$value."' ";
			$cab.=" concat(sum(if (`".$f_name."@".$campo."`='".$key."',1,0)),'(',  ";
			$cab.=" concat(round((sum(if (`".$f_name."@".$campo."`='".$key."',1,0)))/count(*)*100,1),'%)') ) as '".$value."' ";
			$valores.="'".$key."'";
		}
		//$cab.=", sum(if (".$f_name.".".$campo." not in (".$valores.") or ".$f_name.".".$campo." is null ,1,0)) as NE ";
		$cab.=", concat(sum(if (`".$f_name."@".$campo."` not in (".$valores.") or `".$f_name."@".$campo."` is null ,1,0)),'(',concat(round((sum(if (`".$f_name."@".$campo."` not in (".$valores.") or `".$f_name."@".$campo."` is null ,1,0)))/count(*)*100,1),'%)')) as NE ";
	}

	else if(isset($f[$campo]['q'])){
		$q=$f[$campo]['q'];
		$cab="";
		$valores="";
		//echo "La query es $q";
		$r=mysqli_query_d($q);
		$ind=0;
		while ($fila=mysqli_fetch_row($r)){
			if($ind++ > 0){
				$cab.=","; $valores.=",";
			}
			//$cab.=" sum(if (".$f_name.".".$campo."='".$fila[0]."',1,0)) as '".$fila[1]."' ";
			$cab.=" concat(sum(if (`".$f_name."@".$campo."`='".$fila[0]."',1,0)),'(',  ";
			$cab.=" concat(round((sum(if (`".$f_name."@".$campo."`='".$fila[0]."',1,0)))/count(*)*100,1),'%)') ) as '".$fila[1]."' ";
			$valores.="'".$fila[0]."'";
		}
		//$cab.=", sum(if (".$f_name.".".$campo." not in (".$valores.") or ".$f_name.".".$campo." is null ,1,0)) as NE ";
		$cab.=", concat(sum(if (`".$f_name."@".$campo."` not in (".$valores.") or `".$f_name."@".$campo."` is null ,1,0)),'(',concat(round((sum(if (`".$f_name."@".$campo."` not in (".$valores.") or `".$f_name."@".$campo."` is null ,1,0)))/count(*)*100,1),'%)')) as NE ";
	}
	return($cab);
}

//Iterador para formularios, contiene la query el indice actual y la altura (lentgh)
class Form_iterator {
	public	$indice;
	public $query;
	public $length;
	public $filas;
	public $iterator_name='iterator_name';
	//        	private $form;
	public
	function Form_iterator($name,$len=10){
		$this->iterator_name=$name;
		$this->indice=0;
		$this->length=$len;
		$filas=0;
		//$last_query=$fs['lastquery'];
	}
	function PagAv(){
		if (($this->indice + $this->length) < $this->filas ) $this->indice=$this->indice+$this->length;
	}
	function PagRe(){
		if (($this->indice - $this->length) >= 0) $this->indice=$this->indice-$this->length;
		else $this->indice=0;
	}

	public static function factory($name='',$len){
		session_start();

		if(isset($_SESSION[$name]) === TRUE ){
			$i=unserialize($_SESSION[$name]);
			if (isset($_REQUEST["_f_it_".$name."_Av"]) or 
					isset($_REQUEST["_f_it_".$name."_Av_x"])) $i->PagAv() ;
			if (isset($_REQUEST["_f_it_".$name."_Re"]) or  
					isset($_REQUEST["_f_it_".$name."_Re_x"])) $i->PagRe() ;
			$i->length=$len; //Ajusta la longitud
			return $i;
		}
		//echo "Creando el iterador  " . $name;
		return new Form_iterator($name,$len);
	}
	
	public function show(){ //muestra el control si superamos el no de filas
			//print_r($this);
		global $Config;

		if ($this->filas > $this->length ){
			echo "<form method=post>";

			echo "<div style='width: 300px;' >";
		
			echo "<input style='float: left;' type=image src='".$Config->url_base."content/iconos/Back.png' value=Re name=_f_it_".$this->iterator_name."_Re >";

			echo  "<div class=iterator_text >" . ($this->indice+1) . " a "; 
		
			if (($this->indice+$this->length) > $this->filas )echo ($this->filas);
			else echo ($this->indice+$this->length);
			echo " de " . $this->filas ;
			echo "</div>";

			echo "<input style='float: left;' type=image src='".$Config->url_base."content/iconos/Forward.png' value=Av name=_f_it_".$this->iterator_name."_Av >";

			echo "</div>";

			echo "</form>";
			}
		
	}

	public function __destruct(){
		$_SESSION[$this->iterator_name]=serialize($this);
	}
}

function HtmlSelecti($sql,$name,$selected, $extra=""){
        global $Config;
	$return=false;
        $r=mysqli_query($Config->con,$sql);
        echo "<select name='$name' $extra ><br>\n";
        $ro=mysqli_fetch_row($r);
        echo "<option value='".$Config->nullstring."' >".$Config->CBO_NOSELEC."</option>";

        while ($ro){
                echo "<option value='".$ro[0];
                if($ro[0]==$selected){ echo "' selected >"; $return=true;}
                else echo "'>";
                echo $ro[1]."</option><br>\n";
                $ro=mysqli_fetch_row($r);
                }

	//if(! $return and $selected != '' ) echo "<option value='$selected' selected>$selected</option><br>\n";

        echo "</select>\n";
	return $return;
        }

function HtmlAsocArray($arr,$name,$selected,$extra){
        global $Config;
        echo "<select $extra name='$name'><br>\n";
        echo "<option value='".$Config->nullstring."' >".$Config->CBO_NOSELEC."</option>";
        foreach($arr as $clave => $valor ){
                echo "<option value='".$clave;
                if($clave==$selected) echo "' selected >";
                else echo "'>";
                echo $valor."</option><br>\n";
                }
        echo "</select>\n";
        }
function HtmlArray($matriz,$nombre_var,$valor_selecc,$extra=NULL) {
        global $Config;
        $s="<select $extra name=\"$nombre_var\">";
        $s.="<option value='".$Config->nullstring."' >".$Config->CBO_NOSELEC."</option>";

        foreach($matriz as $valor) {
                if ($valor_selecc == $valor) {
                        $s.="<option value=\"$valor\" selected>$valor</option>";
                } else {
                        $s.="<option value=\"$valor\">$valor</option>";
                }
        }
        $s.='</select>';
        echo $s;
	}


//Pone como cabeceras los nombres de los campos

function query_to_table_i($con,$titulo,$query,$ngroup=0){
        $result = mysqli_query($con,$query);
        if (!$result) {
                die("Fallo en la consulta $query");
                }

        $fields_num = mysqli_num_fields($result);

        echo "<table class='query_to_table'><tr>";
        echo "<td class='cabecera' colspan=$fields_num>". $titulo."  (".$result->num_rows .")</td>";
        //for($x=1;$x<$fields_num;$x++) echo "<td>&nbsp;</td>";
        echo "</tr><tr>";
        for($i=0; $i<$fields_num; $i++)
        {
                $field = mysqli_fetch_field($result);
                echo "<th>{$field->name}</th>";
                }
        echo "</tr>\n";

        // printing table rows
        $row_even=0;
	$cabecera="";
	$cabecera_ant="";
        while($row = mysqli_fetch_row($result))
                {
		//Agrupacion de cabeceras
		$cabecera="";
		for($i=0;$i<$ngroup;$i++)
			$cabecera.=$row[$i]." ";

		if($ngroup>0 and $cabecera != $cabecera_ant ){
			echo "<tr class='qtt_group' ><td class='qtt_group' colspan=$fields_num>";
			echo $cabecera;
			echo "</td></tr>";
			$cabecera_ant=$cabecera;
			}

                if (($row_even++ % 2) == 0 ) $class='par';
		else $class='impar';

                echo "<tr class='$class' >";

                // $row is array... foreach( .. ) puts every element
                // of $row to $cell variable
        	for($i=0; $i<$ngroup; $i++)
                   echo "<td class=blanco >"."&nbsp;"."</td>";

        	for($i=$ngroup; $i<$fields_num; $i++)
                   echo "<td class='$class' >".$row[$i]."</td>";

                echo "</tr>\n";
                }
        echo "</table>";
        mysqli_free_result($result);
}

function query_to_labels_i($query,$cols=2,$table_par=""){

	global $Config;

        $result = mysqli_query_d($query);
        if (!$result) {
                die("Fallo en la consulta $query");
                }

        $fields_num = mysqli_num_fields($result);

	echo "<table $table_par cols=$cols border=1 width=100% ><tr>";


	$row_i=0;

        while($row = mysqli_fetch_row($result)){
		//Agrupacion de cabeceras
                echo "<td>";
        	for($i=0; $i<$fields_num; $i++)
                	echo $row[$i];
	 	echo "</td>";

                if ((++$row_i % $cols)==0) echo "</tr><tr>\n";
                }

        echo "</tr></table>";
        mysqli_free_result($result);
	}


//Toma el valor del reuqest y lo mantiene en la sesion hasta que cambie.
//Si no viene ni esta en la sesion toma $def por defecto
function RequestSession($request_var,$def){
	if (isset($_REQUEST[$request_var])){ //Si viene en elrequest refrescamos en la sesion
		$_SESSION['sticky_'.$request_var]=$_REQUEST[$request_var] ;
		}
	if (! isset($_SESSION['sticky_'.$request_var])) 
		$_SESSION['sticky_'.$request_var] = $def ;

	return $_SESSION['sticky_'.$request_var] ;
}

//Ejecuta una query perro tiene en cuenta el flag de depuracion
function mysqli_query_d($q){
        global $Config;
        if ($Config->debug_sql) echo "<br>$q<br>";
	//debug_print_backtrace();
        $res=mysqli_query($Config->con, $q);
        if ($res==null && $Config->debug_sql) echo mysqli_error($Config->con) ;
        return $res;
        }

//Analiza una tabla y devuelve el codigo php
//para la creación de un formulario

function automatic_form($tabla){
	$cad="";
	$form_name="form_$tabla";
	$persistente=false;
	$result=mysqli_query_d("SELECT * FROM $tabla limit 1 ");
	if(!$result) return "Error en la consulta";

	$row=mysqli_fetch_row($result);

	$cad .= <<< EOT
	\$$form_name = array(
		"name"=>"form_$tabla",
		"table"=>"$tabla",
		"filas"=>0, "indice"=>0, "query"=>"","where"=>"", "errormsg"=>"", "statusmsg"=>"",
		//"pre_update"=>"PreUpdate",
		//"pre_insert"=>"PreInsert",
		//"pre_delete"=>"PreDelete",
		//"post_update"=>"PostUpdate",
		//"post_insert"=>"PostInsert",
		//"post_delete"=>"PostDelete",
		"acciones"=>"Actualizar,Insertar,Borrar,Cancelar",//Consultar,Limpiar,Navegar,Numero",
		"fields"=>array(
EOT;
	$campos="";
	$fi=mysqli_fetch_fields($result);
	//print_r($fi;
	foreach($fi as $value){
		//print_r($value);
		$len=$value->length;if ($len > 20) $len=20; 
		$max=$value->length;
		//echo "$len $max <br>";
		$name=$value->name;
		if (!in_array($name, array("id"))) $ac="true";
		else $ac="false";
		$strfield= <<< EOT
			"$name"=>array("l"=>"$name:",
				"bd"=>true,
				"co"=>false,
				"t"=>"TEXT",
				"s"=>$len,
				"max"=>$max,
				"ac"=>$ac,
				"err"=>false,
				"r"=>false,
				"sh"=>true,
				"valor"=>"")
EOT;
		if( strlen($campos) > 0 )  $campos.=",";
		$campos=$campos ."\n\n". $strfield ;
		}
	
	$cad.="$campos
		)
	);


	/* 
	function PreUpdate (&\$f){
		print_r(\$f);
		}
	*/";

	return $cad;
	}
?>
<script>
function editar(id){
alert("Editando : " + id );
}
</script>
