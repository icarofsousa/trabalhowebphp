<?php include_once("../elements/topo.php");?>

<?php

	if (isset($_POST['alterar']) && $_POST['alterar'] == 'alterar') {

		$dados = array(
		    	'id' => $_REQUEST['id'],
					'qtdadedeparcelas' => $_REQUEST['quantidadedeparcelas'],
					'juros' => $_REQUEST['juros'],
	        'data' => $_REQUEST['data'],
	        'status' => (int) $_REQUEST['status'],
	        'updated' => date('Y-m-d H:i:s')
		);
		//
		// // Grava os dados, 1º Parametro = Nome da tabela, 2º Parametro = os dados
			$grava = DBUpDate('contasareceber', $dados, "id = {$dados['id']}");

			if ($grava) {
				echo "<script>location.href='index.php';</script>";
			} else {
				echo "<script>alert('Erro ao editar, tente novamente!');</script>";
			}

	}else{

		@$id = (int) DBEscape($_GET['id']);

		// Faz a busca no Banco de Dados
		$info_contasareceber = DBRead('contasareceber', "ORDER BY id DESC", '*');

	}
?>

<h1 class="page-header">Editar - Contas a Receber</h1>

<a href="javascript:history.back()">
	<button type="button" class="btn btn-info">Voltar</button>
</a>
<hr>

<form name="alterar_contasareceber" action="edit.php" method="post" id="alterar_contasareceber" data-toggle="validator">

  <div class="form-group">
		<div class="checkbox">
		<label>
			<input name="status" type="checkbox" value="1"
			<?php
				if (isset($info_contasareceber['0']['status']) && $info_contasareceber['0']['status'] == 1) {
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
     <label for="vendas_id">Venda</label>
     <?php $vendas = DBRead('vendas', "WHERE status = 1 ORDER by id", '*'); ?>
     <select name="vendas_id" class="form-control form-control-lg" id="clientes_id"  disabled>
       <option value="-1">Selecione...</option >
       <?php foreach($vendas as $valor){
            $_SESSION['listadevendas'] = array(
              'id' => $valor['id'],
              'valorapagar' => $valor['valorapagar']
            );
         ?>
           <option value="<?php echo $valor['id']; ?>"
             <?php
    	 				 if ($valor['id'] == $info_contasareceber['0']['vendas_id']){
    	 					 echo('selected');
    	 				 }else{
    	 					 echo('');
    	 				 } ?>
             ><?php echo 'ID: '.$valor['id'].' | Data: '.$valor['datavenda'].' | Valor: '.$valor['valorapagar']; ?></option>
     <?php  } ?>
	 </select required>
   </div>

	 <div class="form-group">
	 	<label for="quantidadedeparcelas">Quantidade de Parcelas</label>
	 	<input type="number" class="form-control" placeholder="Quantidade de Parcelas" id="quantidadedeparcelas" name="quantidadedeparcelas" required
		value="<?php echo @$info_contasareceber['0']['qtdadedeparcelas']; ?>" >
	 </div>


	 <div class="form-group">
	 	<label for="desconto">Desconto</label>
	 	<input type="text" class="form-control" placeholder="Desconto" id="desconto" name="desconto"
	 	value="<?php echo @$info_contasareceber['0']['desconto']; ?>" disabled>
	 </div>

	 <div class="form-group">
	 	<label for="juros">Juros</label>
	 	<input type="number" class="form-control" placeholder="Juros" id="juros" name="juros"
		value="<?php echo @$info_contasareceber['0']['juros']; ?>" >
	 </div>

	 <div class="form-group">
	 	<label for="valortotal">Valor Total</label>
	 	<input type="text" class="form-control" placeholder="Valor Total" id="valortotal" name="valortotal" required
	 	value="<?php echo @$info_contasareceber['0']['valortotal']; ?>" disabled>
	 </div>

	 <div class="form-group">
	 	<label for="valorpago">Valor Pago</label>
	 	<input type="text" class="form-control" placeholder="Valor Pago" id="valorpago" name="valorpago"
	 	value="<?php echo @$info_contasareceber['0']['valorpago']; ?>" disabled>
	 </div>

	 <div class="form-group">
	 	<label for="data">Data de Recebimento</label>
	 	<input type="date" class="form-control" id="data" name="data" required
		value="<?php echo @$info_contasareceber['0']['data']; ?>" >
	 </div>

  <input type="hidden" name="id" value="<?php echo @$info_contasareceber['0']['id']; ?>"/>
  <input type="hidden" name="alterar" value="alterar"/>
  <input type="submit" class="btn btn-primary" value="alterar"/>

</form>

<script type="text/javascript">

	$(document).ready(function(){
	//Validação em Jquery
	  $("#alterar_contasareceber").validate({
	      messages:{
					vendas_id:{
						required: "Selecione uma Venda!",
					},
					quantidadedeparcelas:{
						required: "Informe a quantidade de parcelas!",
					},
					valortotal:{
						required: "Informe o valor total!",
					},
					data:{
						required: "Selecione uma data!",
					}
	      }
	    });

	});

</script>

<?php include_once("../elements/rodape.php");?>
