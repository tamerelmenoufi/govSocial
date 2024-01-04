<?php

    $con = mysqli_connect("project.mohatron.com","root","SenhaDoBanco", "app");
    
    $ordem = (($_GET['ordem'])?:'asc');

    $query = "select a.codigo, (select cpf from mapcenso_novo where cpf = a.cpf limit 1 ) as tem from se a where a.acao_relatorio = '0' order by a.codigo {$ordem} limit 30";
    $result = mysqli_query($con, $query);
    $r = [];
    while($d = mysqli_fetch_object($result)){
        $r[$d->codigo] = (($d->tem)?'1':'2');
    }
    
    foreach($r as $i => $v){
        echo $q = "update se set acao_relatorio = '{$v}' where codigo = '{$i}'";
        echo "<br>";
        mysqli_query($con, $q);
    }
?>

<script>
    window.location.href='./socio_novo.php?ordem=<?=$ordem?>';
</script>