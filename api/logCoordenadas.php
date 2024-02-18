<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/vns/govSocial/lib/includes.php");


    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
    $_POST = json_decode(file_get_contents('php://input'), true);
 
    if(!is_dir('logs')) mkdir('logs');

    echo 'success';

    file_put_contents('logs/coord_'.date("YmdHis").".txt", print_r($_POST, true));


    foreach($_POST['dados'] as $ind => $val){

        $data = $val;
        unset($data['codigo']);

        // $data['data'] = date("Y-m-d H:i:s");

        $campos = [];
        foreach($data as $i => $v){
            $campos[] = "{$i} = '{$v}'";
        }


        $comando = "INSERT INTO logLocation set ".implode(", ", $campos);

        mysqli_query($con, $comando);

        file_put_contents('logs/coord_comando-'.date("YmdHis").".txt", $comando);


    }

    mysqli_query($con, "UPDATE logLocation set data = STR_TO_DATE(FROM_UNIXTIME(dados->>'$.timestamp'/1000),\"%Y-%m-%d %H:%i:%s\") where data = 0");