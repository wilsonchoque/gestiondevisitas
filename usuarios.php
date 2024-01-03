<?php

//usuarios.php

include('vms.php');

$visitor = new vms();

if(!$visitor->is_login())
{
	header("location:".$visitor->base_url."");
}

if(!$visitor->is_master_user())
{
	header("location:".$visitor->base_url."inicio.php");
}

include('header.php');

include('sidebar.php');
?>
	
	
	        <div class="col-sm-10 offset-sm-2 py-4">
	        	<span id="message"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col">
	            				<h4>Usuarios del Sistema</h4>
	            			</div>
	            			<div class="col text-right">
	            				<button type="button" name="add_user" id="add_user" class="btn btn-info btn-lg"><i class="fas fa-user-plus"></i>Nuevo Usuario</button>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="user_table">
	            				<thead>
	            					<tr>
	            						<th>Imagen</th>
	            						<th>Nombre de Usuario</th>
										<th>N° Contacto </th>
										<th>Correo de Usuario</th>
										<th>Fecha de Creacion</th>					
										<th>Accion</th>
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

<div id="userModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="user_form" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Registro de Usuario</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Nombre de Usuario <span class="text-danger"> <i class="fas fa-user-edit"> </i></span></label>
			            	<div class="col-md-8">
			            		<input type="text" name="admin_name" id="admin_name" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">N° Contacto  <span class="text-danger"><i class="far fa-address-book"> </i></span></label>
			            	<div class="col-md-8">
			            		<input type="number" name="admin_contact_no" id="admin_contact_no" class="form-control" required data-parsley-type="integer" data-parsley-minlength="9" data-parsley-maxlength="9" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Correo Electronico <span class="text-danger"> <i class="fas fa-at"> </i></span></label>
			            	<div class="col-md-8">
			            		<input type="text" name="admin_email" id="admin_email" class="form-control" required data-parsley-type="email" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>

		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Contraseña <span class="text-danger"><i class="fas fa-fingerprint"> </i></span></label>
			            	<div class="col-md-8">
			            		<input type="password" name="admin_password" id="admin_password" class="form-control" Placeholder="***********" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>
		          	
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Imagen Perfil <span class="text-danger"> <i class="fas fa-camera"> </i></label>
			            	<div class="col-md-8">
			            		<input type="file" name="user_image" id="user_image" />
								<span id="user_uploaded_image"></span>
			            	</div>
			            </div>
		          	</div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<script>

$(document).ready(function(){

	var dataTable = $('#user_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"usuarios_accion.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[0, 5],
				"orderable":false,
			},
		],
	});

	$('#add_user').click(function(){		
		$('#user_form')[0].reset();
		$('#user_form').parsley().reset();
    	$('#modal_title').text('Registro de Usuario');
    	$('#action').val('Add');
    	$('#submit_button').val('Guardar');
    	$('#userModal').modal('show');

    	$('#admin_password').attr('required', true);

	    $('#admin_password').attr('data-parsley-minlength', '6');

	    $('#admin_password').attr('data-parsley-maxlength', '16');

	    $('#admin_password').attr('data-parsley-trigger', 'keyup');
	});

	$('#user_image').change(function(){
		var extension = $('#user_image').val().split('.').pop().toLowerCase();
		if(extension != '')
		{
			if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
			{
				alert("Invalid Image File");
				$('#user_image').val('');
				return false;
			}
		}
	});

	$('#user_form').parsley();

	$('#user_form').on('submit', function(event){
		event.preventDefault();
		if($('#user_form').parsley().isValid())
		{		
			var extension = $('#user_image').val().split('.').pop().toLowerCase();
			if(extension != '')
			{
				if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
				{
					alert("Invalid Image File");
					$('#user_image').val('');
					return false;
				}
			}
			$.ajax({
				url:"usuarios_accion.php",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				processData:false,
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('Espere...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					$('#userModal').modal('hide');
					$('#message').html(data);
					dataTable.ajax.reload();
					setTimeout(function(){
						$('#message').html('');
					}, 5000);
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){
		var admin_id = $(this).data('id');
		$('#user_form').parsley().reset();
		$.ajax({
	      	url:"usuarios_accion.php",
	      	method:"POST",
	      	data:{admin_id:admin_id, action:'fetch_single'},
	      	dataType:'JSON',
	      	success:function(data)
	      	{
	        	$('#admin_name').val(data.admin_name);	        	
	        	$('#admin_contact_no').val(data.admin_contact_no);
	        	$('#admin_email').val(data.admin_email);

	        	$('#user_uploaded_image').html('<img src="'+data.admin_profile+'" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_user_image" value="'+data.admin_profile+'" />');

	        	$('#admin_password').attr('required', false);

	        

	        	$('#admin_password').attr('data-parsley-trigger', '');
	        	
	        	$('#modal_title').text('Editar Usuario');
	        	$('#action').val('Edit');
	        	$('#submit_button').val('Actualizar');
	        	$('#userModal').modal('show');
	        	$('#hidden_id').val(admin_id);

	      	}
	    })
	});

	$(document).on('click', '.delete_button', function(){
		var id = $(this).data('id');
		var status = $(this).data('status');
		var next_status = 'Enable';
		if(status == 'Enable')
		{
			next_status = 'Disable';
		}
		if(confirm("Seguro de Elimiar "+next_status+" ?"))
    	{
    		$.ajax({
    			url:"usuarios_accion.php",
    			method:"POST",
    			data:{id:id, action:'delete', status:status, next_status:next_status},
    			success:function(data)
        		{
        			$('#message').html(data);
        			dataTable.ajax.reload();
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
					$('#detail_submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#detail_submit_button').attr('disabled', false);
					$('#detail_submit_button').val('Save');
					$('#visitordetailModal').modal('hide');
					$('#message').html(data);
					dataTable.ajax.reload();
					setTimeout(function(){
						$('#message').html('');
					}, 5000);
				}
			});
		}
  	});

});

</script>