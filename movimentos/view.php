<?php
	include_once("../elements/topo.php");

	@$id = (int) DBEscape($_GET['id']);

	// Faz a busca no Banco de Dados
		$infor = DBRead('movimentos', "WHERE id = $id", 'id, caixas_id, contasareceber_id, valor, tipo, historico, status, created, updated');

?>
	<h1 class="page-header">Visualizar - Movimentos</h1>

	<a href="javascript:history.back()">
		<button type="button" class="btn btn-info">Voltar</button>
	</a>

	<hr>

	<form name="visualizar_movimentos" action="" method="post" id="visualizar_movimentos" data-toggle="validator">

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
 				disabled/>
 				Status
 			</label>
 			</div>
 		</div>


 		<div class="form-group">
 			<label for="caixas_id">Caixas</label>
 			<?php $caixas = DBRead('caixas', "WHERE status = 1 ORDER by id", 'id, nome'); ?>
 			<select name="caixas_id" class="form-control form-control-lg" id="caixas_id" required disabled>
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
 			<select name="contasareceber_id" class="form-control form-control-lg" id="contasareceber_id" required disabled>
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
 			value="<?php echo @$infor['0']['valor'] ?>" disabled>
 		</div>

 		<div class="form-group">
 			<label for="tipo">Tipo</label>
 			<input type="text" class="form-control" placeholder="Tipo" id="tipo" name="tipo" maxlength="1"
 			value="<?php echo @$infor['0']['tipo'] ?>" disabled>
 		</div>

 		<div class="form-group">
 			<label for="historico">Histórico</label>
 			<textarea class="form-control" rows="5" id="historico" name="historico" disabled><?php echo @$infor['0']['historico'] ?></textarea>
 		</div>

 		<input type="hidden" name="id" value="<?php echo @$infor['0']['id']; ?>"/>
	</form>

	<?php include_once("../elements/rodape.php");?>
