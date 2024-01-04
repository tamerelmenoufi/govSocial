<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/vns/govSocial/lib/includes.php");

    echo $query = "select *, DATE_ADD(data, INTERVAL 7 DAY) as intervalo from metas where DATE_ADD(data, INTERVAL 7 DAY) >= NOW()";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result)){
        $metas = [];
        while($d = mysqli_fetch_object($result)){
            $metas[] = $d->codigo;
        }
        if($metas){
            echo $q = "update se set meta = '0', monitor_social = '0' where meta not in (".implode(", ", $metas).") and situacao not in ('c', 'f', 'n')";
            mysqli_query($con, $q);
            echo $q = "update metas set situacao = '0', deletado = '1' where codigo not in (".implode(", ", $metas).")";   
            mysqli_query($con, $q);         
        }
    }
    //teste