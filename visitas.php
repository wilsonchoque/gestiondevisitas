<?php

//visitas.php

include('vms.php');

$visitor = new vms();

if(!$visitor->is_login())
{
	header("location:".$visitor->base_url."");
}

include('header.php');

include('sidebar.php');



?>

<script>
$(document).ready(function(){
    var date = new Date();
        
    $('.input-daterange').datepicker({
        todayBtn: "linked",
        format: "yyyy-mm-dd",
        autoclose: true
    });
        
});
</script>
	
	
	        <div class="col-sm-10 offset-sm-2 py-4">
	        	<span id="message"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col-sm-4">
	            				<h4> <i class="far fa-id-badge"> </i> Registro de Visitas</h4>
	            			</div>
	            			
	            			<div class="col-md-8" align="right">
	            				
	            				<button type="button" name="add_visitor" id="add_visitor" class="btn btn-info btn-lg" style="margin-top: -6px;"><i class="fas fa-user-plus"></i>Nueva Visita</button>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="tabla_visitas">
	            				<thead>
	            					<tr>
	            						<th>Nombre Visitante</th>
										<th>Personal Visitado</th>
										<th>Oficina</th>
										<th>Hora Ingreso</th>
										<th>Hora Salida</th>
										<th>Estado</th>
										<?php
										if($visitor->is_master_user())
										{
											echo '<th>Usuario</th>';
										}
										?>										
										<th>Acciones</th>
	            					</tr>
	            				</thead>
	            			</table>
	            		</div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

</body>
</html>


<div id="visitorModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="visitor_form">
      		<div class="modal-content">
        		<div class="modal-header navbar navbar-dark bg-light">
          			<h4 class="modal-title" id="modal_title"  >REGISTRAR VISITA</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">

				<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Número DNI <span class="text-danger"> <i class="far fa-id-card"> </i></span></label>
			            	<div class="col-md-8">
			            		<input type="number" name="visita_dni" id="visita_dni" class="form-control" required data-parsley-type="integer" data-parsley-minlength="8" data-parsley-maxlength="8" data-parsley-trigger="keyup" />
								<br>
								<button type="button"  onclick="consultarNombre()" class="btn btn-primary"><i class="fas fa-search"></i> Validar DNI</button>								
							</div>
			            </div>
		          	</div>


		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Nombres Completos <span class="text-danger"> <i class="fas fa-user-alt"> </i></span></label>
			            	<div class="col-md-8">
			            		<input type="text" name="visita_nombre" id="visita_nombre" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" onkeydown="return false" />
			            	</div>
			            </div>
		          	</div>  
		          	
		         
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Oficina a Visitar<span class="text-danger"> <i class="fas fa-building"> </i></span></label>
			            	<div class="col-md-8">
			            		<select name="visita_aoficina" id="visita_aoficina" class="form-control" required data-parsley-trigger="keyup">
			            			<option value="">Selecione Oficina</option>
			            			<?php echo $visitor->load_department(); ?>
			            		</select>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Personal a Contactar <span class="text-danger"> <i class="fas fa-user-tag"> </i></span></label>
			            	<div class="col-md-8">
			            		<select name="visita_apersona" id="visita_apersona" class="form-control" required data-parsley-trigger="keyup">
			            			<option value="">Selecione Personal</option>
			            		</select>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Razon de Visita <span class="text-danger"> <i class="far fa-calendar-alt"> </i></span></label>
			            	<div class="col-md-8">
			            		<textarea name="visita_motivo" id="visita_motivo" class="form-control" required data-parsley-maxlength="400" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
		          	</div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-info btn-lg" value="Add" />
          			<!--<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>-->
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="visitordetailModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="visitor_details_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title"> <i class="fas fa-user-slash"></i> CERRAR VISITA</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">

		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Nombre Visitante</b></label>
			            	<div class="col-md-8">
			            		<span id="visita_nombre_detail"></span>
			            	</div>
			            </div>
		          	</div>		          	
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Numero DNI</b></label>
			            	<div class="col-md-8">
			            		<span id="visita_dni_detail"></span>
			            	</div>
			            </div>
		          	</div>		          	
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Oficina</b></label>
			            	<div class="col-md-8">
			            		<span id="visita_aoficina_detail"></span>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Personal Municipal</b></label>
			            	<div class="col-md-8">
			            		<span id="visita_apersona_detail"></span>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Motivo Visita</b></label>
			            	<div class="col-md-8">
			            		<span id="visita_motivo_detail"></span>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Observación de salida</b></label>
			            	<div class="col-md-8">
			            		<textarea name="visita_observaciones" id="visita_observaciones" class="form-control" required data-parsley-maxlength="400" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
		          	</div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_visita_id" id="hidden_visita_id" />
          			<input type="hidden" name="action" value="update_outing_detail" />
          			<input type="submit" name="submit" id="detail_submit_button" class="btn btn-danger btn-lg" value="Finalizar Visita" />
          			<!--<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>-->
        		</div>

				
      		</div>
    	</form>
  	</div>
