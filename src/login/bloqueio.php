<?php
include("{$_SERVER['DOCUMENT_ROOT']}/vns/govSocial/lib/includes.php");
?>
<style>
.pagina{
    position:fixed;
    left:0;
    top:0;
    bottom:0;
    right:0;
    width:100%;
    height: 100%;
    background-repeat: no-repeat;
    /* background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33)); */
    /* background-image: linear-gradient(#19ae46, #ffffff); */
    background-color:#333;
}

.card-container.card {
    width: 350px;
    padding: 40px 40px;
    border-radius:5px;
}


/*
 * Card component
 */
.card {
    background-color: #F7F7F7;
    /* just in case there no content*/
    padding: 20px 25px 30px;
    margin: 0 auto 25px;
    margin-top: 50px;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.profile-img-card {
    width: 200px;
    height: auto;
    margin: 0 auto 10px;
    display: block;
}

/*
 * Form styles
 */
.profile-name-card {
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    margin: 10px 0 0;
    min-height: 1em;
}

.reauth-email {
    display: block;
    color: #404040;
    line-height: 2;
    margin-bottom: 10px;
    font-size: 14px;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin #inputEmail,
.form-signin #inputPassword {
    direction: ltr;
    height: 44px;
    font-size: 16px;
}

.form-signin input[type=email],
.form-signin input[type=password],
.form-signin input[type=text],
.form-signin button {
    width: 100%;
    display: block;
    margin-bottom: 10px;
    z-index: 1;
    position: relative;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin .form-control:focus {
    border-color: rgb(104, 145, 162);
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
}

.forgot-password {
    color: rgb(104, 145, 162);
}

.forgot-password:hover,
.forgot-password:active,
.forgot-password:focus{
    color: rgb(12, 97, 33);
}
</style>

<div class="pagina">
    <div class="container">
        <div class="card card-container">
            
            <div class="text-center">
                <h3>SISTEMA EM MANUTENÇÃO</h3>
                <p style="color:#a1a1a1; font-size:14px;">O sistema encontra-se desativado com previsão indeterminada.</p>
                <p style="color:#a1a1a1; font-size:14px;">Para mais informações, favor entre em contato com o administrador do sistema.</p>
            </div>

        </div><!-- /card-container -->
    </div><!-- /container -->
</div>

<script>
    $(function(){
        // Carregando('none');
        AcaoBotao = ()=>{
            login = $("#login").val();
            senha = $("#senha").val();
            Carregando();
            $.ajax({
                url:"src/login/index.php",
                type:"POST",
                dataType:"json",
                data:{
                    acao:'login',
                    login,
                    senha
                },
                success:function(dados){
                    // let retorno = JSON.parse(dados);
                    // $.alert(dados.sucesso);
                    console.log(dados.ProjectSeLogin);
                    if(dados.ProjectSeLogin > 0){
                        window.location.href='./';
                    }else{
                        $.alert('Ocorreu um erro.<br>Favor confira os dados do login.')
                        Carregando('none');
                    }

                }
            });
        };

        $("#Acessar").click(function(){
            AcaoBotao();
        });

        $(document).on('keypress', function(e){

            var key = e.which || e.keyCode;
            if (key == 13) { // codigo da tecla enter
                AcaoBotao();
            }


        });

    })
</script>