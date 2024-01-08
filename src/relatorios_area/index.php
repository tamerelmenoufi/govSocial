<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/vns/govSocial/lib/includes.php");
?>
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

<script>
    $(function(){
        Carregando('none')

    })
</script>