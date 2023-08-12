<div class="container">
    <div class="row">

        {$link_active = "mail"}
        {include file="../../ucp/views/ucp_navigation.tpl"}

        <div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
            <br>
            <div class="section-body">

                <div class="alert alert-info firefox text-center" style="display:true;" role="alert">
                    Se envío un correo a la dirección {$mail}, por favor introduzca el token enviado para terminar la
                    validación del correo </br>
                </div>
                <br>
                <br>


                <div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                    <div class="card-body p-6 text-center">
                        <form onSubmit="vMail.request(); return false">
                            <div class="alert text-center error-feedback d-none" role="alert"></div>
                            <div class="mb-3">
                                <label for="v_mail">Introduce el Token de verificación</label></p>
                                <input class="form-control" type="text" name="v_mail" id="v_mail" required />
                            </div>
                            <div class="form-group text-center mt-4">
                                <button class="card-footer nice_button" type="submit">Validar</button>
                            </div>
                        </form>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>