<?php

class Admin extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('tokenpd_model');

        parent::__construct();

        requirePermission("canViewAdmin");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("tokenpd locations");

        $tokenpd_locations = $this->tokenpd_model->gettokenpdLocations();

        if ($tokenpd_locations) {
            foreach ($tokenpd_locations as $key => $value) {
                if (strlen($value['description']) > 15) {
                    $tokenpd_locations[$key]['description'] = mb_substr($value['description'], 0, 15) . '...';
                }

                $tokenpd_locations[$key]['realmName'] = $this->realms->getRealm($value['realm'])->getName();
            }
        }

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'tokenpd_locations' => $tokenpd_locations,
            'realms' => $this->realms->getRealms()
        );

        // Load my view
        $output = $this->template->loadPage("tokenpd_admin.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('tokenpd locations', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/tokenpd/js/tokenpd_admin.js");
    }

    public function create()
    {
        // Check for the permission
        requirePermission("canAdd");

        $data["name"] = $this->input->post("name");
        $data["description"] = $this->input->post("description");
        $data["x"] = $this->input->post("x");
        $data["y"] = $this->input->post("y");
        $data["z"] = $this->input->post("z");
        $data["orientation"] = $this->input->post("orientation");
        $data["mapId"] = $this->input->post("mapId");
        $data["vpCost"] = $this->input->post("vpCost");
        $data["dpCost"] = $this->input->post("dpCost");
        $data["goldCost"] = $this->input->post("goldCost");
        $data["realm"] = $this->input->post("realm");
        $data["required_faction"] = $this->input->post("required_faction");

        if (empty($data["name"])) {
            die("Name can't be empty");
        }

        if (!is_numeric($data["x"]) || !is_numeric($data["y"]) || !is_numeric($data["z"]) || !is_numeric($data["orientation"])) {
            die("tokenpd location can't be empty");
        }

        $this->tokenpd_model->add($data);

        // Add log
        $this->logger->createLog("admin", "add", "Added tokenpd location", ['Name' => $data['name']]);

        $this->plugins->onAddtokenpd($data);

        die('yes');
    }

    public function new()
    {
        // Check for the permission
        requirePermission("canEdit");

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'realms' => $this->realms->getRealms()
        );

        // Load my view
        $output = $this->template->loadPage("tokenpd_admin_add.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('New tokenpd location', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/tokenpd/js/tokenpd_admin.js");
    }

    public function edit($id = false)
    {
        // Check for the permission
        requirePermission("canEdit");

        if (!is_numeric($id) || !$id) {
            die();
        }

        $tokenpd_location = $this->tokenpd_model->tokenpdLocationExists($id);

        if (!$tokenpd_location) {
            show_error("There is no tokenpd location with ID " . $id);

            die();
        }

        // Change the title
        $this->administrator->setTitle($tokenpd_location['name']);

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'tokenpd_location' => $tokenpd_location,
            'realms' => $this->realms->getRealms()
        );

        // Load my view
        $output = $this->template->loadPage("tokenpd_admin_edit.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('<a href="' . $this->template->page_url . 'tokenpd/admin">tokenpd locations</a> &rarr; ' . $tokenpd_location['name'], $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/tokenpd/js/tokenpd_admin.js");
    }

    public function save($id = false)
    {
        // Check for the permission
        requirePermission("canEdit");

        if (!$id || !is_numeric($id)) {
            die('No ID');
        }

        $data["name"] = $this->input->post("name");
        $data["description"] = $this->input->post("description");
        $data["x"] = str_replace(',','.', $this->input->post("x"));
        $data["y"] = str_replace(',','.', $this->input->post("y"));
        $data["z"] = str_replace(',','.', $this->input->post("z"));
        $data["orientation"] = str_replace(',','.', $this->input->post("orientation"));
        $data["mapId"] = $this->input->post("mapId");
        $data["vpCost"] = $this->input->post("vpCost");
        $data["dpCost"] = $this->input->post("dpCost");
        $data["goldCost"] = $this->input->post("goldCost");
        $data["realm"] = $this->input->post("realm");
        $data["required_faction"] = $this->input->post("required_faction");

        $this->tokenpd_model->edit($id, $data);

        // Add log
        $this->logger->createLog("admin", "edit", "Edited tokenpd location", ['Name' => $data['name']]);

        $this->plugins->onEdittokenpd($id, $data);

        die('yes');
    }

    public function delete($id = false)
    {
        // Check for the permission
        requirePermission("canRemove");

        if (!$id || !is_numeric($id)) {
            die();
        }

        $this->tokenpd_model->delete($id);

        // Add log
		$this->logger->createLog("admin", "delete", "Deleted tokenpd location", ['ID' => $id]);

        $this->plugins->onDeletetokenpd($id);
    }
}
