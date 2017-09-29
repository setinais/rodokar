<?php 
/**
* 
*/
class WebService 
{

	public $status;
	public $logs;

	public function __construct()
	{
		require_once 'activerecord/ActiveRecord.php';
  
		  ActiveRecord\Config::initialize(function($cfg){
		    $cfg->set_model_directory('model');
		    $cfg->set_connections(array('development' => 'mysql://root:@localhost/espanglish'));
		    //$cfg->set_connections(array('development' => 'mysql://vinnicyus:vmf*2016@espanglish.mysql.uhserver.com/espanglish?charset=utf8'));
		  });
	}

	public function init($dados = "")
	{
		$this->status = $this->tratamentoDados($dados);
		//$cadastrar = Teste::create(array('text' => $dados['dados']));
	}

	public function retornoApp()
	{
		return $this->status;
	}

	private function tratamentoDados($dados)
	{
		$retornoDadosApi = "";
		$dados = explode("[", $dados['dados']);
		if(isset($dados[1]))
			$dados['barraca'] = explode("{", $dados[1]);
		$retornoDadosApi = "{barraca(";
		for($v=1;$v<count($dados['barraca']);$v++)
		{
			if(isset($dados['barraca'][$v]) && !empty($dados['barraca'][$v]))
				$barraca = explode(";", $dados['barraca'][$v]);
				if(!empty($barraca))
					$retornoDadosApi .= $this->inserirBarraca($this->separarAvaliacoes($barraca)).";";
		}

		if(isset($dados[2]))
			$dados['palco'] = explode("{", $dados[2]);
		$retornoDadosApi .= "{palco(";
		for ($i=1; $i < count($dados['palco']); $i++) { 
			if(isset($dados['palco'][$i]) && !empty($dados['palco'][$i]))
				$palco = explode(";", $dados['palco'][$i]);
				if (!empty($palco))
					$retornoDadosApi .= $this->inserirPalco($this->separarAvaliacoes($palco)).";";
		}
		return $retornoDadosApi;
	}

	private function separarAvaliacoes($dados)
	{
		$tratado = "";
		for($v=0;$v<count($dados);$v++)
		{
			$separado = explode(":", $dados[$v]);
			if(isset($separado[1]))
				$tratado[$separado[0]] = $separado[1];
		}
		
		return $tratado;
	}
	private function inserirBarraca($create)
	{
		$jurado_pais = explode(".",$create['codigo']);
		if(isset($jurado_pais[1]))
			$barraca['paise_id'] = $jurado_pais[0];
			$barraca['jurado_id'] =Jurado::find_by_cpf($jurado_pais[1])->id;
			$barraca['comidas_tipicas'] = $create['comidas_tipicas'];
	        $barraca['criatividade'] = $create['criatividade'];
	        $barraca['fluencia_lingua'] = $create['fluencia_lingua'];
	        $barraca['informacoes_pais_bandeira'] = $create['informacoes_pais_bandeira'];
	        $barraca['jogos_interacao'] = $create['jogos_interacao'];
	        $barraca['organizacao'] = $create['organizacao'];
	        $barraca['producao_tecnologica'] = $create['producao_tecnologica'];
	        $barraca['recepcao'] = $create['recepcao'];
	        $barraca['utilizacao_materiais'] = $create['utilizacao_materiais'];
	        if(Barraca::exist($barraca['paise_id'],$barraca['jurado_id']))
	        {
	        	$atualizar = Barraca::find('all',array('conditions' => array('jurado_id = ? AND paise_id = ?', $barraca['jurado_id'],$barraca['paise_id'])));
	        	$atualizar = Barraca::find($atualizar[0]->id);
	        	$atualizar->update_attributes($barraca);
	        	$atualizar->save();
	        	return $create['codigo'];
	        }
	        else
	        {
	        	Barraca::create($barraca);
	        	return $create['codigo'];
	        }

	}
	private function inserirPalco($create)
	{
		$jurado_pais = explode(".",$create['codigo']);
		$palco['paise_id'] = $jurado_pais[0];
		if(isset($jurado_pais[1]))
			$palco['jurado_id'] = Jurado::find_by_cpf($jurado_pais[1])->id;
	        $palco['apresentacao_cultural'] = $create['apresentacao_cultural'];
	        $palco['desfile'] = $create['desfile'];
	        $palco['fluencia_lingua'] = $create['fluencia_lingua'];
	        $palco['preenca_de_palco'] = $create['preenca_de_palco'];
	        $palco['qualidade_slide'] = $create['qualidade_slide'];
	        $palco['uso_tempo'] = $create['uso_tempo'];

	        if(Palco::exist($palco['paise_id'],$palco['jurado_id']))
	        {
	        	$atualizar = Palco::find('all',array('conditions' => array('jurado_id = ? AND paise_id = ?', $palco['jurado_id'],$palco['paise_id'])));
	        	$atualizar = Palco::find($atualizar[0]->id);
	        	$atualizar->update_attributes($palco);
	        	$atualizar->save();
	        	return $create['codigo'];
	        }
	        else
	        {
	        	Palco::create($palco);
	        	return $create['codigo'];
	        }
	}
}