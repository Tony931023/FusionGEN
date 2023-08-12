<div class="container">
	<div class="row">

		{$link_active = "mail"}
		{include file="../../ucp/views/ucp_navigation.tpl"}

		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<br>
			<div class="section-body">

				<div class="alert alert-info firefox text-center" style="display:true;" role="alert">
					💌 ¡Excelentes noticias! 💌 </br> Ahora puedes cambiar tu correo electrónico de forma gratuita la
					primera
					vez. Después, puedes actualizarlo por tan solo 2 PD. 💫
					<br>
					Si deseas mantener tu correo, debes validarlo.
				</div>


				<br>
				<br>


				<div class="row">

					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover ">

							<div class="card-body text-center">
								{form_open('mail/cemail')}
								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										Cambiar Correo Electrónico </p>
										<div class="h6">
											{$mail}
										</div>
									</div>

								</div>

								<input type="submit" value="Cambiar" class="card-body text-center">

								{form_close()}
							</div>
						</div>
					</div>

					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover ">

							<div class="card-body text-center">
								{form_open('mail/vemail')}
								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										Validar Correo Electrónico </p>
										<div class="h6">
											{$mail}
										</div>
									</div>

								</div>
								{if $vmail == 0}
								<input type="submit" value="Validar" class="card-body text-center">
								{else}
								<input type="submit" value="Validar" class="card-body text-center" disabled>
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