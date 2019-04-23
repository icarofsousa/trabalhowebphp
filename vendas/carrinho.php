<?php include_once("../elements/topo.php");?>

<div class="row">
  <h1 class="page-header">Carrinho</h1>
  <button type="button" class="btn btn-info" onclick="location.href='add.php' ">Inserir Novo Produto</button>
  <hr>
</div>

<?php
//Recebe os parametros para adicionar produtos ao carrinho
if (isset($_POST['cadastro_itens_venda']) && $_POST['cadastro_itens_venda'] == 'cadastro_itens_venda') {

  $valor_unitario = $_SESSION['lista_produtos'][$_REQUEST['produtos_id']]['valorunit'];
  $estoque = $_SESSION['lista_produtos'][$_REQUEST['produtos_id']]['estoque'];
  $valor_total = $_REQUEST['quantidade'] * $valor_unitario;

  $_SESSION['carrinho'][$_REQUEST['produtos_id']] = array(
    'id_produto'=>$_REQUEST['produtos_id'],
    'nome_produto'=>$_SESSION['lista_produtos'][$_REQUEST['produtos_id']]['nome'],
    'quantidade'=>$_REQUEST['quantidade'],
    'estoque'=>$estoque,
    'valorunit'=>$_SESSION['lista_produtos'][$_REQUEST['produtos_id']]['valorunit'],
    'valortotal'=>$valor_total
  );
}

if (isset($_POST['cadastro_venda']) && $_POST['cadastro_venda'] == 'cadastro_venda') {

  $dados_venda = array(
      'clientes_id' => $_REQUEST['clientes_id'],
      'funcionarios_id' => $_REQUEST['funcionarios_id'],
      'tipodepagamento' => $_REQUEST['tipodepagamento'],
      'datavenda' => $_REQUEST['datavenda'],
      'valortotal' => $_SESSION['venda']['valor_total'],
      'desconto' => isset ($_SESSION['venda']['desconto']) ? $_SESSION['venda']['desconto'] : '',
      'valorapagar' => isset($_SESSION['venda']['valor_a_pagar']) ? $_SESSION['venda']['valor_a_pagar'] : $_SESSION['venda']['valor_total'],
      'status' => 1,
      'created' => date('Y-m-d H:i:s'),
      'updated' => date('Y-m-d H:i:s')

  );

  //Este "true" no final, é o método que retorna o id que acabamos de cadastrar no banco!
  $grava_venda = DBCreate('vendas', $dados_venda, true);

  if ($grava_venda){

    foreach($_SESSION['carrinho'] as $key => $row){
      $dados_itens_venda = array(
        'produtos_id' => $_SESSION['carrinho'][$key]['id_produto'],
        //O id da ultima venda, fica gravado na variavel $grava_venda
        'vendas_id' => $grava_venda,
        'quantidade' => $_SESSION['carrinho'][$key]['quantidade'],
        'valortotal' => $_SESSION['carrinho'][$key]['valortotal']
      );

      $grava_itens_venda = DBCreate('vendasitens', $dados_itens_venda, true);

      if ($grava_itens_venda){
        $estoque_restante = $_SESSION['carrinho'][$key]['estoque'] - $_SESSION['carrinho'][$key]['quantidade'];
        $dados_produto = array(
          'id' => $_SESSION['carrinho'][$key]['id_produto'],
          'qtdadeestoque' => $estoque_restante
        );

        $atualiza_estoque = DBUpDate('produtos', $dados_produto, "id = {$dados_produto['id']}");
  			if ($atualiza_estoque) {
          //Não adicionei nada, pois não precisa!
  			} else {
  				echo "<script>alert('Erro ao editar, tente novamente!');</script>";
  			}

      }

    }

    //Depois de cadastrar tudo no banco, ele limpa as variaveis utilizadas!
    unset($_SESSION['carrinho']);
    unset($_SESSION['venda']);
    unset($_SESSION['lista_produtos']);
    echo "<script>location.href='../vendas/index.php';</script>";

  }

}

//Cria o carrinho se existir produtos nele.
if(isset($_SESSION['carrinho']) and count($_SESSION['carrinho']) > 0){

  echo '<div class="row"">';
    echo '<div>';
      echo'<form method="post" autocomplete="off" class="venda" action="atualiza_produto_carrinho.php">';
        echo '<div class="table-responsive">';
          echo'<table class="table table-striped table-bordered">';
            echo'<thead>';
              echo'<tr>';
                echo'<th>QUANTIDADE</th>';
                echo'<th>PRODUTO</th>';
                echo'<th>VALOR UNITÁRIO</th>';
                echo'<th>VALOR TOTAL</th>';
                echo'<th>OPÇÃO</th>';
              echo'</tr>';
            echo'</thead>';
              echo'<tbody>';

                //Percorre a sessão com os produtos cadastrados, para criar as linhas da tabela.
                //name="variavel[]" é um método que se cria um array de valores e depois pode-se passá-los por POST ou GET
                foreach($_SESSION['carrinho'] as $key => $row){
                  echo '<tr>';
                    echo '
                    <td>
                      <input class="text-center" type="number" name="qtd_item[]"
                      value="'.$_SESSION['carrinho'][$key]['quantidade'].'" onkeyup=maskIt(this,event,"#####",true) min="1" required />
                    </td>';
                    echo '<td>'.$_SESSION['carrinho'][$key]['nome_produto'].'</td>';
                    echo '
                    <td>R$
                    <input type="text" name="val_item[]" value="'.$_SESSION['carrinho'][$key]['valorunit'].'"></td>';
                    echo '<td>'.$_SESSION['carrinho'][$key]['valortotal'].'</td>';

                    echo '<input type="hidden" name="ide_item[]" value="'.$_SESSION['carrinho'][$key]['id_produto'].'">';
                    echo '<input type="hidden" name="est_item[]" value="'.$_SESSION['carrinho'][$key]['estoque'].'">';
                    echo'<td>
                        <a href="remove_produto_carrinho.php?id='.$_SESSION['carrinho'][$key]['id_produto'].'" class="btn btn-danger btn-xs"">
                        remover
                        </a></td>';
                  echo '<tr>';
                }

              echo'</tbody>';
            echo'</table>';
          echo '</div>';
        echo '<div class="row">';
          echo '<div class="form-group col-md-12">';
            echo '<button type="submit" class="btn btn-primary" name="atualizar">Atualizar - carrinho</button>';
          echo '</div>';
        echo '</div>';
      echo'</form>';
    echo '</div>';
  echo "</div>";

} else{
  echo "<h4 style='text-align: center;'>Carrinho Vazio!</h4>";
} ?>

<!-- INCLUI O CODIGO DA PARTE FINAL DE VENDA -->
<?php include_once ('finalizar_venda.php'); ?>

<?php include_once("../elements/rodape.php");?>
