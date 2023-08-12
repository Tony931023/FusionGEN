<div class="container">
	<div class="row">

		{$link_active = "tokenpd"}
		{include file="../../ucp/views/ucp_navigation.tpl"}
		{if $dp == 0}
		<script type="text/javascript">
			setTimeout(function(){
				window.location = "{$url}tokenpd";
			}, 1);
	</script>
		{/if}

		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">

			<div class="section-body">

				<div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">

					<div class="card-body p-5">
						<div class="alert alert-info firefox text-center" style="display:true;"
							role="alert">							
							Al recibir el Token de Regalo se acredita automáticamente los PD por el valor del Token 							
						</div>
						<form onSubmit="cToken.request(); return false">
							<div class="alert text-center error-feedback d-none" role="alert"></div>
							<div class="mb-3">
								<label for="t_cangear">Introduce el Token de Regalo</label></p>
								<input class="form-control" type="text" name="t_cangear" id="t_cangear" required />
							</div>
							<div class="form-group text-center mt-4">
								<button class="card-footer nice_button" type="submit">Recibir Token</button>
							</div>
						</form>

					</div>
					</br>

				</div>

			</div>
		</div>		