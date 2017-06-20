<?php
session_start();
header( 'Content-type: text/html; charset=utf-8' );
require_once('../configuracion.php');
require_once('../sharedphp/forms_functions.php');
require_once('../sharedphp/funciones.php');
require_once('joomla_login.php');
$pag_entrada="tutor.php";//Pagina inicial cuando se pasa el login

Function Compara($clave_hallada,$clave){

if (strpos($clave_hallada, '$P$') === 0) {
	// Use PHPass's portable hashes with a cost of 10.
	$phpass = new PasswordHash(10, true);
	$match = $phpass->CheckPassword($clave, $clave_hallada);
	return $match;
	}

else  {
	//$extpassword_hash = explode( ':', $extpassword_hash_ori); //[0] );	// Seprate main hash from salt
	$extpassword_hash = explode( ':', $clave_hallada); //[0] );	// Seprate main hash from salt
	$extpassword_hash_salt	= @$extpassword_hash[1];	//store salt
	$extpassword_hash_main = md5($clave.$extpassword_hash_salt);	//encrypted username + salt to create main hash
	$extpassword = $extpassword_hash_main.':'.$extpassword_hash_salt; // Create final password [main hash]:[salt]

	$res=(md5($clave) == $clave_hallada || $clave_hallada == $extpassword);
	return $res;
	}
}











//global $Config;
//Do not remove. Security issue
if ( isset($_SESSION['USER_T'])){ //Estamos dentro
	//require_once("tutor.php");
	echo ("<script> location.href='".$pag_entrada."'</script>");
	die();
	}
?>
<link rel='stylesheet' href=<?php echo $Config->css;?> >
<script type='text/javascript' src=../scripts/funciones.js></script>

<?php

$TABLA_LOGIN=$Config->database.".fct_tutor";
//$DATABASE=$Config->database;
//$conexion=conectar_bd($DATABASE) or die ("Base de datos no disponible, disculpe las molestias");

$acc="noop";
$error=false;
$error_text="";



if (isset($_POST['op'])){
	$acc=$_POST['op'];
	}


//entrar a modificar
if ($acc == 'login') {
	$user=$_POST['usuario'];
	$clave=$_POST['clave'];
	if(strlen($user) == 0 || strlen($clave)==0 ){
		$error=true;
		$error_text="Debes introducir tu correo electr&oacute;nico y tu clave.";
		}
	else{
		/**
		 * Modificado por Amadeo
		 * 
		 * Accede identificándose contra joomla
		 */
		$q="SELECT password, email FROM j25_users WHERE username = '$user'";
		//$q="SELECT password, email FROM jos15_users WHERE username = '$user'";
		$r=mysqli_query_d($q) or die ("Usuario o clave err&oacute;neas");
		$row=mysqli_fetch_array($r);	
		$clave_hallada=$row['password'];

		$reconocido=Compara($clave_hallada,$clave);

		if (!$reconocido){
			$error=true;
			$error_text="El usuario y/o la clave dados son err&oacute;neos.Por favor inténtalo de nuevo, solicita que te recordemos tu clave o date de alta.";
			}
		else {
			
			$_SESSION['USER_T']=$row['email'];
			$_SESSION['USER_IES']=$user;
			$_SESSION['NOMBRE_IES']=$row['username'];
			echo ("<script> location.href='".$pag_entrada."'</script>");
			die();
			}
		}

	}
?>
	<table align=center border=1 cols=1 width=558 cellspacing=0>
	<tr><td align=center>
		<?php echo $Config->welcome_message_tutor; ?> 
	</td></tr>
	</table>

	<?php 
	if ($error) {
	echo "<table align=center border=1 cols=1 width=558><tr><td><p class=errormsg >$error_text</p></td></tr></table>";
	}
	?>


	<br>
	<table class=ficha align=center>
	<tr>
	<td align=center > <img src=../content/tutor.jpg> </td>
	<td align=center>

	<p>Ya estoy dado de alta y quiero entrar a mi cuenta :</p><br>

	<form method=post>
		<table align=center>
		<!-- Amadeo
		<tr> <td align=right> Correo Electr&oacute;nico:</td><td><input name=email></td> </tr> 
		-->
		<tr> <td align=right>Usuario:</td><td><input name=usuario></td> </tr> 
		<tr> <td align=right>Clave:</td><td><input type=password name=clave> </td> </tr>
		<tr> <td colspan=2 align=center><input type=submit value=Enviar> </td> </tr>
		<input type=hidden name=action value=consultar>
		<input type=hidden name=op value=login>
		</table>
	</form>
<!-- Amadeo
	<p>Quiero darme de alta / Recordadme mi clave : <input type=checkbox id=alta_recuerdo_check_id
          onClick="ocultar_mostrar('alta_recuerdo_check_id','alta_recuerdo')" ></p>
-->
	</td></tr>
	</table>

	<br>
<!-- Amadeo
	<div id=alta_recuerdo>
	<table align=center border=1 cols=1 width=558 cellspacing=0 bgcolor=<?=$bgcolor;?> >
	<tr><td align=center>


	<p>Ya estoy dado de alta pero no recuerdo mi clave :</p>
	<form method=post>
	<table align=center><tr>
	<td align=right> Correo Electr&oacute;nico:</td><td><input name=email></td>
	</tr>
	<tr>
	<td colspan=2 align=center><input type=submit value=Enviar> </td>
	<input type=hidden name=op value=rclave>
	</tr>
	</table>
	</form>
	</td></tr>
	</table>
	<br>
	<table align=center border=1 cols=1 width=558 cellspacing=0 bgcolor=<?=$bgcolor;?> >
	<tr><td align=center>
	<p>Aún no tengo cuenta y me gustar&iacute;a darme de alta:</p>

	<form method=post>
	<table align=center><tr>
	<td align=right> Correo Electr&oacute;nico:</td><td><input name=email></td>
	</tr>
	<tr>
	<td align=right>Clave:</td><td><input type=password name=clave> </td>
	</tr>
	<tr>
	<td align=right>Repita la Clave:</td><td> <input type=password name=rclave></td>
	</tr>
	<tr>
	<td colspan=2 align=center><input type=submit value=Enviar> </td>
	<input type=hidden name=op value=alta>

	</tr>
	</table>
	</div>
	</form>
	</td></tr>
	</table>
-->
<?php
mysqli_close($Config->con);
?>
<script>ocultar_mostrar('alta_recuerdo_check_id','alta_recuerdo'); </script>
