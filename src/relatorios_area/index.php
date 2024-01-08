<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/vns/govSocial/lib/includes.php");
?>

<style>
    .cartao{
        position:relative;
        width:99%;
        min-height:90px;
        background-color:#459adb;
        border-radius:10px;
        color:#fff;
    }
    .cartao span{
        font-size:10px;
        margin-left:10px;
    }
    .cartao p{
        font-size:25px;
        font-weight:bold;
        text-align:center;
        padding-top:0px;
        padding-bottom:15px;
    }
</style>
<div class="row g-0 p-3">
    <div class="col">
        <div class="form-floating mb-3 p-2">
            <select required name="municipio" id="municipio" class="form-control" placeholder="Município">
                <option value="">::Selecione o Município::</option>
                <?php
                    $q = "select * from municipios order by municipio";
                    $r = mysqli_query($con, $q);
                    while($s = mysqli_fetch_object($r)){
                ?>
                <option value="<?=$s->codigo?>" <?=(($_POST['municipio'] == $s->codigo)?'selected':false)?>><?=$s->municipio?></option>
                <?php
                    }
                ?>
            </select>
            <label for="email">Município</label>
        </div>
    </div>
    <div class="col">
        <div class="form-floating mb-3 p-2">
            <select required name="zona" id="zona" class="form-control" placeholder="Zona">
                <option value="">::Selecione a Zona::</option>
                <option value="Urbano" <?=(($_POST['zona'] == 'Urbano')?'selected':false)?>>Urbano</option>
                <option value="Rural" <?=(($_POST['zona'] == 'Rural')?'selected':false)?>>Rural</option>
            </select>
            <label for="zona">Zona</label>
        </div>
    </div>
    <div class="col">
        <div class="d-flex flex-row mb-3 p-2">
            <div class="form-floating w-100">
                <select required name="bairro_comunidade" id="bairro_comunidade" class="form-control" placeholder="Bairro">
                    <option value="">::Selecione a Localização::</option>
                    <?php
                        $q = "select * from bairros_comunidades where municipio = '{$_POST['municipio']}' ".(($_POST['zona'])?" and tipo = '{$_POST['zona']}'":false)." order by descricao";
                        $r = mysqli_query($con, $q);
                        while($s = mysqli_fetch_object($r)){
                    ?>
                    <option value="<?=$s->codigo?>" <?=(($_POST['bairro_comunidade'] == $s->codigo)?'selected':false)?>><?=$s->descricao?> (<?=$s->tipo?>)</option>
                    <?php
                        }
                    ?>
                </select>
                <label for="bairro_comunidade">Bairro/Comunidade</label>
            </div>
            <button class="btn btn-success buscar ms-2" style="height:55px;">Buscar</button>
        </div>
    </div> 
</div>


<div class="row g-0">
    <?php
    $query = "select *, count(*) as qt, (select count(*) from se where municipio = '{$_POST['municipio']}' and bairro_comunidade = '{$_POST['bairro_comunidade']}' and local = '{$_POST['zona']}' and meta > 0 and meta in('i','p')) as metas from se where municipio = '{$_POST['municipio']}' and bairro_comunidade = '{$_POST['bairro_comunidade']}' and local = '{$_POST['zona']}' group by situacao";
    $result = mysqli_query($con, $query);
    $r = [];
    $total = 0;
    while($d = mysqli_fetch_object($result)){
        $r[$d->situacao] = $d->qt;
        $total = ($total + $d->qt);
        $metas = $d->metas;
    }


    $exibe = [
        'p' => 'Pendente',
        'i' => 'Iniciado',
        'n' => 'Não Encontrado',
        'c' => 'Concluido',
        'f' => 'Finalizado'
    ];
    foreach($exibe as $i => $v){
    ?>
    <div class="col p-1">
        <div class="cartao">
            <span><?=$v?></span>
            <p><?=$r[$i]*1?></p>
        </div>
    </div>    
    <?php
    }
    ?>
    <div class="col p-1">
        <div class="cartao" style="background-color:green">
            <span>Total</span>
            <p><?=$total*1?></p>
        </div>
    </div>   
    <div class="col p-1">
        <div class="cartao" style="background-color:orange">
            <span>Em Metas</span>
            <p><?=$metas*1?></p>
        </div>
    </div> 
