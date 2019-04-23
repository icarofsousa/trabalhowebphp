<?php
include_once("../elements/topo.php");

$vendas_id = $_POST['vendas_id'];
$escolha = $_POST['escolha'];

if ($escolha == 'atualizar_venda'){

  echo "ID VENDA".$vendas_id;
  $venda_escolhida = DBRead('vendas', "WHERE status = 1 AND ID = ".$vendas_id."", '*');

  $_SESSION['contasareceber'] = array(
    'id' => $venda_escolhida['0']['id'],
    'desconto' => $venda_escolhida['0']['desconto'],
    'valorapagar' => $venda_escolhida['0']['valortotal'],
    'valortotal' => $venda_escolhida['0']['valorapagar'],
    'datavenda' => $venda_escolhida['0']['datavenda']
  );
  header("location:add.php");

}

include_once("../elements/rodape.php");
?>
