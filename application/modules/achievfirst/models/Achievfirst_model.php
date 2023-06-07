<?php

class Achievfirst_model extends CI_Model
{
	public $realm;
	private $connection;
	
    public function __construct()
	{
		parent::__construct();		
	}

	public function setRealm($id)
	{
		$this->realm = $this->realms->getRealm($id);
	}

	public function connect()
	{
		$this->realm->getCharacters()->connect();
		$this->connection = $this->realm->getCharacters()->getConnection();
	}

	public function getAchievFirstPlayers()
	{
		$this->connect();
        
        $data = array(
            457 => array("&iexcl;Primero del reino con Nivel 80!", "achievement_level_80"),
            
            458 => array("&iexcl;Primero del reino! P&iacute;caro nivel 80", "inv_throwingknife_04"),
            459 => array("&iexcl;Primero del reino! Guerrero nivel 80", "inv_sword_27"),
            460 => array("&iexcl;Primero del reino! Mago nivel 80", "inv_staff_13"),
            461 => array("&iexcl;Primero del reino! Caballero de la Muerte nivel 80", "spell_deathknight_classicon"),
            462 => array("&iexcl;Primero del reino! Cazador nivel 80", "inv_weapon_bow_07"),
            463 => array("&iexcl;Primero del reino! Brujo nivel 80", "spell_nature_drowsy"),
            464 => array("&iexcl;Primero del reino! Sacerdote nivel 80", "inv_staff_30"),
            465 => array("&iexcl;Primero del reino! Palad&iacute;n nivel 80", "ability_thunderbolt"),
            466 => array("&iexcl;Primero del reino! Druida nivel 80", "ability_druid_maul"),
            467 => array("&iexcl;Primero del reino! Cham&aacute;n nivel 80", "spell_nature_bloodlust"),
            
            1404 => array("&iexcl;Primero del reino! Gnomo nivel 80", "achievement_character_gnome_male"),
            1405 => array("&iexcl;Primero del reino! Elfo de sangre nivel 80", "achievement_character_bloodelf_female"),
            1406 => array("&iexcl;Primero del reino! Draenei nivel 80", "achievement_character_draenei_female"),
            1407 => array("&iexcl;Primero del reino! Enano nivel 80", "achievement_character_dwarf_male"),
            1408 => array("&iexcl;Primero del reino! Humano nivel 80", "achievement_character_human_female"),
            1409 => array("&iexcl;Primero del reino! Elfo de la noche nivel 80", "achievement_character_nightelf_male"),
            1410 => array("&iexcl;Primero del reino! Orco nivel 80", "achievement_character_orc_male"),
            1411 => array("&iexcl;Primero del reino! Tauren nivel 80", "achievement_character_tauren_female"),
            1412 => array("&iexcl;Primero del reino! Trol nivel 80", "achievement_character_troll_male"),
            1413 => array("&iexcl;Primero del reino! Renegado nivel 80", "achievement_character_undead_male"),
            
            1414 => array("&iexcl;Primero del reino! Gran maestro Herrero", "trade_blacksmithing"),
            1415 => array("&iexcl;Primero del reino! Gran maestro Alquimista", "trade_alchemy"),
            1416 => array("&iexcl;Primero del reino! Gran maestro Cocinero", "inv_misc_food_15"),
            1417 => array("&iexcl;Primero del reino! Gran maestro Encantador", "trade_engraving"),
            1418 => array("&iexcl;Primero del reino! Gran maestro Ingeniero", "trade_engineering"),
            1419 => array("&iexcl;Primero del reino! Gran maestro en Primeros auxilios", "spell_holy_sealofsacrifice"),
            1420 => array("&iexcl;Primero del reino! Gran maestro Pescador", "trade_fishing"),
            1421 => array("&iexcl;Primero del reino! Gran maestro Herborista", "trade_herbalism"),
            1422 => array("&iexcl;Primero del reino! Gran maestro Escriba", "inv_feather_05"),
            1423 => array("&iexcl;Primero del reino! Gran maestro Joyero", "inv_misc_gem_01"),
            1424 => array("&iexcl;Primero del reino! Gran maestro Peletero", "trade_leatherworking"),
            1425 => array("&iexcl;Primero del reino! Gran maestro Minero", "trade_mining"),
            1426 => array("&iexcl;Primero del reino! Gran maestro Desollador", "inv_misc_pelt_wolf_01"),
            1427 => array("&iexcl;Primero del reino! Gran maestro Sastre", "trade_tailoring")
        );
        
        $result = $this->connection->query("SELECT a.achievement AS aid, b.guid AS guid, b.name AS name FROM character_achievement AS a, characters AS b WHERE a.guid = b.guid AND b.name != '' AND ((achievement >= 457 AND achievement <= 467) OR (achievement >= 1404 AND achievement <= 1427)) ORDER BY a.achievement;");
		
		if($result && $result->num_rows() > 0)
		{
			$players = $result->result_array();
			
			$i = 1;
			foreach ($players as $key => $player)
			{
				$players[$key]['rank'] = $i;
				$players[$key]['achiname'] = $data[$players[$key]['aid']][0];
				$players[$key]['achiicon'] = $data[$players[$key]['aid']][1];
				$i++;
			}			
			return $players;
		}		
		unset($result);		
		return false;
	}
}