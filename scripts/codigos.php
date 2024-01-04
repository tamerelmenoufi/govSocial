<?php

include("{$_SERVER['DOCUMENT_ROOT']}/vns/govSocial/lib/includes.php");


$query = "SELECT b.codigo as cod_municipio, b.municipio, a.codigo as cod_bairro, a.descricao as bairro, a.tipo as zona FROM bairros_comunidades a left join municipios b on a.municipio = b.codigo order by b.municipio, a.descricao";

$result = mysqli_query($con, $query);
?>
<div class="container">
    <div class="row">
        <div class="col">


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cod. Município</th>
                        <th>Município</th>
                        <th>Cod. Bairro</th>
                        <th>Bairro</th>
                        <th>Zona</th>
                    </tr>
                </thead>
                <tbody>

            <?php
            while($d = mysqli_fetch_object($result)){
            ?>
                    <tr>
                        <td><?=$d->cod_municipio?></td>
                        <td><?=$d->municipio?></td>
                        <td><?=$d->cod_bairro?></td>
                        <td><?=$d->bairro?></td>
                        <td><?=$d->zona?></td>
                    </tr>
            <?php
            }
            ?>
                </tbody>
            </table>

</div>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');
    })
</script>