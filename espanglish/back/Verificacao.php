<?php
require_once 'activerecord/ActiveRecord.php';
  
  ActiveRecord\Config::initialize(function($cfg){
    $cfg->set_model_directory('model');
    //$cfg->set_connections(array('development' => 'mysql://root:@localhost/espanglish'));
    $cfg->set_connections(array('development' => 'mysql://vinnicyus:vmf*2016@espanglish.mysql.uhserver.com/espanglish?charset=utf8'));
  });
  if(!empty($_POST['liberacao']) && $_POST['liberacao'] == 'verifica'){
      
     $verificar = Jurado::find('all',array('conditions' => array('nome = ?','Vinnicyus')));

      if($verificar[0]->liberar == 'Permitido'){
          echo 'Permitido';
      }elseif ($verificar[0]->liberar == 'Negado') {
          echo 'Negado';
      }
  }
  ?>