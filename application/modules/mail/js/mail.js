var vMail = {

	timeout: null,
	request: function () {
		var postData = {
			"v_mail": $(".form-control").val(),
			"csrf_token_name": Config.CSRF,
			"token": Config.CSRF
		};

		clearTimeout(vMail.timeout);
		vMail.timeout = setTimeout(function () {
			$(".cargando").removeClass("d-none");
			$(".error-feedback1").removeClass("d-none");
			$(".error-feedback1").addClass("d-none");
			$.post(Config.URL + "mail/vmail_ok", postData, function (data) {
				try {
					data = JSON.parse(data);
					console.log(data);
					// Antes de la llamada AJAX
					$(".cargando").removeClass("d-none");

					if (data["messages"]["error"]) {
						if ($(".form-control").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["error"]);
						}
					}
					else if (data["messages"]["success"]) {
						if ($(".form-control").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["success"]);
							setTimeout(function () {
								// Aquí, reemplaza 'URL_DESTINO' con la URL de la página a la que deseas redirigir
								window.location.href = 'index';
							}, 10000); // 10000 milisegundos = 10 segundos

						}
					}

				} catch (e) {
					console.error(e);
					console.log(data);
				}
			});

			console.log(postData);

		}, 500);
	},

}

var cMail = {

	timeout: null,
	request: function () {
		var postData = {
			"c_mail": $(".form-control").val(),
			"csrf_token_name": Config.CSRF,
			"token": Config.CSRF
		};

		clearTimeout(cMail.timeout);
		cMail.timeout = setTimeout(function () {
			$(".cargando").removeClass("d-none");
			$(".error-feedback1").removeClass("d-none");
			$(".error-feedback1").addClass("d-none");
			$.post(Config.URL + "mail/cmail_ok", postData, function (data) {
				try {
					data = JSON.parse(data);
					console.log(data);
					// Antes de la llamada AJAX
					$(".cargando").removeClass("d-none");

					if (data["messages"]["error"]) {
						if ($(".form-control").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["error"]);
						}
					}
					else if (data["messages"]["success"]) {
						if ($(".form-control").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["success"]);
							setTimeout(function () {
								// Aquí, reemplaza 'URL_DESTINO' con la URL de la página a la que deseas redirigir
								window.location.href = 'vemail';
							}, 10000); // 20000 milisegundos = 20 segundos

						}
					}

				} catch (e) {
					console.error(e);
					console.log(data);
				}
			});

			console.log(postData);

		}, 500);
	},

}