</div>

<div class="row g-0">
    <div class="col-md-6">
        <table class="table">
            <?php
            foreach($exibe as $i => $v){
            ?>
            <tr>
                <th style="white-space: nowrap;">
                    <?=$v?>
                </th>
                <td class="w-100">
                    <div title="<?=($r[$i]*1)." beneficiado(s) que correspondem a ".number_format(($r[$i]*100/$total),0,false,false)?>% do total de <?=$total?> beneficiado(s)." style="color:#fff; cursor:pointer; opacity:0.7; text-align:center; background-color:blue; padding:3px; border-radius:7px; width:<?=number_format(($r[$i]*100/$total),0,false,false)?>%"><?=number_format(($r[$i]*100/$total),0,false,false)?>%</div>
                    <span style="color:#a1a1a1; font-size:12px;"><?=($r[$i]*1)." beneficiado(s) que correspondem a ".number_format(($r[$i]*100/$total),0,false,false)?>% do total de <?=$total?> beneficiado(s).</span>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>


    <?php
    $query = "select *, count(*) as qt from se where municipio = '{$_POST['municipio']}' and bairro_comunidade = '{$_POST['bairro_comunidade']}' and local = '{$_POST['zona']}' and meta > 0 group by situacao";
    $result = mysqli_query($con, $query);
    $r = [];
    $total = 0;
    while($d = mysqli_fetch_object($result)){
        $r[$d->situacao] = $d->qt;
        $total = ($total + $d->qt);
        $metas = $d->metas;
    }
    ?>
    <div class="col-md-6">
        <table class="table">
            <?php
            foreach($exibe as $i => $v){
            ?>
            <tr>
                <th style="white-space: nowrap;">
                    <?=$v?>
                </th>
                <td class="w-100">
                    <div title="<?=($r[$i]*1)." beneficiado(s) que correspondem a ".number_format(($r[$i]*100/$total),0,false,false)?>% do total de <?=$total?> beneficiado(s)." style="color:#fff; cursor:pointer; opacity:0.7; text-align:center; background-color:orange; padding:3px; border-radius:7px; width:<?=number_format(($r[$i]*100/$total),0,false,false)?>%"><?=number_format(($r[$i]*100/$total),0,false,false)?>%</div>
                    <span style="color:#a1a1a1; font-size:12px;"><?=($r[$i]*1)." beneficiado(s) que correspondem a ".number_format(($r[$i]*100/$total),0,false,false)?>% do total de <?=$total?> beneficiado(s).</span>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
    
</div>

<script>
    $(function(){
        Carregando('none')


        var filtro = (bairro_comunidade, zona) => {
        if(!municipio){
                $("#bairro_comunidade").html('<option value="">::Selecione a Localização::</option>');
                return false;
            }
            if(!zona){
                $("#bairro_comunidade").html('<option value="">::Selecione a Localização::</option>');
                return false;
            }
            $.ajax({
                url:"src/metas/filtro.php",
                type:"POST",
                data:{
                    municipio,
                    zona,
                    acao:'bairro_comunidade'
                },
                success:function(dados){
                    $("#bairro_comunidade").html(dados);
                }
            });
        }

        $("#zona").change(function(){
            municipio = $("#municipio").val();
            zona = $(this).val();
            filtro(municipio, zona);
        });

        $("#municipio").change(function(){
            zona = $("#zona").val();
            municipio = $(this).val();
            filtro(municipio, zona);
        });

        $(".buscar").click(function(){
            zona = $("#zona").val();
            municipio = $("#municipio").val();
            bairro_comunidade = $("#bairro_comunidade").val();
            
            if(zona && municipio && bairro_comunidade){
                Carregando()
                $.ajax({
                    url:"src/relatorios_area/index.php",
                    type:"POST",
                    data:{
                        zona,
                        municipio,
                        bairro_comunidade,
                    },
                    success:function(dados){
                        Carregando('none')
                        $("#paginaHome").html(dados);
                    }
                });
            }else{
                $.alert('Favor informe a localidade!');
            }


        });

    })
</script>