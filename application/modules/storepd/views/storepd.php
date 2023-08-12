<div class="container">
	<div class="row">

		{$link_active = "storepd"}
		{include file="../../ucp/views/ucp_navigation.tpl"}

		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<br>
			<div class="section-body">

				{if $rdon == 0}
				<h1>Políticas de Donación</h1>
				</br>
				</br>

				<div class="alert alert-danger firefox text-center" style="display:true;" role="alert">
					<h6>
						Antes de realizar una donación en nuestro servidor de WoW Aman'Thul, es importante leer y
						comprender
						los términos y condiciones establecidos. Estos términos están diseñados para garantizar una
						donación
						segura y satisfactoria.
					</h6>
				</div>
				<div class="alert alert-success firefox text-center" style="display:true;" role="alert">
					<p class="font-weight-bold">1. Propiedad del método de pago:</p>
					Antes de donar, asegúrate de ser el propietario legal del método de
					pago que utilizarás o contar con la autorización expresa del propietario legal. Esto es fundamental
					para garantizar que estés utilizando los fondos de manera legítima y evitar cualquier tipo de
					transacción no autorizada.
					</br>
					</br>
					<p class="font-weight-bold">2. Origen legal de los fondos: </p>
					Es importante asegurarte de que los fondos que vayas a donar no estén
					vinculados de ninguna manera a fuentes ilícitas de enriquecimiento. Antes de realizar la donación,
					verifica que los fondos hayan sido adquiridos de manera legal y cumplan con todas las leyes y
					regulaciones aplicables.
					</br>
					</br>
					<p class="font-weight-bold">3. Voluntad propia:</p>
					La donación debe ser realizada por tu propia
					voluntad y sin ninguna forma de
					presión externa. No permitas que nadie te presione o influya indebidamente para realizar una
					donación. La donación debe ser un acto voluntario y desinteresado, basado en tu apoyo y compromiso
					con nuestro servidor.
					</br>
					</br>
					<p class="font-weight-bold">4. Acceso a servicios sin donaciones:</p>
					Queremos asegurarte que el acceso a nuestros servicios y la
					posibilidad de jugar en nuestro servidor no están condicionados a realizar donaciones. Todos los
					jugadores tienen igualdad de oportunidades y pueden disfrutar de la experiencia del juego sin
					necesidad de hacer donaciones. Las donaciones son opcionales y están destinadas a apoyar el
					mantenimiento y mejoras del servidor.
					</br>
					</br>
					<p class="font-weight-bold"> </p>
					Recuerda que al realizar una donación, aceptas y te haces responsable de cumplir con los términos y
					condiciones establecidos. Aunque asumimos que los fondos donados fueron adquiridos legalmente, no
					nos hacemos responsables en caso contrario, ya que no tenemos la capacidad de verificar la
					procedencia de los fondos.
					</br>
					Agradecemos tu interés en apoyar nuestro servidor de WoW Aman'Thul a través de una donación. Tu
					contribución es valiosa y nos ayuda a brindarte una experiencia de juego aún mejor. Si tienes alguna
					pregunta adicional sobre el proceso de donación, no dudes en comunicarte con nuestro equipo de
					soporte. ¡Disfruta tu tiempo en nuestro servidor y gracias por tu apoyo!


				</div>
				<div class="text-center">
					{form_open('storepd/storepd')}
					<input type="hidden" name="t_uso" value="1" />
					<input type="submit" value="Acepto" class="card-body text-center">
					{form_close()}
				</div>
				{else}
				<h1>Panel Donación</h1>
				<br>


				<div class="alert alert-success firefox text-center" style="display:true;" role="alert">
					<h6>
						🎁 ¡Descubre diferentes métodos de donación y elige el que más te convenga! 🎁
					</h6>
					<h6> </h6>
					<h6> 🌟
						No importa el método que elijas, tu apoyo significará mucho.
						¡Gracias!🌟</h6>

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
				{/if}
			</div>
		</div>
	</div>
</div>