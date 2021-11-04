<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

	public function listar()
    {
        return $this->db->select('*')->from('tb_agenda')->order_by('idagenda','desc')->get()->result();
    }

    public function detalhe($id)
    {
        return $this->db->select('*')->from('tb_agenda')->where('idagenda', $id)->order_by('idagenda','desc')->get()->row();
    }

    public function criar($fkidusuario, $data, $dataSituacaoConfirmado)
    {
        // PEGA O SALDO DO PACOTE ATIVO DO USUÁRIO
        $this->db->where('fkidusuario', $fkidusuario);
        $this->db->where('situacao', 1);
        $saldo = $this->db->get('tb_alunos_pacote')->row();

        if(is_null($saldo) || $saldo == "" || $saldo->creditohoras == 0)
        {
            $this->db->insert('tb_agenda', $data);
            return array('status' => 201, 'message' => 'Registro criado com sucesso');
        }
        else
        {
            $this->db->insert('tb_agenda', $dataSituacaoConfirmado);
            return array('status' => 201, 'message' => 'Registro criado com sucesso');
        }
    }

    public function atualizar($id, $data)
    {
        $this->db->where('idagenda', $id)->update('tb_agenda', $data);
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
        $this->db->where('idagenda', $id)->delete('tb_agenda');
        if($this->db->affected_rows() === 0)
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            return array('status' => 202, 'message' => 'Registro removido com sucesso');
        }
    }

    public function detalhe_agenda_usuario($id)
    {
        return $this->db->select('*')->from('tb_agenda')->where('fkidusuario', $id)->where('situacao', 1)->get()->row();
    }

    public function detalhe_agenda_ultima_aula_usuario($id)
    {
        return $this->db->select('*')->from('tb_agenda')->where('fkidusuario', $id)->where('situacao', 2)->order_by('idagenda','desc')->get()->row();
    }

    public function cancelar($id, $data)
    {
        $this->db->where('idagenda', $id)->where_in('situacao', array(0,1))->update('tb_agenda', $data);
        if($this->db->affected_rows() === 0)
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            return array('status' => 202, 'message' => 'Registro atualizado com sucesso');
        }
    }

    public function confirma_cancelar($id, $data, $fkidusuario, $horainicio, $horafim)
    {
        // CALCULA AS HORAS DA AULA
        $tothora = $horafim - $horainicio;

        // PEGA O SALDO DO PACOTE ATIVO DO USUÁRIO
        $this->db->where('fkidusuario', $fkidusuario);
        $this->db->where('situacao', 1);
        $saldo = $this->db->get('tb_alunos_pacote')->row();

        if(is_null($saldo))
        {
            return array('status' => 203, 'message' => 'Registro não existe');
        }
        else
        {
            // CALCULA O SALDO
            $totsaldo = $saldo->creditohoras - $tothora;

            // ATUALIZA O SALDO DE HORAS E O SALDO RESTANTE DO PACOTE
            $this->db->where('fkidusuario', $fkidusuario);
            $this->db->where('situacao', 1);
            $this->db->update('tb_alunos_pacote',array(
                'creditohoras'=>$totsaldo,
                'horasconsumidas'=>$tothora + $saldo->horasconsumidas
            ));

            // FINALIZA O CANCELAMENTO
            $this->db->where('idagenda', $id)->where_in('situacao', array(0,1))->update('tb_agenda', $data);
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

    public function todas_agendas_usuario($id)
    {
        return $this->db->select('*')->from('vw_agenda')->where('fkidusuario', $id)->order_by('idagenda', 'desc')->get()->result();
    }

    public function listar_agenda_professor($professor, $dia)
    {
        $nome = explode("%20", $professor);
        $this->db->where('professor', $nome[0] . " " . $nome[1]);
        $this->db->where('dia', $dia);
        $this->db->where('situacao <>', 3);
        $this->db->order_by('dia','desc');
        $query = $this->db->get('tb_agenda');

        if($query->num_rows() === 0)
        {
            return $this->db->get('tb_horario_professor')->result();
        }
        else
        {
            $horinicio = array();
            $horfim = array();

            foreach ($query->result() as $row):
                $horinicio[] = $row->horainicio;
                $horfim[] = $row->horafim;
            endforeach;

            $this->db->where_not_in('horainicio', $horinicio);
            $this->db->where_not_in('horafim', $horfim);
            $querydisp = $this->db->get('tb_horario_professor');
            
            if($querydisp->num_rows() === 0)
            {
                return array([
                    "idhorarioprofessor" => "0",
                    "horainicio" => "0",
                    "horafim" => "0"
                ]);
            }
            else
            {
                return $querydisp->result();
            }
        }
        

        /*if($query->num_rows() == 0)
        {
            return $this->db->get('tb_horario_professor')->result();
        }
        else
        {
            $horinicio = array();
            $horfim = array();

            foreach ($query->result() as $row)
            {
                $horinicio = $row->horainicio;
                $horfim = $row->horafim;
            }

            $this->db->where_not_in('horainicio', $horinicio);
            $this->db->where_not_in('horafim', $horfim);
            return $this->db->get('tb_horario_professor')->result();
        }*/
        
    }

    public function todas_notas_usuario($id)
    {
        return $this->db->select('*')->from('vw_notas')->where('fkidusuario', $id)->where('situacao', 2)->order_by('idagenda', 'desc')->get()->result();
    }
}