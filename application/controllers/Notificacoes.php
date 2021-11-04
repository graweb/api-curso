<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacoes extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('token_model');
        $this->load->model('notificacoes_model');
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
	        		$conteudo = $this->notificacoes_model->listar();

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
	        		$resp = $this->notificacoes_model->detalhe($id);

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
					$data = array(
				        'fkidusuario' => $this->input->post('fkidusuario'),
				        'assunto' => $this->input->post('assunto'),
				        'mensagem' => $this->input->post('mensagem')
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
	        			$resp = $this->notificacoes_model->criar($data);
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
				        'assunto' => $parametros['assunto'],
				        'mensagem' => $parametros['mensagem']
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
		        		$resp = $this->notificacoes_model->atualizar($id, $data);
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
		        	$resp = $this->notificacoes_model->remover($id);
					json_output($resp['status'], $resp);
		        }
		        else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function detalhe_notificacao_usuario($id)
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
	        		$resp = $this->notificacoes_model->detalhe_notificacao_usuario($id);

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

	public function contar_notificacao_usuario($id)
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
	        		$resp = $this->notificacoes_model->contar_notificacao_usuario($id);

	        		if(is_null($resp))
	        		{
	        			json_output(203, array('status' => 203, 'message' => 'Registro não existe'));
	        		}
	        		else
	        		{
	        			json_output($response['status'], array('status' => 200, 'total' => "$resp", 'message' => 'Total calculado com sucesso'));
	        		}
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function marcar_como_lida($id)
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
				        'situacao' => 1,
				        'atualizado_em' => date('Y-m-d H:i:s')
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
		        		$resp = $this->notificacoes_model->marcar_como_lida($id, $data);
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
}