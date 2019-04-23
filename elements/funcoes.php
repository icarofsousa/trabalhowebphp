<?php
// Função para debug
function debug($valor = null){
	echo "<pre>";
		die(var_dump($valor));
	echo "</pre>";
}

// Deleta Registros
function DBDelete($table, $where = null){

    $where = ($where) ? " WHERE {$where}" : null;
    $query = "DELETE FROM {$table}{$where}";

    // Chama a função DBExecute e exclui as informações no BD
    return DBExecute($query);
}

// Atualizar os Registros
function DBUpDate($table, array $data, $where = null, $insertId = false)
{

    // Percorro o vetor data com os campos a serem alterados
    foreach ($data as $key => $value) {
        $fields[] = "{$key} = '{$value}'";
    }
    $fields = implode(', ', $fields);
    $where = ($where) ? " WHERE {$where}" : null;

    // Monta a Query que faz o Upadate no Banco de dados
    $query = "UPDATE {$table} SET {$fields}{$where}";

	//debug($query);

    // Chama a função DBExecute e persiste as informações no BD
    return DBExecute($query, $insertId);
}

// Ler Registros
function DBRead($table, $params = null, $fields = "*")
{
    $params = ($params) ? " {$params}" : null;

    // Monta a Query de leitura
    $query = "SELECT {$fields} FROM {$table}{$params}";

	//debug($query);

    // Chama a função DBExecute e busca as informações no BD
    $result = DBExecute($query);


	// Verificar se existe algum registro a ser mostrado
    if (!mysqli_num_rows($result)) {
        return false;
    } else {
        // Percorre o objeto $result e transforma em array
        while ($res = mysqli_fetch_assoc($result)) {
            $data[] = $res;
        };
        return $data;
    }
}



function DBRead_ID($table, $params = null, $fields = "*")
{

	$params = ($params) ? " {$params}" : null;

	// Monta a Query de leitura
	$query = "SELECT {$fields} FROM {$table}{$params}";

//debug($query);

	// Chama a função DBExecute e busca as informações no BD
	$result = DBExecute($query, true);


// Verificar se existe algum registro a ser mostrado
	if (!mysqli_num_rows($result)) {
			return false;
	} else {
			// Percorre o objeto $result e transforma em array
			while ($res = mysqli_fetch_assoc($result)) {
					$data[] = $res;
			};
			return $data;
	}


}

// Grava registros
function DBCreate($table, array $data, $insertId = false)
{
    $table = DBEscape($table);
    $data = DBEscape($data);

    // Separa o vetor
    $fields = implode(', ', array_keys($data));
    $values = "'" . implode("', '", $data) . "'";

    // Monta a Query de Inserção
    $query = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";

	//debug($query);

    // Chama a função DBExecute e persiste as informações no BD
    return DBExecute($query, $insertId);
}



// Execulta Querys
function DBExecute($query, $insertId = false)
{
    $link = DBConnect();
    $result = @mysqli_query($link, $query) or die(mysqli_error($link));

    // Retorna o último ID em caso de novo registro ou alterar
    if($insertId){
        $result = mysqli_insert_id($link);
    }

    DBClose($link);
    return $result;
}

?>
