<?php
header('Access-Control-Allow-Origin: *');
/* Tablets IFTO   e-mail: espanglish.paraiso@gmail.com senha: vinni123
  router ip: 192.168.1.100
  repetidor: http://tplinkrepeater.net/
  modem: 192.168.1.1
*/
require_once 'activerecord/ActiveRecord.php';
	//session_start();
	SESSION_START();
  	ActiveRecord\Config::initialize(function($cfg){
    $cfg->set_model_directory('model');
    $cfg->set_connections(array('development' => 'mysql://root:@localhost/espanglish'));
    //$cfg->set_connections(array('development' => 'mysql://time_guida:Guida*12@espanglish.mysql.uhserver.com/espanglish'));
  });
  
  if(isset($_POST['funcao'])){
  	if($_POST['funcao'] == 'LoginJurado'){
  			$valida = LoginJurado();
  		if(empty($valida))
		{
			echo "#Fudeu";
		}else{
			$_SESSION['logado']= $valida[0]->nome;
			$_SESSION['id_do_logado'] = $valida[0]->id;
      $_SESSION['tipo_lingua'] = $valida[0] ->lingua;
      if($valida[0]->tipo_usu == 2){
			echo "#Partiu2";
      }else{
        echo "#Partiu";
      }
		}
  	
  	}elseif ($_POST['funcao'] == 'VotarDesfile') {
      unset($_POST['funcao']);
      $_POST['paise_id'] = (int)$_SESSION['id_pais'];
      $_POST['jurado_id'] = (int)$_SESSION['id_do_logado'];
        if(empty(Desfile::find('all',array('conditions' => array('jurado_id = ? AND paise_id = ?',$_POST['jurado_id'],$_POST['paise_id']))))){
          Desfile::create($_POST);
        }else{
          $desfile = Desfile::find("all",array('conditions'=>array('jurado_id = ? AND paise_id = ?',$_POST['jurado_id'],$_POST['paise_id'])))[0];
          $desfile -> update_attributes($_POST);
        }
  		unset($_SESSION['id_pais']);
  	}elseif ($_POST['funcao'] == 'VotarBarraca') {
  		unset($_POST['funcao']);
  		$_POST['paise_id'] = (int)$_SESSION['id_pais'];
  		$_POST['jurado_id'] = (int)$_SESSION['id_do_logado'];
  		if(empty(Barraca::find("all",array('conditions'=>array('paise_id = ? AND jurado_id = ?',$_POST['paise_id'],$_POST['jurado_id']))))){
  			Barraca::create($_POST);
  		}else{
  			$barraca = Barraca::find("all",array('conditions'=>array('paise_id = ? AND jurado_id = ?',$_POST['paise_id'],$_POST['jurado_id'])))[0];
  			$barraca->update_attributes($_POST);
  		}
  		unset($_SESSION['id_pais']);
  	}elseif ($_POST['funcao'] == 'VotarPalco') {
  		unset($_POST['funcao']);
  		$_POST['paise_id'] = (int)$_SESSION['id_pais'];
  		$_POST['jurado_id'] = (int)$_SESSION['id_do_logado'];
  		if(empty(Palco::find("all",array('conditions'=>array('paise_id = ? AND jurado_id = ?',$_POST['paise_id'],$_POST['jurado_id']))))){
  			Palco::create($_POST);
  		}else{
  			$palco = Palco::find("all",array('conditions'=>array('paise_id = ? AND jurado_id = ?',$_POST['paise_id'],$_POST['jurado_id'])))[0];
  			$palco->update_attributes($_POST);
  		}
  		unset($_SESSION['id_pais']);
  	}elseif($_POST['funcao'] == 'ValidarJurado'){
  		echo ValidarJurado();
  	}elseif($_POST['funcao'] == 'DeslogarJurado'){
  		DeslogarJurado();
  	}elseif($_POST['funcao'] == 'dados'){
  		if(!empty($_SESSION['id_pais'])){
  			$nome_pais = Paise::find($_SESSION['id_pais'])->nome;
  			if($_POST['tipo'] == "barraca"){
  				if(!empty(Barraca::find('all',array('conditions'=>array('paise_id = ? AND jurado_id = ?',$_SESSION['id_pais'],$_SESSION['id_do_logado']))))){
  				$dados = Barraca::find('all',array('conditions'=>array('paise_id = ? AND jurado_id = ?',$_SESSION['id_pais'],$_SESSION['id_do_logado'])))[0];
	  				echo '<script type="text/javascript">
	  				$("#id_barraca_1").val('.$dados->recepcao.');
					$("#id_barraca_2").val('.$dados->mat_reciclavel.');
					$("#id_barraca_3").val('.$dados->fluencia_in_esp.');
					$("#id_barraca_4").val('.$dados->comidas.');
					$("#id_barraca_5").val('.$dados->info_paises.');
					$("#id_barraca_6").val('.$dados->jogo_interativo.');
					$("#id_barraca_7").val('.$dados->criatividade.');
					$("#id_barraca_8").val('.$dados->organizacao.');
					$("#id_barraca_9").val('.$dados->projeto.');
					$("#id_nome_pais").html("'.$nome_pais.'");
						
						
					</script>';

  				}else{
  					echo '<script type="text/javascript">$("#id_nome_pais").html("'.$nome_pais.'")</script>';
  				}
  			}elseif($_POST['tipo'] == "palco"){
  				if(!empty(Palco::find('all',array('conditions'=>array('paise_id = ? AND jurado_id = ?',$_SESSION['id_pais'],$_SESSION['id_do_logado']))))){
  				$dados = Palco::find('all',array('conditions'=>array('paise_id = ? AND jurado_id = ?',$_SESSION['id_pais'],$_SESSION['id_do_logado'])))[0];
          $por = $dados->qualidade_slide * 10;
	  				echo '<script type="text/javascript">$("#id_nota_slide").val('.$dados->qualidade_slide.');
	                $("#id_nota_itens").val('.$dados->itens_obrigatorios.');
	                $("#id_nota_fala").val('.$dados->fluencia_esp_in.');
	                $("#id_nota_palco").val('.$dados->presenca_palco.');
	                $("#id_nota_apresentacao").val('.$dados->apre_cultural.');
	                $("#id_nota_tempo").val('.$dados->uso_tempo.');
	                $("#id_nome_pais").html("'.$nome_pais.'");
                  $(document).ready(function($){
                    $("id_nota_slide-label").attr({
                                                    title: '.$dados->qualidade_slide.',
                                                    style: "left:'.$por.'%"
                                                    });
                  });
                    </script>';
  				}else{
  					echo '<script type="text/javascript">$("#id_nome_pais").html("'.$nome_pais.'")</script>';
  				}
  			}elseif ($_POST['tipo'] == 'desfile') {
          if(!empty(Desfile::find('all',array('conditions'=>array('jurado_id = ? AND paise_id = ?',$_SESSION['id_do_logado'],$_SESSION['id_pais']))))){
              $dados2 = Desfile::find('all',array('conditions'=>array('jurado_id = ? AND paise_id = ?',$_SESSION['id_do_logado'],$_SESSION['id_pais'])))[0];
                echo '<script type="text/javascript">$("#id_desfile_1").val("'.$dados2->desfile.'"); 
                  $("#id_nome_pais").html("'.$nome_pais.'");</script>';
          }else{

            echo '<script type="text/javascript">$("#id_nome_pais").html("'.$nome_pais.'");</script>'; 
          }
        }
  		}
  	}elseif($_POST['funcao'] == 'selePaises'){
      foreach (Paise::find("all",array('conditions'=>array('lingua = ?',$_SESSION['tipo_lingua']))) as $value) {
      
    echo "<li class='payment-method img".$value->id."' style='padding:4%;width:120px;margin-left:3%;'>
                    <input name='paises' nome='".$value->nome."' type='radio' value='".$value->id."' id='imagins".$value->id."' onClick='DisableButton()'>
                    <label for='imagins".$value->id."'>".$value->nome."</label>
                    <div class='nomeP' style='font-weight: 900;margin-top: 4%;margin-left:-45%;background-color: rgba(168,179,184,0.1);
'>".$value->nome."</div>
                  </li>
          <style type='text/css'>
.img".$value->id." label {
  
  background-image: url(app/img/".$value->src.");
  background-size: 100% 100%;
  background-color: transparent;
  margin-left: 5%;
}
          </style>


                  ";
            }
    }else{
  		echo 'Tentando me racker ne vagabundo! .l.';
  	}
  }
  	if(isset($_POST['id_pai'])){
  		if($_POST['id_pai'] == 'id'){
  			$_SESSION['id_pais'] = (int)$_POST['id_pais'];
  	}
  	}
    if(isset($_POST['funcao2'])){
      if($_POST['funcao2'] == 'CalcularNotaFinal'){
        CalcularNotaFinal();
        $v=1;
        foreach (Npublico::find('all', array('order' => 'qntd desc')) as $notas){
         $paises7 = Paise::all(array('conditions' => array('id = ?',$notas->paise_id)));
          echo '<script type="text/javascript">
            $("#orderP'.$v.'").html("'.$v.'º '.$paises7[0]->nome.'");
            $("#NotaP'.$v.'").attr("value", '.$notas->qntd.');
            
          </script>';
          $v++;
        }
      }elseif($_POST['funcao2'] == 'MostrarNota'){
        $v=1;
        foreach (Nota::find('all', array('order' => 'nota desc')) as $notas){
         $paises7 = Paise::all(array('conditions' => array('id = ?',$notas->paise_id)));
         $vetor[$v] = '<script type="text/javascript">
            $("#order'.$v.'").html("'.$v.'º '.$paises7[0]->nome.'");
            $("#NotaCalculadas'.$v.'").attr("value", '.$notas->nota.');
            $("#des'.$v.'").attr("onClick", "Descontar('.$notas->paise_id.');");
            $("#des'.$v.'").attr("idd", "'.$notas->paise_id.'");
            
            document.getElementById("des'.$v.'").removeAttribute("disabled");

          </script>';
          $v++; 
        }

        $j=1;
        foreach (Npublico::find('all', array('order' => 'qntd desc')) as $notas){
         $paises7 = Paise::all(array('conditions' => array('id = ?',$notas->paise_id)));
          $vetor[$v] = '<script type="text/javascript">
            $("#orderP'.$j.'").html("'.$j.'º '.$paises7[0]->nome.'");
            $("#NotaP'.$j.'").attr("value", '.$notas->qntd.');
            
          </script>';
          $j++;
          $v++;
        }
        $j=1;
         $asd = Nota::find("all",array('order'=>'nota desc'));
         foreach($asd as $val){
            if($val->paise->lingua == 'Ingles'){
              $vetor[$v] = '<script type="text/javascript">
                $("#orderI'.$j.'").html("'.$j.'º '.$val->paise->nome.'");
                $("#NotaI'.$j.'").attr("value", '.$val->nota.');
                
              </script>';
              $v++;
              $j++;
            }
         }
         $j=1;
         foreach($asd as $val){
            if($val->paise->lingua == 'Espanhol'){
              $vetor[$v] = '<script type="text/javascript">
                $("#orderE'.$j.'").html("'.$j.'º '.$val->paise->nome.'");
                $("#NotaE'.$j.'").attr("value", '.$val->nota.');
                
              </script>';
              $v++;
              $j++;
            }
         }
        
          foreach ($vetor as $value) {
            echo $value;
          }
        
      }elseif ($_POST['funcao2'] == 'Descontar') {
        $notas = Nota::all(array('conditions' => array('paise_id = ?',$_POST['id'])));
        $total = $notas[0]->nota;
        $total -= $total * 0.1;

    $nota = Nota::find($_POST['id']);
    $nota->nota;
    $nota->nota = $total;
    $nota->save();
      }elseif($_POST['funcao2'] == 'desempate'){
        unset($_POST['funcao2']);
        $pais = Paise::find("all",array('conditions'=>array('id in (?)',array($_POST['id1'],$_POST['id2'],$_POST['id3']))));
        echo "<pre>";
        foreach($pais as $val){
          $ary[$val->id] =0;
          foreach($val->palcos as $na){
            $ary[$val->id] += ($na->fluencia_esp_in);
            for($i=0;$i<count($ary);$i++){
              
            }
          }
        }
        echo "</pre>";

        /*$j=1;
        foreach($_POST as $val){
          $nota = 0;
          foreach(Paise::find($val)->palcos as $pa){
            $nota += $pa->fluencia_esp_in;
          }
          echo '<script type="text/javascript">
                $("#orderFP'.$j.'").html("'.$j.'º '.Paise::find($val)->nome.'");
                $("#NotaFP'.$j.'").attr("value", '.$nota.');
                
              </script>';
          $j++;
        }*/
      }
    }

  function LoginJurado(){
	$auth =	Jurado::all(array('conditions' => array("login = ? AND senha = ?",$_POST['nome'],$_POST['senha'])));
	return $auth;
  }

  function ValidarJurado(){
  	if(empty($_SESSION['logado'])){
  		echo "#NaoLogado";
  	}else{
  		echo $_SESSION['logado'];

  	}
  }
  function DeslogarJurado(){
  	//session_destroy();
  	SESSION_DESTROY();
  }


