<?php
	include_once("../elements/topo.php");

	@$id = (int) DBEscape($_GET['id']);

	// Faz a busca no Banco de Dados
		$infor = DBRead('caixas', "WHERE id = $id", 'id, nome, status, created, updated');

?>

<h1 class="page-header">Visualizar - Caixas</h1>

<a href="javascript:history.back()">
	<button type="button" class="btn btn-info">Voltar</button>
</a>

<hr>
<form name="visualizar_caixas" action="" method="post" id="visualizar_caixas" data-toggle="validator">

  <div class="form-group">
    <div class="checkbox">
		<label>
			<input name="status" type="checkbox" value="1"
			<?php
				if (isset($infor['0']['status']) && $infor['0']['status'] == 1) {
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
    <label for="nome">Nome</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome" name="nome" required
    value="<?php echo @$infor['0']['nome']; ?>" disabled>
  </div>

  <input type="hidden" name="id" value="<?php echo @$infor['0']['id']; ?>"/>

</form>

<?php include_once("../elements/rodape.php");?>
