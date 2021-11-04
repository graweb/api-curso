<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alunos extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('token_model');
        $this->load->model('alunos_model');
        $this->load->helper('json_output');
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
	        		$resp = $this->alunos_model->detalhe($id);

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
				        'cpf' => $this->input->post('cpf'),
				        'celular' => $this->input->post('celular'),
				        'nivel' => 1,
				        'datanascimento' => $this->input->post('datanascimento'),
				        'cep' => $this->input->post('cep'),
				        'uf' => $this->input->post('uf'),
				        'cidade' => $this->input->post('cidade'),
				        'bairro' => $this->input->post('bairro'),
				        'tipologradouro' => $this->input->post('tipologradouro'),
				        'logradouro' => $this->input->post('logradouro'),
				        'numero' => $this->input->post('numero'),
					);

					if (false !== array_search(false, $data, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					} 
					else 
					{
	        			$resp = $this->alunos_model->criar($data);
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
		if($method != 'POST' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE)
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
					$parametros = json_decode(file_get_contents('php://input'), true);

					$dados = array(
				        'cpf' => $this->input->post('cpf'),
				        'celular' => $this->input->post('celular'),
				        'nivel' => 1,
				        'datanascimento' => $this->input->post('datanascimento'),
				        'cep' => $this->input->post('cep'),
				        'uf' => $this->input->post('uf'),
				        'cidade' => $this->input->post('cidade'),
				        'bairro' => $this->input->post('bairro'),
				        'tipologradouro' => $this->input->post('tipologradouro'),
				        'logradouro' => $this->input->post('logradouro'),
				        'numero' => $this->input->post('numero'),
				        'atualizado_em' => date('Y-m-d H:i:s'),
					);

					if (false !== array_search(false, $dados, false)) 
					{
						$resp = array('status' => 404, 'message' => 'Favor, informar todos os campos');
					}
					else 
					{
		        		$resp = $this->alunos_model->atualizar($id, $dados);
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