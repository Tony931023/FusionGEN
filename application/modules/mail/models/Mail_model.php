<?php

class Mail_model extends CI_Model
{
    private $connection;
    public function __construct()
    {
        parent::__construct();
        if (empty($this->connection)) {
            $this->connection = $this->load->database("account", true);
        }
    }

    public function vemail($id)
    {
        // Asegurarse de que $id sea un número entero (para evitar la inyección de SQL)
        $id = intval($id);

        // Realizar la consulta utilizando el Query Builder de CodeIgniter
        $this->db->select('vemail');
        $this->db->from('account_data');
        $this->db->where('id', $id);
        $query = $this->db->get();

        // Obtener la fila de resultados
        $row = $query->row();

        if ($row == NULL) {
            return false;
        } else {
            return $row->vemail;
        }
    }

    public function cemail($id)
    {
        // Asegurarse de que $id sea un número entero (para evitar la inyección de SQL)
        $id = intval($id);

        // Realizar la consulta utilizando el Query Builder de CodeIgniter
        $this->db->select('cemail');
        $this->db->from('account_data');
        $this->db->where('id', $id);
        $query = $this->db->get();

        // Obtener la fila de resultados
        $row = $query->row();

        if ($row == NULL) {
            return false;
        } else {
            return $row->cemail;
        }
    }

    public function v_mail()
    {
        $id = $this->user->getId();
        $this->db->query("UPDATE account_data SET vemail = 1 WHERE id = ?", array($id));
    }

    public function c_mail($v_mail, $xx)
    {
        $id = $this->user->getId();

        if ($xx == 1) {
            $pd = $this->user->getDp();
            $pd_u = $pd - 2;
            $this->db->query("UPDATE account_data SET dp = ? WHERE id = ?", array($pd_u, $id));
        }

        $external_account_access_data = array(
            'email' => $v_mail,
        );

        $this->connection->where(column('account', 'id'), $id);
        $this->connection->update(table('account'), $external_account_access_data);
        $this->db->query("UPDATE account_data SET cemail = 1, vemail = 0 WHERE id = ?", array($id));

    }

    public function vcemail()
    {
        // Si deseas agregar una cláusula WHERE:
        $id_usuario = $this->user->getId();
        // Realizar la consulta utilizando el Query Builder de CodeIgniter
        $this->connection->select('email');
        $this->connection->from('account');
        $this->connection->where('id', $id_usuario);
        $query = $this->connection->get();

        // Obtener la fila de resultados
        $row = $query->row();

        if ($row == NULL) {
            return false;
        } else {
            return $row->email;
        }

    }

    public function eforo($old_email, $account, $v_mail)
    {
        if (empty($this->connectionx)) {
            $this->connectionx = $this->load->database("foro", true);
        }

        $this->connectionx->query("UPDATE core_members SET email = ? WHERE email = ? AND name = ?", array($v_mail, $old_email, $account));

    }

    public function old_email()
    {

        // Realizar la consulta utilizando el Query Builder de CodeIgniter
        $this->connection->select('email');
        $this->connection->from('account');
        $this->connection->where('id', $this->user->getId());
        $query = $this->connection->get();

        // Obtener la fila de resultados
        $row = $query->row();

        if ($row == NULL) {
            return false;
        } else {
            return $row->email;
        }
    }
    public function account()
    {

        // Realizar la consulta utilizando el Query Builder de CodeIgniter
        $this->connection->select('username');
        $this->connection->from('account');
        $this->connection->where('id', $this->user->getId());
        $query = $this->connection->get();

        // Obtener la fila de resultados
        $row = $query->row();

        if ($row == NULL) {
            return false;
        } else {
            return $row->username;
        }
    }

    public function test()
    {
        if (empty($this->connectionx)) {
            $this->connectionx = $this->load->database("foro", true);
        }

        // Realizar la consulta utilizando el Query Builder de CodeIgniter
        $this->connection->select('email');
        $this->connection->from('account');
        $this->connection->where('id', $this->user->getId());
        $query = $this->connection->get();

        // Obtener la fila de resultados
        $row = $query->row();

        if ($row == NULL) {
            return false;
        } else {
            return $row->email;
        }
    }
}