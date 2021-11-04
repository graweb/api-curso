<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alunos_model extends CI_Model {

    public function detalhe($id)
    {
        return $this->db->select('*')->from('vw_alunos')->where('fkidusuario', $id)->get()->result();
    }

    public function criar($data)
    {
        $this->db->insert('tb_alunos', $data);
        return array('status' => 201, 'message' => 'Registro criado com sucesso');
    }

    public function atualizar($id, $data)
    {
        $this->db->where('fkidusuario', $id)->update('tb_alunos', $data);
        if($this->db->affected_rows() === 0)
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            return array('status' => 202, 'message' => 'Registro atualizado com sucesso');
        }
    }
}