<?php

class Storepd_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ver_donaciones()
    {
        $this->db->select();
        $this->db->from('donacion');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return "kk";
        }
    }

    public function ver_rdon($id)
    {
        $query = $this->db->query("SELECT rdon FROM account_data WHERE id=?", array($id));
        $row = $query->row();
        return $row->rdon;
    }
    public function update_ron($id_acc, $rdon)
    {
        $this->db->query("UPDATE account_data SET rdon = ? WHERE id = ?", array($rdon, $id_acc));
    }

    public function create_token($tpd, $acc, $accid, $token)
    {

        $create_token = array(
            'user' => $acc,
            'token' => $token,
            'pd' => $tpd,
            'estado' => '0',
            'f_creado' => date("Y-m-d H:i:s"),
            'id_user' => $accid
        );

        $this->db->insert("tokenpd", $create_token);
        $pd = $this->user->getDp();
        $pd_u = $pd - $tpd;
        $this->db->query("UPDATE account_data SET dp = ? WHERE id = ?", array($pd_u, $accid));
    }

    public function create_token_prev($token)
    {

        $query = $this->db->query("SELECT token FROM tokenpd WHERE id=?", array($token));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function token_creados($id)
    {
        $query = $this->db->query("SELECT  COUNT(*) token FROM tokenpd WHERE id_user=?", array($id));
        $row = $query->row();
        return $row->token;
    }
    public function token_recibido($id)
    {
        $query = $this->db->query("SELECT  COUNT(*) token FROM tokenpd WHERE id_recibido=?", array($id));
        $row = $query->row();
        return $row->token;
    }

    public function ver_token($token)
    {
        $query = $this->db->query("SELECT * FROM tokenpd WHERE token=?", array($token));
        $row = $query->row();

        if ($row == NULL) {
            return false;
        } else {
            return $row = $query->row();
        }
    }
    public function acr_token($id_user, $name_user, $token, $off, $v_token)
    {
        if ($off == 5) {
            $off = 2;
        }
        $fecha = date("Y-m-d H:i:s");
        $this->db->query("UPDATE tokenpd SET estado = ?, f_recibido = ?, id_recibido = ?, user_recibido = ? WHERE token = ?", array($off, $fecha, $id_user, $name_user, $token));

        $pd = $this->user->getDp();
        $pd_u = $pd + $v_token;
        $this->db->query("UPDATE account_data SET dp = ? WHERE id = ?", array($pd_u, $id_user));
    }
    public function del_token()
    {

        $query = $this->db->get('tokenpd');

        // Verifica si hay resultados
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }
    public function findAll()
    {
        $this->db->select();
        $this->db->from('tokenpd');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return "kk";
        }

    }
    public function find($id)
    {
        $this->db->select();
        $this->db->from('tokenpd');
        $this->db->where('id_user', $id);
        $this->db->where('estado', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }





}