<?php include_once("../elements/topo.php");?>
<h1 class="page-header">Cadastrar - Fabricante</h1>

<button type="button" class="btn btn-info" onclick="location.href='index.php' ">voltar</button>
<hr>

<?php
if (isset($_POST['cadastro']) && $_POST['cadastro'] == 'cadastro') {

    $dados = array(
        'nome' => $_REQUEST['nome'],
        'site' => $_REQUEST['site'],
        'status' => (int) $_REQUEST['status'],
        'created' => date('Y-m-d H:i:s'),
        'updated' => date('Y-m-d H:i:s')
    );

    // Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
    $grava = DBCreate('fabricantes', $dados);

    if ($grava) {
        //echo "<script>alert('Cadastrado realizado com sucesso!');</script>";
        echo "<script>location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar, tente novamente!');</script>";
    }
}
?>

<form name="cadastro_fabricante" action="add.php" method="post" id="cadastro_fabricante" data-toggle="validator">
  <div class="form-group">
    <div class="checkbox">
      <label>
        <input type="checkbox" name="status" checked=checked value="1">
        Status
      </label>
    </div>
  </div>

  <div class="form-group">
    <label for="nome">Nome Completo</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome" name="nome" required>
  </div>

  <div class="form-group">
    <label for="site">Site</label>
    <input type="text" class="form-control" placeholder="Site" id="site" name="site">
  </div>

  <input type="hidden" name="cadastro" value="cadastro"/>
  <input type="submit" class="btn btn-primary" value="Cadastrar"/>
</form>


<script type="text/javascript">

$(document).ready(function(){
//Validação em Jquery
  $("#cadastro_fabricante").validate({
      messages:{
          nome:{
            required: "Informe o Nome!",
          }
      }
    });
});

</script>

<?php include_once("../elements/rodape.php");?>
