<link href="<?php echo $Config->url_base ?>/content/js/css/jquery-ui.css" rel="stylesheet">
<script src="<?php echo $Config->url_base ?>/content/scripts/funciones.js"></script>
<script src="<?php echo $Config->url_base ?>/content/js/jquery.js"></script>
<script src="<?php echo $Config->url_base ?>/content/js/jquery-ui.js"></script>
<script src="<?php echo $Config->url_base ?>/content/js/calendario.js"></script>

<script type="text/javascript">
$(document).ready(function() {
   // Calendario a los campos de tipo DATE
   $("input[id*='_DATE']").datepicker();

   //Script de confirmación de los borrados
   $("input[name*='_action_Borrar']").click(function(e){
		var name=this.name;
		e.preventDefault();
		if (confirm("Esto borrará el registro")){	
			$(this.form).append("<input name="+this.name+"_x value=10>");
			this.form.submit();
			}
		})	
	});
</script>
