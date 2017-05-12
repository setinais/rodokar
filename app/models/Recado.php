<?php 

class Recado extends \HXPHP\System\Model
{
	public static function cadastrar($attr)
	{
		$callback = new \stdClass;
		$callback->status = false;
		$callback->user = null;
		$callback->errors = [];

		
		$cadastrar = self::create($attr);
		if($cadastrar->is_valid())
		{
			$callback->status = true;
			$callback->user = $cadastrar;
		}
		return $callback;
	
	}
}