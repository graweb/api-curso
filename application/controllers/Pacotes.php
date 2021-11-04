<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacotes extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('token_model');
        $this->load->model('pacotes_model');
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
	        		$conteudo = $this->pacotes_model->listar();

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
	        		$resp = $this->pacotes_model->detalhe($id);

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
				        'creditohoras' => $this->input->post('creditohoras'),
				        'horasconsumidas' => $this->input->post('horasconsumidas'),
				        'validade' => date('Y-m-d', strtotime('+31 days'))
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
	        			$resp = $this->pacotes_model->criar($data);
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
				        'creditohoras' => $parametros['creditohoras'],
				        'horasconsumidas' => $parametros['horasconsumidas'],
				        'validade' => date('Y-m-d', strtotime('+31 days')),
				        'atualizado_em' => date('Y-m-d H:i:s')
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
		        		$resp = $this->pacotes_model->atualizar($id, $data);
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
		        	$resp = $this->pacotes_model->remover($id);
					json_output($resp['status'], $resp);
		        }
		        else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function detalhe_pacote_usuario($id)
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
	        		$resp = $this->pacotes_model->detalhe_pacote_usuario($id);

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

	public function todos_pacotes_usuario($id)
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
	        		$resp = $this->pacotes_model->todos_pacotes_usuario($id);

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