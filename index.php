<?php

include('vms.php');

$visitor = new vms();

if($visitor->is_login())
{
	header("location:".$visitor->base_url."inicio.php");
}

include('header.php');

?>
	


<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
     <title>SGV-GORE</title>
     <link rel="stylesheet" href="css/vaidroll.css">	
</head>
<body>
	
<div class="cajafuera" align="center">
<div class="formulariocaja">

<form method="post" id="login_form" name="vaidrollteam">

<img src="images/logo.png">


<input type="text" name="user_email" id="user_email" placeholder="&#128100; Usuario" class="form-control cajaentradatexto" required data-parsley-type="email" data-parsley-trigger="keyup">


<input type="password" name="user_password" placeholder="&#128274; Contraseña" id="user_password" class="form-control cajaentradatexto" required  data-parsley-trigger="keyup">


<input type="submit"  class="botonenviar" name="login" id="login_button" value="Iniciar Sesion">

<input type="reset" value="Cancelar" class="botonenviar">



</form>
</div>
</div> 
</body>


</html>




<script>

$(document).ready(function(){

$('#login_form').parsley();

$('#login_form').on('submit', function(event){
  event.preventDefault();
  if($('#login_form').parsley().isValid())
  {       
	$.ajax({
	  url:"login_action.php",
	  method:"POST",
	  data:$(this).serialize(),
	  dataType:'json',
	  beforeSend:function()
	  {
		$('#login_button').attr('disabled', 'disabled');
	  },
	  success:function(data)
	  {
		$('#login_button').attr('disabled', false);
		if(data.error != '')
		{
		  Swal.fire({
			icon: 'error',
			title: 'Error de Credenciales...',
			text: data.error  // Usar el mensaje de error proporcionado desde el servidor
		  });
		  $('#login_button').val('Iniciar Sesion');
		}
		else
		{
		  Swal.fire({
			title: 'Validando su Acceso...',
			html: 'Iniciando sesión',
			timer: 2000,
			timerProgressBar: true,
			didOpen: () => {
			  Swal.showLoading();
			},
			willClose: () => {
			  // Aquí puedes realizar alguna acción después de la carga exitosa, si es necesario
			  window.location.href = "<?php echo $visitor->base_url; ?>inicio.php";
			}
		  });
		}
	  }
	});
  }
});

});


</script>