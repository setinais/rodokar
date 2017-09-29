<?php

require_once 'activerecord/ActiveRecord.php';

ActiveRecord\Config::initialize(function($cfg){
	$cfg->set_model_directory('model');
	$cfg->set_connections(array('development' => 'mysql://vinnicyus:vmf*2016@espanglish.mysql.uhserver.com/espanglish?charset=utf8'));
		//$cfg->set_connections(array('development' => 'mysql://time_guida:Guida*12@espanglish.mysql.uhserver.com/espanglish'));
});
if(!empty($_POST['tipo']) && $_POST['tipo']=='SalvarVoto'){
	$verificar = Jurado::find('all',array('conditions' => array('nome = ?','Vinnicyus')));

	if($verificar[0]->liberar == 'Permitido'){


		if(validar_cpf($_POST['cpf'])){
			if(empty(Voto::find("all",array('conditions'=>array("cpf = ?",$_POST['cpf'])))) && validar_cpf($_POST['cpf'])){
				$date = date('Y-m-d');
				$hora = date('H:i:s');
				unset($_POST['tipo']);
				$_POST['status'] = 1;
				if(Voto::create($_POST)){
					echo '<script type="text/javascript">$("#confirmacao").hide();$("#recebeMsg").html("Voto Confirmado em '.Voto::last()->paise->nome.'");$("#msg").show();</script>';
				}
			}else{
				$vot = Voto::find("all",array('conditions'=>array("cpf = ?",$_POST['cpf'])))[0];
				$vot->paise_id = $_POST['paise_id'];
				$vot->save();
				echo '<script type="text/javascript">$("#confirmacao").hide();$("#recebeMsg").html("Voto alterado com sucesso!<br>Seu voto agora é em '.$vot->paise->nome.'");$("#msg").show();</script>';
			}
		}else{
			echo '<script type="text/javascript">$("#ErroCpf").show();$("#confirmacao").hide();$("#recebeMsg").html();</script>';
		} 
	}elseif ($verificar[0]->liberar == 'Negado') {
		echo '<script type="text/javascript">$("#confirmacao").hide();$("#recebeMsg").html("Votação indisponível!");$("#msg").show();</script>';
	}
}else{
	$bandeiras = "";
	foreach (Paise::all() as $value) {

	$bandeiras .="<option value='".$value->id."' data-icon='app/img/".str_replace(' ', '',$value->nome).".png' class='left circle'>".$value->nome."</option>";
	}
	echo $bandeiras;
}

function validar_cpf($cpf) {

		// Extrai somente os números
	$cpf = preg_replace( '/[^0-9]/is', '', $cpf );
	
		// Verifica se foi informado todos os digitos corretamente
	if (strlen($cpf) != 11) {
		return false;
	}
		// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
	if (preg_match('/(\d)\1{10}/', $cpf)) {
		return false;
	}
		// Faz o calculo para validar o CPF
	for ($t = 9; $t < 11; $t++) {
		for ($d = 0, $c = 0; $c < $t; $c++) {
			$d += $cpf{$c} * (($t + 1) - $c);
		}
		$d = ((10 * $d) % 11) % 10;
		if ($cpf{$c} != $d) {
			return false;
		}
	}
	return true;
}
?>