<?php 

class IndexController extends \HXPHP\System\Controller
{
	public function __construct($configs)
	{
		parent::__construct($configs);
	}

	public function indexAction()
	{
		
	}
	public function contatoAction()
	{
		$this->view->setAssets('js',[$this->configs->baseURI.'public/js/contato/contact_me.js',$this->configs->baseURI.'public/js/contato/jqBootstrapValidation.js']);
	}

	public function messagemAction()
	{
		
	}
}