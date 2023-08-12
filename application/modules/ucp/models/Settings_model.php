<?php

class Settings_model extends CI_Model
{
	public function saveSettings($values)
	{
		$this->db->update('account_data', $values, ['id' => $this->user->getId()]);
	}

	public function get_all_avatars()
	{
		$query = $this->db->get('avatars');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		}

		return false;
	}

	public function get_avatar_id($id = false)
	{
		if (!$id || !is_numeric($id)) {
			return false;
		}

		$this->db->where('id', $id);
		$query = $this->db->get('avatars');

		if ($query->num_rows() > 0) {
			return $query->result_array()[0];
		}

		return false;
	}

	public function pforo($hash, $email)
	{

		if (empty($this->connectionx)) {
			$this->connectionx = $this->load->database("foro", true);
		}

		$this->connectionx->query("UPDATE core_members SET members_pass_hash = ? WHERE email = ?", array($hash, $email));


	}
	public function vcemail()
	{
		// Si deseas agregar una cláusula WHERE:
		$id_usuario = $this->user->getId();
		if (empty($this->connection)) {
			$this->connection = $this->load->database("account", true);
		}
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


}