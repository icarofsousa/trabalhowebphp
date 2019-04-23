<?php include_once("../elements/topo.php");?>

	<?php

		if (isset($_POST['alterar']) && $_POST['alterar'] == 'alterar') {

			$dados = array(
				'id' => $_REQUEST['id'],
				'caixas_id' => $_REQUEST['caixas_id'],
        'contasareceber_id' => $_REQUEST['contasareceber_id'],
        'valor' => $_REQUEST['valor'],
        'tipo' => $_REQUEST['tipo'],
        'historico' => $_REQUEST['historico'],
        'status' => (int) $_REQUEST['status'],
        'updated' => date('Y-m-d H:i:s')
			);

			// Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
				$grava = DBUpDate('movimentos', $dados, "id = {$dados['id']}");

				if ($grava) {
					echo "<script>location.href='index.php';</script>";
				} else {
					echo "<script>alert('Erro ao editar, tente novamente!');</script>";
				}

		}else{

			@$id = (int) DBEscape($_GET['id']);

			// Faz a busca no Banco de Dados
			$infor = DBRead('movimentos', "WHERE id = $id", 'id, caixas_id, contasareceber_id, valor, tipo, historico, status, updated');

		}
	?>
	<h1 class="page-header">Editar - movimentos</h1>

	<a href="javascript:history.back()">
		<button type="button" class="btn btn-info">Voltar</button>
	</a>

	<hr>

	<form name="alterar_movimentos" action="" method="post" id="alterar_movimentos" data-toggle="validator">

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
		    <label for="caixas_id">Caixas</label>
		    <?php $caixas = DBRead('caixas', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
		    <select name="caixas_id" class="form-control form-control-lg" id="caixas_id" required>
		      <option disabled value="-1">Selecione...</option >

						<?php foreach($caixas as $valor){?>
			        <option value="<?php echo $valor['id']; ?>" <?php
			        	if ($valor['id'] == @$infor['0']['caixas_id']){
			        		echo('selected');
			        	}else{
			        		echo('');
			        	} ?>
			        ><?php echo $valor['nome']; ?></option>
			      <?php } ?>

		    </select>
		  </div>

		  <div class="form-group">
		    <label for="contasareceber_id">Contas a Receber</label>
		    <?php $contasareceber = DBRead('contasareceber', "WHERE status = 1 ORDER by id", '*'); ?>
		    <select name="contasareceber_id" class="form-control form-control-lg" id="contasareceber_id" required>
		      <option disabled value="-1">Selecione...</option >

						<?php foreach($contasareceber as $valor){?>
			        <option value="<?php echo $valor['id']; ?>" <?php
			        	if ($valor['id'] == @$infor['0']['contasareceber_id']){
			        		echo('selected');
			        	}else{
			        		echo('');
			        	} ?>
			        ><?php echo 'Data: '.$valor['data'].' | Parcelas: '.$valor['qtdadedeparcelas'].' | Valor Pago: '.$valor['valorpago']; ?></option>
			      <?php } ?>

		    </select>
		  </div>

		  <div class="form-group">
		    <label for="valor">Valor</label>
		    <input type="text" class="form-control" placeholder="Valor" id="valor" name="valor"
				value="<?php echo @$infor['0']['valor'] ?>">
		  </div>

		  <div class="form-group">
		    <label for="tipo">Tipo</label>
		    <input type="text" class="form-control" placeholder="Tipo" id="tipo" name="tipo" maxlength="1"
				value="<?php echo @$infor['0']['tipo'] ?>">
		  </div>

		  <div class="form-group">
		    <label for="historico">Histórico</label>
		    <textarea class="form-control" rows="5" id="historico" name="historico"><?php echo @$infor['0']['historico'] ?></textarea>
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
						caixas_id:{
	            required: "Selecione o Caixa!",
	          },
	          contasareceber_id:{
	            required: "Selecione a Conta!",
	          }
		      }
		    });

		});

	</script>

	<?php include_once("../elements/rodape.php");?>
