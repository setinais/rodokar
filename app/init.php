<?php
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
header("Content-type: application/json; charset=utf-8");

if (!empty($_POST)){
	
	if(is_null($_POST))
	{
		require_once("WebService.php");

		$web_service = new WebService;
		$web_service->init($_POST);
		echo json_encode(array('callback' => "Conexao bem sucedia!"));
	}
	else
	{
		echo json_encode(array('callback_error' => "Dados enviado vazio!"));
	}
}
else
{
	echo json_encode(array('callback_error' => "Dados enviado vazio!"));
}