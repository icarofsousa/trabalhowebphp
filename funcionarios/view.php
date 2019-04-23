<?php
	include_once("../elements/topo.php");

	@$id = (int) DBEscape($_GET['id']);

	// Faz a busca no Banco de Dados
	$info_funcionario = DBRead('funcionarios', "WHERE id = $id", 'id, pessoas_id, datadeadmissao, comissao, tipofuncionario, status, created, updated');
	$info_pessoa = DBRead('pessoas', "WHERE id = ".$info_funcionario['0']['pessoas_id']."", 'id, nome, datanascimento, cpf, email, telefone, celular, endereco, numero, cep, bairro, cidades_id, senha, status, created, updated');
?>

<h1 class="page-header">Visualizar - Funcionário</h1>

<a href="javascript:history.back()">
	<button type="button" class="btn btn-info">Voltar</button>
</a>

<hr>
<form name="visualizar_funcionario" action="" method="post" id="visualizar_funcionario" data-toggle="validator">

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
			disabled />
			Status
		</label>
    </div>
  </div>

  <div class="form-group">
    <label for="nome_completo">Nome Completo</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome_completo" name="nome" required
    value="<?php echo @$info_pessoa['0']['nome']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="data_nascimento">Data de Nascimento</label>
    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
    value="<?php echo @$info_pessoa['0']['datanascimento']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="cpf">CPF</label>
    <input type="text" class="form-control" placeholder="CPF" id="cpf" name="cpf" required
    value="<?php echo @$info_pessoa['0']['cpf']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="Email">Email</label>
    <input type="email" class="form-control" placeholder="Email" id="email" name="email" required
    value="<?php echo @$info_pessoa['0']['email']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="telefone">Telefone</label>
    <input type="text" class="form-control" placeholder="Telefone" id="telefone" name="telefone"
    value="<?php echo @$info_pessoa['0']['telefone']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="celular">Celular</label>
    <input type="text" class="form-control" placeholder="Celular" id="celular" name="celular"
    value="<?php echo @$info_pessoa['0']['celular']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="endereco">Endereço</label>
    <input type="text" class="form-control" placeholder="Endereço" id="endereco" name="endereco"
    value="<?php echo @$info_pessoa['0']['endereco']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="numero">Número</label>
    <input type="text" class="form-control" placeholder="Número" id="numero" name="numero"
    value="<?php echo @$info_pessoa['0']['numero']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="cep">CEP</label>
    <input type="text" class="form-control" placeholder="CEP" id="cep" name="cep"
    value="<?php echo @$info_pessoa['0']['cep']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="bairro">Bairro</label>
    <input type="text" class="form-control" placeholder="Bairro" id="bairro" name="bairro"
    value="<?php echo @$info_pessoa['0']['bairro']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="cidade">Cidade</label>
    <?php $cidades = DBRead('cidades', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
    <select name="cidade" class="form-control form-control-lg" id="cidade" required
    value="<?php echo @$info_pessoa['0']['cidades_id']; ?>" disabled>

      <option value="-1">Selecione...</option >

      <?php foreach($cidades as $valor){?>
        <option value="<?php echo $valor['id']; ?>" <?php
        	if ($valor['id'] == @$info_pessoa['0']['cidades_id']){
        		echo('selected');
        	}else{
        		echo('');
        	} ?>
        disabled ><?php echo $valor['nome']; ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="senha">Senha</label>
    <input type="password" class="form-control" placeholder="********" id="senha" name="senha" required
    value="<?php echo @$info_pessoa['0']['senha']; ?>" disabled>
  </div>

	<div class="form-group">
		<label for="datadeadmissao">Data de Admissão</label>
		<input type="date" class="form-control" id="datadeadmissao" name="datadeadmissao" required
		value="<?php echo @$info_funcionario['0']['datadeadmissao']; ?>" disabled>
	</div>

	<div class="form-group">
		<label for="comissao">Comissão</label>
		<input type="text" class="form-control" placeholder="Comissão" id="comissao" name="comissao"
		value="<?php echo @$info_funcionario['0']['comissao']; ?>" disabled>
	</div>

	<div class="form-group">
		<label for="tipofuncionario">Tipo de Funcionario</label>
		<input type="text" class="form-control" placeholder="Tipo de Funcionario" id="tipofuncionario" name="tipofuncionario" maxlength="1"
		value="<?php echo @$info_funcionario['0']['tipofuncionario']; ?>" disabled>
	</div>

	<input type="hidden" name="id_pessoa" value="<?php echo @$info_pessoa['0']['id']; ?>"/>
	<input type="hidden" name="id_funcionario" value="<?php echo @$info_funcionario['0']['id']; ?>"/>

</form>

<?php include_once("../elements/rodape.php");?>
