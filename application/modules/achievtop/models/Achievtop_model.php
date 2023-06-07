<?php

class Achievtop_model extends CI_Model
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

	public function getAchievTopPlayers($count = 25)
	{
		if (!ctype_digit($count))
		{
			$count = 25;
		}
		
		$this->connect();
		
		$result = $this->connection->query("SELECT a.guid AS guid, b.name AS name, b.level AS level, b.race AS race, b.gender AS gender, b.class AS class, COUNT(*) AS total FROM character_achievement AS a, characters AS b WHERE b.guid = a.guid AND b.name != ''  GROUP BY a.guid ORDER BY total DESC LIMIT 0,?;", array($count));
		
		if($result && $result->num_rows() > 0)
		{
			$players = $result->result_array();
			
			$i = 1;
			foreach ($players as $key => $player)
			{
				$players[$key]['rank'] = $i;
				$i++;
			}			
			return $players;
		}		
		unset($result);		
		return false;
	}
}
