<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('token_model');
        $this->load->model('agenda_model');
        $this->load->helper('json_output');
    }

	public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'GET')
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use GET'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$response = $this->token_model->verificar_token();
	        	if($response['status'] == 200)
	        	{
	        		$conteudo = $this->agenda_model->listar();

	        		if(count($conteudo) == 0)
	        		{
	        			json_output(203, array('status' => 203, 'message' => 'Registro não existe'));
	        		}
	        		else
	        		{
	        			json_output($response['status'], $conteudo);
	        		}
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function detalhe($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use GET'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$response = $this->token_model->verificar_token();
	        	if($response['status'] == 200)
	        	{
	        		$resp = $this->agenda_model->detalhe($id);

	        		if(is_null($resp))
	        		{
	        			json_output(203, array('status' => 203, 'message' => 'Registro não existe'));
	        		}
	        		else
	        		{
	        			json_output($response['status'], $resp);
	        		}
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function criar()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST')
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use POST'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$response = $this->token_model->verificar_token();
	        	$respStatus = $response['status'];
	        	if($response['status'] == 200)
	        	{
	        		$fkidusuario = $this->input->post('fkidusuario');

					$data = array(
				        'fkidusuario' => $fkidusuario,
				        'professor' => $this->input->post('professor'),
				        'dia' => $this->input->post('dia'),
				        'horainicio' => $this->input->post('horainicio'),
				        'horafim' => $this->input->post('horafim')
					);

					$dataSituacaoConfirmado = array(
				        'fkidusuario' => $fkidusuario,
				        'professor' => $this->input->post('professor'),
				        'dia' => $this->input->post('dia'),
				        'horainicio' => $this->input->post('horainicio'),
				        'horafim' => $this->input->post('horafim'),
				        'situacao' => 1
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
	        			$resp = $this->agenda_model->criar($fkidusuario, $data, $dataSituacaoConfirmado);
					}
					json_output($resp['status'], $resp);
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function atualizar($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'PUT' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use PUT'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
		        $response = $this->token_model->verificar_token();
		        $respStatus = $response['status'];
				if($response['status'] == 200)
				{
					$parametros = json_decode(file_get_contents('php://input'), TRUE);

					$data = array(
				        'professor' => $parametros['professor'],
				        'dia' => $parametros['dia'],
				        'horainicio' => $parametros['horainicio'],
				        'horafim' => $parametros['horafim'],
				        'atualizado_em' => date('Y-m-d H:i:s')
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
		        		$resp = $this->agenda_model->atualizar($id, $data);
					}
					json_output($resp['status'], $resp);
		       	}
		       	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function remover($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'DELETE' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use DELETE'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
		        $response = $this->token_model->verificar_token();
		        if($response['status'] == 200)
		        {
		        	$resp = $this->agenda_model->remover($id);
					json_output($resp['status'], $resp);
		        }
		        else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function detalhe_agenda_usuario($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use GET'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$response = $this->token_model->verificar_token();
	        	if($response['status'] == 200)
	        	{
	        		$resp = $this->agenda_model->detalhe_agenda_usuario($id);

	        		if(is_null($resp))
	        		{
	        			json_output(203, array('status' => 203, 'message' => 'Registro não existe'));
	        		}
	        		else
	        		{
	        			json_output($response['status'], $resp);
	        		}
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function detalhe_agenda_ultima_aula_usuario($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use GET'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$response = $this->token_model->verificar_token();
	        	if($response['status'] == 200)
	        	{
	        		$resp = $this->agenda_model->detalhe_agenda_ultima_aula_usuario($id);

	        		if(is_null($resp))
	        		{
	        			json_output(203, array('status' => 203, 'message' => 'Registro não existe'));
	        		}
	        		else
	        		{
	        			json_output($response['status'], $resp);
	        		}
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function cancelar($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'PUT' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use PUT'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
		        $response = $this->token_model->verificar_token();
		        $respStatus = $response['status'];
				if($response['status'] == 200)
				{
					// PEGA OS DADOS DO AGENDAMENTO
        			$query = $this->db->select('dia, horainicio')->from('tb_agenda')->where('idagenda', $id)->get()->row();
        			//$convertedia = date('Y-m-d', strtotime($query->dia));

        			if(date("Y-m-d H") >= date('Y-m-d', strtotime('-24 hour', strtotime($query->dia))) . ' ' . $query->horainicio)
        			{
        				$resp = array('status' => 205, 'message' => 'Não pode ser executada devido as regras do negócio');
        			}
					else
					{
						$data = array(
					        'situacao' => 3,
					        'atualizado_em' => date('Y-m-d H:i:s')
						);

						if (false !== array_search(false, $data, false)) 
						{
							$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
						}
						else
						{
			        		$resp = $this->agenda_model->cancelar($id, $data);
						}
					}
					json_output($resp['status'], $resp);
		       	}
		       	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function confirma_cancelar($id, $fkidusuario, $horainicio, $horafim)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'PUT' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use PUT'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
		        $response = $this->token_model->verificar_token();
		        $respStatus = $response['status'];
				if($response['status'] == 200)
				{
					$data = array(
				        'situacao' => 3,
				        'atualizado_em' => date('Y-m-d H:i:s')
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					}
					else
					{
		        		$resp = $this->agenda_model->confirma_cancelar($id, $data, $fkidusuario, $horainicio, $horafim);
					}
					json_output($resp['status'], $resp);
		       	}
		       	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function todas_agendas_usuario($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use GET'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$response = $this->token_model->verificar_token();
	        	if($response['status'] == 200)
	        	{
	        		$resp = $this->agenda_model->todas_agendas_usuario($id);

	        		if(is_null($resp))
	        		{
	        			json_output(203, array('status' => 203, 'message' => 'Registro não existe'));
	        		}
	        		else
	        		{
	        			json_output($response['status'], $resp);
	        		}
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function listar_agenda_professor($professor, $dia)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET')
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use GET'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$response = $this->token_model->verificar_token();
	        	if($response['status'] == 200)
	        	{
	        		$resp = $this->agenda_model->listar_agenda_professor($professor, $dia);

	        		if(is_null($resp) || empty($resp))
	        		{
	        			json_output(203, array('status' => 203, 'message' => 'Registro não existe'));
	        		}
	        		else
	        		{
	        			json_output($response['status'], $resp);
	        		}
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function todas_notas_usuario($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
		{
			json_output(400,array('status' => 400, 'message' => 'Tipo de requisição errada, use GET'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$response = $this->token_model->verificar_token();
	        	if($response['status'] == 200)
	        	{
	        		$resp = $this->agenda_model->todas_notas_usuario($id);

	        		if(is_null($resp))
	        		{
	        			json_output(203, array('status' => 203, 'message' => 'Registro não existe'));
	        		}
	        		else
	        		{
	        			json_output($response['status'], $resp);
	        		}
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}
}