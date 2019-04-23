<?php
	include_once("../elements/topo.php");

	@$id = (int) DBEscape($_GET['id']);


// Faz a busca no Banco de Dados
$info_venda = DBRead('vendas', "WHERE id = $id", 'id, clientes_id, funcionarios_id, tipodepagamento, datavenda, valortotal, desconto, valorapagar, status, updated');

$info_vendas_itens = DBRead('vendasitens', "WHERE vendas_id = ".@$info_venda['0']['id']."", 'id, produtos_id, vendas_id, quantidade, valortotal');

		if (!isset($_SESSION['carrinho_edit'])){
			foreach($info_vendas_itens as $key => $row){
				$info_produtos = DBRead('produtos', "WHERE id = ".@$info_vendas_itens[$key]['produtos_id']."", 'id, nome, valorunit, qtdadeestoque');
				if ($info_produtos){
					foreach($info_produtos as $linha => $row){
						$_SESSION['lista_produtos_edit'][$key] = array(
							'id' => @$info_produtos[$linha]['id'],
							'nome' => @$info_produtos[$linha]['nome'],
							'valorunit' => @$info_produtos[$linha]['valorunit'],
							'qtdadeestoque' => @$info_produtos[$linha]['qtdadeestoque']
						);
					}
				}

				$_SESSION['carrinho_edit'][$key] = array(
					'id' => @$info_vendas_itens[$key]['id'],
					'id_produto' => @$info_vendas_itens[$key]['produtos_id'],
					'nome_produto' => @$_SESSION['lista_produtos_edit'][$key]['nome'],
					'valorunit' => @$_SESSION['lista_produtos_edit'][$key]['valorunit'],
					'estoque' => @$_SESSION['lista_produtos_edit'][$key]['qtdadeestoque'],
					'vendas_id' => @$info_vendas_itens[$key]['vendas_id'],
					'quantidade_old' => @$info_vendas_itens[$key]['quantidade'],
					'quantidade' => @$info_vendas_itens[$key]['quantidade'],
					'valortotal' => @$info_vendas_itens[$key]['valortotal']
				);

			}
		}

?>

<h1 class="page-header">Visualizar - Venda</h1>

<a href="javascript:history.back()">
<button type="button" class="btn btn-info">Voltar</button>
</a>
<hr>

<?php


	echo '<div class="row"">';
	echo'<form method="post" autocomplete="off" class="venda" action="atualiza_produto_carrinho.php">';
	echo '<div class="table-responsive">';
		echo'<table class="table table-striped table-bordered">';
			echo'<thead>';
				echo'<tr>';
					echo'<th>QUANTIDADE</th>';
					echo'<th>ID</th>';
					echo'<th>PRODUTO</th>';
					echo'<th>VALOR UNITÁRIO</th>';
					echo'<th>VALOR TOTAL</th>';
				echo'</tr>';
			echo'</thead>';
			echo'<tbody>';
				foreach($_SESSION['carrinho_edit'] as $key => $row){

					echo '<tr>';
						echo '
						<td>
							<input class="text-center" type="number" name="qtd_item[]"
							value="'.$_SESSION['carrinho_edit'][$key]['quantidade'].'" min="1" required disabled/>
						</td>';
						echo '<td>'.$_SESSION['carrinho_edit'][$key]['id_produto'].'</td>';
						echo '<td>'.$_SESSION['carrinho_edit'][$key]['nome_produto'].'</td>';
						echo '
						<td>R$
						<input type="text" name="val_item[]" value="'.$_SESSION['carrinho_edit'][$key]['valorunit'].'" disabled></td>';
						echo '<td>'.$_SESSION['carrinho_edit'][$key]['valortotal'].'</td>';

						echo '<input type="hidden" name="ide_item[]" value="'.$key.'" disabled>';
						echo '<input type="hidden" name="est_item[]" value="'.$_SESSION['carrinho_edit'][$key]['estoque'].'" disabled>';
					echo '<tr>';
				}
			echo'</tbody>';
		echo'</table>';
	echo '</div>';
	echo '<input type="hidden" name="carrinho_edit" value="carrinho_edit"/>';
	echo '<input type="hidden" name="id" value="'.@$id.'"/>';
	echo'</form>';

	echo "</div>";
	echo "<br>";

	?>

<?php include_once("editar_finalizar_venda.php"); ?>

<script>

	$(document).ready(function(){
		$("#desconto").prop("disabled", true);
		$("#clientes_id").prop("disabled", true);
		$("#funcionarios_id").prop("disabled", true);
		$("#tipodepagamento").prop("disabled", true);
		$("#datavenda").prop("disabled", true);
		$("#alterar_btn").hide();
		$("#atualizar_valor").hide();
	});
	
	

</script>

<?php include_once("../elements/rodape.php");?>
