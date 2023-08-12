<div class="container">
	<div class="row">

		{$link_active = "storepd"}
		{include file="../../ucp/views/ucp_navigation.tpl"}

		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<br>
			<div class="section-body">


				<h1>💰 Donación vía Saldo Móvil💰</h1>
				</br>



				<div class="alert alert-success firefox text-center" style="display:true;" role="alert">
					<h6>
						Las donaciones se realizan al número de teléfono</h6>
					<h5> +53 52629386 </h5>
					<h6> Debes verificar que
						esté
						correctamente escrito. Al realizar la donación, debes enviar un SMS al mismo número con la
						cantidad donada y el usuario de la cuenta a la que se le acreditarán los PD.</h6>



				</div>

				<br>

				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">

					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover ">
							<img src="{$url}application/modules/storepd/images/saldo.png" alt="Saldo Movil">

							<div class="card-body text-center">
								{form_open('storepd/saldo')}

								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										Saldo </p>
										<div class="h6">
											Trasferencia de Saldo (Cuba)
											<br>
										</div>
									</div>
								</div>
								<input type="submit" value="Paquetes" class="card-body text-center">
								{form_close()}
							</div>
						</div>
					</div>

					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover ">
							<img src="{$url}application/modules/storepd/images/trasfer.png" alt="Enzona o Trasfermovil">

							<div class="card-body text-center">
								{form_open('storepd/trasfer')}
								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										Tarjeta </p>
										<div class="h6">
											Enzona o Trasfermovil (Cuba)
										</div>
									</div>

								</div>

								<input type="submit" value="Paquetes" class="card-body text-center">
								{form_close()}
							</div>
						</div>
					</div>
					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover ">
							<img src="{$url}application/modules/storepd/images/paypal.png" alt="paypal">

							<div class="card-body text-center">
								{form_open('tokenpd/paypal')}
								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										PayPal </p>
										<div class="h6">
											Alternativa desde cualquier país
										</div>
									</div>

								</div>

								<input type="submit" value="Ver" class="card-body text-center">
								{form_close()}
							</div>
						</div>
					</div>

					<div class="col mb-3">
						<div class="card h-100 cursor-pointer card-hover ">
							<img src="{$url}application/modules/storepd/images/zelle.png" alt="zelle">

							<div class="card-body text-center">
								{form_open('tokenpd/zelle')}
								<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center">
									<div class="h4">
										Zelle </p>
										<div class="h6">
											Solo disponible para EU
										</div>
									</div>

								</div>
								<input type="submit" value="Ver" class="card-body text-center">

								{form_close()}
							</div>
						</div>
					</div>


				</div>

			</div>
		</div>
	</div>
</div>