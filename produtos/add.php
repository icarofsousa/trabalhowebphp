<?php include_once("../elements/topo.php");?>
<h1 class="page-header">Cadastrar - Produto</h1>

<button type="button" class="btn btn-info" onclick="location.href='index.php' ">voltar</button>

<hr>


<?php
if (isset($_POST['cadastro']) && $_POST['cadastro'] == 'cadastro') {

    $dados = array(
        'fabricantes_id' => $_REQUEST['fabricante_id'],
        'nome' => $_REQUEST['nome'],
        'qtdadeestoque' => $_REQUEST['qtdadeestoque'],
        'valorunit' => $_REQUEST['valorunit'],
        'status' => (int) $_REQUEST['status'],
        'created' => date('Y-m-d H:i:s'),
        'updated' => date('Y-m-d H:i:s')
    );

    // Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
    $grava = DBCreate('produtos', $dados);

    if ($grava) {
        //echo "<script>alert('Cadastrado realizado com sucesso!');</script>";
        echo "<script>location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar, tente novamente!');</script>";
    }
}
?>


<form name="cadastro_produtos" action="add.php" method="post" id="cadastro_produtos" data-toggle="validator">

  <div class="form-group">
    <div class="checkbox">
      <label>
        <input type="checkbox" name="status" checked=checked value="1">
        Status
      </label>
    </div>
  </div>

   <div class="form-group">
    <label for="fabricante_id">Fabricante</label>
    <?php $pessoas = DBRead('fabricantes', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
    <select name="fabricante_id" class="form-control form-control-lg" id="fabricante_id" required>
      <option disabled selected value="-1">Selecione...</option >
      <?php foreach($pessoas as $valor){?>
        <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nome']; ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="nome">Nome Completo</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome" name="nome" required>
  </div>

  <div class="form-group">
    <label for="qtdadeestoque">Quantidade de Estoque</label>
    <input type="number" class="form-control" placeholder="Quantidade de Estoque" id="qtdadeestoque" name="qtdadeestoque">
  </div>

  <div class="form-group">
    <label for="valorunit">Valor Unitário</label>
    <input type="text" class="form-control" placeholder="Valor Unitário" id="valorunit" name="valorunit" required>
  </div>

  <input type="hidden" name="cadastro" value="cadastro"/>
  <input type="submit" class="btn btn-primary" value="Cadastrar"/>

</form>

<script type="text/javascript">

  $(document).ready(function(){
  //Validação em Jquery
    $("#cadastro_produtos").validate({
        messages:{
          nome:{
            required: "Informe o Nome!",
          },
          valorunit:{
            required: "Informe o Valor do Produto!",
          },
          fabricante_id:{
            required: "Selecione o Fabricante!",
          }
        }
      });

  });

</script>

<?php include_once("../elements/rodape.php");?>
