<?php include_once("../elements/topo.php");?>
<h1 class="page-header">Cadastrar - Movimentos</h1>

<!-- <a href="javascript:history.back()">
<button type="button" class="btn btn-info">Voltar</button>
</a>
 -->
<button type="button" class="btn btn-info" onclick="location.href='index.php' ">voltar</button>

<hr>


<?php
if (isset($_POST['cadastro']) && $_POST['cadastro'] == 'cadastro') {

    $dados = array(
        'caixas_id' => $_REQUEST['caixas_id'],
        'contasareceber_id' => $_REQUEST['contasareceber_id'],
        'valor' => $_REQUEST['valor'],
        'tipo' => $_REQUEST['tipo'],
        'historico' => $_REQUEST['historico'],
        'status' => (int) $_REQUEST['status'],
        'created' => date('Y-m-d H:i:s'),
        'updated' => date('Y-m-d H:i:s')
    );

    // Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
    $grava = DBCreate('movimentos', $dados);

    if ($grava) {
        //echo "<script>alert('Cadastrado realizado com sucesso!');</script>";
        echo "<script>location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar, tente novamente!');</script>";
    }
}
?>


<form name="cadastro_movimentos" action="add.php" method="post" id="cadastro_movimentos" data-toggle="validator">

  <div class="form-group">
    <div class="checkbox">
      <label>
        <input type="checkbox" name="status" checked=checked value="1">
        Status
      </label>
    </div>
  </div>

  <div class="form-group">
    <label for="caixas_id">Caixas</label>
    <?php $caixas = DBRead('caixas', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
    <select name="caixas_id" class="form-control form-control-lg" id="caixas_id" required>
      <option disabled selected value="-1">Selecione...</option >
      <?php foreach($caixas as $valor){?>
        <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nome']; ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="contasareceber_id">Contas a Receber</label>
    <?php $contasareceber = DBRead('contasareceber', "WHERE status = 1 ORDER by id", '*'); ?>
    <select name="contasareceber_id" class="form-control form-control-lg" id="contasareceber_id" required>
      <option disabled selected value="-1">Selecione...</option >
      <?php foreach($contasareceber as $valor){?>
        <option value="<?php echo $valor['id']; ?>"><?php echo 'Data: '.$valor['data'].' | Parcelas: '.$valor['qtdadedeparcelas'].' | Valor Pago: '.$valor['valorpago']; ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="valor">Valor</label>
    <input type="text" class="form-control" placeholder="Valor" id="valor" name="valor">
  </div>

  <div class="form-group">
    <label for="tipo">Tipo</label>
    <input type="text" class="form-control" placeholder="Tipo" id="tipo" name="tipo" maxlength="1">
  </div>

  <div class="form-group">
    <label for="historico">Histórico</label>
    <textarea class="form-control" rows="5" id="historico" name="historico"></textarea>
  </div>

  <input type="hidden" name="cadastro" value="cadastro"/>
  <input type="submit" class="btn btn-primary" value="Cadastrar"/>
</form>




<script type="text/javascript">

$(document).ready(function(){
//Validação em Jquery
  $("#cadastro_movimentos").validate({
      messages:{
          caixas_id:{
            required: "Selecione o Caixa!",
          },
          contasareceber_id:{
            required: "Selecione a Conta!",
          }
      }
    });

});

</script>

<?php include_once("../elements/rodape.php");?>
