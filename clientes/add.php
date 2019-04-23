<?php include_once("../elements/topo.php");?>
<h1 class="page-header">Cadastrar - Cliente</h1>

<button type="button" class="btn btn-info" onclick="location.href='index.php' ">voltar</button>

<hr>

<?php
  if (isset($_POST['cadastro']) && $_POST['cadastro'] == 'cadastro') {

    $dados_pessoa = array(
        'nome' => $_REQUEST['nome'],
        'datanascimento' => $_REQUEST['data_nascimento'],
        'cpf' => $_REQUEST['cpf'],
        'email' => $_REQUEST['email'],
        'telefone' => $_REQUEST['telefone'],
        'celular' => $_REQUEST['celular'],
        'endereco' => $_REQUEST['endereco'],
        'numero' => $_REQUEST['numero'],
        'cep' => $_REQUEST['cep'],
        'bairro' => $_REQUEST['bairro'],
        'cidades_id' => $_REQUEST['cidade'],
        'senha' => $_REQUEST['senha'],
        'status' => (int) $_REQUEST['status'],
        'created' => date('Y-m-d H:i:s'),
        'updated' => date('Y-m-d H:i:s')
    );

    // Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
    $grava_pessoa = DBCreate('pessoas', $dados_pessoa, true);

    if($grava_pessoa){
      $pessoa_id = $grava_pessoa;

      $dados_cliente = array(
          'pessoas_id' => $pessoa_id,
          'limitedecompra' => $_REQUEST['limitedecompra'],
          'status' => (int) $_REQUEST['status'],
          'created' => date('Y-m-d H:i:s'),
          'updated' => date('Y-m-d H:i:s')
      );

      // Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
      $grava_cliente = DBCreate('clientes', $dados_cliente);

      if ($grava_cliente) {
          //echo "<script>alert('Cadastrado realizado com sucesso!');</script>";
          echo "<script>location.href='index.php';</script>";
      } else {
          echo "<script>alert('Erro ao cadastrar, tente novamente!');</script>";
      }
    }
}
?>

<form name="cadastro_cliente" action="add.php" autocomplete="off" method="post" id="cadastro_cliente" data-toggle="validator">

  <div class="form-group">
    <div class="checkbox">
      <label>
        <input type="checkbox" name="status" checked=checked value="1">
        Status
      </label>
    </div>
  </div>

  <div class="form-group">
    <label for="nome_completo">Nome Completo</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome_completo" name="nome" required=>
  </div>

  <div class="form-group">
    <label for="data_nascimento">Data de Nascimento</label>
    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
  </div>

  <div class="form-group">
    <label for="cpf">CPF</label>
    <input type="text" class="form-control" placeholder="CPF" id="cpf" name="cpf" required>
  </div>

  <div class="form-group">
    <label for="Email">Email</label>
    <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
  </div>

  <div class="form-group">
    <label for="telefone">Telefone</label>
    <input type="text" class="form-control" placeholder="Telefone" id="telefone" name="telefone">
  </div>

  <div class="form-group">
    <label for="celular">Celular</label>
    <input type="text" class="form-control" placeholder="Celular" id="celular" name="celular">
  </div>

  <div class="form-group">
    <label for="endereco">Endereço</label>
    <input type="text" class="form-control" placeholder="Endereço" id="endereco" name="endereco">
  </div>

  <div class="form-group">
    <label for="numero">Número</label>
    <input type="text" class="form-control" placeholder="Número" id="numero" name="numero">
  </div>

  <div class="form-group">
    <label for="cep">CEP</label>
    <input type="text" class="form-control" placeholder="CEP" id="cep" name="cep">
  </div>

  <div class="form-group">
    <label for="bairro">Bairro</label>
    <input type="text" class="form-control" placeholder="Bairro" id="bairro" name="bairro">
  </div>

  <div class="form-group">
    <label for="cidade">Cidade</label>
    <?php $cidades = DBRead('cidades', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
    <select name="cidade" class="form-control form-control-lg" id="cidade" required>
      <option value="-1">Selecione...</option >
      <?php foreach($cidades as $valor){?>
        <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nome']; ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="senha">Senha</label>
    <input type="password" class="form-control" placeholder="********" id="senha" name="senha" required>
  </div>

  <div class="form-group">
    <label for="limitedecompra">Limite de Compra</label>
    <input type="number" class="form-control" placeholder="Limite de Compra" id="limitedecompra" name="limitedecompra" required=>
  </div>

  <input type="hidden" name="cadastro" value="cadastro"/>
  <input type="submit" class="btn btn-primary" value="Cadastrar"/>

</form>

<script type="text/javascript">

$(document).ready(function(){
//Validação em Jquery
  $("#cadastro_cliente").validate({
      messages:{
          limitedecompra:{
            required: "Informe o Limite de Compra!",
          },
          nome:{
            required: "Informe o Nome!",
          },
          cpf:{
            required: "Informe o CPF!",
          },
          email:{
            required: "Informe o Email",
          },
          senha:{
            required: "Informe a Senha",
          },
          cidade:{
            required: "Informe a Senha",
          }
      }
    });
});

</script>

<?php include_once("../elements/rodape.php");?>
