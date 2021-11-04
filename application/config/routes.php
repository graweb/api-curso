<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'apieasyenglish';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ROTAS DE LOGIN/LOGOUT
$route['token/login']['post']  = 'token/login';
$route['token/logout']['post'] = 'token/logout';
$route['token/verificar_token']['get'] = 'token/verificar_token';

/*
// ROTA ENVIAR E-MAIL
*/
$route['email/enviar_email']['post'] = "email/enviar_email";
$route['email/enviar_email_agenda_para_professor']['post'] = "email/enviar_email_agenda_para_professor";
$route['email/enviar_email_cancelamento']['post'] = "email/enviar_email_cancelamento";

// ROTAS USUÁRIOS
$route['usuarios']['get'] = 'usuarios';
$route['usuarios/professores']['get'] = 'usuarios/professores';
$route['usuarios/detalhe/(:num)']['get'] = 'usuarios/detalhe/$1';
$route['usuarios/criar']['post'] = 'usuarios/criar';
$route['usuarios/atualizar/(:num)']['put'] = 'usuarios/atualizar/$1';
$route['usuarios/remover/(:num)']['delete'] = 'usuarios/remover/$1';
$route['usuarios/recuperar_senha/(:num)']['post'] = 'usuarios/recuperar_senha/$1';
$route['usuarios/mudar_senha/(:num)']['post'] = 'usuarios/mudar_senha/$1';

// ROTAS PACOTE
$route['pacotes']['get'] = 'pacotes';
$route['pacotes/detalhe/(:num)']['get'] = 'pacotes/detalhe/$1';
$route['pacotes/criar']['post'] = 'pacotes/criar';
$route['pacotes/atualizar/(:num)']['put'] = 'pacotes/atualizar/$1';
$route['pacotes/remover/(:num)']['delete'] = 'pacotes/remover/$1';
$route['pacotes/detalhe_pacote_usuario/(:num)']['get'] = 'pacotes/detalhe_pacote_usuario/$1';
$route['pacotes/todos_pacotes_usuario/(:num)']['get'] = 'pacotes/todos_pacotes_usuario/$1';

// ROTAS AGENDA
$route['agenda']['get'] = 'agenda';
$route['agenda/detalhe/(:num)']['get'] = 'agenda/detalhe/$1';
$route['agenda/criar']['post'] = 'agenda/criar';
$route['agenda/atualizar/(:num)']['put'] = 'agenda/atualizar/$1';
$route['agenda/remover/(:num)']['delete'] = 'agenda/remover/$1';
$route['agenda/detalhe_agenda_usuario/(:num)']['get'] = 'agenda/detalhe_agenda_usuario/$1';
$route['agenda/detalhe_agenda_ultima_aula_usuario/(:num)']['get'] = 'agenda/detalhe_agenda_ultima_aula_usuario/$1';
$route['agenda/cancelar/(:num)']['put'] = 'agenda/cancelar/$1';
$route['agenda/confirma_cancelar/(:num)/(:num)/(:num)/(:num)']['put'] = 'agenda/confirma_cancelar/$1/$2/$3/$4';
$route['agenda/todas_agendas_usuario/(:num)']['get'] = 'agenda/todas_agendas_usuario/$1';
$route['agenda/listar_agenda_professor/(:any)/(:any)']['get'] = 'agenda/listar_agenda_professor/$1/$2';
$route['agenda/todas_notas_usuario/(:num)']['get'] = 'agenda/todas_notas_usuario/$1';

// ROTAS NOTIFICACÕES
$route['notificacoes']['get'] = 'notificacoes';
$route['notificacoes/detalhe/(:num)']['get'] = 'notificacoes/detalhe/$1';
$route['notificacoes/criar']['post'] = 'notificacoes/criar';
$route['notificacoes/atualizar/(:num)']['put'] = 'notificacoes/atualizar/$1';
$route['notificacoes/remover/(:num)']['delete'] = 'notificacoes/remover/$1';
$route['notificacoes/detalhe_notificacao_usuario/(:num)']['get'] = 'notificacoes/detalhe_notificacao_usuario/$1';
$route['notificacoes/contar_notificacao_usuario/(:num)']['get'] = 'notificacoes/contar_notificacao_usuario/$1';
$route['notificacoes/marcar_como_lida/(:num)']['put'] = 'notificacoes/marcar_como_lida/$1';

// ROTAS ALUNOS
$route['alunos/detalhe/(:num)']['get'] = 'alunos/detalhe/$1';
$route['alunos/criar']['post'] = 'alunos/criar';
$route['alunos/atualizar/(:num)']['post'] = 'alunos/atualizar/$1';

// ROTAS EXERCICIOS
$route['exercicios']['get'] = 'exercicios';