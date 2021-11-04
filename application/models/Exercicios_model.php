<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exercicios_model extends CI_Model {

	public function listar()
    {
        $query = $this->db->where('situacao', 1)->get('tb_exercicios');
        foreach ($query->result() as $row)
        {
            if($row->tipoquestao == 1)
            {
                $results[] = [
                    "type" => "multiple",
                    "question" => $row->exercicio,
                    "correct_answer" => $row->respostacorreta,
                    "incorrect_answers" => [
                        $row->respostaa,
                        $row->respostab,
                        $row->respostac,
                        $row->respostad,
                    ]
                ];
            }
            else
            {
                $results[] = [
                    "type" => "boolean",
                    "question" => $row->exercicio,
                    "correct_answer" => $row->respostacorreta,
                    "incorrect_answers" => [
                        $row->respostaa,
                        $row->respostab
                    ]
                ];
            }
            
        }

        return 
        $dados = [
            "response_code" => 0,
            "results" => $results
        ];
    }
}