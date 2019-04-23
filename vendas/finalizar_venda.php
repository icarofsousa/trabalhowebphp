<!-- //FINALIZAR -->
<!-- caso o carrinho existe, ele mostra a parte de finalizar venda! -->
<?php if(isset($_SESSION['carrinho']) and count($_SESSION['carrinho']) > 0){ ?>

<div class="row">
  <div class="panel panel-primary">
    <div class="panel-heading">
        <h4>Finalizar - Venda</h4>
    </div>

      <div class="panel-body">

        <!-- Formulario para atualizar valor final da venda. -->
        <form action="atualiza_venda_carrinho.php" method="post">

          <div class="form-group col-md-4">
            <label for="vt_venda">Valor Total</label>
            <input type="text" class="form-control" placeholder="Valor Total" id="vt_venda" name="vt_venda"
            value="<?php 
            $_SESSION['venda']['valor_total'] = 0;

              //Percorre o carrinho somando os valores de cada item
              foreach($_SESSION['carrinho'] as $key => $row){
                $_SESSION['venda']['valor_total'] += $_SESSION['carrinho'][$key]['valortotal'];
              }

              echo $_SESSION['venda']['valor_total'];
            ?>" required disabled>
          </div>

          <div class="form-group col-md-4">
            <label for="desconto">Desconto (em %)</label>
            <input type="text" class="form-control" placeholder="Desconto" id="desconto" name="desconto"
            value="<?php
            
                //Caso já exista desconto, ele vai exibir
                $desconto = isset ($_SESSION['venda']['desconto']) ? $_SESSION['venda']['desconto'] : '';
                echo $desconto;
              ?>">
          </div>

          <div class="form-group col-md-4">
            <label for="valorapagar">Valor à Pagar</label>
            <input type="text" class="form-control" placeholder="Valor à Pagar" id="valorapagar" name="valorapagar"
            value="<?php

                $default = $_SESSION['venda']['valor_total'];

                //Se existir o valor a pagar (valor total com desconto), ele vai exibir este valor, senão, ele vai exibir o valor total do carrinho.
                $total_a_pagar = isset($_SESSION['venda']['valor_a_pagar']) ? $_SESSION['venda']['valor_a_pagar'] : ''.$default.'' ;

                echo $total_a_pagar;
              ?>" disabled>
          </div>

          <div class="form-group col-md-12">
            <button type="submit" class="btn btn-info" name="atualizar_valor" style="float: right;">Atualizar - Valor</button>
          </div>
        </form> <!-- FINAL DA 1º FORM -->

        <!-- FORMULARIO A ULTIMA PARTE DA VENDA -->
        <form name="venda_final" method="post" id="venda_final" autocomplete="off" class="venda" action="carrinho.php" data-toggle="validator">

          <!-- Variável com todas as pessoas cadastradas no banco -->
          <?php
           $pessoas = DBRead('pessoas', "WHERE status = 1 ORDER by id", 'id, nome');
           foreach($pessoas as $valor){
              $_SESSION['listapessoas'][$valor['id']] = array('id'=>$valor['id'],'nome'=>$valor['nome']);
            }
          ?>

         <div class="form-group col-md-6">
            <label for="clientes_id">Clientes</label>
            <?php $clientes = DBRead('clientes', "WHERE status = 1 ORDER by id", 'id, pessoas_id, limitedecompra'); ?>
            <select name="clientes_id" class="form-control form-control-lg" id="clientes_id" required>
              <option disabled selected value="-1">Selecione...</option >
              <?php foreach($clientes as $valor){

                  //Variável com todos os clientes cadastrados no banco
                  $_SESSION['listadeclientes'][$valor['id']] = array('id'=>$valor['id'],'pessoas_id'=>$valor['pessoas_id'],'limitedecompra'=>$valor['limitedecompra']);

                  //Recebe o nome da pessoa vinculada na tabela cliente.
                  $nome_cliente = $_SESSION['listapessoas'][$valor['pessoas_id']]['nome'];

                  echo'<option value='.$valor['id'].'><h2>'.$nome_cliente.'</h2></option>';
              } ?>
            </select>
          </div>

         <div class="form-group col-md-6">
            <label for="funcionarios_id">Funcionários</label>
            <?php $funcionarios = DBRead('funcionarios', "WHERE status = 1 ORDER by id", 'id, pessoas_id, tipofuncionario'); ?>
            <select name="funcionarios_id" class="form-control form-control-lg" id="funcionarios_id">
              <option value="-1">Selecione...</option >
              <?php foreach($funcionarios as $valor){

                //Variável com todos os funcionarios cadastrados no banco
                $_SESSION['listadefuncionarios'][$valor['id']] = array('id'=>$valor['id'],'pessoas_id'=>$valor['pessoas_id'],'tipofuncionario'=>$valor['tipofuncionario']);

                //Recebe o nome da pessoa vinculada na tabela funcionario.
                $nome_funcionario = $_SESSION['listapessoas'][$valor['pessoas_id']]['nome'];

                echo'<option value='.$valor['id'].'><h2>'.$nome_funcionario.'</h2></option>';
              } ?>
            </select>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group col-md-4">
                <label for="tipodepagamento">Tipo de Pagamento</label>
                <input type="text" class="form-control" placeholder="Tipo de Pagamento" id="tipodepagamento" name="tipodepagamento" maxlength="1">
              </div>

              <div class="form-group col-md-3">
                <label for="datavenda">Data de Venda</label>
                <input type="date" class="form-control" id="datavenda" name="datavenda" required>
              </div>

            </div>
          </div>

          <div class="form-group col-md-12">
            <input type="hidden" name="cadastro_venda" value="cadastro_venda"/>
            <button type="submit" class="btn btn-primary" style="float: right;" name="finalizar">Finalizar</button>
          </div>

        </form> <!-- FINAL DA 2º FORM -->

    </div>
  </div>
</div>

<?php } ?>



<!-- VALIDAÇÃO -->
<script type="text/javascript">

$(document).ready(function(){
//Validação em Jquery
  $("#venda_final").validate({
      messages:{
          datavenda:{
            required: "Selecione a Data de Venda!",
          },
          clientes_id:{
            required: "Selecione o Cliente",
          }
      }
    });
});

</script>