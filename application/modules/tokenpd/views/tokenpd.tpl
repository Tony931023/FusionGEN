<div class="container">
	<div class="row">
		
		{$link_active = "tokenpd"}
		{include file="../../ucp/views/ucp_navigation.tpl"}
		
		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<br>
			<div class="section-body">
			
				<div class="alert alert-info firefox text-center" style="display:true;" role="alert">
				  {if $dp >0}
				  Usted tiene disponible en su cuenta actualmente {$dp} Puntos de Donación.
				  {else}				  
				  Usted no disponible en su cuenta actualmente ningún Puntos de Donación.
				  {/if}
				</div>
				
			
			<br>
			<br>
			<br>
			<br>
			<br>
				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
					
					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover " >
							
							<div class="card-body text-center">
							{form_open('tokenpd/create_token')}
								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										Token de Regalo </p> 
										<div class="h6" >
										Creados: </br>{$t_creados} Token
										</div>
									</div>								
									
								</div>
							{if $dp >0}	
							<input type="submit" value="Crear" class="card-body text-center" >	
							{else}	
							<input type="submit" value="Crear" class="card-body text-center" disabled>	
							{/if}
							{form_close()}
							</div>
						</div>
					</div>
					
					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover " >
							
							<div class="card-body text-center">
							{form_open('tokenpd/rec_token')}
								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										Token de Regalo </p> 
										<div class="h6" >
										Recibidos: </br>{$t_recibido} Token
										</div>
									</div>								
									
								</div>
								
							<input type="submit" value="Recibir" class="card-body text-center">												
							{form_close()}
							</div>
						</div>
					</div>
					
					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover " >
							
							<div class="card-body text-center">
							{form_open('tokenpd/ver_token')}
								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										Token de Regalo </p> 
										<div class="h6" >
										Ver: </br>{$t_ver} Tokens
										</div>
									</div>							
									
								</div>
								{if $t_ver >0}	
							<input type="submit" value="Ver" class="card-body text-center" >	
							{else}	
							<input type="submit" value="Ver" class="card-body text-center" disabled>	
							{/if}
																		
							{form_close()}
							</div>
						</div>
					</div>
					
					
				</div>
			
			</div>
		</div>	
	</div>	
</div>	


	