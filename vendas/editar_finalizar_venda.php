
<div class="row">
  <div class="panel panel-primary">
    <div class="panel-heading">
        <h4>Finalizar - Venda</h4>
    </div>

    <div class="panel-body">

		<!-- Formulario para atualizar valor carrinho_edit. -->
		<form action="atualiza_venda_carrinho.php" method="post">
			<div class="form-group col-md-4">
			  <label for="vt_venda">Valor Total</label>
			  <input type="text" class="form-control" placeholder="Valor Total" id="vt_venda" name="vt_venda"
			  value="<?php
			    $_SESSION['venda_edit']['valor_total'] = 0;

			    foreach($_SESSION['carrinho_edit'] as $key => $row){
			      $_SESSION['venda_edit']['valor_total'] += $_SESSION['carrinho_edit'][$key]['valortotal'];
			    }

			    echo $_SESSION['venda_edit']['valor_total'];  ?>" required disabled>
			</div>

			<div class="form-group col-md-4">
			  <label for="desconto">Desconto (em %)</label>
			  <input type="text" class="form-control" placeholder="Desconto" id="desconto" name="desconto"
			  value="<?php
				if (!isset($_SESSION['venda_edit']['desconto'])){
					$desconto = isset ($info_venda['0']['desconto']) ? $info_venda['0']['desconto'] : '';
				}else{
					$desconto = isset ($_SESSION['venda_edit']['desconto']) ? $_SESSION['venda_edit']['desconto'] : '';
				}
				echo $desconto; ?>">
			</div>

			<div class="form-group col-md-4">
			  <label for="valorapagar">Valor à Pagar</label>
			  <input type="text" class="form-control" placeholder="Valor à Pagar" id="valorapagar" name="valorapagar"
			  value="<?php

				if (!isset($_SESSION['venda_edit']['valor_a_pagar'])){
					$total_a_pagar = isset($info_venda['0']['valorapagar']) ? $info_venda['0']['valorapagar'] : ''.$_SESSION['venda_edit']['valor_total'].'' ;
				}else{
					$total_a_pagar = $_SESSION['venda_edit']['valor_a_pagar'];
					// print_r($_SESSION['venda_edit']);
				}
			    echo $total_a_pagar; ?>  " disabled>
			</div>

			<div class="form-group col-md-12">
				<input type="hidden" name="carrinho_edit" value="carrinho_edit"/>
				<input type="hidden" name="id" value="<?php echo @$id; ?>"/>
			  <button type="" class="btn btn-info" id="atualizar_valor" name="atualizar_valor" style="float: right;">Atualizar - Valor</button>
			</div>
		</form>


		<!-- venda -->
		<form name="venda_final" method="post" id="venda_final" autocomplete="off" class="venda" action="" data-toggle="validator">
			<?php
			//Lista com todas as pessoas cadastradas
			$pessoas = DBRead('pessoas', "WHERE status = 1 ORDER by id", 'id, nome');
			foreach($pessoas as $valor){
			  $_SESSION['listapessoas'][$valor['id']] = array('id'=>$valor['id'], 'nome'=>$valor['nome']
			  );
			} ?>

			<div class="form-group col-md-6">
			  <label for="clientes_id">Clientes</label>
			  <?php $clientes = DBRead('clientes', "WHERE status = 1 ORDER by id", 'id, pessoas_id, limitedecompra'); ?>
			  <select name="clientes_id" class="form-control form-control-lg" id="clientes_id">
			    <option value="-1">Selecione...</option >
			    <?php foreach($clientes as $valor){ ?>

					<option value="<?php echo $valor['id']; ?>" <?php

					$_SESSION['listadeclientes_edit'][$valor['id']] = array('id'=>$valor['id'], 'pessoas_id'=>$valor['pessoas_id'], 'limitedecompra'=>$valor['limitedecompra']);

					 $nome_cliente = $_SESSION['listapessoas'][$valor['pessoas_id']]['nome'];

	 				 if ($valor['id'] == @$info_venda['0']['clientes_id']){
	 					 echo('selected');
	 				 }else{
	 					 echo('');
	 				 } ?> 
	 				 ><?php echo $nome_cliente; ?></option>
			  	<?php  } ?>
			  </select required>
			</div>

			<div class="form-group col-md-6">
			  <label for="funcionarios_id">Funcionários</label>
			  <?php $funcionarios = DBRead('funcionarios', "WHERE status = 1 ORDER by id", 'id, pessoas_id, tipofuncionario'); ?>
			  <select name="funcionarios_id" class="form-control form-control-lg" id="funcionarios_id">
			    <option value="-1">Selecione...</option>
				<?php foreach($funcionarios as $valor){  ?>
	 			 <option value="<?php echo $valor['id']; ?>" <?php
					 $_SESSION['listadefuncionarios'][$valor['id']] = array('id'=>$valor['id'], 'pessoas_id'=>$valor['pessoas_id'], 'tipofuncionario'=>$valor['tipofuncionario']);
					 $nome_funcionario = $_SESSION['listapessoas'][$valor['pessoas_id']]['nome'];

	 				 if ($valor['id'] == @$info_venda['0']['funcionarios_id']){
	 					 echo('selected');
	 				 }else{
	 					 echo('');
	 				 } ?> 
	 				 ><?php echo $nome_funcionario; ?></option>
	 		 	<?php } ?>
			  </select>
			</div>

			<div class="form-group col-md-4">
			  <label for="tipodepagamento">Tipo de Pagamento</label>
			  <input type="text" class="form-control" placeholder="Tipo de Pagamento" id="tipodepagamento" name="tipodepagamento" maxlength="1"
				value="<?php echo @$info_venda['0']['tipodepagamento']; ?>">
			</div>

			<div class="form-group col-md-3">
			  <label for="datavenda">Data de Venda</label>
			  <input type="date" class="form-control" id="datavenda" name="datavenda" required
				value="<?php echo @$info_venda['0']['datavenda']; ?>">
			</div>

			<div class="form-group col-md-12">
			<input type="hidden" name="alterar" value="alterar"/>
			<button type="submit" class="btn btn-primary" id="alterar_btn" style="float: right;" name="alterar_btn">Alterar</button>
			</div>

		</form>

    </div>
  </div>
</div>

</div>

<script type="text/javascript">

	$(document).ready(function(){
	//Validação em Jquery
	  $("#venda_final").validate({
	      messages:{
					datavenda:{
            required: "Selecione a Data de Venda!",
          },
          clientes_id:{
            required: "Selecione o Cliente",
          }
	      }
	    });
	});

</script>