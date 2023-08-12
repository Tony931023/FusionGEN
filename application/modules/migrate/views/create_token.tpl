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
							{if $dp >0}
							Al crear el Token de Regalo se retirará automáticamente los PD por el valor del Token 
							{else}
							Usted no disponible en su cuenta actualmente ningún Puntos de Donación.
							{/if}
						</div>
						<form onSubmit="cTokenpd.request(); return false">
							<div class="alert text-center error-feedback d-none" role="alert"></div>
							<div class="mb-3">
								<label for="tpd">Valor del Token de Regalo</label></p>
								<input class="form-control" type="text" name="tpd" id="tpd"
									inputmode="numeric" pattern="[0-9]+" title="Solo números" required />
							</div>
							<div class="form-group text-center mt-4">
								<button class="card-footer nice_button" type="submit">Crear Token</button>
							</div>
						</form>

					</div>
					</br>
									
					<div class="justify-content-between text-center alert cargando d-none " role="alert">
					Creando Token de Regalo...					
					</div>

					<div class="btn-toolbar  justify-content-between error-feedback1 d-none " role="toolbar" 	aria-label="Toolbar with button groups">
	
					</div>

				</div>

			</div>
		</div>
		<script>
function copiarAlPortapapeles() {
  // Selecciona el elemento de entrada de texto
  var inputElement = document.getElementById("token");
  
  // Selecciona el texto dentro del elemento de entrada de texto
  inputElement.select();
  
  // Copia el texto al portapapeles
  document.execCommand("copy");
  
  // Deselecciona el texto
  window.getSelection().removeAllRanges();
  
  // Cambia el texto del botón después de copiar
  var btnCopiar = document.getElementById("btn-copiar");
  btnCopiar.innerHTML = "¡Copiado!";
}
</script>