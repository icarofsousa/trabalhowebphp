<?php include_once("../elements/topo.php");?>

<h1 class="page-header">Lista de Produtos</h1>

<a href="add.php">
	<button type="button" class="btn btn-info">Novo</button>
</a>

<?php
	// Faz a busca no Banco de Dados
	$produtos = DBRead('produtos', "ORDER BY id DESC", 'id, fabricantes_id, nome, qtdadeestoque, valorunit, status, created, updated');
?>

<hr>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>NOME</th>
				<th>ESTOQUE</th>
				<th>VALOR UNITÁRIO</th>
				<th>STATUS</th>
				<th>DATA CRIAÇÃO</th>
				<th>DATA ATUALIZAÇÃO</th>
				<th colspan="3" class="centraliza">AÇÕES</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($produtos as $produtos) { ?>
          <tr>
						<td><?php echo $produtos['id']; ?></td>
						<td><?php echo $produtos['nome']; ?></td>
						<td><?php echo $produtos['qtdadeestoque']; ?></td>
						<td><?php echo $produtos['valorunit']; ?></td>
						<td><?php echo $produtos['status'] == 1 ? "<span class='statusAtivo'>Ativo</style>" : "<span class='statusInativo'>Inativo</style>"; ?></td>
						<td><?php echo date('d/m/Y - H:i:s', strtotime($produtos['created'])); ?></td>
						<td><?php echo date('d/m/Y - H:i:s', strtotime($produtos['updated'])); ?></td>
						<td><a href="view.php?id=<?php echo $produtos['id'];?>"><button type="button" class="btn btn-success cortextobtn">VISUALIZAR</button></a></td>
						<td><a href="edit.php?id=<?php echo $produtos['id'];?>"><button type="button" class="btn btn-primary cortextobtn">EDITAR</button></a></td>
						<td>
								<a href="index.php?action=delete&id=<?php echo $produtos['id']; ?>">
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

    $dropRegistro = DBDelete('produtos', "id = $id");

    if ($dropRegistro) {
        //echo "<script>alert('Registro deletado com sucesso!');</script>";
        echo "<script>location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao deletar o registro, tente novamente!');</script>";
    }
}
?>
<?php include_once("../elements/rodape.php");?>
