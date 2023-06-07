<?php

class Register extends MX_Controller
{
    private $usernameError;
    private $emailError;

    public function __construct()
    {
        parent::__construct();

        // Make sure that we are not logged in yet
        $this->user->guestArea();

        requirePermission("view");

        $this->load->helper(array('form', 'url', 'security'));
        $this->load->library('form_validation');

        $this->load->helper('email_helper');

        $this->load->config('bridge');
        $this->load->config('activation');
        $this->load->config('captcha');

        $this->load->model('activation_model');
    }

    public function index()
    {
        clientLang("username_limit_length", "register");
        clientLang("username_limit", "register");
        clientLang("username_not_available", "register");
        clientLang("email_not_available", "register");
        clientLang("email_invalid", "register");
        clientLang("password_short", "register");
        clientLang("password_match", "register");

        $this->template->setTitle(lang("register", "register"));

        //Load the form validations for if they tried to sneaky bypass our js system
        $this->form_validation->set_rules('register_username', 'username', 'trim|required|min_length[4]|max_length[24]|xss_clean|alpha_numeric');
        $this->form_validation->set_rules('register_email', 'email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('register_password', 'password', 'trim|required|min_length[6]|xss_clean');
        $this->form_validation->set_rules('register_password_confirm', 'password confirmation', 'trim|required|matches[register_password]|xss_clean');

        $this->form_validation->set_error_delimiters('<img src="' . $this->template->page_url . 'application/images/icons/exclamation.png" data-tip="', '" />');

        require_once('application/libraries/Captcha.php');

        $captchaObj = new Captcha($this->config->item('use_captcha'));

        if (count($_POST)) {
            $emailAvailable = $this->email_check($this->input->post('register_email'));
            $usernameAvailable = $this->username_check($this->input->post('register_username'));
        } else {
            $emailAvailable = false;
            $usernameAvailable = false;
        }

        //Check if everything went correct
        if (
            $this->form_validation->run() == false
            || strtoupper($this->input->post('register_captcha')) != strtoupper($captchaObj->getValue())
            || !count($_POST)
            || !$usernameAvailable
            || !$emailAvailable
        ) {
            $fields = array('username', 'email', 'password', 'password_confirm');

            $data = array(
                "username_error" => $this->usernameError,
                "email_error" => $this->emailError,
                "password_error" => "",
                "password_confirm_error" => "",
                "use_captcha" => $this->config->item('use_captcha'),
                "captcha_type" => $this->config->item('captcha_type'),
                "captcha_error" => "",
                "url" => $this->template->page_url
            );

            if (count($_POST) > 0) {
                // Loop through fields and assign error or success image
                foreach ($fields as $field) {
                    if (strlen(form_error('register_' . $field)) == 0 && empty($data[$field . "_error"])) {
                        $data[$field . "_error"] = '<img src="' . $this->template->page_url . 'application/images/icons/accept.png" />';
                    } elseif (empty($data[$field . "_error"])) {
                        $data[$field . "_error"] = form_error('register_' . $field);
                    }
                }

                if ($this->input->post('register_captcha') != $captchaObj->getValue()) {
                    $data['captcha_error'] = '<img src="' . $this->template->page_url . 'application/images/icons/exclamation.png" />';
                }
            }

            // If not then display our page again
            $this->template->view($this->template->loadPage(
                "page.tpl",
                array(
                    "module" => "default",
                    "headline" => "Creación de cuenta",
                    "content" => $this->template->loadPage("register.tpl", $data),
                )
            ), false, "modules/register/js/validate.js", "Creación de cuenta");
        } else {

            if (!$this->username_check($this->input->post("register_username"))) {
                die();
            }

            // Show success message
            $data = array(
                "url" => $this->template->page_url,
                "account" => $this->input->post('register_username'),
                "username" => $this->input->post('register_username'),
                "email" => $this->input->post('register_email'),
                "password" => $this->input->post('register_password'),
                "email_activation" => $this->config->item('enable_email_activation')
            );

            if ($this->config->item('enable_email_activation')) {
                $result = $this->activation_model->createAccountveremail($this->input->post('register_username'), $this->input->post('register_password'), $this->input->post('register_email'), $this->input->post('register_expansion'));

                $username = $result['username'];
                $email = $result['email'];

                $this->load->config('smtp');

                // Pass the custom SMTP settings if any
                if ($this->config->item('smtp_protocol') == 'smtp') {
                    $config = array(
                        'protocol' => $this->config->item('smtp_protocol'),
                        'smtp_host' => $this->config->item('smtp_host'),
                        'smtp_user' => $this->config->item('smtp_user'),
                        'smtp_pass' => $this->config->item('smtp_pass'),
                        'smtp_port' => $this->config->item('smtp_port'),
                        'smtp_crypto' => $this->config->item('smtp_crypto'),
                        'crlf' => "\r\n",
                        'newline' => "\r\n",
                    );
                }

                // Configuration
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = true;
                $config['mailtype'] = 'html';

                $sender = $this->config->item('smtp_sender');
                $this->load->library('email', $config);
                $user = $this->input->post('register_username');
                $Year = date("Y");
                #$useremail =$this->input->post('register_email');
                $useremail = 'snet3040@gmail.com';
                $link = base_url() . 'register/activate/' . $result['key'];

                $body = '<table width="100%" cellspacing="0" cellpadding="0" border="0"
                bgcolor="#f2f3f8">
                <tbody>
                  <tr>
                    <td>
                      <table style="background-color: #f2f3f8; max-width:670px;
                        margin:0 auto;" width="100%" cellspacing="0"
                        cellpadding="0" border="0" align="center">
                        <tbody>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td style="text-align:center;"><a
                                href="https://www.amanthul.nat.cu" title="logo"
                                target="_blank" moz-do-not-send="true"><img
                                  src="https://wow-zamimg.amanthul.nat.cu/static/logo1.png" title="Aman\'Thul" alt="Aman\'Thul"
                                  moz-do-not-send="true" width="150"></a></td>
                          </tr>
                          <tr>
                            <td style="height:20px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>
                              <table style="max-width:670px;background:#fff;
                                border-radius:3px;
                                text-align:center;-webkit-box-shadow:0 6px 18px 0
                                rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0
                                rgba(0,0,0,.06);box-shadow:0 6px 18px 0
                                rgba(0,0,0,.06);" width="95%" cellspacing="0"
                                cellpadding="0" border="0" align="center">
                                <tbody>
                                  <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="padding:0 35px;">
                                      <h1 style="color:#1e1e2d; font-weight:500;
                                        margin:0;font-size:32px;"> Aman\'Thul WoW</h1>
                                      <span style="display:inline-block;
                                        vertical-align:middle; margin:29px 0 26px;
                                        border-bottom:1px solid #cecece;
                                        width:100px;"></span>
                                      <p style="color:#455056;
                                        font-size:15px;line-height:24px;
                                        margin:0;">Has creado la cuenta <b
                                          style="color: darkgreen;">' . $user . '</b></p>
                                        
                                        
                                      <a href="' . $link . '"
                                        style="background:#20e277;text-decoration:none
                                        !important; font-weight:500;
                                        margin-top:35px;
                                        color:#fff;text-transform:uppercase;
                                        font-size:14px;padding:10px
                                        24px;display:inline-block;border-radius:50px;"
                                        moz-do-not-send="true">Activar cuenta</a></td>
                                  </tr>
                                  <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="height:20px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td style="text-align:center;">
                              <p style="font-size:14px; color:rgba(69, 80, 86,
                                0.7411764705882353); line-height:18px; margin:0 0
                                0;"><strong>Aman\'Thul WoW © ' . $Year . '</strong></p>
                            </td>
                          </tr>
                          <tr>
                            <td style="height:80px;">&nbsp;</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
                
                ';
                $this->email->from($sender, $this->config->item('server_name'));
                $this->email->to($useremail);
                $this->email->subject('Activar la cuenta ' . $user . ' en Aman\'Thul WoW');
                $this->email->message($body);
                $this->email->send();

            } else {

                //Register our user.
                $this->external_account_model->createAccount($this->input->post('register_username'), $this->input->post('register_password'), $this->input->post('register_email'));

                // Log in
                $sha_pass_hash = $this->user->createHash($this->input->post('register_username'), $this->input->post('register_password'));
                $check = $this->user->setUserDetails($this->input->post('register_username'), $sha_pass_hash["verifier"]);
            }

            $title = lang("created", "register");

            $this->template->view($this->template->box($title, $this->template->loadPage("register_success.tpl", $data)));
        }
    }

