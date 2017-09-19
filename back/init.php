<?php
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

if (isset($_POST) && !empty($_POST)){
		if(isset($_POST['dados'])){
			require_once("WebService.php");

			$web_service = new WebService;
			$web_service->init($_POST);
			echo $web_service->retornoApp();
		}
		else
		{
			echo "Solicitacao invalida!";
		}
}
else
{
	echo "Error";
}

	
    
    
    
    
    
    
    