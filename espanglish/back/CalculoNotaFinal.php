<?php 
require_once 'activerecord/ActiveRecord.php';

ActiveRecord\Config::initialize(function($cfg){
	$cfg->set_model_directory('model');
	//$cfg->set_connections(array('development' => 'mysql://vinnicyus:vmf*2016@espanglish.mysql.uhserver.com/espanglish?charset=utf8'));
	$cfg->set_connections(array('development' => 'mysql://root:@localhost/espanglish?charset=utf8'));
});

$barraca = Barraca::find_by_sql("select
									p.id,
									p.nome,
									(sum(j.comidas_tipicas) + sum(j.criatividade) + sum(j.fluencia_lingua) + sum(j.informacoes_pais_bandeira) + sum(j.jogos_interacao) + sum(j.organizacao) + sum(j.producao_tecnologica) + sum(j.recepcao) + sum(j.utilizacao_materiais)) as barraca
									from
									paises as p
									inner join barracas as j on p.id = j.paise_id
									group by p.id,p.nome
									order by p.id");
$palco = Palco::find_by_sql("select p.id,
							p.nome,
							(sum(b.desfile) +sum(b.apresentacao_cultural) +sum(b.fluencia_lingua) +sum(b.preenca_de_palco) + sum(b.qualidade_slide) +sum(b.uso_tempo)) as palco
							from
							paises as p
							inner join palcos as b on p.id = b.paise_id
							group by p.id,p.nome
							order by p.id;
							");
$votos = Voto::find_by_sql("select
							paise_id as id_pais,
							count(*) as total
							from
							votos group by paise_id order by total desc;");
$total = null;
for ($i=0; $i < 9; $i++) { 
	for ($v=0; $v < 9; $v++) { 
			if($votos[$v]->id_pais == $palco[$i]->id){
				switch ($v) {
					case 0:
						$total[$i]['nota'] = ($barraca[$i]->barraca + $palco[$i]->palco)* 1.15;	
						$total[$i]['text'] = ($barraca[$i]->barraca + $palco[$i]->palco)." + 15% = ";
						break;
					case 1:
						$total[$i]['nota'] = ($barraca[$i]->barraca + $palco[$i]->palco)* 1.10;	
						$total[$i]['text'] = ($barraca[$i]->barraca + $palco[$i]->palco)." + 10% = ";
						break;
					case 2:
						$total[$i]['nota'] = ($barraca[$i]->barraca + $palco[$i]->palco)* 1.05;	
						$total[$i]['text'] = ($barraca[$i]->barraca + $palco[$i]->palco)." + 5% = ";
						break;
					default:
						$total[$i]['nota'] = $barraca[$i]->barraca + $palco[$i]->palco;	
						$total[$i]['text'] = "";
						break;
				}
				$total[$i]['nome'] = $barraca[$i]->nome;
				$total[$i]['id'] = $barraca[$i]->id;
				$total[$i]['votos'] = (int) $votos[$v]->total;
			}
		
	}
	
}
//var_dump($total);
echo json_encode($total);