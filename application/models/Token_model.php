<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model {

    var $accept = "application/json";

    public function checar_header()
    {
        $accept = $this->input->get_request_header('Accept', TRUE);
        
        if($accept == $this->accept)
        {
            return true;
        } 
        else 
        {
            return json_output(401, array('status' => 401, 'message' => 'Não autorizado'));
        }
    }

    public function login($email, $senha)
    {
        $this->load->library('encryption');

        // PEGA OS DADOS DO USUÁRIO
        $query = $this->db->select('idusuario, nome, email, senha, mudar_senha')->from('tb_usuarios')->where('email', $email)->where('situacao', 1)->get()->row();

        // SE FOR VAZIO OU USUÁRIO INATIVO, RETORNA 203
        if(is_null($query))
        {
            return array('status' => 203, 'message' => 'Usuário não encontrado ou inativo');
        } 
        else 
        {
            // VARIÁVEIS DO USUÁRIO
            $idusuario = $query->idusuario;
            $senha_usuario = $query->senha;

            // VERIFICA SE EXISTE UM TOKEN GERADO
            $queryId = $this->db->select('fkidusuario')->from('tb_usuarios_autenticados')->where('fkidusuario', $idusuario)->get()->row();

            // VARIÁVEIS
            $ultimo_acesso = date('Y-m-d H:i:s');
            $token = hash("sha512", substr(md5(rand()), 0, 9));
            $expira_em = date("Y-m-d H:i:s", strtotime('+2 week'));
            $atualizado_em = date('Y-m-d H:i:s');

            // SE EXISTIR, ATUALIZA O TOKEN SE NÃO CRIA
            if(!is_null($queryId))
            {
                if($queryId->fkidusuario == $idusuario)
                {
                    $this->db->where('fkidusuario', $idusuario)->update('tb_usuarios_autenticados', array('token' => $token, 'expira_em' => $expira_em, 'atualizado_em' => $atualizado_em));
                    return array('status' => 200, 'message' => 'Token atualizado com sucesso', 'idusuario' => $idusuario, 'nome' => $query->nome, 'email' => $email, 'mudar_senha' => $query->mudar_senha, 'token' => $token);
                }
            }
            else
            {
                if (hash_equals($senha_usuario, hash("sha1", $senha))) 
                {
                    $this->db->trans_start();
                    $this->db->where('idusuario', $idusuario)->update('tb_usuarios', array('ultimo_acesso' => $ultimo_acesso));
                    $this->db->insert('tb_usuarios_autenticados',array('fkidusuario' => $idusuario, 'token' => $token,'expira_em' => $expira_em));

                    if ($this->db->trans_status() === FALSE)
                    {
                        $this->db->trans_rollback();
                        return array('status' => 500,'message' => 'Erro interno');
                    }
                    else 
                    {
                        $this->db->trans_commit();
                        return array('status' => 200, 'message' => 'Logado com sucesso', 'idusuario' => $idusuario, 'nome' => $query->nome, 'email' => $email, 'mudar_senha' => $query->mudar_senha, 'token' => $token);
                    }
                } 
                else 
                {
                    return array('status' => 404, 'message' => 'Senha incorreta');
                }
            }
        }
    }

    public function logout()
    {
        $token = $this->input->get_request_header('Authorization', TRUE);
        
        if($token)
        {
            $this->db->where('token', $token)->delete('tb_usuarios_autenticados');
            $removeu = $this->db->affected_rows();

            if($removeu == 0)
            {
                return array('status' => 403, 'message' => 'Token inválido');
            }
            else
            {
                return array('status' => 200, 'message' => 'Logout realizado com sucesso');
            }
        }
        else
        {
            return array('status' => 403, 'message' => 'Token inválido');
        }
    }

    public function verificar_token()
    {
        $token = $this->input->get_request_header('Authorization', TRUE);
        $query = $this->db->select('expira_em')->from('tb_usuarios_autenticados')->where('token', $token)->get()->row();

        if(is_null($query))
        {
            return array('status' => 403, 'message' => 'Token inválido');
        } 
        else 
        {
            if($query->expira_em < date('Y-m-d H:i:s'))
            {
                return array('status' => 401, 'message' => 'Token expirado');
            } 
            else 
            {
                $infoUsu = $this->db->select('*')->from('vw_usuarios_autenticados')->where('token', $token)->get()->row();

                return array('status' => 200, 'message' => 'Token válido', 'idusuario' => $infoUsu->idusuario, 'nome' => $infoUsu->nome, 'email' => $infoUsu->email, 'token' => $token, 'Expira em:' => date('d/m/Y H:i:s', strtotime($query->expira_em)));
            }
        }
    }
}