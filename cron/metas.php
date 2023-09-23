<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectSocioEconomico/lib/includes.php");

    echo $query = "select *, DATE_ADD(data, INTERVAL 7 DAY) as intervalo from metas where DATE_ADD(data, INTERVAL 7 DAY) >= NOW()";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result)){
        $metas = [];
        while($d = mysqli_fetch_object($result)){
            $metas[] = $d->codigo;
        }
        echo $q = "update se set meta = '0', monitor_social = '0' where codigo not in (".implode(", ", $metas).") and situacao not in ('c', 'f', 'n')";
    }