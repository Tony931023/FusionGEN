var cTokenpd = {	
	timeout: null,

	request: function() {
		var postData = {
			"tpd": $(".form-control").val(),
			"csrf_token_name": Config.CSRF,
			"token": Config.CSRF
		};

		clearTimeout (cTokenpd.timeout);
		cTokenpd.timeout = setTimeout (function()
		{
			$(".cargando").removeClass("d-none");
			$(".error-feedback1").removeClass("d-none");
			$(".error-feedback1").addClass("d-none");
			$.post(Config.URL + "tokenpd/add_create_token1", postData, function(data) {
				try {
					data = JSON.parse(data);
					console.log(data);
					// Antes de la llamada AJAX
					$(".cargando").removeClass("d-none");

					if(data["messages"]["error"]) {
						if($(".form-control").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["error"]);
						}
					}
					else if(data["messages"]["success"]) {
						if($(".form-control").val() != "") {
							$(".error-feedback1").removeClass("d-none");
							//$(".form-control").val('');
							var inputGroup = '<div class="input-group">' +
            '<input type="text" id="token" value="' + data["messages"]["success"] + '" class="form-control" aria-describedby="btnGroupAddon2">' +
            '<div class="input-group-text" id="btnGroupAddon2">' +
            '<button id="btn-copiar" class="btn btn-overflow-light" onclick="copiarAlPortapapeles()">Copiar</button>' +
            '</div>' +
            '</div>';
        $(".error-feedback1").html(inputGroup);
		// Después de procesar la respuesta AJAX
		$(".cargando").addClass("d-none");

						}
					}
					
				} catch(e) {
					console.error(e);
					console.log(data);
				}				
			});

			console.log(postData);

		}, 500);
	},
}

var cToken = {
	
	timeout: null,
	request: function() {
		var postData = {
			"t_cangear": $(".form-control").val(),
			"csrf_token_name": Config.CSRF,
			"token": Config.CSRF
		};

		clearTimeout (cToken.timeout);
		cToken.timeout = setTimeout (function()
		{
			$(".cargando").removeClass("d-none");
			$(".error-feedback1").removeClass("d-none");
			$(".error-feedback1").addClass("d-none");
			$.post(Config.URL + "tokenpd/rec_token_add", postData, function(data) {
				try {
					data = JSON.parse(data);
					console.log(data);
					// Antes de la llamada AJAX
					$(".cargando").removeClass("d-none");

					if(data["messages"]["error"]) {
						if($(".form-control").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["error"]);
						}
					}
					else if(data["messages"]["success"]) {
						if($(".form-control").val() != "") {
							$(".error-feedback").addClass("invalid-feedback alert-danger d-block").removeClass("d-none").html(data["messages"]["success"]);

						}
					}
					
				} catch(e) {
					console.error(e);
					console.log(data);
				}				
			});

			console.log(postData);

		}, 500);
	},
	
}