<?php

class Achievfirst extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model("achievfirst_model");
	}
	
	public function index($RealmId = false)
	{
		$this->template->setTitle("Primeros del reino");
		
		$user_id = $this->user->getId();
		$realm = $this->user->getId();
		
		$data = array(
			'user_id' 			=> $user_id,
			'realms_count'		=> !isset($this->realms),
			'selected_realm'	=> $RealmId,
			'url' 				=> $this->template->page_url,
		);
		
		if (!isset($this->realms) > 0)
		{
			foreach ($this->realms->getRealms() as $realm)
			{
				if (!$RealmId)
				{
					$RealmId = $realm->getId();
					$data['selected_realm']	= $RealmId;
				}
					
				$data['realms'][$realm->getId()] = array('name' => $realm->getName());
			}
		}
		
		$this->achievfirst_model->setRealm($RealmId);
		
		$data['AchievFirst'] = $this->achievfirst_model->getAchievFirstPlayers();
		
		$output = $this->template->loadPage("achievfirst.tpl", $data);

		$this->template->box("Primeros del reino", $output, true, "modules/achievfirst/css/style.css", "modules/achievfirst/js/scripts.js");
	}
}
