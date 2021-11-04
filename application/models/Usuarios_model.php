<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public function listar()
    {
        return $this->db->where('situacao', 1)->order_by('idusuario','desc')->get('tb_usuarios')->result();
    }

    public function professores()
    {
        return $this->db->where('fkidpermissao', 2)->where('situacao', 1)->order_by('idusuario','desc')->get('tb_usuarios')->result();
    }

    public function detalhe($id)
    {
        return $this->db->select('*')->from('tb_usuarios')->where('idusuario', $id)->order_by('idusuario','desc')->get()->row();
    }

    public function criar($data)
    {
        $this->db->where('email', $data['email'])->get('tb_usuarios')->row();
        if($this->db->affected_rows() === 0)
        {
            $this->db->insert('tb_usuarios', $data);
            $idUser = $this->db->insert_id();
            $this->db->set('fkidusuario', $idUser);
            $this->db->insert('tb_alunos');
            
            return array('status' => 201, 'message' => 'Registro criado com sucesso');
        }
        else
        {
            return array('status' => 205, 'message' => 'Registro já existe');
        }
    }

    public function atualizar($id, $data)
    {
        $this->db->where('idusuario', $id)->update('tb_usuarios', $data);
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
        $this->db->where('idusuario', $id)->delete('tb_usuarios');
        if($this->db->affected_rows() === 0)
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            return array('status' => 202, 'message' => 'Registro removido com sucesso');
        }
    }

    public function recuperar_senha($email, $data) 
    {
        $this->db->where('email', $email)->update('tb_usuarios', $data);
        if($this->db->affected_rows() === 0)
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            return array('status' => 202, 'message' => 'Registro atualizado com sucesso');
        }
    }

    public function mudar_senha($id, $data) 
    {
        $this->db->where('idusuario', $id)->update('tb_usuarios', $data);
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