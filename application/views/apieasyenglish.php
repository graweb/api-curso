<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>API Easy English</title>
</head>
<body>

<h1>API Easy English</h1>

<table border="1">
	<th>STATUS</th>
	<th>TIPO</th>
	<th>DESCRIÇÃO</th>
	<th>RETORNO</th>
	<tr>
		<td>200</td>
		<td>GET</td>
		<td>Requisição bem sucedida, retorna todos um ou todos os registros</td>
		<td></td>
	</tr>
	<tr>
		<td>201</td>
		<td>POST</td>
		<td>Requisição bem sucedida e criou um registro</td>
		<td></td>
	</tr>
	<tr>
		<td>202</td>
		<td>POST/PUT/DELETE</td>
		<td>Requisição bem sucedida e alterou um registro</td>
		<td></td>
	</tr>
	<tr>
		<td>203</td>
		<td>GET/POST</td>
		<td>Requisição bem sucedida, porém não existem registros</td>
		<td>Registro não existe</td>
	</tr>
	<tr>
		<td>205</td>
		<td>GET/POST/PUT/DELETE</td>
		<td>Requisição bem sucedida, porém não pode ser executada</td>
		<td>Não pode ser executada devido as regras doi negócio</td>
	</tr>
	<tr>
		<td>400</td>
		<td>GET/POST/PUT/DELETE</td>
		<td>Requisição mal sucedida</td>
		<td>Tipo de requisição errada, use GET/POST/PUT/DELETE</td>
	</tr>
	<tr>
		<td>401</td>
		<td>GET/POST/PUT/DELETE</td>
		<td>Requisição não autorizada. Verifique o Header "Accept => application/json"</td>
		<td>Não autorizado</td>
	</tr>
	<tr>
		<td>403</td>
		<td>GET/POST/PUT/DELETE</td>
		<td>A credencial token está inválida</td>
		<td>Token inválido</td>
	</tr>
	<tr>
		<td>404</td>
		<td>GET/POST/PUT/DELETE</td>
		<td>Requisição não encontrada</td>
		<td>Favor, informar todos os campos</td>
	</tr>
	<tr>
		<td>500</td>
		<td>GET/POST/PUT/DELETE</td>
		<td>Erro interno</td>
		<td>Erro interno</td>
	</tr>
	<tr>
		<td>503</td>
		<td>GET/POST/PUT/DELETE</td>
		<td>Requisição indisponível</td>
		<td></td>
	</tr>
</table>
</body>
</html>