</div>

<script>

$(document).ready(function(){

	load_data();

	function load_data(from_date = '', to_date = '')
	{
		var dataTable = $('#tabla_visitas').DataTable({
			"processing" : true,
			"serverSide" : true,
			"order" : [],
			"ajax" : {
				url:"visitas_accion.php",
				type:"POST",
				data:{action:'fetch', from_date:from_date, to_date:to_date}
			},
			"columnDefs":[
				{
					<?php
					if($visitor->is_master_user())
					{
					?>
					"targets":[7],
					<?php
					}
					else
					{
					?>
					"targets":[6],
					<?php
					}
					?>
					"orderable":false,
				},
			],
		});
	}

	$('#add_visitor').click(function(){		
		$('#visitor_form')[0].reset();
		$('#visitor_form').parsley().reset();
    	$('#modal_title').text('REGISTRO DE VISITA');
    	$('#action').val('Add');
    	$('#submit_button').val('Registrar Visita');
    	$('#visitorModal').modal('show');
	});

	$(document).on('change', '#visita_aoficina', function(){
		var person = $('#visita_aoficina').find(':selected').data('person');
		var person_array = person.split(", ");
		var html = '<option value="">Selec Personal</option>';
		for(var count = 0; count < person_array.length; count++)
		{
			html += '<option value="'+person_array[count]+'">'+person_array[count]+'</option>';
		}
		$('#visita_apersona').html(html);
	});

	$('#visitor_form').parsley();

	$('#visitor_form').on('submit', function(event){
		event.preventDefault();
		if($('#visitor_form').parsley().isValid())
		{		
			$.ajax({
				url:"visitas_accion.php",
				method:"POST",
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('Espere...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					$('#visitorModal').modal('hide');
					$('#message').html(data);
					$('#tabla_visitas').DataTable().destroy();
					load_data();
					setTimeout(function(){
						$('#message').html('');
					}, 5000);
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){
		var visita_id = $(this).data('id');
		$('#visitor_form').parsley().reset();
		$.ajax({
	      	url:"visitas_accion.php",
	      	method:"POST",
	      	data:{visita_id:visita_id, action:'fetch_single'},
	      	dataType:'JSON',
	      	success:function(data)
	      	{
	        	$('#visita_nombre').val(data.visita_nombre);	        	
	        	$('#visita_dni').val(data.visita_dni);	        	
	        	$('#visita_aoficina').val(data.visita_aoficina);

	        	var person = $('#visita_aoficina').find(':selected').data('person');
				var person_array = person.split(", ");
				var html = '<option value="">Selec Personal</option>';
				for(var count = 0; count < person_array.length; count++)
				{
					html += '<option value="'+person_array[count]+'">'+person_array[count]+'</option>';
				}
				$('#visita_apersona').html(html);
				$('#visita_apersona').val(data.visita_apersona);
				$('#visita_motivo').val(data.visita_motivo);
	        	
	        	$('#modal_title').text('EDITAR VISITA');
	        	$('#action').val('Edit');
	        	$('#submit_button').val('Editar');
	        	$('#visitorModal').modal('show');
	        	$('#hidden_id').val(visita_id);

	      	}
	    })
	});

	$(document).on('click', '.delete_button', function(){
		var id = $(this).data('id');
		if(confirm("Seguro de Eliminar?"))
    	{
    		$.ajax({
    			url:"visitas_accion.php",
    			method:"POST",
    			data:{id:id, action:'delete'},
    			success:function(data)
        		{
        			$('#message').html(data);
        			$('#tabla_visitas').DataTable().destroy();
        			load_data();
        			setTimeout(function(){
        				$('#message').html('');
        			}, 5000);
        		}
        	});
    	}
  	});

  	$(document).on('click', '.view_button', function(){
  		var visita_id = $(this).data('id');
  		$.ajax({
  			url:"visitas_accion.php",
	      	method:"POST",
	      	data:{visita_id:visita_id, action:'fetch_single'},
	      	dataType:'JSON',
	      	success:function(data)
	      	{
	      		$('#visita_nombre_detail').text(data.visita_nombre);	      		
	      		$('#visita_dni_detail').text(data.visita_dni);	      		
	      		$('#visita_aoficina_detail').text(data.visita_aoficina);
	      		$('#visita_apersona_detail').text(data.visita_apersona);
	      		$('#visita_motivo_detail').text(data.visita_motivo);
	      		$('#visita_observaciones').val(data.visita_observaciones);
	      		$('#visitordetailModal').modal('show');
	      		$('#hidden_visita_id').val(visita_id);
	      	}
  		})
  	});

  	$('#visitor_details_form').parsley();

  	$('#visitor_details_form').on('submit', function(event){
  		event.preventDefault();
  		if($('#visitor_details_form').parsley().isValid())
		{		
			$.ajax({
				url:"visitas_accion.php",
				method:"POST",
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#detail_submit_button').attr('disabled', 'disabled');
					$('#detail_submit_button').val('Espere...');
				},
				success:function(data)
				{
					$('#detail_submit_button').attr('disabled', false);
					$('#detail_submit_button').val('Cerrar');
					$('#visitordetailModal').modal('hide');
					$('#message').html(data);
					$('#tabla_visitas').DataTable().destroy();
					load_data();
					setTimeout(function(){
						$('#message').html('');
					}, 5000);
				}
			});
		}
  	});

  	$('#filter').click(function(){
  		var from_date = $('#from_date').val();
  		var to_date = $('#to_date').val();
  		$('#tabla_visitas').DataTable().destroy();
  		load_data(from_date, to_date);
  	});

  	$('#refresh').click(function(){
  		$('#from_date').val('');
  		$('#to_date').val('');
  		$('#tabla_visitas').DataTable().destroy();
  		load_data();
  	});

  	$('#export').click(function(){
  		var from_date = $('#from_date').val();
  		var to_date = $('#to_date').val();

  		if(from_date != '' && to_date != '')
  		{
  			window.location.href="<?php echo $visitor->base_url; ?>export.php?from_date="+from_date+"&to_date="+to_date+"";
  		}
  		else
  		{
  			window.location.href="<?php echo $visitor->base_url; ?>export.php";
  		}
  	});

});

</script>
<script>
	function consultarNombre() {
    const dni = document.getElementById('visita_dni').value;

    // Comprobar que el campo de DNI no esté vacío
    if (dni.trim() === '') {
        alert('Por favor ingresa un número de DNI válido.');
        return;
    }

    const params = {
        dni: dni
    };

    fetch('https://apiperu.dev/api/dni', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer 4a81405db8fbed3e95e780bb44b55a90159329e885c73d98fdd1b5b29d30f92a'
        },
        body: JSON.stringify(params)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la solicitud.');
        }
        return response.json();
    })
    .then(data => {
        // Mostrar los datos obtenidos en la consola
        console.log('Datos recibidos:', data);

        // Verificar si hay datos válidos recibidos de la API
        if (data && data.data && data.data.nombre_completo) {
            // Eliminar la coma del nombre antes de establecerlo en el campo visita_nombre
            const nombreSinComa = data.data.nombre_completo.replace(',', '');
            document.getElementById('visita_nombre').value = nombreSinComa;
        } else {
            throw new Error('No se encontraron datos para el DNI ingresado.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al consultar el DNI.');
    });
}
</script>