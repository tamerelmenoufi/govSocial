<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectSocioEconomico/lib/includes.php");

    exit();

    $query = "select * from se where situacao = 'c'";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
        // var_dump($d);
        // echo "<hr>";
        $tot = 0;
        $qt = 0;
        $remov = ['[""]', 'null', '0', '0.00', ' ', 0, null];
        $log = false;
        foreach ($d as $name => $value) {
            $qt = ((trim(str_replace($remov, false,$value)))?($qt+1):$qt);
            $tot++;
        }


        $pct = (100*$qt/$tot);
        echo $update = "update se set percentual = '" . $pct . "' where codigo = '{$d->codigo}'";
        mysqli_query($con, $update);
        echo "<hr>";
    }