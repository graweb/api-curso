<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model
{
	public function enviar_email($de, $para, $nome, $assunto, $mensagem) 
	{
		$this->load->library('email');

		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);

		if($para == null || $para == "")
		{
			$this->email->from($de, $nome);
			$this->email->to('pedagogico@faleeasy.com.br');
			$this->email->subject($assunto);
			$this->email->message($mensagem);
		}
		else
		{
			$this->email->from($de, $nome);
			$this->email->to($para);
			$this->email->cc('pedagogico@faleeasy.com.br');
			$this->email->subject($assunto);
			$this->email->message($mensagem);
		}

		$result = $this->email->send();

		if($result)
		{
			return array('status' => 200, 'message' => 'E-mail enviado com sucesso');
		}
	}

	public function enviar_email_agenda_para_professor($de, $para, $nome, $assunto, $mensagem) 
	{
		$prof = $this->db->where('nome', $para)->get('tb_usuarios')->row();

		$this->load->library('email');

		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);

		$this->email->from($de, $nome);
		$this->email->to($prof->email);
		$this->email->to('pedagogico@faleeasy.com.br');
		$this->email->subject($assunto);
		$this->email->message($mensagem);

		$result = $this->email->send();

		if($result)
		{
			return array('status' => 200, 'message' => 'E-mail enviado com sucesso');
		}
	}

	public function enviar_email_cancelamento($de, $para, $nome, $assunto, $mensagem) 
	{
		$this->load->library('email');

		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);

		$this->email->from($de, $nome);
		$this->email->to($para);
		$this->email->cc('pedagogico@faleeasy.com.br');
		$this->email->subject($assunto);
		$this->email->message($mensagem);

		$result = $this->email->send();

		if($result)
		{
			return array('status' => 200, 'message' => 'E-mail enviado com sucesso');
		}
	}
}