<?php include_once("../elements/topo.php");?>

<h1 class="page-header">Inserir Produto no Carrinho</h1>

<button type="button" class="btn btn-info" onclick="location.href='index.php' ">voltar</button>

<hr>

    <!-- Envia informações para o carrinho -->
    <form name="adicionar_carrinho"  action="carrinho.php"  method="post" id="adicionar_carrinho" data-toggle="validator">
      <div class="row">
        <div class="form-group col-md-12">
          <label for="produtos_id">Produtos Disponíveis</label>
          <?php $produtos = DBRead('produtos', "WHERE status = 1 AND qtdadeestoque > 0 ORDER by id", 'id, nome, valorunit, qtdadeestoque'); ?>
          <select name="produtos_id" class="form-control form-control-lg" id="produtos_id" required>
            <option disabled selected value="-1">Selecione...</option >
            <?php foreach($produtos as $valor){
              
              //Cria array com os produtos cadastrados no banco, só para facilitar a reutilização.
              $_SESSION['lista_produtos'][$valor['id']] = array('nome'=>$valor['nome'], 'valorunit'=>$valor['valorunit'], 'estoque'=>$valor['qtdadeestoque']);
            ?>
              <option value="<?php echo $valor['id']; ?>"><?php echo "<h2>".$valor['nome']."</h2>"; echo " | Valor: R$ ".$valor['valorunit'].""; echo " | Estoque: ".$valor['qtdadeestoque'].""; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-12">
          <label for="quantidade">Quantidade</label>
          <input type="number" class="form-control" placeholder="Quantidade" id="quantidade" name="quantidade" min="1" required>
        </div>

        <div class="form-group col-md-12">
          <input type="hidden" name="cadastro_itens_venda" value="cadastro_itens_venda"/>
          <input type="submit" class="btn btn-primary" value="Inserir"/>

          <!-- Só exibe se a sessão carrinho existir! -->
          <button type="button" class="btn btn-primary" id="btn_carrinho" onclick="location.href='carrinho.php'" style="float: right; display: none;">Ir Para Carrinho</button>
          <?php if(isset($_SESSION['carrinho']) and count($_SESSION['carrinho']) > 0){
            echo '<script>$("#btn_carrinho").show();</script>';
          }else{
            echo '<script>$("#btn_carrinho").hide();</script>';
          } ?>
        </div>
      </div>
    </form>

<script type="text/javascript">

$(document).ready(function(){
// //Validação em Jquery
  $("#adicionar_carrinho").validate({
      messages:{
          quantidade:{
            required: "Informe a Quantidaade!",
          },
          produtos_id:{
            required: "Selecione o Produto!",
          }
      }
    });
});

</script>

<?php include_once("../elements/rodape.php");?>
