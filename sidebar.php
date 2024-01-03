<div class="container-fluid fixed-top bg-dark py-3" style="z-index:1049;">
    <div class="row">
        <div class="col-1 collapse show sidebar text-center">
            <img src="<?php echo $visitor->Get_profile_image(); ?>" class="img-fluid rounded-circle" width="50" />
        </div>

		<div class="col-8">
            <!-- Toggler -->
            <a data-toggle="collapse" href="#" data-target=".collapse" role="button">
                <h4 class="mt-2 mb-2 text-white"><i class="far fa-window-restore"></i></h4>
            </a>
        </div>

        <div class="col-2"><h5 class="mt-2 mb-2 text-white"> <i class="far fa-user-circle"> </i> <?php echo $visitor->Get_profile_name(); ?></h5></div> <!-- Nuevo div al lado derecho -->
        
		
    </div>
</div>

	
	<div class="container-fluid">
	    <div class="row vh-100 flex-nowrap">
	        <div class="col-sm-2 collapse show sidebar bg-dark px-0 position-fixed">
	            <ul class="nav flex-column flex-nowrap pt-2 vh-100" id="sidebar">
	            	<?php 
	            	$page_name = basename($_SERVER['PHP_SELF']);
	            	$dashboard_active = 'inactive_class';
	            	$user_active = 'inactive_class';
	            	$department_active = 'inactive_class';
	            	$visitor_active = 'inactive_class';
	            	$profile_active = 'inactive_class';
					$report_active = 'inactive_class';
					$gestion_user = 'inactive_class';
	            	$change_password_active = 'inactive_class';

	            	if($page_name == 'inicio.php')
	            	{
	            		$dashboard_active = 'active_class';
	            	}
	            	if($page_name == 'usuarios.php')
	            	{
	            		$user_active = 'active_class';
	            	}
	            	if($page_name == 'oficinas.php')
	            	{
	            		$department_active = 'active_class';
	            	}
	            	if($page_name == 'visitas.php')
	            	{
	            		$visitor_active = 'active_class';
	            	}
	            	if($page_name == 'perfil.php')
	            	{
	            		$profile_active = 'active_class';
	            	}

					if($page_name == 'reportes.php')
	            	{
	            		$report_active = 'active_class';
	            	}

	            	if($page_name == 'cambiar_contraseña.php')
	            	{
	            		$change_password_active = 'active_class';
	            	}
	            	?>


	            	<li class="nav-item">
	                    <a class="nav-link <?php echo $dashboard_active; ?>" href="inicio.php"><span class="ml-2 d-none d-sm-inline"><i class="fa fa-home"></i> Inicio</span></a>
	                </li>

	            	<?php

	            	if($visitor->is_master_user())
	            	{
	            	?><li class="nav-item">
						<a class="nav-link <?php echo $gestion_user; ?>" data-toggle="collapse" href="#menu" aria-expanded="false" aria-controls="ui-basic">
							<span class="ml-2 d-none d-sm-inline"><i class="fas fa-user-tie"></i> Perfil Usuario</span>
							<i class="fas fa-caret-down"></i>
						</a>
						<div class="collapse" id="menu">
							<ul class="nav flex-column sub-menu">
								<li class="nav-item">
									<a class="nav-link <?php echo $profile_active; ?>" href="perfil.php">
										<span class="ml-2 d-none d-sm-inline"><i class="fas fa-user-tie"></i>&nbsp;&nbsp;Actualizar Perfil</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php echo $change_password_active; ?>" href="cambiar_contraseña.php">
										<i class="fas fa-key"></i>&nbsp;&nbsp;Cambio de Clave
									</a>
								</li>
							</ul>
						</div>
					</li>
	            	<li class="nav-item">
	                    <a class="nav-link <?php echo $user_active; ?>" href="usuarios.php"><span class="ml-2 d-none d-sm-inline"><i class="fas fa-users"></i> Usuarios</span></a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link <?php echo $department_active; ?>" href="oficinas.php"><span class="ml-2 d-none d-sm-inline"><i class="fas fa-hotel"></i> Oficinas</span></a>
	                </li>
					
	            	<?php
	            	}

	            	?>
	            	<li class="nav-item">
	                    <a class="nav-link <?php echo $visitor_active; ?>" href="visitas.php"><span class="ml-2 d-none d-sm-inline"><i class="far fa-id-card"></i>&nbsp;&nbsp;Nueva Visita</span></a>
	                </li>
	                
					<li class="nav-item">
	                    <a class="nav-link <?php echo $report_active; ?> " href="reportes.php"><span class="ml-2 d-none d-sm-inline"><i class="fas fa-file-invoice"></i>&nbsp;&nbsp;Reportes</span></a>
	                </li>
					


	                <li class="nav-item">
	                    <a class="nav-link inactive_class" href="logout.php"><span class="ml-2 d-none d-sm-inline"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Cerrar Sesión</span></a>
	                </li>
	            </ul>
	        </div>
