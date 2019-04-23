<?php include_once("../elements/topo.php");?>

<?php

	if (isset($_POST['alterar']) && $_POST['alterar'] == 'alterar') {

		$dados = array(
		    'id'      => $_REQUEST['id'],
	        'nome' => $_REQUEST['nome'],
	        'site' => $_REQUEST['site'],
	        'status' => (int) $_REQUEST['status'],
	        'updated' => date('Y-m-d H:i:s')
		);

		// Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
			$grava = DBUpDate('fabricantes', $dados, "id = {$dados['id']}");

			if ($grava) {
				echo "<script>location.href='index.php';</script>";
			} else {
				echo "<script>alert('Erro ao editar, tente novamente!');</script>";
			}

	}else{

		@$id = (int) DBEscape($_GET['id']);

		// Faz a busca no Banco de Dados
		$infor = DBRead('fabricantes', "WHERE id = $id", 'id, nome, site, status, created, updated');

	}
?>

<h1 class="page-header">Editar - Fabricantes</h1>

<a href="javascript:history.back()">
	<button type="button" class="btn btn-info">Voltar</button>
</a>
<hr>

<form name="alterar_fabricante" action="edit.php" method="post" id="alterar_fabricante" data-toggle="validator">

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
    <label for="nome">Nome Completo</label>
    <input type="text" class="form-control" placeholder="Nome Completo" id="nome" name="nome" required
    value="<?php echo @$infor['0']['nome']; ?>" >
  </div>

  <div class="form-group">
    <label for="site">Site</label>
    <input type="text" class="form-control" placeholder="Site" id="site" name="site"
    value="<?php echo @$infor['0']['site']; ?>">
  </div>

  <input type="hidden" name="id" value="<?php echo @$infor['0']['id']; ?>"/>
  <input type="hidden" name="alterar" value="alterar"/>
  <input type="submit" class="btn btn-primary" value="alterar"/>

</form>

<script type="text/javascript">

	$(document).ready(function(){
	//Validação em Jquery
	  $("#alterar_fabricante").validate({
	      messages:{
	          nome:{
	            required: "Informe o Nome!",
	          }
	      }
	    });
	});

</script>

<?php include_once("../elements/rodape.php");?>
