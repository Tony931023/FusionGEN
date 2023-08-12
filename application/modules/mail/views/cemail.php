<div class="container">
    <div class="row">

        {$link_active = "mail"}
        {include file="../../ucp/views/ucp_navigation.tpl"}

        <div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
            <br>
            <div class="section-body">

                <div class="alert alert-info firefox text-center" style="display:true;" role="alert">
                    Ahora puedes cambiar tu correo electrónico de forma gratuita la primera vez.
                    <br> Después, puedes
                    actualizarlo por tan solo 2 PD. 💫<br>
                    Si deseas mantener tu correo, debes validarlo.</br> {$cmail}
                </div>
                <br>
                <br>
                <div class="alert alert-warning firefox text-center" style="display:true;" role="alert">
                    {if $cmail == 0}
                    Este es tu primer cambio de correo electrónico. Recuerda que es totalmente gratis
                    {else}
                    Ya utilizaste tu cambio de correo electrónico gratis. Para cambiarlo de ahora en adelante tendrá un
                    costo de 2 PD.
                    {/if}
                </div>
                {if $dp <=1} <div class="alert alert-warning firefox text-center" style="display:true;" role="alert">
                    No tienes PD suficientes para hacer el cambio de correo a tu cuenta
            </div>
            {/if}
            {if $dp >=2}
            <div class="alert text-center error-feedback d-none" role="alert"></div>
            <div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
                <div class="card-body p-6 text-center">
                    <form onSubmit="cMail.request(); return false">

                        <div class="mb-3">
                            <label for="c_mail">Introduce el nuevo correo</label></p>
                            <input class="form-control" type="text" name="c_mail" id="c_mail" required />
                        </div>
                        <div class="form-group text-center mt-4">
                            <button class="card-footer nice_button" type="submit">Cambiar</button>
                        </div>
                    </form>


                </div>
            </div>
            {/if}

        </div>
    </div>
</div>
</div>