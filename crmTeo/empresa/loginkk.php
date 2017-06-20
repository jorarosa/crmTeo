<?php
session_start();
header( 'Content-type: text/html; charset=utf-8' );
require_once('../configuracion.php');
require_once('../sharedphp/forms_functions.php');
require_once('../sharedphp/funciones.php');
global $Config;

$pag_entrada="empresa.php";//Pagina inicial cuando se pasa el login

//Do not remove. Security issue
if ( isset($_SESSION['USER_A'])){ //Estamos dentro
	echo ("<script> location.href='".$pag_entrada."'</script>");
	die();
	}
?>
<link rel='stylesheet' href=<?php echo $Config->css;?> >
<script type='text/javascript' src=../scripts/funciones.js></script>
<?php

$TABLA_LOGIN=$Config->database.".fct_empresa";
//$DATABASE=$Config->database;
//$conexion=conectar_bd($DATABASE) or die ("Base de datos no disponible, disculpe las molestias");

$acc="noop";
$error=false;
$error_text="";



if (isset($_POST['op'])){
	$acc=$_POST['op'];
	}

//Un nuevo usuario
if ($acc == 'alta'){
	$user=$_POST['email'];
	$clave=$_POST['clave'];
	$rclave=$_POST['rclave'];
	if (strlen($user)==0 || 
		strlen($clave)==0 || 
		strlen($rclave)==0){
			$error=true;
			$error_text="Debe introducir su correo electr&oacute;nico";
			$error_text.=" y la clave que desea por duplicado";
			}
	else{
		if(!ereg("[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+",$user)){
			$error=true;
			$error_text="Por favor utilice una direcci&oacute;n de correo";
			$error_text.=" v&aacute;lida";
			}
		else if ($clave != $rclave) {
			$error=true;
			$error_text="Las claves no coinciden.";
			$error_text.=" Por favor intentelo de nuevo";
			}
			else{
				$q="insert into $TABLA_LOGIN ";
				$q.="(email, clave) values ('$user','$clave')";
				if (mysqli_query_d($q)){ 
				 	//Usuario creado y autenticado
					$_SESSION['USER_A']=$user;
					//$_SESSION['CLAVE']=$clave;
					//Vamos a la aplicación
					echo ("<script> location.href='".$pag_entrada."'</script>");
					die();
					}
				else {
					$error=true;
					$error_text="No es posible realizar ";
					$error_text.=" el alta con esta";
					$error_text.=" direcci&oacute;n de correo ";
					$error_text.= $user ;
					}
				}
			}	
	}


//Recordar clave
if ($acc == 'rclave'){
	$user=$_POST['email'];
	if (strlen($user) > 0 ){
		$q="select clave from $TABLA_LOGIN where email='$user'";	
		$r=mysqli_query_d($q) or die ("Correo no hallado");
		$row=mysqli_fetch_array($r);	
		if ($row){$clave=$row[0];
			$asunto="Acceso a su cuenta";

			$mensaje="La clave para acceder a su cuenta";
			$mensaje.="en la página de FCT del IES CLARA DEL REY  es \n'".$clave."'\n\n";
			$mensaje.="Saludos.";
			//echo "La clave emailed is : $clave <br>";
			//Aqui se envia un correo electr&oacute;nico con la clave el usuario
			if(mail($user,
				$asunto,
				$mensaje,
				'From: fct@iesclaradelrey.es')){
				echo "<table align=center bgcolor=$bgcolor width=558><tr><td>";
				echo "<p>Le hemos enviado un correo";
				echo " con tu clave a ". $user."</p>" ;
				echo "</table>"; 
				}
			else{
				$error=true;
				$error_text= "No hemos podido enviar el correo con su clave a ". $user ;
				$error_text.=" Inténtelo en unos momentos</p>" ;
				}
			}
		else{
			$error=true;
			$error_text='La dirección de correo no se ha encontrado.';
			}
		}
	else{
		//$user_error=true;
		$error_text="Debes introducir tu correo electr&oacute;nico";
		$error=true;
		}
	}


//entrar a modificar
if ($acc == 'login') {
	$user=$_POST['email'];
	$clave=$_POST['clave'];
	if(strlen($user) == 0 || strlen($clave)==0 ){
		$error=true;
		$error_text="Debes introducir tu correo electr&oacute;nico y tu clave.";
		}
	else{
		$q="select clave from $TABLA_LOGIN where email='$user'";	
		$r=mysqli_query_d($q) or die ("Correo o clave err&oacute;neas");
		$row=mysqli_fetch_array($r);	
		$clave_hallada=$row[0];
		if($clave != $clave_hallada){
			$error=true;
			$error_text="El correo y/o la clave dados son err&oacute;neos.Por favor inténtalo de nuevo, solicita que te recordemos tu clave o date de alta.";
			}
		else {
			$_SESSION['USER_A']=$user;
			//$_SESSION['CLAVE']=$clave;
			//Vamos a la aplicación
			echo ("<script> location.href='".$pag_entrada."'</script>");
			die();
			}
		}

	}
?>
	<table align=center border=1 cols=1 width=558 cellspacing=0>
	<tr><td align=center>
		<?php echo $Config->welcome_message_empresa; ?> 
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
	<td align=center> <img src=../content/empresa.jpg> </td>
	<td align=center>

	<p>Ya estoy dado de alta y quiero entrar a mi cuenta :</p><br>

	<form method=post>
		<table align=center>
		<tr> <td align=right> Correo Electr&oacute;nico:</td><td><input name=email></td> </tr> 
		<tr> <td align=right>Clave:</td><td><input type=password name=clave> </td> </tr>
		<tr> <td colspan=2 align=center><input type=submit value=Enviar> </td> </tr>
		<input type=hidden name=action value=consultar>
		<input type=hidden name=op value=login>
		</table>
	</form>
	<p>Quiero darme de alta / Recordadme mi clave : <input type=checkbox id=alta_recuerdo_check_id
          onClick="ocultar_mostrar('alta_recuerdo_check_id','alta_recuerdo')" ></p>
	</td>
	</tr>
	</table>
	
		<table class=ficha align=center>
	<tr><td>
		<li> Su nombre de usuario es su correo electrónico 
		<li> Si no recuerda su clave solicite que se la enviemos a su correo electrónico marcando la casilla anterior y siguiendo las instrucciones.
	</ul>
	<p>La aplicación permite:</p>
		<ul>
		<li> El registro de solicitudes de alumnos para la realización de prácticas FCT
		<li> La publicación de ofertas de empleo
		<li> La búsqueda de candidatos entre los alumnos registrados y obtención de sus datos de contacto y su C.V.
	</ul>
	
        <small> En virtud de lo establecido en la Ley Orgánica
                de Protección de Datos 15/1999 y la  Ley 34/2002,
                le informamos que los datos que incluya en esta
                aplicación informática, propiedad del IES Clara del Rey,
                serán para uso exclusivo de la gestión de ofertas de empleo
                y serán tratados con estricta confidencialidad. 
         	Puede ejercer los derechos de acceso, rectificación, cancelación y oposición,
                dándose de alta o de baja de la aplicación, usted mismo, cuando desee.<br>
		Si tiene algún problema o dudas acerca de la operatoria de la aplicación ponga un correo con su consulta a bolsatrabajo@iesclaradelrey.es. Disculpe las molestias </small>
	</td></tr>
	</table>

	<br>
	<div id=alta_recuerdo>
	<table align=center class=ficha >
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
	<table align=center class=ficha >
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
<?php
mysqli_close($Config->con);
?>
<script>ocultar_mostrar('alta_recuerdo_check_id','alta_recuerdo'); </script>
