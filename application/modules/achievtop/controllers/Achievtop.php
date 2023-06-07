<?php

class Achievtop extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model("achievtop_model");
		$this->load->config('achievtop/achievtop_config');
	}
	
	public function index($RealmId = false)
	{
		$this->template->setTitle("Jugadores con mas logros");
		
		$user_id = $this->user->getId();
		
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
		
		$this->achievtop_model->setRealm($RealmId);
		
		$data['AchievTop'] = $this->achievtop_model->getAchievTopPlayers($this->config->item("achievtop_players_limit"));
		
		$output = $this->template->loadPage("achievtop.tpl", $data);

		$this->template->box("Jugadores con mas logros", $output, true, "modules/achievtop/css/style.css", "modules/achievtop/js/scripts.js");
	}
}
