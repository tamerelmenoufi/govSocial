<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/vns/govSocial/lib/includes.php");


  $url = 'src/home/dashboard/home.php';

?>

<script>
  $(function(){

    $.ajax({
      url:'<?=$url?>',
      success:function(dados){
        $("#paginaHome").html(dados);
      },
      error:function(){
        console.log('Erro');
      }
    });

  })
</script>