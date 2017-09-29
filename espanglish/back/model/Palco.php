<?php
class Palco extends ActiveRecord\Model {
	static $belongs_to = array(
    	array('paise'),
    	array('jurado')
    );
    public static function exist($id_pais,$id_jurado)
    {
    	$verificar = self::find('all', array('conditions' => array('paise_id = ? AND jurado_id = ?', $id_pais,$id_jurado)));
    	if(is_null($verificar) || empty($verificar))
    		return false;
    	return true;
    }
}
//[barraca{codigo:3.02286373175;comidas_tipicas:0;criatividade:0;fluencia_lingua:0;informacoes_pais_bandeira:0;jogos_interacao:0;organizacao:0;producao_tecnologica:0;recepcao:0;utilizacao_materiais:0
//[palco{codigo:3.02286373175;apresentacao_cultural:0;desfile:0;fluencia_lingua:0;preenca_de_palco:0;qualidade_slide:0;uso_tempo:0{codigo:1.02286373175;apresentacao_cultural:0;desfile:0;fluencia_lingua:0;preenca_de_palco:0;qualidade_slide:4;uso_tempo:0