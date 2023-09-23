<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectSocioEconomico/lib/includes.php");


    //Questionários

    $k = 0;

    function questoes($d){

        global $_SESSION;
        global $con;
        // global $dashboard;
        global $VetorTeste;
        global $k;

        // $filtro = $f_usuario = $f_meta = $f_data = false;
        // if($_SESSION['relatorio']['usuario']){
        //     $f_usuario = " and a.monitor_social in( {$_SESSION['relatorio']['usuario']} ) ";
        // }
        // if($_SESSION['relatorio']['meta']){
        //     $f_meta = " and a.meta in( {$_SESSION['relatorio']['meta']} ) ";
        // }else if($_SESSION['ProjectSeLogin']->perfil == 'crd'){
        //     $f_meta = " and a.meta in( select codigo from metas where usuario in(select codigo from usuarios where coordenador = '{$_SESSION['ProjectSeLogin']->codigo}') ) ";
        // }

        // if($_SESSION['relatorio']['data_inicial']){
        //     $f_data = " and (a.data between '{$_SESSION['relatorio']['data_inicial']} 00:00:00' and '".(($_SESSION['relatorio']['data_final'])?:$_SESSION['relatorio']['data_inicial'])." 23:59:59')";
        // }

        // $filtro = $f_usuario . $f_meta . $f_data;

        if($d['join']){
            $join = $d['join'];
        }
        if($d['item']){
            $item = ", {$d['item']} as item";
        }
    
        $query = "select a.codigo, a.{$d['campo']} as campo {$item}, a.data, a.monitor_social, a.meta from se a {$join} where a.monitor_social > 0 and a.meta > 0 and acao_relatorio != '1' /*{$filtro}*/ ";
        $result = mysqli_query($con, $query);
        $t = 0;
        if(mysqli_num_rows($result)){
            while($s = mysqli_fetch_object($result)){

                set_time_limit(90);

                if($d['tipo'] == 'json'){
                    $J = json_decode($s->campo);
                    if($J){
                        foreach($J as $i => $v){

                            $VetorTeste[] = [
                                'ordem' => $d['ordem'],
                                'rotulo' => $d['rotulo'],
                                'campo' => $d['campo'],
                                'valor' => trim($v),
                                'legenda' => ((trim($v))?:'Não Informado'),
                                'data' => $s->data,
                                'monitor_social' => $s->monitor_social,
                                'meta' => $s->meta,
                                'se' => $s->codigo,
                                'chave' => md5($d['campo'].((trim($v))?:'Não Informado').$s->codigo)
                            ];
                            
                            // $d['legenda'][trim($v)] = ((trim($v))?:'Não Informado');

                            // $D[$v] = ($D[$v] + 1);
                            // $t = ($t + 1);
                        }
                    }
                }else{

                    // if($item) {$d['legenda'][trim($s->campo)] = $s->item;}
                    // else if(!$d['legenda'][$s->campo]) { $d['legenda'][trim($s->campo)] = ((trim($s->campo))?:'Não Informado'); }


                    $VetorTeste[] = [
                        'ordem' => $d['ordem'],
                        'rotulo' => $d['rotulo'],
                        'campo' => $d['campo'],
                        'valor' => trim($s->campo),
                        'legenda' => $d['legenda'][trim($s->campo)],
                        'data' => $s->data,
                        'monitor_social' => $s->monitor_social,
                        'meta' => $s->meta,
                        'se' => $s->codigo,
                        'chave' => md5($d['campo'].$d['legenda'][trim($s->campo)].$s->codigo)
                    ];

                    // $D[$s->campo] = ($D[$s->campo] + 1);
                    // $t = ($t + 1);
                }
                
            }

            // if($D){
            //     arsort($D);
            //     $dashboard['questionario'][$k]['rotulo'] = $d['rotulo'];
            //     // echo "<h5>{$d['rotulo']}</h5>";
            //     $w = 0;
            //     foreach($D as $ind => $val){
            //         $p = number_format($val*100/$t, 0,false,false);
            //         // echo "<p>{$d['legenda'][$ind]} | {$p} | {$val}</p>";
            //         $dashboard['questionario'][$k]['dados'][$w]['legenda'] = $d['legenda'][$ind];
            //         $dashboard['questionario'][$k]['dados'][$w]['percentual'] = $p;
            //         $dashboard['questionario'][$k]['dados'][$w]['quantidade'] = $val;
            //         $w++;
            //     }
            // }
            $k++;
        }
    }

    $ordem = 1;

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Situação da Pesquisa',
        'campo' => 'situacao',
        'legenda' => [
            'i' => 'Iniciada',
            'c' => 'Concluida',
            'n' => 'Não encontrado',
            'p' => 'Pendente',
            '' => 'Não Informada',
        ]
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Municípios',
        'campo' => 'municipio',
        'join' => "left join municipios b on a.municipio = b.codigo ",
        'item' => "b.municipio"
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Bairros / Comunidades',
        'campo' => 'bairro_comunidade',
        'join' => "left join bairros_comunidades b on a.bairro_comunidade = b.codigo ",
        'item' => "b.descricao"
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Zonas',
        'campo' => 'local',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Genéro',
        'campo' => 'genero',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Estado Civil',
        'campo' => 'estado_civil',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Redes Sociais',
        'campo' => 'redes_sociais',
        'tipo' => 'json' 
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Meio de Trasporte',
        'campo' => 'meio_transporte',
        'tipo' => 'json' 
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Tipo de Imóvel',
        'campo' => 'tipo_imovel',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Tipo de Moradia',
        'campo' => 'tipo_moradia',
        'tipo' => 'json'
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Quantidade de Cômodos na Moradia',
        'campo' => 'quantidade_comodos',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Grau de escolaridade',
        'campo' => 'grau_escolaridade',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Cursos Profissionalizantes',
        'campo' => 'curos_profissionais',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Interesse por novos Cursos',
        'campo' => 'intereese_curso',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Renda Mensal',
        'campo' => 'renda_mensal',
    ]);


    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Renda Familiar',
        'campo' => 'renda_familiar',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Beneficio Social',
        'campo' => 'beneficio_social',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Serviço de Saúde',
        'campo' => 'servico_saude',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Condições de Saúde',
        'campo' => 'condicoes_saude',
    ]);


    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Vacina contra o Covid-19',
        'campo' => 'vacina_covid',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Necessita de Documentos',
        'campo' => 'necessita_documentos',
        'tipo' => 'json',
    ]);
    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Como você avalia o Beneficio',
        'campo' => 'avaliacao_beneficios',
    ]);
    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'O beneficio atendido as Necessidades',
        'campo' => 'atende_necessidades',
    ]);
    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Opinião na Saúde',
        'campo' => 'opiniao_saude',
        'tipo' => 'json',
    ]);
    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Opinião na Educação',
        'campo' => 'opiniao_educacao',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Opinião na Cidadania',
        'campo' => 'opiniao_cidadania',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Opinião na Infraestrutura',
        'campo' => 'opiniao_infraestrutura',
        'tipo' => 'json',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Opinião na Assistência Social',
        'campo' => 'opiniao_assistencia_social',
        'tipo' => 'json',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Opinião nos Direitos Humanos',
        'campo' => 'opiniao_direitos_humanos',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Opinião na Segurança',
        'campo' => 'opiniao_seguranca',
        'tipo' => 'json',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Opinião no Esporte e Lazer',
        'campo' => 'opiniao_esporte_lazer',
        'tipo' => 'json',
    ]);

    questoes([
        'ordem' => $ordem++,
        'rotulo' => 'Recepção pelo Beneficiado',
        'campo' => 'recepcao_entrevistado',
    ]);

    echo "<pre>";
    print_r($VetorTeste);
    echo "</pre>";
    $update = [];
    if($VetorTeste){
        foreach($VetorTeste as $campo => $valor){
            set_time_limit(90);
            $cmp = [];
            foreach($valor as $c => $v){
                $cmp[] = "{$c} = '{$v}'";
            }
            echo $q = "REPLACE INTO relatorios SET ".implode(", ",$cmp);
            echo "<hr>";
            mysqli_query($con, $q);
            $update[] = $valor['se'];
        }
    }

    if($update) mysqli_query($con, "UPDATE se SET acao_relatorio = '1' WHERE codigo in (".implode(",",$update).")");

    set_time_limit(90);
    $query = "DELETE FROM `relatorios` where se in (select codigo from se where meta = 0 and monitor_social = 0)";
    $result = mysqli_query($con, $query);

    set_time_limit(90);
    $query = "UPDATE se SET meta = '0', monitor_social = '0' where meta in (select codigo from metas where DATE_ADD(data, INTERVAL 8 DAY) <= NOW()) and situacao in ('','i','p')";
    $result = mysqli_query($con, $query); 
    
    set_time_limit(90);
    $query = "UPDATE metas set quantidade = '0', deletado = '1' where DATE_ADD(data, INTERVAL 8 DAY) <= NOW()";
    $result = mysqli_query($con, $query); 
       

?>