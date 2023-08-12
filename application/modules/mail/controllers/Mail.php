<?php
class Mail extends MX_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
    $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");

    //Make sure that we are logged in
    $this->user->userArea();
    $this->load->library('form_validation');
    $this->load->helper('url');
    $this->load->model('mail_model');
  }

  public function index()
  {
    $vmail = $this->mail_model->vemail($this->user->getId());
    $cmail = $this->mail_model->cemail($this->user->getId());

    $data = array(
      'url' => $this->template->page_url,
      'dp' => $this->user->getDp(),
      'vmail' => $vmail,
      'cmail' => $cmail,
      'mail' => $this->mail_model->vcemail()
    );

    $content = $this->template->loadPage("mail.php", $data);
    $page = $this->template->box('Cambio de Correo', $content);
    $this->template->view($page, false, false);
  }

  public function vemail()
  {
    $vmail = $this->mail_model->vemail($this->user->getId());
    if ($vmail == 1) {
      redirect('mail/');
    } else {


      $cmail = $this->mail_model->cemail($this->user->getId());

      // Generar el token combinando el correo y el nombre de usuario
      $token = md5($this->user->getEmail() . $this->user->getUsername());

      // Tomar los primeros 8 caracteres del hash MD5 para obtener un token de 5 caracteres
      $short_token = substr($token, 0, 8);

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
      $user = $this->user->getNickname();
      $Year = date("Y");
      $useremail = $this->mail_model->vcemail();

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
                            href="https://www.amanthul.cu" title="logo"
                            target="_blank" moz-do-not-send="true"><img
                              src="https://wow-zamimg.amanthul.cu/static/logo1.png" title="Aman\'Thul" alt="Aman\'Thul"
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
                                    margin:0;">Validación del correo ' . $useremail . ' perteneciente a la cuenta  <b
                                      style="color: darkgreen;">' . $user . '</b></p>
                                    
                                    <h1>Token:</h1>
                                  <p style="background:#20e277;text-decoration:none
                                    !important; font-weight:500;
                                    margin-top:35px;
                                    color:#fff;text-transform:uppercase;
                                    font-size:14px;padding:10px
                                    24px;display:inline-block;border-radius:50px;"
                                    moz-do-not-send="true">' . $short_token . ' </p></td>
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
      $this->email->subject('Validación del correo de su cuenta en Aman\'Thul WoW');
      $this->email->message($body);
      $this->email->send();

      $data = array(
        'url' => $this->template->page_url,
        'dp' => $this->user->getDp(),
        'vmail' => $vmail,
        'cmail' => $cmail,
        'mail' => $this->mail_model->vcemail(),
        'token' => $token,
        'stoken' => $short_token,
      );

      $content = $this->template->loadPage("vemail.php", $data);
      $page = $this->template->box('Validar Correo', $content);
      $this->template->view($page, false, "modules/mail/js/mail.js");
    }
  }

  public function cvemail()
  {
    $vmail = $this->mail_model->vemail($this->user->getId());

    $cmail = $this->mail_model->cemail($this->user->getId());

    // Generar el token combinando el correo y el nombre de usuario
    $token = md5($this->user->getEmail() . $this->user->getUsername());

    // Tomar los primeros 8 caracteres del hash MD5 para obtener un token de 5 caracteres
    $short_token = substr($token, 0, 8);

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
    $user = $this->user->getNickname();
    $Year = date("Y");
    $useremail = $this->mail_model->vcemail();

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
                            href="https://www.amanthul.cu" title="logo"
                            target="_blank" moz-do-not-send="true"><img
                              src="https://wow-zamimg.amanthul.cu/static/logo1.png" title="Aman\'Thul" alt="Aman\'Thul"
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
                                    margin:0;">Validación del correo ' . $useremail . ' perteneciente a la cuenta  <b
                                      style="color: darkgreen;">' . $user . '</b></p>
                                    
                                    <h1>Token:</h1>
                                  <p style="background:#20e277;text-decoration:none
                                    !important; font-weight:500;
                                    margin-top:35px;
                                    color:#fff;text-transform:uppercase;
                                    font-size:14px;padding:10px
                                    24px;display:inline-block;border-radius:50px;"
                                    moz-do-not-send="true">' . $short_token . ' </p></td>
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
    $this->email->subject('Validación del correo de su cuenta en Aman\'Thul WoW');
    $this->email->message($body);
    $this->email->send();

    $data = array(
      'url' => $this->template->page_url,
      'dp' => $this->user->getDp(),
      'vmail' => $vmail,
      'cmail' => $cmail,
      'mail' => $this->mail_model->vcemail(),
      'token' => $token,
      'stoken' => $short_token,
    );

    $content = $this->template->loadPage("vemail.php", $data);
    $page = $this->template->box('Validar Correo', $content);
    $this->template->view($page, false, "modules/mail/js/mail.js");
  }

  public function v_email()
  {
    $vmail = $this->mail_model->vemail($this->user->getId());
    $cmail = $this->mail_model->cemail($this->user->getId());

    $data = array(
      'url' => $this->template->page_url,
      'dp' => $this->user->getDp(),
      'vmail' => $vmail,
      'cmail' => $cmail,
      'mail' => $this->user->getEmail(),
    );

    $content = $this->template->loadPage("vemail.php", $data);
    $page = $this->template->box('Validar Correo', $content);
    $this->template->view($page, false, "modules/mail/js/mail.js");
  }

  public function vmail_ok()
  {
    $this->form_validation->set_rules('v_mail', 'V_mail', 'trim|required');
    $v_mail = $this->input->post('v_mail');

    $vmail = $this->mail_model->vemail($this->user->getId());
    $cmail = $this->mail_model->cemail($this->user->getId());

    // Generar el token combinando el correo y el nombre de usuario
    $token = md5($this->user->getEmail() . $this->user->getUsername());

    // Tomar los primeros 8 caracteres del hash MD5 para obtener un token de 5 caracteres
    $short_token = substr($token, 0, 8);

    $token = strtolower($short_token);
    $vtoken = strtolower($v_mail);

    $data = [
      "messages" => false,
      "success" => false
    ];

    if ($this->form_validation->run()) {

      //Check csrf
      if ($this->input->post("token") != $this->security->get_csrf_hash()) {
        $data['messages']["error"] = 'Algo salió mal. Por favor recarga la página.';
        die(json_encode($data));
      }

      if ($vtoken == $token) {
        $this->mail_model->v_mail();
        $data['messages']["success"] = 'Su correo fue validado correctamente';
        die(json_encode($data));
      } else {
        $data['messages']["error"] = 'El Token es inválido';
        die(json_encode($data));
      }
    }
  }

  public function cemail()
  {
    $cmail = $this->mail_model->cemail($this->user->getId());

    $data = array(
      'dp' => $this->user->getDp(),
      'cmail' => $cmail,
      'mail' => $this->user->getEmail()
    );

    $content = $this->template->loadPage('cemail.php', $data);
    $page = $this->template->box('Cambio de la dirección de correo', $content);
    $this->template->view($page, false, "modules/mail/js/mail.js");
  }

  public function cmail_ok()
  {

    //obtengo el viejo correo
    $old_email = $this->mail_model->old_email();
    $account = $this->mail_model->account(); // Nombre de la Cuenta
    $account = ucfirst(strtolower($account)); //Convierto nombre (Account)


    $this->form_validation->set_rules('c_mail', 'C_mail', 'trim|required');
    $v_mail = $this->input->post('c_mail');

    $vmail = $this->mail_model->vemail($this->user->getId());
    $cmail = $this->mail_model->cemail($this->user->getId());

    $data = [
      "messages" => false,
      "success" => false
    ];

    if ($this->form_validation->run()) {

      //Check csrf
      if ($this->input->post("token") != $this->security->get_csrf_hash()) {
        $data['messages']["error"] = 'Algo salió mal. Por favor recarga la página.';
        die(json_encode($data));
      }
      $link = base_url() . 'mail/vemail';

      if (filter_var($v_mail, FILTER_VALIDATE_EMAIL)) {

        if (!$this->external_account_model->emailExists($v_mail)) {
          if ($cmail == 1) {
            $pd = $this->user->getDp();
            if ($pd >= 2) {

              $xx = 1;
              $this->mail_model->c_mail($v_mail, $xx);
              $this->mail_model->eforo($old_email, $account, $v_mail);


              $data['messages']["success"] = 'Se descontó de tu cuenta 2 PD, por favor valida tu nuevo correo: ' . $v_mail . ' <br> Revisa tu correo y usa el token enviado para validarlo. <br> Serás redireccionado en 20 segundos';
              die(json_encode($data));
            } else {
              $data['messages']["error"] = 'No tienes PD suficiente para poder cambiar la dirección de correo';
              die(json_encode($data));
            }
          }
          $xx = 0;
          $this->mail_model->c_mail($v_mail, $xx);
          $this->mail_model->eforo($old_email, $account, $v_mail);

          $data['messages']["success"] = 'Por favor valida tu nuevo correo: ' . $v_mail . ' <br> Revisa tu correo y usa el token enviado para validarlo. <br> Serás redireccionado en 20 segundos';
          die(json_encode($data));

        } else {
          $data['messages']["error"] = 'Ya la dirección de correo electrónico esta en uso, por favor utiliza otro correo valido';
          die(json_encode($data));
        }

      } else {
        $data['messages']["error"] = 'No es una dirección de correo valida.';
        die(json_encode($data));
      }
    }
  }

  public function test()
  {
    $id = $this->user->getEmail();
    $id = $this->user->getId();
    $id = $this->mail_model->test();

    var_dump($id);
    $data = array(
      'url' => $this->template->page_url,
      'dp' => $this->user->getDp(),
      'mail' => $this->user->getEmail(),
    );

    $content = $this->template->loadPage("test.php", $data);
    $page = $this->template->box('Test', $content);
    $this->template->view($page, false, "modules/mail/js/mail.js");

  }
}