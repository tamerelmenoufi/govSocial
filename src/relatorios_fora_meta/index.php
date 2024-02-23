<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/vns/govSocial/lib/includes.php");

    if($_POST['filtro']){
        $_SESSION['filtro_usuario'] = $_POST['usuario'];
    }

    if($_SESSION['filtro_usuario']){
        $where = " and monitor_social = '{$_SESSOIN['filtro_usuario']}' ";
    }

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
            <select required name="usuario" id="usuario" class="form-control" placeholder="Usuários">
                <option value="">::Todos os usuários::</option>
                <?php
                    $q = "select * from usuarios where codigo in(select monitor_social from se where monitor_social > 0 and meta = '0' and situacao in('c','f','n')) order by nome";
                    $r = mysqli_query($con, $q);
                    while($s = mysqli_fetch_object($r)){
                ?>
                <option value="<?=$s->codigo?>" <?=(($_SESSION['filtro_usuario'] == $s->codigo)?'selected':false)?>><?=$s->nome?></option>
                <?php
                    }
                ?>
            </select>
            <label for="email">Usuário</label>
        </div>
    </div>

</div>


<div class="row g-0">
    <?php
    $query = "select *, count(*) as qt, (select count(*) from se where municipio = '{$_POST['municipio']}' and bairro_comunidade = '{$_POST['bairro_comunidade']}' and local = '{$_POST['zona']}' and meta > 0 and meta in('i','p')) as metas from se where municipio = '{$_POST['municipio']}' and bairro_comunidade = '{$_POST['bairro_comunidade']}' and local = '{$_POST['zona']}' group by situacao";
    $query = "select *, count(*) as qt from se where 1 {$where} and meta = '0' and situacao in('f','c','n') group by situacao";
    $result = mysqli_query($con, $query);
    $r = [];
    $total = 0;
    while($d = mysqli_fetch_object($result)){
        $r[$d->situacao] = $d->qt;
        $total = ($total + $d->qt);
    }


    $exibe = [
        // 'p' => 'Pendente',
        // 'i' => 'Iniciado',
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
</div>

<div class="row g-0">
    <div class="col-md-12">
        <h5 style="margin:5px; margin-top:20px;">Desempenho das Situações da Pesquisa fora da Meta</h5>
        <table class="table">
            <?php
            foreach($exibe as $i => $v){
                $dv = ($r[$i]*100/(($total)?:1));
            ?>
            <tr>
                <th style="white-space: nowrap;">
                    <?=$v?>
                </th>
                <td class="w-100">
                    <div title="<?=($r[$i]*1)." beneficiado(s) que correspondem a ".number_format(($dv),0,false,false)?>% do total de <?=$total?> beneficiado(s)." style="color:#fff; cursor:pointer; opacity:0.7; text-align:center; background-color:blue; padding:3px; border-radius:7px; width:<?=number_format(($dv),0,false,false)?>%"><?=number_format(($dv),0,false,false)?>%</div>
                    <span style="color:#a1a1a1; font-size:12px;"><?=($r[$i]*1)." beneficiado(s) que correspondem a ".number_format(($dv),0,false,false)?>% do total de <?=$total?> beneficiado(s).</span>
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

        $("#usuario").change(function(){
            usuario = $(this).val();
            Carregando()
            $.ajax({
                url:"src/relatorios_fora_meta/index.php",
                type:"POST",
                data:{
                    usuario,
                    acao:'filtro'
                },
                success:function(dados){
                    Carregando('none')
                    $("#paginaHome").html(dados);
                }
            });
        });

    })
</script>