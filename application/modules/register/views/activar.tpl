<style>
input + span[id] {
    top: unset;
}
</style>

<div class="page-subbody mt-0">
<div class="page-subbody mt-0">
	<div style="text-align:center;">
	<a href="https://www.amanthul.nat.cu" title="logo" target="_blank" moz-do-not-send="true">
	<img src="https://wow-zamimg.amanthul.nat.cu/static/logo1.png" title="Aman\'Thul" alt="Aman\'Thul" moz-do-not-send="true" width="250"></a>
</div>
	<div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
			<div class="card-body p-5">
			{form_open('register/activateacc')}
			
			<div class="mb-3">
			<label for="register_username">{lang("username", "register")}</label>
				<input class="form-control" type="text" name="register_username" id="register_username" value="{$user}"  onChange="Validate.checkUsername()" disabled/>
				 <input type="hidden" name="register_username" value="{$user}">
				 
			<span id="username_error">{$username_error}</span>
			</div>
			<input type="hidden" name="key" value="{$key1}">
			<div class="mb-3">
			<label for="register_email">{lang("email", "register")}</label>
				<input class="form-control" type="email" name="register_email" id="register_email" value="{$email}" onChange="Validate.checkEmail()" disabled/>
				<input type="hidden" name="register_email" value="{$email}">
			<span id="email_error">{$email_error}</span>
			</div>
	
			<div class="mb-3">
			<label for="register_password">{lang("password", "register")}</label>
				<input class="form-control" type="password" name="register_password" id="register_password" autocomplete="new-password" value="{set_value('register_password')}" onChange="Validate.checkPassword()"/>
			<span id="password_error">{$password_error}</span>
			</div>
	
			<div class="mb-3">
			<label for="register_password_confirm">{lang("confirm", "register")}</label>
				<input class="form-control" type="password" name="register_password_confirm" autocomplete="new-password" id="register_password_confirm" value="{set_value('register_password_confirm')}" onChange="Validate.checkPasswordConfirm()"/>
			<span id="password_confirm_error">{$password_confirm_error}</span>
			</div>	
			

		<div class="form-group text-center mt-4">
			<button class="card-footer nice_button" type="submit" name="login_submit">{lang("submit", "register")}</button>
		</div>

{form_close()}