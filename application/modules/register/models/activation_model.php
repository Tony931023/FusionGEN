<?php

class Activation_model extends CI_Model
{
	public function add($username, $password, $email, $expansion)
	{		
		
		$this->connect();

        $expansion = $this->config->item('max_expansion');

        $hash = $this->user->createHash($username, $password);
        $encryption = $this->realms->getEmulator()->encryption();

        $data = array(
            column("account", "username") => $username,
            column("account", "email") => $email,
            column("account", "expansion") => $expansion,
            column("account", "joindate") => date("Y-m-d H:i:s")
        );

        if ($encryption == 'SRP6' || $encryption == 'HEX') {
            $data[column("account", "password")] = $hash["verifier"];
            $data[column("account", "salt")] = $hash["salt"];
        } else {
            $data[column("account", "password")] = $hash["verifier"];
        }

        if (!preg_match("/^cmangos/i", get_class($this->realms->getEmulator())))
        {
            $data[column("account", "last_ip")] = $this->input->ip_address();
        }

        $userId = $this->connection->insert(table("account"), $data);

        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator())))
        {
            $ip_data = array(
                'accountId' => $userId,
                'ip' => $this->input->ip_address(),
                'loginTime' => date("Y-m-d H:i:s"),
                'loginSource' => '0'
            );

            $this->connection->insert(table("account_logons"), $ip_data);
        }

        // Battlenet accounts
        if ($this->realms->getEmulator()->battlenet() == true) {
            $userId = $this->user->getId($username);
            $hash = $this->user->createHash2($email, $password);

            $battleData = array(
                column("battlenet_accounts", "id") => $userId,
                column("battlenet_accounts", "email") => $email,
                column("battlenet_accounts", "sha_pass_hash") => $hash,
                column("battlenet_accounts", "last_ip") => $this->input->ip_address(),
                column("battlenet_accounts", "joindate") => date("Y-m-d H:i:s")
            );

            $this->connection->insert(table("battlenet_accounts"), $battleData);

            $this->connection->query("UPDATE account SET battlenet_account = $userId, battlenet_index = 1 WHERE id = $userId", array($userId));
        }

        // Fix for TrinityCore RBAC (or any emulator with 'rbac' in it's emulator filename)
        if (preg_match("/rbac/i", get_class($this->realms->getEmulator()))) {
            $userId = $this->user->getId($username);
            $this->connection->query("INSERT INTO rbac_account_permissions(`accountId`, `permissionId`, `granted`, `realmId`) values (?, 195, 1, -1)", array($userId));
        }
	}
	
	public function createAccountveremail($username, $password, $email)
    {
        $expansion = $this->config->item('max_expansion');

        $hash = $this->user->createHash($username, $password);
        $encryption = $this->realms->getEmulator()->encryption();
		
		$data = array(
			'username' => $username,
			'email' => $email,			
			'expansion' => $expansion,
			'timestamp' => date("Y-m-d H:i:s"),			
			'key' => sha1($username.$email.$password.time())
			
		);

		if ($encryption == 'SRP6' || $encryption == 'HEX') {
            $data['password'] = $hash["verifier"];
            //$data['salt'] = $hash["salt"];
        } else {
            $data['password'] = $hash["verifier"];
        }  
		
		$this->db->insert("pending_accounts", $data);
		
		$result = array(			
			'email' => $email,
            'username' => $username,
            'key' => sha1($username.$email.$password.time())	
		);

		return $result;
        
        $this->updateDailySignUps();
    }

	public function getAccount($key)
	{
		$query = $this->db->query("SELECT * FROM pending_accounts WHERE `key`=?", array($key));

		if($query->num_rows())
		{
			$row = $query->result_array();

			return $row[0];
		}
		else
		{
			return false;
		}
	}

	public function remove($id, $username, $email)
	{
		$this->db->query("DELETE FROM pending_accounts WHERE id=? OR username=? OR email=?", array($id, $username, $email));
	}
}