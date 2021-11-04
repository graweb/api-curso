<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacotes_model extends CI_Model {

	public function listar()
    {
        return $this->db->where_in('situacao', array(0, 1))->order_by('idalunopacote','desc')->get('tb_alunos_pacote')->result();
    }

    public function detalhe($id)
    {
        return $this->db->where('idalunopacote', $id)->order_by('idalunopacote','desc')->get('tb_alunos_pacote')->row();
    }

    public function criar($data)
    {
        $this->db->insert('tb_alunos_pacote', $data);
        return array('status' => 201, 'message' => 'Registro criado com sucesso');
    }

    public function atualizar($id, $data)
    {
        $this->db->where('idalunopacote', $id)->update('tb_alunos_pacote', $data);
        if($this->db->affected_rows() === 0)
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            return array('status' => 202, 'message' => 'Registro atualizado com sucesso');
        }
    }

    public function remover($id)
    {
        $this->db->where('idalunopacote', $id)->delete('tb_alunos_pacote');
        if($this->db->affected_rows() === 0)
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            return array('status' => 202, 'message' => 'Registro removido com sucesso');
        }
    }

    public function detalhe_pacote_usuario($id)
    {
        return $this->db->where('fkidusuario', $id)->where('situacao', 1)->get('tb_alunos_pacote')->row();
    }

    public function todos_pacotes_usuario($id)
    {
        return $this->db->where_in('situacao', array(0, 1))->where('fkidusuario', $id)->order_by('idalunopacote','desc')->get('tb_alunos_pacote')->result();
    }
}