function CalcularNotaFinal(){
  foreach (Paise::find('all') as $pais) {
    $total = 0;
    foreach (Palco::all(array('conditions' => array("paise_id = ?",$pais->id))) as $notas) { 
      $total += $notas->qualidade_slide+$notas->itens_obrigatorios+$notas->fluencia_esp_in+$notas->presenca_palco+$notas->apre_cultural+$notas->uso_tempo;
    }
   /* foreach (Barraca::all(array('conditions' => array("paise_id = ?",$pais->id))) as $notas2) {
      $total += $notas2->recepcao+$notas2->mat_reciclavel+$notas2->fluencia_in_esp+$notas2->comidas+$notas2->info_paises+$notas2->jogo_interativo+$notas2->criatividade+$notas2->organizacao+$notas2->projeto;
    }*/
    foreach (Desfile::all(array('conditions' => array("paise_id = ?",$pais->id))) as $notas3) {
      $total += $notas3->desfile;
    }
    /*$atributos = array('paise_id' => $pais->id, 'nota' => $total); 
    $nota = new Nota($atributos);
    $nota -> save();*/
   
    $nota = Nota::find($pais->id);
    $nota->nota;
    $nota->nota = $total;
    $nota->save();

  }
  CalcularNotaPublico();
}
 
function CalcularNotaPublico(){

  foreach (Paise::all() as $pais) {
    $total = 0;
    foreach (Voto::all(array('conditions' => array('paise_id = ?',$pais->id))) as $voto) {
      if(!empty($voto->ip->status)){
      if($voto->ip->status == 'Permitido'){
      $total++;
      }
    }
  }
    $npublico = Npublico::find($pais->id);
    $npublico->qntd;
    $npublico->qntd = $total;
    $npublico->save();
  }

 /* $colocados = Npublico::find('all', array('order' => 'qntd desc'));
$por = 0.15;

  for ($i=0; $i < 3; $i++) { 
    
  
        $notas = Nota::all(array('conditions' => array('paise_id = ?',$colocados[$i]->paise_id)));
        $total = $notas[0]->nota;
        $total += $total * $por;

    $nota = Nota::find($colocados[$i]->paise_id);
    $nota->nota;
    $nota->nota = $total;
    $nota->save();

    $por -=0.05;
  }
  */
  }

   //$asd = Nota::find('all',array('conditions' => array('lingua = ?','Ingles' ), 'order' => 'nota desc'));
   /**
   * 
   */
 

 
 

 
   
?>