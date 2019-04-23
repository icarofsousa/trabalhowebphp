<?php include_once("../elements/topo.php");?>

<h1 class="page-header">Lista de Clientes</h1>

<a href="add.php">
	<button type="button" class="btn btn-info">Novo</button>
</a>

<?php
	// Faz a busca no Banco de Dados
	$clientes = DBRead('clientes', "ORDER BY id DESC", 'id, pessoas_id, limitedecompra, status, created, updated');

?>

<hr>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>NOME</th>
				<th>LIMITE DE COMPRA</th>
				<th>STATUS</th>
				<th>DATA CRIAÇÃO</th>
				<th>DATA ATUALIZAÇÃO</th>
				<th colspan="3" class="centraliza">AÇÕES</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($clientes as $clientes) {
				$pessoa_id = $clientes['pessoas_id'];
				$nome_cliente = DBRead('pessoas', "WHERE id = $pessoa_id", 'nome');

				foreach ($nome_cliente as $nome_cliente) {

				?>
          <tr>
						<td><?php echo $clientes['id']; ?></td>
						<td><?php echo $nome_cliente['nome']; ?></td>
						<td><?php echo $clientes['limitedecompra']; ?></td>
						<td><?php echo $clientes['status'] == 1 ? "<span class='statusAtivo'>Ativo</style>" : "<span class='statusInativo'>Inativo</style>"; ?></td>
						<td><?php echo date('d/m/Y - H:i:s', strtotime($clientes['created'])); ?></td>
						<td><?php echo date('d/m/Y - H:i:s', strtotime($clientes['updated'])); ?></td>
						<td><a href="view.php?id=<?php echo $clientes['id'];?>"><button type="button" class="btn btn-success cortextobtn">VISUALIZAR</button></a></td>
						<td><a href="edit.php?id=<?php echo $clientes['id'];?>"><button type="button" class="btn btn-primary cortextobtn">EDITAR</button></a></td>
						<td>
							<a href="index.php?action=delete&id=<?php echo $clientes['id']; ?>">
								<button type="button" class="btn btn-danger cortextobtn"
								onClick="return confirm('Deseja realmente excluir?')">DELETAR
								</button>
						</td>
					</tr>
			<?php } } ?>
				</tbody>
			</table>
		</div>

<?php
$id     = (isset($_REQUEST['id'])) ? DBEscape($_REQUEST['id']) : null;
$action = (isset($_REQUEST['action'])) ? DBEscape($_REQUEST['action']) : null;

if($id && $action){

		$id_pessoa = DBRead('clientes', "WHERE id = $id", 'pessoas_id');
		$dropRegistro = DBDelete('clientes', "id = $id");
		if ($dropRegistro) {
    } else {
        echo "<script>alert('Erro ao deletar o registro, tente novamente!');</script>";
    }

    $dropRegistro = DBDelete('pessoas', "id = ".$id_pessoa['0']['pessoas_id']."");

    if ($dropRegistro) {
			echo "<script>location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao deletar o registro, tente novamente!');</script>";
    }
}
?>
<?php include_once("../elements/rodape.php");?>
