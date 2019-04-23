<?php include_once("../elements/topo.php");?>

<h1 class="page-header">Lista de Vendas</h1>

<a href="add.php">
	<button type="button" class="btn btn-info">Novo</button>
</a>

<?php
	// Faz a busca no Banco de Dados
	$vendas = DBRead('vendas', "ORDER BY id DESC", 'id, clientes_id, funcionarios_id, datavenda, valortotal, desconto, valorapagar, status, created, updated');

	//Limpa as variáveis do carrinho_edit, para não haver quaisquer conflitos
	unset($_SESSION['carrinho_edit']);
	unset($_SESSION['venda_edit']);
	unset($_SESSION['lista_produtos_edit']);
?>

<hr>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>DATA VENDA</th>
				<th>VALOR TOTAL</th>
				<th>STATUS</th>
				<th>DATA CRIAÇÃO</th>
				<th>DATA ATUALIZAÇÃO</th>
				<th colspan="3" class="centraliza">AÇÕES</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($vendas as $vendas) { ?>
          <tr>
						<td><?php echo $vendas['id']; ?></td>
						<td><?php echo $vendas['datavenda']; ?></td>
						<td><?php echo $vendas['valorapagar']; ?></td>
						<td><?php echo $vendas['status'] == 1 ? "<span class='statusAtivo'>Ativo</style>" : "<span class='statusInativo'>Inativo</style>"; ?></td>
						<td><?php echo date('d/m/Y - H:i:s', strtotime($vendas['created'])); ?></td>
						<td><?php echo date('d/m/Y - H:i:s', strtotime($vendas['updated'])); ?></td>
						<td><a href="view.php?id=<?php echo $vendas['id'];?>"><button type="button" class="btn btn-success cortextobtn">VISUALIZAR</button></a></td>
						<td><a href="edit.php?id=<?php echo $vendas['id'];?>"><button type="button" class="btn btn-primary cortextobtn">EDITAR</button></a></td>
						<td>
							<a href="index.php?action=delete&id=<?php echo $vendas['id']; ?>">
								<button type="button" class="btn btn-danger cortextobtn"
								onClick="return confirm('Deseja realmente excluir?')">DELETAR
								</button>
						</td>
					</tr>
			<?php } ?>
				</tbody>
			</table>
		</div>

<?php
$id     = (isset($_REQUEST['id'])) ? DBEscape($_REQUEST['id']) : null;
$action = (isset($_REQUEST['action'])) ? DBEscape($_REQUEST['action']) : null;

if($id && $action){

	$LISTA_CONTASARECEBER = DBRead('contasareceber', "ORDER BY ID", 'vendas_id');

	foreach($LISTA_CONTASARECEBER as $key => $row){
		if ($LISTA_CONTASARECEBER[$key]['vendas_id'] == $id){
			echo "<script>alert('Não é possível deletar pois esta venda está sendo utilizada no setor de contas a receber!');</script>";
			die();
		}
	}

	//Recebe Informações do Banco
	$info_venda = DBRead('vendas', "WHERE id = $id", 'id, clientes_id, funcionarios_id, tipodepagamento, datavenda, valortotal, desconto, valorapagar, status, updated');
	$info_vendas_itens = DBRead('vendasitens', "WHERE vendas_id = ".@$info_venda['0']['id']."", 'id, produtos_id, vendas_id, quantidade, valortotal');

	//Percorre itens vendas cadastrados no banco
	foreach($info_vendas_itens as $key => $row){
		$produtos = DBRead('produtos', "WHERE id = ".@$info_vendas_itens[$key]['produtos_id']."", 'id, qtdadeestoque');
		$estoque_atualizado = array(
		 'id' => $produtos[$key]['id'],
		 'qtdadeestoque' => $produtos[$key]['qtdadeestoque'] + $info_vendas_itens[$key]['quantidade']
		);
    //Atualiza os estoques dos produtos
		$atualiza_produtos = DBUpDate('produtos', $estoque_atualizado, "id = {$estoque_atualizado['id']}");

		//Caso a atualização funcione, ele deleta o itens venda
		if ($atualiza_produtos){
		 $dropVendasItens = DBDelete('vendasitens', "id = ".$info_vendas_itens[$key]['id']."");
		} else {
		   echo "<script>alert('Erro ao deletar o registro, tente novamente!');</script>";
		}
	}

	//Deleta a venda depois de deletar todos os itens venda
	$dropVenda =  DBDelete('vendas', "id = ".$info_venda['0']['id']."");
	if ($dropVenda) {
	    //echo "<script>alert('Registro deletado com sucesso!');</script>";
	    echo "<script>location.href='index.php';</script>";
	} else {
	    echo "<script>alert('Erro ao deletar o registro, tente novamente!');</script>";
	}
}
?>
<?php include_once("../elements/rodape.php");?>
