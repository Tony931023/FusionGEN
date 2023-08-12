<?php
class Tokenpd extends MX_Controller
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
        $this->load->model('tokenpd_model');
    }

    public function index()
    {
        $token_creados = $this->tokenpd_model->token_creados($this->user->getId());
        $token_recibido = $this->tokenpd_model->token_recibido($this->user->getId());
        $token_ver = $this->tokenpd_model->find($this->user->getId());

        if ($token_ver != false){
            $token_ver = count($token_ver);            
        }
        else {
            $token_ver = 0;
        }

        $data = array(
            'url' => $this->template->page_url,
            'dp' => $this->user->getDp(),
            't_creados' => $token_creados,
            't_recibido' => $token_recibido,
            't_ver' => $token_ver,
        );

        $content = $this->template->loadPage("tokenpd.tpl", $data);
        $page = $this->template->box('Tokens de Regalo (PD)', $content);
        $this->template->view($page, "modules/tokenpd/css/tokenpd.css", false);
    }

    public function create_token()
    {
        $data = array(
            'dp' => $this->user->getDp(),
        );

        $content = $this->template->loadPage('create_token.tpl', $data);
        $page = $this->template->box('Regalar PD mediante Tokens', $content);
        $this->template->view($page, "modules/tokenpd/css/tokenpd.css", "modules/tokenpd/js/tokenpd.js");
    }
    public function rec_token()
    {
        $data = array(
            'dp' => $this->user->getDp(),
        );

        $content = $this->template->loadPage('rec_token.tpl', $data);
        $page = $this->template->box('Recibir Tokens', $content);
        $this->template->view($page, "modules/tokenpd/css/tokenpd.css", "modules/tokenpd/js/tokenpd.js");
    }

    public function add_create_token1()
    {
        $this->form_validation->set_rules('tpd', 'Tpd', 'trim|required|numeric');
        $tpd = $this->input->post('tpd');

        //$this->form_validation->set_error_delimiters('', '');

        $data = [
            "messages" => false,
            "success" => false
        ];

        $pd = $this->user->getDp();
        $acc = $this->user->getUsername();
        $accid = $this->user->getId();

        $cadena = $acc; // Cadena de ejemplo
        $primeraParte = substr($cadena, 0, 3); // Obtiene las primeras tres letras de la cadena

        $fecha = date("md"); // Obtiene el mes y día actual en formato "md"

        $cadenaAleatoria = $this->generateRandomString(4); // Genera una cadena aleatoria de longitud 4

        // Mezclar aleatoriamente las partes del token
        $primeraParte = str_shuffle($primeraParte);
        $fecha = str_shuffle($fecha);
        $cadenaAleatoria = str_shuffle($cadenaAleatoria);
        $token = $primeraParte . $fecha . $cadenaAleatoria;
        $token = str_shuffle($token);

        if ($this->form_validation->run()) {

            //Check csrf
            if ($this->input->post("token") != $this->security->get_csrf_hash()) {
                $data['messages']["error"] = 'Algo salió mal. Por favor recarga la página.';
                die(json_encode($data));
            }

            if ($tpd == 0) {
                $data['messages']["error"] = 'No puedes crear un Token de Regalo con 0 PD';
                die(json_encode($data));
            }

            if ($pd < $tpd) {
                $data['messages']["error"] = 'No tines ' . $tpd . ' PD para el Token de Regalo';
                die(json_encode($data));
            } else {
                $this->tokenpd_model->create_token($tpd, $acc, $accid, $token);

                $data = array(
                    'dp' => $tpd,
                    'acc' => $this->user->getUsername(),
                    'token' => $token,

                );

                $data['messages']["success"] = $token;
                die(json_encode($data));

            }
        } else {
            $data['messages']["error"] = "Datos Incorrectos";
            die(json_encode($data));
        }

    }

    public function rec_token_add()
    {
        $this->form_validation->set_rules('t_cangear', 'T_cangear', 'trim|required');
        $t_cangear = $this->input->post('t_cangear');

        $data = [
            "messages" => false,
            "success" => false
        ];

        $pd = $this->user->getDp();
        $acc = $this->user->getUsername();
        $accid = $this->user->getId();

        if ($this->form_validation->run()) {

            //Check csrf
            if ($this->input->post("token") != $this->security->get_csrf_hash()) {
                $data['messages']["error"] = 'Algo salió mal. Por favor recarga la página.';
                die(json_encode($data));
            }

            $ver_token[] = $this->tokenpd_model->ver_token($t_cangear);           

            if (!$ver_token[0]) {
                $data['messages']["error"] = 'El Token es invalido';
                die(json_encode($data));

            } else {
                $estado = $ver_token[0]->estado;
                if ($estado != 0) {
                    if ($estado == 1) {
                        $data['messages']["error"] = 'Error el Token ya fue activado';
                        die(json_encode($data));
                    }
                    if ($estado == 2) {
                        $data['messages']["error"] = 'Error el Token fue borrado';
                        die(json_encode($data));
                    }
                } else {
                    $id_user = $ver_token[0]->id_user;
                    $v_token = $ver_token[0]->pd;
                    if ($id_user == $accid){
                        $off = 5;
                        $acr_token = $this->tokenpd_model->acr_token($accid,$acc,$t_cangear,$off,$v_token); 
                        $data['messages']["success"] = 'Se acreditaron ' .$v_token. ' PD a tu cuenta';
                        die(json_encode($data));

                    }
                    else {
                        $off = 1;
                        $acr_token = $this->tokenpd_model->acr_token($accid,$acc,$t_cangear,$off,$v_token); 
                        $data['messages']["success"] = 'Se acreditaron ' .$v_token. ' PD a tu cuenta';
                        die(json_encode($data));
                    }
                }

            }
        }
    }

    public function ver_token()
    {        
        $id = $this->user->getId();
        $data["tokens"] = $this->tokenpd_model->find($id);   
        //redirect("/personas/listado"); 
          
        if($data["tokens"] != false){
            $content = $this->template->loadPage('ver_token.tpl', $data);
            $page = $this->template->box('Ver Tokens sin activar', $content);
            $this->template->view($page, "modules/tokenpd/css/tokenpd.css", "modules/tokenpd/js/tokenpd.js");
        } else {
            redirect("tokenpd"); 
        }
       
        
    }

    public function generateRandomString($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}