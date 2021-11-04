<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacoes_model extends CI_Model {

	public function listar()
    {
        return $this->db->select('*')->from('tb_notificacoes')->order_by('idnotificacao','desc')->get()->result();
    }

    public function detalhe($id)
    {
        return $this->db->select('*')->from('tb_notificacoes')->where('idnotificacao', $id)->order_by('idnotificacao','desc')->get()->row();
    }

    public function criar($data)
    {
        $this->db->insert('tb_notificacoes', $data);
        return array('status' => 201, 'message' => 'Registro criado com sucesso');
    }

    public function atualizar($id, $data)
    {
        $this->db->where('idnotificacao', $id)->update('tb_notificacoes', $data);
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
        $this->db->where('idnotificacao', $id)->delete('tb_notificacoes');
        if($this->db->affected_rows() === 0)
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            return array('status' => 202, 'message' => 'Registro removido com sucesso');
        }
    }

    public function detalhe_notificacao_usuario($id)
    {
        return $this->db->select('*')->from('tb_notificacoes')->where('fkidusuario', $id)->order_by('idnotificacao','desc')->get()->result();
    }

    public function contar_notificacao_usuario($id)
    {
        return $this->db->select('*')->from('tb_notificacoes')->where('fkidusuario', $id)->where('situacao', 0)->count_all_results();
    }

    public function marcar_como_lida($id, $data)
    {
        $this->db->where('idnotificacao', $id)->update('tb_notificacoes', $data);
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