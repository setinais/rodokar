<?php 

class IndexController extends \HXPHP\System\Controller
{
	public function __construct($configs)
	{
		parent::__construct($configs);
		$this->load(
				'Helpers\Menu',
				$this->request,
				$this->configs
			);
	}

	public function indexAction()
	{
		
	}
	public function sobreAction()
	{

	}

	public function contatoAction()
	{

	}
}