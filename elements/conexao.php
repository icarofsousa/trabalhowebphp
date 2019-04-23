<?php
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', null);
define('DB_DATABASE', 'trabalho_web');
define('DB_CHARSET', 'utf8');

// Proteção contra SQLInjection
function DBEscape($data)
{
    // Abre a conexão com DB
    $link = DBConnect();

    // Verifica se os dados não são do tip array
    if (!is_array($data)) {
        $data = mysqli_real_escape_string($link, strip_tags(trim($data)));
    } else {
        // Se for array
        $arr = $data;

        // Percorre o array
        foreach ($arr as $key => $value) {
            $key = mysqli_real_escape_string($link, strip_tags(trim($key)));
            $value = mysqli_real_escape_string($link, strip_tags(trim($value)));

            $data[$key] = $value;
        }
    }
    DBClose($link);
    return $data;
}

// Fecha conexão com o bando de dados MySQL
function DBClose($mysqli)
{
    @mysqli_close($mysqli) or die(mysqli_error($mysqli));
}

// Conecta-se ao bando de dados MySQL
function DBConnect()
{
    $mysqli = @mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysqli_connect_error());

    // Seta o Charset para o Banco de Dados
    mysqli_set_charset($mysqli, DB_CHARSET) or die(mysqli_error($mysqli));

    return $mysqli;
}

?>