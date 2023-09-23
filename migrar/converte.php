<?php

    $con = mysqli_connect("project.mohatron.com","root","SenhaDoBanco", "manutencao");
    $dados = file_get_contents("lista6.csv");

    mysqli_query($con, "insert into `municipios` (municipio) select municipio from se group by municipio order by municipio");

    echo "ok - query 1";
    exit();
    function M($d){
        global $con;

        $q = "select * from municipios where descricao = '{$d}'";
        $r = mysqli_query($con, $q);
        if(mysqli_num_rows($r)){

        }

    }

    $l = explode("\n",$dados);
    // echo "<table border='1'>";
    $comando = [];

    $start = "INSERT INTO se (
        municipio,
        CPF,
        nome,
        nascimento,
        Identidade,
        endereco,
        localidade,
        tipo,
        telefone
    ) VALUES ";

    for($i=0;$i<count($l);$i++){
        set_time_limit(90);
        // echo "
        //     <tr>";

        $c = explode(":", $l[$i]);
        $campos = [];
        for($k=0;$k<count($c);$k++){
            if($k == 1){
                $cpf = str_pad($c[$k], 11, "0", STR_PAD_LEFT);
                $p1 = substr($cpf, 0,3);
                $p2 = substr($cpf, 3,3);
                $p3 = substr($cpf, 6,3);
                $p4 = substr($cpf, 9,2);

                $cpf = "{$p1}.{$p2}.{$p3}-{$p4}";

                $campos[] = "{$cpf}";
            }else{
                // echo "<td>{$c[$k]}</td>";
                $campos[] = "{$c[$k]}";
            }


        }

        $comando[] = "('".implode("','", $campos)."')";

        // echo "</tr>
        // ";
        if($i%100 == 0 and $i > 0) {
            $query =  $start.implode(", ",$comando);
            if(mysqli_query($con, $query)){
                echo "ok<hr>";
            }else{
                echo $query."<hr>";
            }
            $quey = false;
            $comando = [];

        }
        if($i === 10) {
            // echo $query."<hr>";
            // break;
        }
    }


        $query =  $start.implode(", ",$comando);
        if(mysqli_query($con, $query)){
            echo "ok<hr>";
        }else{
            echo $query."<hr>";
        }
        $quey = false;
        $comando = [];

    // echo "</table>";

    // insert into `municipios` (municipio) select municipio from se group by municipio order by municipio
    // update se a set a.municipio_cod = (select codigo from municipios where a.municipio = municipio)

    // insert into `bairros_comunidades` (municipio, descricao, tipo) select municipio_cod, localidade, tipo from se group by municipio, localidade, tipo
    // update se a set a.localidade_cod = (select b.codigo from bairros_comunidades b where a.municipio_cod = b.municipio and a.localidade = b.descricao and a.tipo = b.tipo)


    // insert into app.se (nome, cpf, telefone, municipio, bairro_comunidade, local, endereco) SELECT nome, cpf, telefone, municipio_cod, localidade_cod, tipo, endereco FROM manutencao.se WHERE municipio_cod = 66