    public function email_check($email)
    {
        if (!$this->external_account_model->emailExists($email)) {
            $this->emailError = '';

            // The email does not exists so they can register
            return true;
        } else {
            // Email exists
            $this->emailError = '<img src="' . $this->template->page_url . 'application/images/icons/exclamation.png" data-tip="This email is not available" />';

            return false;
        }
    }

    public function username_check($username)
    {
        if (!$this->external_account_model->usernameExists($username)) {
            $this->usernameError = '';

            // The user does not exists so they can register
            return true;
        } else {
            // User exists
            $this->usernameError = '<img src="' . $this->template->page_url . 'application/images/icons/exclamation.png" data-tip="This username is not available" />';

            return false;
        }
    }

    public function activate($key = false)
    {
        if (!$key) {
            $this->template->box(lang("invalid_key", "register"), lang("invalid_key_long", "register"), true);
        }

        $account = $this->activation_model->getAccount($key);

        if (!$account) {
            $this->template->box(lang("invalid_key", "register"), lang("invalid_key_long", "register"), true);
        }

        $this->activation_model->remove($account['id'], $account['username'], $account['email']);

        $this->external_account_model->createAccount($account['username'], $account['password'], $account['email'], $account['expansion'], true);
        $this->updateRecruiter($this->external_account_model->getId($account['username']), $account['recruiter']);
        // Log in
        if ($this->realms->getEmulator()->isSRP6()) {
            list(1 => $password) = explode('|', $account['password']);

            $this->user->setUserDetails($account['username'], hex2Bin($password));
        } else {
            $this->user->setUserDetails($account['username'], $account['password']);
        }

        // Show success message
        $data = array(
            "url" => $this->template->page_url,
            "account" => $account['username'],
            "bridgeName" => $this->config->item('forum_bridge'),
            "username" => $account['username'],
            "email" => $account['email'],
            "password" => $account['password'],
            "email_activation" => false
        );

        $title = lang("created", "register");

        $this->template->view($this->template->box($title, $this->template->loadPage("register_success.tpl", $data)));
    }
}