<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exercicios extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('token_model');
        $this->load->model('exercicios_model');
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
	        		$conteudo = $this->exercicios_model->listar();

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
}