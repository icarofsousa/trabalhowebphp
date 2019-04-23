<?php include_once("../elements/topo.php");?>

<?php
	if (isset($_POST['alterar']) && $_POST['alterar'] == 'alterar') {

		$dados = array(
		    'id'      => $_REQUEST['id'],
	        'fabricantes_id' => $_REQUEST['fabricante_id'],
	        'nome' => $_REQUEST['nome'],
	        'qtdadeestoque' => $_REQUEST['qtdadeestoque'],
	        'valorunit' => $_REQUEST['valorunit'],
	        'status' => (int) $_REQUEST['status'],
	        'updated' => date('Y-m-d H:i:s')
		);

		// Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
			$grava = DBUpDate('produtos', $dados, "id = {$dados['id']}");

			if ($grava) {
				echo "<script>location.href='index.php';</script>";
			} else {
				echo "<script>alert('Erro ao editar, tente novamente!');</script>";
			}
	}else{

		@$id = (int) DBEscape($_GET['id']);

		// Faz a busca no Banco de Dados
		$infor = DBRead('produtos', "WHERE id = $id", 'id, fabricantes_id, nome, qtdadeestoque, valorunit, status, updated');
	}
?>

<h1 class="page-header">Editar - Produto</h1>

<a href="javascript:history.back()">
	<button type="button" class="btn btn-info">Voltar</button>
</a>
<hr>

<form name="alterar_produtos" action="" method="post" id="alterar_produtos" data-toggle="validator">

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
				/>
				Status
			</label>
    	</div>
  </div>

  <div class="form-group">
    <label for="fabricante_id">Fabricante</label>
    <?php $fabricantes = DBRead('fabricantes', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
    <select  name="fabricante_id" class="form-control form-control-lg" id="fabricante_id" required>
      <option disabled  value="-1">Selecione...</option >

      <?php foreach($fabricantes as $valor){?>
        <option value="<?php echo $valor['id']; ?>" <?php
        	if ($valor['id'] == @$infor['0']['fabricantes_id']){
        		echo('selected');
        	}else{
        		echo('');
        	} ?>
        ><?php echo $valor['nome']; ?></option>
      <?php } ?>

    </select>
  </div>

  <div class="form-group">
    <label for="nome">Nome Completo</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome" name="nome" required
     value="<?php echo @$infor['0']['nome']; ?>" >
  </div>

  <div class="form-group">
    <label for="qtdadeestoque">Quantidade de Estoque</label>
    <input type="number" class="form-control" placeholder="Quantidade de Estoque" id="qtdadeestoque" name="qtdadeestoque"
     value="<?php echo @$infor['0']['qtdadeestoque']; ?>" >
  </div>

  <div class="form-group">
    <label for="valorunit">Valor Unitário</label>
    <input type="text" class="form-control" placeholder="Valor Unitário" id="valorunit" name="valorunit" required
     value="<?php echo @$infor['0']['valorunit']; ?>" >
  </div>

  <input type="hidden" name="id" value="<?php echo @$infor['0']['id']; ?>"/>
  <input type="hidden" name="alterar" value="alterar"/>
  <input type="submit" class="btn btn-primary" value="alterar"/>
</form>

<script type="text/javascript">

	$(document).ready(function(){
	//Validação em Jquery
	  $("#alterar_produtos").validate({
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
