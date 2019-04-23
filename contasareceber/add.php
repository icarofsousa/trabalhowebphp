<?php include_once("../elements/topo.php");?>
<h1 class="page-header">Cadastrar - Contas a Receber</h1>

<button type="button" class="btn btn-info" onclick="location.href='index.php' ">voltar</button>
<hr>

<?php
if (isset($_POST['cadastro']) && $_POST['cadastro'] == 'cadastro') {

    $dados = array(
        'vendas_id' => $_SESSION['contasareceber']['id'],
        'qtdadedeparcelas' => $_REQUEST['quantidadedeparcelas'],
        'desconto' => $_SESSION['contasareceber']['desconto'],
        'juros' => $_REQUEST['juros'],
        'valortotal' => $_SESSION['contasareceber']['valortotal'],
        'valorpago' => $_SESSION['contasareceber']['valorapagar'],
        'data' => $_REQUEST['data'],
        'status' => (int) $_REQUEST['status'],
        'created' => date('Y-m-d H:i:s'),
        'updated' => date('Y-m-d H:i:s')
    );

    // Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
    $grava = DBCreate('contasareceber', $dados);

    if ($grava) {
        //echo "<script>alert('Cadastrado realizado com sucesso!');</script>";
        echo "<script>location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar, tente novamente!');</script>";
    }
}
?>

<form name="escolha_venda" action="atualizacontas.php" method="post" id="escolha_venda" data-toggle="validator">

  <div class="form-group">
     <label for="vendas_id">Venda</label>
     <?php $vendas = DBRead('vendas', "WHERE status = 1 ORDER by id", '*'); ?>
     <select name="vendas_id" class="form-control form-control-lg" id="clientes_id">
       <option value="-1">Selecione...</option >
       <?php foreach($vendas as $valor){
            $_SESSION['listadevendas'] = array(
              'id' => $valor['id'],
              'valorapagar' => $valor['valorapagar']
            );
         ?>
           <option value="<?php echo $valor['id']; ?>"
             <?php
    	 				 if (isset($_SESSION['contasareceber']) && $valor['id'] == $_SESSION['contasareceber']['id']){
    	 					 echo('selected');
    	 				 }else{
    	 					 echo('');
    	 				 } ?>
             ><?php echo 'ID: '.$valor['id'].' | Data: '.$valor['datavenda'].' | Valor: '.$valor['valorapagar']; ?></option>
     <?php  } ?>
     </select required>
   </div>

   <input type="hidden" name="escolha" value="atualizar_venda"/>
   <input type="submit" class="btn btn-primary" value="Selecionar"/>

</form>

<?php if (isset($_SESSION['contasareceber'])){ ?>
  <form name="cadastro_contasareceber" action="add.php" method="post" id="cadastro_contasareceber" data-toggle="validator">

    <div class="form-group">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="status" checked=checked value="1">
          Status
        </label>
      </div>
    </div>

    <div class="form-group">
      <label for="quantidadedeparcelas">Quantidade de Parcelas</label>
      <input type="number" class="form-control" placeholder="Quantidade de Parcelas" id="quantidadedeparcelas" name="quantidadedeparcelas" required>
    </div>

    <div class="form-group">
      <label for="desconto">Desconto</label>
      <input type="text" class="form-control" placeholder="Desconto" id="desconto" name="desconto"
      value="<?php echo $_SESSION['contasareceber']['desconto']; ?>" disabled>
    </div>

    <div class="form-group">
      <label for="juros">Juros</label>
      <input type="number" class="form-control" placeholder="Juros" id="juros" name="juros">
    </div>

    <div class="form-group">
      <label for="valortotal">Valor Total</label>
      <input type="text" class="form-control" placeholder="Valor Total" id="valortotal" name="valortotal" required
      value="<?php echo $_SESSION['contasareceber']['valortotal']; ?>" disabled>
    </div>

    <div class="form-group">
      <label for="valorpago">Valor Pago</label>
      <input type="text" class="form-control" placeholder="Valor Pago" id="valorpago" name="valorpago"
      value="<?php echo $_SESSION['contasareceber']['valorapagar']; ?>" disabled>
    </div>

    <div class="form-group">
      <label for="data">Data de Recebimento</label>
      <input type="date" class="form-control" id="data" name="data" required>
    </div>


    <input type="hidden" name="cadastro" value="cadastro"/>
    <input type="submit" class="btn btn-primary" value="Cadastrar"/>

  </form>

<?php } ?>

<script type="text/javascript">

  $(document).ready(function(){
  //Validação em Jquery
    $("#cadastro_contasareceber").validate({
        messages:{
            vendas_id:{
              required: "Selecione uma Venda!",
            },
            quantidadedeparcelas:{
              required: "Informe a quantidade de parcelas!",
            },
            valortotal:{
              required: "Informe o valor total!",
            },
            data:{
              required: "Selecione uma data!",
            }
        }
      });
  });

</script>

<?php include_once("../elements/rodape.php");?>
