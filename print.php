<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectSocioEconomico/lib/includes.php");

    if($_GET['u']){
        $url = base64_decode($_GET['u']);
    }else{
        exit();
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/icone.png">
    <title>AADESAM - Pesquisa Socioeconômico</title>
    <?php
    include("lib/header.php");
    ?>

    <style>
        .CorpoApp{
            /* margin-top:150px;
            margin-bottom:190px; */
        }
        header{
            position:relative;
            /* top:0;
            left:0; */
            width:100%;
            height:60px;
            background-image:url("img/topo_gov.png");
            background-position:center center;
            background-size:auto 100%;
            background-repeat:no-repeat;
            z-index:99;
        }
        footer {
            position:relative;
            /* bottom:0;
            left:0; */
            width:100%;
            height:70px;
            background-image:url("img/rodape_gov.png");
            background-position:right;
            background-size:100% 80px;
            background-repeat:no-repeat;
            z-index:99;
        }
    </style>

  </head>
  <body>
    <header class="Topo"></header>
    <div class="CorpoApp"></div>
    <footer class="Rodape"></footer>
    <?php
    include("lib/footer.php");
    ?>

    <script>
        $(function(){

            $.ajax({
                url:"<?=$url?>?p=1",
                success:function(dados){
                    $(".CorpoApp").html(dados);
                }
            });
        })
    </script>

  </body>
</html>