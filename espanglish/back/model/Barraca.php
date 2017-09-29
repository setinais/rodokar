<?php
class Barraca extends ActiveRecord\Model {
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