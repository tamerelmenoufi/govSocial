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
                <option value="<?=$s->codigo?>" <?=(($d->municipio == $s->codigo)?'selected':false)?>><?=$s->municipio?></option>
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
                <option value="Urbano" <?=(($d->zona == 'Urbano')?'selected':false)?>>Urbano</option>
                <option value="Rural" <?=(($d->zona == 'Rural')?'selected':false)?>>Rural</option>
            </select>
            <label for="zona">Zona</label>
        </div>
    </div>
    <div class="col">
        <div class="form-floating mb-3 p-2">
            <select required name="bairro_comunidade" id="bairro_comunidade" class="form-control" placeholder="Bairro">
                <option value="">::Selecione a Localização::</option>
                <?php
                    $q = "select * from bairros_comunidades where municipio = '{$d->municipio}' ".(($d->zona)?" and tipo = '{$d->zona}'":false)." order by descricao";
                    $r = mysqli_query($con, $q);
                    while($s = mysqli_fetch_object($r)){
                ?>
                <option value="<?=$s->codigo?>" <?=(($d->bairro_comunidade == $s->codigo)?'selected':false)?>><?=$s->descricao?> (<?=$s->tipo?>)</option>
                <?php
                    }
                ?>
            </select>
            <label for="bairro_comunidade">Bairro/Comunidade</label>
        </div>
    </div>
</div>


<div class="row g-0">
    <?php
    $query = "select *, count(*) as qt from se where municipio = '{$_POST['municipio']}' and bairro_comunidade = '{$_POST['bairro_comunidade']}' and local = '{$_POST['zona']}' group by situacao";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
    ?>
    <div class="col-2 p-1">
        <div class="cartao">
            <span><?=$d->situacao?></span>
            <p><?=$d->qt?></p>
        </div>
    </div>
    <?php
    }
    ?>
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

        $("#bairro_comunidade").change(function(){
            zona = $("#zona").val();
            municipio = $("#municipio").val();
            bairro_comunidade = $("#bairro_comunidade").val();
            
            if(zona && municipio && bairro_comunidade){
                $.ajax({
                    url:"src/relatorios_area/index.php",
                    type:"POST",
                    data:{
                        zona,
                        municipio,
                        bairro_comunidade,
                    },
                    success:function(dados){
                    $("#paginaHome").html(dados);
                    }
                });
            }else{
                $.alert('Favor informe a localidade!');
            }


        });

    })
</script>