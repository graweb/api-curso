<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('token_model');
		$this->load->model('email_model');
		$this->load->helper('json_output');
	}
	
	public function enviar_email() 
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
				$de = $this->input->post('de');
				$para = $this->input->post('para');
				$nome = $this->input->post('nome');
				$assunto = $this->input->post('assunto');
				$mensagem = $this->input->post('mensagem');

        		$resp = $this->email_model->enviar_email($de, $para, $nome, $assunto, $mensagem);
				json_output($resp['status'], $resp);
			}
		}
	}

	public function enviar_email_agenda_para_professor() 
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
				$de = $this->input->post('de');
				$para = $this->input->post('para');
				$nome = $this->input->post('nome');
				$assunto = $this->input->post('assunto');
				$mensagem = $this->input->post('mensagem');

        		$resp = $this->email_model->enviar_email_agenda_para_professor($de, $para, $nome, $assunto, $mensagem);
				json_output($resp['status'], $resp);
			}
		}
	}

	public function enviar_email_cancelamento() 
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
				$de = $this->input->post('de');
				$para = $this->input->post('para');
				$nome = $this->input->post('nome');
				$assunto = $this->input->post('assunto');
				$mensagem = $this->input->post('mensagem');

        		$resp = $this->email_model->enviar_email_cancelamento($de, $para, $nome, $assunto, $mensagem);
				json_output($resp['status'], $resp);
			}
		}
	}
}