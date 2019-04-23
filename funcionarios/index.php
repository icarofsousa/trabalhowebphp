<?php include_once("../elements/topo.php");
?>

<h1 class="page-header">Lista de Funcionarios</h1>

<a href="add.php">
	<button type="button" class="btn btn-info">Novo</button>
</a>

<?php
	// Faz a busca no Banco de Dados
	$funcionarios = DBRead('funcionarios', "ORDER BY id DESC", 'id, pessoas_id, datadeadmissao, comissao, tipofuncionario, status, created, updated');
?>

<hr>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>NOME</th>
				<th>STATUS</th>
				<th>DATA CRIAÇÃO</th>
				<th>DATA ATUALIZAÇÃO</th>
				<th colspan="3" class="centraliza">AÇÕES</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($funcionarios as $funcionarios) {
				$pessoa_id = $funcionarios['pessoas_id'];
				$nome_cliente = DBRead('pessoas', "WHERE id = $pessoa_id", 'nome');

				foreach ($nome_cliente as $nome_cliente) { ?>
          <tr>
						<td><?php echo $funcionarios['id']; ?></td>
						<td><?php echo $nome_cliente['nome']; ?></td>
						<td><?php echo $funcionarios['status'] == 1 ? "<span class='statusAtivo'>Ativo</style>" : "<span class='statusInativo'>Inativo</style>"; ?></td>
						<td><?php echo date('d/m/Y - H:i:s', strtotime($funcionarios['created'])); ?></td>
						<td><?php echo date('d/m/Y - H:i:s', strtotime($funcionarios['updated'])); ?></td>
						<td><a href="view.php?id=<?php echo $funcionarios['id'];?>"><button type="button" class="btn btn-success cortextobtn">VISUALIZAR</button></a></td>
						<td><a href="edit.php?id=<?php echo $funcionarios['id'];?>"><button type="button" class="btn btn-primary cortextobtn">EDITAR</button></a></td>
						<td>
							<a href="index.php?action=delete&id=<?php echo $funcionarios['id']; ?>">
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

		$id_pessoa = DBRead('funcionarios', "WHERE id = $id", 'pessoas_id');

		//Deleta Funcionario
		$dropRegistro = DBDelete('funcionarios', "id = $id");
		if ($dropRegistro) {
        //echo "<script>alert('Registro deletado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao deletar o registro, tente novamente!');</script>";
    }
		//Deleta Pessoa
		$dropRegistro = DBDelete('pessoas', "id = ".$id_pessoa['0']['pessoas_id']."");
    if ($dropRegistro) {
        //echo "<script>alert('Registro deletado com sucesso!');</script>";
        echo "<script>location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao deletar o registro, tente novamente!');</script>";
    }
}
?>
<?php include_once("../elements/rodape.php");?>
