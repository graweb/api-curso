<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('token_model');
        $this->load->model('usuarios_model');
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
	        		$conteudo = $this->usuarios_model->listar();

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

	public function professores()
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
	        		$conteudo = $this->usuarios_model->professores();

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
	        		$resp = $this->usuarios_model->detalhe($id);

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
	        	/*$response = $this->token_model->verificar_token();
	        	$respStatus = $response['status'];
	        	if($response['status'] == 200)
	        	{
	        		$this->load->library('encryption');

					$data = array(
				        'nome' => $this->input->post('nome'),
				        'email' => $this->input->post('email'),
				        'senha' => hash("sha1", $this->input->post('senha'))
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
	        			$resp = $this->usuarios_model->criar($data);
					}
					json_output($resp['status'], $resp);
	        	}
	        	else
	        	{
	        		json_output($response['status'], $response);
	        	}*/

	        	// COMENTADO ACIMA POIS UM USUÁRIO NÃO PRECISA DO TOKEN PARA SE CADASTRAR
	        	$this->load->library('encryption');

				$data = array(
			        'nome' => $this->input->post('nome'),
			        'email' => $this->input->post('email'),
			        'senha' => hash("sha1", $this->input->post('senha'))
				);

				if (false !== array_search(false, $data, false)) 
				{
					$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
				} 
				else 
				{
        			$resp = $this->usuarios_model->criar($data);
				}
				json_output($resp['status'], $resp);
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
					$this->load->library('encryption');
					$parametros = json_decode(file_get_contents('php://input'), TRUE);

					$data = array(
				        'nome' => $parametros['nome'],
				        'usuario' => $parametros['usuario'],
				        'email' => $parametros['email'],
				        'senha' => hash("sha1", $parametros['senha']),
				        'atualizado_em' => date('Y-m-d H:i:s')
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
		        		$resp = $this->usuarios_model->atualizar($id, $data);
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
		        	$resp = $this->usuarios_model->remover($id);
					json_output($resp['status'], $resp);
		        }
		        else
	        	{
	        		json_output($response['status'], $response);
	        	}
			}
		}
	}

	public function recuperar_senha()
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
	        	$this->load->library('encryption');

				$data = array(
			        'senha' => hash("sha1", $this->input->post('senha'))
				);

				if (false !== array_search(false, $data, false)) 
				{
					$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
				} 
				else 
				{
        			$resp = $this->usuarios_model->recuperar_senha($this->input->post('email'), $data);
				}
				json_output($resp['status'], $resp);
			}
		}
	}

	public function mudar_senha($id)
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
	        	$this->load->library('encryption');

				$data = array(
			        'senha' => hash("sha1", $this->input->post('senha')),
			        'mudar_senha' => 0
				);

        		$resp = $this->usuarios_model->mudar_senha($id, $data);
				json_output($resp['status'], $resp);
			}
		}
	}
}