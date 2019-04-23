<?php
	include_once("../elements/topo.php");

	@$id = (int) DBEscape($_GET['id']);

	// Faz a busca no Banco de Dados
		$infor = DBRead('produtos', "WHERE id = $id", 'id, fabricantes_id, nome, qtdadeestoque, valorunit, status, created, updated');
?>

<h1 class="page-header">Visualizar - Produtos</h1>
<a href="javascript:history.back()">
	<button type="button" class="btn btn-info">Voltar</button>
</a>
<hr>

<form name="visualizar_produto" action="" method="post" id="visualizar_produto" data-toggle="validator">
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
    <label for="fabricante_id">Fabricante</label>
    <?php $fabricantes = DBRead('fabricantes', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
    <select name="fabricante_id" class="form-control form-control-lg" id="fabricante_id" required disabled>
      <option value="-1">Selecione...</option >
      	<?php foreach($fabricantes as $valor){?>
        <option value="<?php echo $valor['id']; ?>" <?php
        	if ($valor['id'] == @$infor['0']['fabricantes_id']){
        		echo('selected');
        	}else{
        		echo('');
        	} ?>
        ><?php echo $valor['nome']; ?></option>
      <?php } ?>
    </select disabled>
  </div>

  <div class="form-group">
    <label for="nome">Nome Completo</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome" name="nome" required
     value="<?php echo @$infor['0']['nome']; ?>"  disabled>
  </div>

  <div class="form-group">
    <label for="qtdadeestoque">Quantidade de Estoque</label>
    <input type="number" class="form-control" placeholder="Quantidade de Estoque" id="qtdadeestoque" name="qtdadeestoque"
     value="<?php echo @$infor['0']['qtdadeestoque']; ?>" disabled>
  </div>

  <div class="form-group">
    <label for="valorunit">Valor Unitário</label>
    <input type="text" class="form-control" placeholder="Valor Unitário" id="valorunit" name="valorunit" required
     value="<?php echo @$infor['0']['valorunit']; ?>" disabled>
  </div>

  <input type="hidden" name="id" value="<?php echo @$infor['0']['id']; ?>"/>
</form>

<?php include_once("../elements/rodape.php");?>
