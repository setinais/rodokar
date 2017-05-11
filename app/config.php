<?php
	//Constantes
	$configs = new HXPHP\System\Configs\Config;

	$configs->env->add('development');

		//Globais
		$configs->title = 'RODOKAR';

		//Configurações de Ambiente - Desenvolvimento
		$configs->env->add('development');

		$configs->env->development->baseURI = '/rodokar/';

		$configs->env->development->database->setConnectionData([
			'driver' => 'mysql',
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'dbname' => 'rodokar',
			'charset' => 'utf8'
		]);

		$configs->env->development->mail->setFrom([
			'from' => 'RODOKAR',
			'from_mail' => 'no-replay@rodokar.com.br'
		]);

		$configs->env->development->menu->setConfigs([
			'container' => 'nav',
			'container_class' => 'navbar navbar-default',
			'menu_class' => 'nav navbar-nav'
		]);

		$configs->env->development->menu->setMenus([
			'Home/home' => '%siteURL%',
			'Sobre/user' => '%siteURL%/index/sobre/',
			'Contatos/phone' => '%siteURL%/index/contato/'
		]);

		$configs->env->development->auth->setURLs('/rodokar/home/', '/rodokar/login/');
		$configs->env->development->auth->setURLs('/rodokar/admin/home/', '/rodokar/admin/login/', 'admin');

		//Configurações de Ambiente - Produção
		$configs->env->add('production');

		$configs->env->production->baseURI = '/';
		
		$configs->env->production->database->setConnectionData([
			'driver' => 'mysql',
			'host' => 'rodokar.mysql.uhserver.com',
			'user' => 'rodoakr',
			'password' => '0V2m56gtf@',
			'dbname' => 'rodoakr',
			'charset' => 'utf8'
		]);

		$configs->env->production->menu->setConfigs([
			'container' => 'nav',
			'container_class' => 'navbar navbar-default',
			'menu_class' => 'nav navbar-nav'
		]);

		$configs->env->production->menu->setMenus([
			'Home/home' => '%siteURL%',
			'Sobre/user' => '%siteURL%/index/sobre/',
			'Endereço/building' => '%siteURL%/index/endereco/',
			'Contatos/phone' => '%siteURL%/index/contato/'
		]);
		
		$configs->env->production->mail->setFrom([
			'from' => 'RODOKAR',
			'from_mail' => 'no-replay@rodokar.com.br'
		]);
	


	return $configs;
