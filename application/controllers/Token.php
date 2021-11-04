<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('token_model');
        $this->load->helper('json_output');
    }

    // LOGIN
	public function login()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST')
		{
			json_output(400,array('status' => 400,'message' => 'Tipo de requisição errada, use POST'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
	        	$email = $this->input->post('email');
	        	$senha = $this->input->post('senha');

	        	if(is_null($email) || is_null($senha))
	        	{
	        		json_output(404, array('status' => 404, 'message' => 'Favor, informar todos os campos'));
	        	}
	        	else
	        	{
		        	$response = $this->token_model->login($email, $senha);
					json_output($response['status'], $response);
				}
			}
		}
	}

	// LOGOUT
	public function logout()
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
		        $response = $this->token_model->logout();
				json_output($response['status'], $response);
			}
		}
	}

	// VERIFICAR TOKEN
	public function verificar_token()
	{	
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET')
		{
			json_output(400, array('status' => 400,'message' => 'Tipo de requisição errada, use GET'));
		} 
		else 
		{
			$checar_header = $this->token_model->checar_header();
			if($checar_header == true)
			{
		        $response = $this->token_model->verificar_token();
				json_output($response['status'], $response);
			}
		}
	}
}
