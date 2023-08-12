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

        if (!preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
            $data[column("account", "last_ip")] = $this->input->ip_address();
        }

        $userId = $this->connection->insert(table("account"), $data);

        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
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
            'key' => sha1($username . $email . $password . time())

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
            'key' => sha1($username . $email . $password . time())
        );

        return $result;

        $this->updateDailySignUps();
    }

    public function getAccount($key)
    {
        $query = $this->db->query("SELECT * FROM pending_accounts WHERE `key`=?", array($key));

        if ($query->num_rows()) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function remove($id, $username, $email)
    {
        $this->db->query("DELETE FROM pending_accounts WHERE id=? OR username=? OR email=?", array($id, $username, $email));
    }

    public function aforo($user, $pass, $email)
    {
        $fecha_actual = date('Y-m-d H:i:s'); // Obtener la fecha actual en formato 'YYYY-MM-DD HH:MM:SS'
        $timestamp_unix = strtotime($fecha_actual);
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $user = ucfirst(strtolower($user));

        if (empty($this->connectionx)) {
            $this->connectionx = $this->load->database("foro", true);
        }

        $insert_sql = "insert into `core_members` ( `name`, `member_group_id`, `email`, `joined`, `ip_address`, `skin`, `warn_level`, `warn_lastwarn`, `language`, `restrict_post`, `bday_day`, `bday_month`, `bday_year`, `msg_count_new`, `msg_count_total`, `msg_count_reset`, `msg_show_notification`, `last_visit`, `last_activity`, `mod_posts`, `auto_track`, `temp_ban`, `mgroup_others`, `members_seo_name`, `members_cache`, `failed_logins`, `failed_login_count`, `members_profile_views`, `members_pass_hash`, `members_pass_salt`, `members_bitoptions`, `members_day_posts`, `notification_cnt`, `pp_last_visitors`, `pp_main_photo`, `pp_main_width`, `pp_main_height`, `pp_thumb_photo`, `pp_thumb_width`, `pp_thumb_height`, `pp_setting_count_comments`, `pp_reputation_points`, `pp_photo_type`, `signature`, `pconversation_filters`, `pp_customization`, `timezone`, `pp_cover_photo`, `profilesync`, `profilesync_lastsync`, `allow_admin_mails`, `members_bitoptions2`, `create_menu`, `members_disable_pm`, `marked_site_read`, `pp_cover_offset`, `acp_language`, `member_title`, `member_posts`, `member_last_post`, `member_streams`, `photo_last_update`, `mfa_details`, `failed_mfa_attempts`, `permission_array`, `completed`, `achievements_points`, `unique_hash`, `latest_alert`, `conv_password`, `conv_password_extra`, `idm_block_submissions`, `cm_credits`, `cm_no_sev`, `cm_return_group`)	
        values('" . $user . "','3','" . $email . "','" . $timestamp_unix . "','146.70.183.204','2',NULL,'0','3','0',NULL,NULL,NULL,'0','0','0','0',NULL,'0','0','{\"content\":0,\"comments\":0,\"method\":\"immediate\"}','0','','" . $user . "',NULL,NULL,'0','6','" . $pass . "',NULL,'0','0,0','0','{\"1\":1691567665}','monthly_2023_08/NicePng_world-of-warcraft-png_767679.png.657f45bf80bf39166517253bccbeec4c.png',NULL,NULL,'monthly_2023_08/NicePng_world-of-warcraft-png_767679.thumb.png.ade6a8396240f4a106ada8577b5c6be1.png',NULL,NULL,'0','0','custom','',NULL,NULL,'America/Havana','monthly_2023_08/vk01s637v8w01.jpg.cf5d222a19a00a97213dbbe4354ba7e7.jpg',NULL,'0','','16777232',NULL,'0','0','0',NULL,NULL,'0',NULL,NULL,'1691567364',NULL,'0',NULL,'','0',NULL,'0',NULL,NULL,'0',NULL,'0','0');";
        $this->connectionx->query($insert_sql);
    }
}