<?php include_once("../elements/topo.php");?>

<?php

	if (isset($_POST['alterar']) && $_POST['alterar'] == 'alterar') {

		$dados_pessoa = array(
		    	'id' => $_REQUEST['id_pessoa'],
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
	        'updated' => date('Y-m-d H:i:s')
		);

		$dados_funcionario = array(
        'id' =>  $_REQUEST['id_funcionario'],
        'datadeadmissao' => $_REQUEST['datadeadmissao'],
        'comissao' => $_REQUEST['comissao'],
        'tipofuncionario' => $_REQUEST['tipofuncionario'],
        'status' => (int) $_REQUEST['status'],
        'updated' => date('Y-m-d H:i:s')
    );

		// Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
		$grava_pessoa = DBUpDate('pessoas', $dados_pessoa, "id = {$dados_pessoa['id']}");

		if ($grava_pessoa) {
		} else {
			echo "<script>alert('Erro ao editar, tente novamente!');</script>";
		}

		$grava_funcionario = DBUpDate('funcionarios', $dados_funcionario, "id = {$dados_funcionario['id']}");

		if ($grava_funcionario) {
			echo "<script>location.href='index.php';</script>";
		} else {
			echo "<script>alert('Erro ao editar, tente novamente!');</script>";
		}

	}else{

		@$id = (int) DBEscape($_GET['id']);

		// Faz a busca no Banco de Dados
		$info_funcionario = DBRead('funcionarios', "WHERE id = $id", 'id, pessoas_id, datadeadmissao, comissao, tipofuncionario, status, created, updated');
		$info_pessoa = DBRead('pessoas', "WHERE id = ".$info_funcionario['0']['pessoas_id']."", 'id, nome, datanascimento, cpf, email, telefone, celular, endereco, numero, cep, bairro, cidades_id, senha, status, created, updated');

	}
?>

<h1 class="page-header">Editar - Funcionário</h1>

<a href="javascript:history.back()">
	<button type="button" class="btn btn-info">Voltar</button>
</a>

<hr>
<form name="alterar_funcionario" action="" method="post" id="alterar_funcionario" data-toggle="validator">

  <div class="form-group">
    <div class="checkbox">
		<label>
			<input name="status" type="checkbox" value="1"
			<?php
				if (isset($info_pessoa['0']['status']) && $info_pessoa['0']['status'] == 1) {
					echo "checked";
					} else {
					echo "";
				}
			?>
			/>
			Status
		</label>
    </div>
  </div>

  <div class="form-group">
    <label for="nome_completo">Nome Completo</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome_completo" name="nome" required
    value="<?php echo @$info_pessoa['0']['nome']; ?>">
  </div>

  <div class="form-group">
    <label for="data_nascimento">Data de Nascimento</label>
    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
    value="<?php echo @$info_pessoa['0']['datanascimento']; ?>">
  </div>

  <div class="form-group">
    <label for="cpf">CPF</label>
    <input type="text" class="form-control" placeholder="CPF" id="cpf" name="cpf" required
    value="<?php echo @$info_pessoa['0']['cpf']; ?>">
  </div>

  <div class="form-group">
    <label for="Email">Email</label>
    <input type="email" class="form-control" placeholder="Email" id="email" name="email" required
    value="<?php echo @$info_pessoa['0']['email']; ?>">
  </div>

  <div class="form-group">
    <label for="telefone">Telefone</label>
    <input type="text" class="form-control" placeholder="Telefone" id="telefone" name="telefone"
    value="<?php echo @$info_pessoa['0']['telefone']; ?>">
  </div>

  <div class="form-group">
    <label for="celular">Celular</label>
    <input type="text" class="form-control" placeholder="Celular" id="celular" name="celular"
    value="<?php echo @$info_pessoa['0']['celular']; ?>">
  </div>

  <div class="form-group">
    <label for="endereco">Endereço</label>
    <input type="text" class="form-control" placeholder="Endereço" id="endereco" name="endereco"
    value="<?php echo @$info_pessoa['0']['endereco']; ?>">
  </div>

  <div class="form-group">
    <label for="numero">Número</label>
    <input type="text" class="form-control" placeholder="Número" id="numero" name="numero"
    value="<?php echo @$info_pessoa['0']['numero']; ?>">
  </div>

  <div class="form-group">
    <label for="cep">CEP</label>
    <input type="text" class="form-control" placeholder="CEP" id="cep" name="cep"
    value="<?php echo @$info_pessoa['0']['cep']; ?>">
  </div>

  <div class="form-group">
    <label for="bairro">Bairro</label>
    <input type="text" class="form-control" placeholder="Bairro" id="bairro" name="bairro"
    value="<?php echo @$info_pessoa['0']['bairro']; ?>">
  </div>

  <div class="form-group">
    <label for="cidade">Cidade</label>
    <?php $cidades = DBRead('cidades', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
    <select name="cidade" class="form-control form-control-lg" id="cidade" required
    value="<?php echo @$info_pessoa['0']['cidades_id']; ?>">

      <option value="-1">Selecione...</option >

      <?php foreach($cidades as $valor){?>
        <option value="<?php echo $valor['id']; ?>" <?php
        	if ($valor['id'] == @$info_pessoa['0']['cidades_id']){
        		echo('selected');
        	}else{
        		echo('');
        	} ?>
        ><?php echo $valor['nome']; ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="senha">Senha</label>
    <input type="password" class="form-control" placeholder="********" id="senha" name="senha" required
    value="<?php echo @$info_pessoa['0']['senha']; ?>">
  </div>

	<div class="form-group">
		<label for="datadeadmissao">Data de Admissão</label>
		<input type="date" class="form-control" id="datadeadmissao" name="datadeadmissao" required
		value="<?php echo @$info_funcionario['0']['datadeadmissao']; ?>">
	</div>

	<div class="form-group">
		<label for="comissao">Comissão</label>
		<input type="text" class="form-control" placeholder="Comissão" id="comissao" name="comissao"
		value="<?php echo @$info_funcionario['0']['comissao']; ?>">
	</div>

	<div class="form-group">
		<label for="tipofuncionario">Tipo de Funcionario</label>
		<input type="text" class="form-control" placeholder="Tipo de Funcionario" id="tipofuncionario" name="tipofuncionario" maxlength="1"
		value="<?php echo @$info_funcionario['0']['tipofuncionario']; ?>">
	</div>

	<input type="hidden" name="id_pessoa" value="<?php echo @$info_pessoa['0']['id']; ?>"/>
	<input type="hidden" name="id_funcionario" value="<?php echo @$info_funcionario['0']['id']; ?>"/>
  <input type="hidden" name="alterar" value="alterar"/>
  <input type="submit" class="btn btn-primary" value="alterar"/>

</form>

<script type="text/javascript">

  $(document).ready(function(){
  //Validação em Jquery
    $("#alterar_funcionario").validate({
        messages:{
					datadeadmissao:{
            required: "Informe o a Data de Admissão!",
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
