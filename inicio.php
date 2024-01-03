<?php

//inicio.php

include('vms.php');

$visitor = new vms();

if(!$visitor->is_login())
{
	header("location:".$visitor->base_url."");
}

include('header.php');

include('sidebar.php');


?>
<style>
  .container {
    display: flex; /* Utilizamos flexbox para posicionar los elementos */
    align-items: center; /* Centramos verticalmente los elementos */
  }

  .content {
    flex: 1; /* Permite que el contenido tome el espacio restante */
  }

  .image {
    width: 200px; /* Ajusta el ancho de la imagen según tus necesidades */
    margin-right: 20px; /* Agrega un margen a la derecha para separar la imagen */
  }
</style>




	        <div class="col-sm-10 offset-sm-2 py-4">
				
			<div class="row">
			<div class="content col-md-7"">
  				 
				<br>
 				<br>
				
				
						<h2 style="color: #e4e6eb;">SISTEMA DE GESTION DE VISITAS</h2><hr>
						<h7 style="color: #9da1a4;">Gobierno Regional de Puno | 2023</h7><br>
				 		<img class="image" src="images/logo.png" alt="Imagen">
 
					</div>
					<div class="col-md-5">
					<br>
 					<br>
					
 					<br>
						<main class="fecha">
							<h4 class="fecha__completa" id="fecha__completa" style="color:#ffff;"></h4>
							<div class="hora">
								<div class="hora__estado" id="hora__estado">
									 
								</div>
								<div class="hora__tiempo" id="hora__tiempo">
									
								</div>
							</div>
						</main>
					</div>
				</div>
  				<br>
				<br>
				<br>
 				<br>
				<br>
 				<br>

	            <!-- <div class="row">
	            	<div class="col-sm-3">
	            		<div class="card  btn btn-light mb-3" style="color: #002b59de;">
						  	<div class="card-header text-center"><h5>HOY <i class="fas fa-user-friends"></i> </h5></div>
						  	<div class="card-body">
						    	<h3 class="card-title text-center"><?php echo $visitor->Get_total_today_visitor(); ?></h3>
						  	</div>
						</div>
	            	</div>
	            	<div class="col-sm-3">
	            		<div class="card btn btn-light  mb-3" style="color: #002b59de;">
						  	<div class="card-header text-center"><h5>AYER <i class="fas fa-chalkboard-teacher"></i> </h5></div>
						  	<div class="card-body">
						    	<h3 class="card-title text-center"><?php echo $visitor->Get_total_yesterday_visitor(); ?></h3>
						  	</div>
						</div>
	            	</div>
	            	<div class="col-sm-3">
	            		<div class="card btn btn-light mb-3" style="color: #002b59de;" >
						  	<div class="card-header text-center"><h5>ULTIMOS DIAS <i class="fas fa-users"></i> </h5></div>
						  	<div class="card-body">
						    	<h3 class="card-title text-center"><?php echo $visitor->Get_last_seven_day_total_visitor(); ?></h3>
						  	</div>
						</div>
	            	</div>
	            	<div class="col-sm-3">
	            		<div class="card btn btn-light mb-3" style="color: #002b59de;">
						  	<div class="card-header text-center"><h5>TOTAL VISITAS <i class="far fa-address-card"></i> </h5></div>
						  	<div class="card-body">
						    	<h3 class="card-title text-center"><?php echo $visitor->Get_total_visitor(); ?></h3>
						  	</div>
						</div>
	            	</div>
	            </div> -->

		 </div>
	    </div>
	</div>

</body>
</html>