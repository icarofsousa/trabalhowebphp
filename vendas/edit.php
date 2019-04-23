<?php include_once("../elements/topo.php");?>

<?php
	if (isset($_POST['alterar']) && $_POST['alterar'] == 'alterar') {

		  $dados_venda = array(
			  'id' => (int) DBEscape($_GET['id']),
		      'clientes_id' => $_REQUEST['clientes_id'],
		      'funcionarios_id' => $_REQUEST['funcionarios_id'],
		      'tipodepagamento' => $_REQUEST['tipodepagamento'],
		      'datavenda' => $_REQUEST['datavenda'],
		      'valortotal' => $_SESSION['venda_edit']['valor_total'],
		      'desconto' => isset ($_SESSION['venda_edit']['desconto']) ? $_SESSION['venda_edit']['desconto'] : $info_venda['0']['desconto'],
		      'valorapagar' => isset($_SESSION['venda_edit']['valor_a_pagar']) ? $_SESSION['venda_edit']['valor_a_pagar'] : $info_venda['0']['valorapagar'],
		      'status' => 1,
		      'updated' => date('Y-m-d H:i:s')

		  );

		  $atualiza_venda = DBUpDate('vendas', $dados_venda, "id = {$dados_venda['id']}");

		  if ($atualiza_venda){

		    foreach($_SESSION['carrinho_edit'] as $key => $row){
		      $dados_itens_venda = array(
				'id' =>  $_SESSION['carrinho_edit'][$key]['id'],
		        'quantidade' => $_SESSION['carrinho_edit'][$key]['quantidade'],
		        'valortotal' => $_SESSION['carrinho_edit'][$key]['valortotal']
		      );

		      $atualiza_itens_venda = DBUpDate('vendasitens', $dados_itens_venda, "id = {$dados_itens_venda['id']}");

		      if ($atualiza_itens_venda){
						if ($_SESSION['carrinho_edit'][$key]['quantidade_old'] < $_SESSION['carrinho_edit'][$key]['quantidade']){
							//Diminuir no estoque
							$quantidade = $_SESSION['carrinho_edit'][$key]['quantidade'] - $_SESSION['carrinho_edit'][$key]['quantidade_old'];
							$estoque_restante = $_SESSION['carrinho_edit'][$key]['estoque'] - $quantidade;
						}else{
							//Acrescentar no estoque
							$quantidade = $_SESSION['carrinho_edit'][$key]['quantidade_old'] - $_SESSION['carrinho_edit'][$key]['quantidade'];
							$estoque_restante = $_SESSION['carrinho_edit'][$key]['estoque'] + $quantidade;
						}

						$dados_produto = array(
							'id' => $_SESSION['carrinho_edit'][$key]['id_produto'],
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
	    }

    	//Depois de alterar tudo no banco, ele limpa as variaveis utilizadas!
	    unset($_SESSION['carrinho_edit']);
	    unset($_SESSION['venda_edit']);
	    unset($_SESSION['lista_produtos_edit']);
	    echo "<script>location.href='../vendas/index.php';</script>";

	}else{

		@$id = (int) DBEscape($_GET['id']);

		// Faz a busca no Banco de Dados
		$info_venda = DBRead('vendas', "WHERE id = $id", 'id, clientes_id, funcionarios_id, tipodepagamento, datavenda, valortotal, desconto, valorapagar, status, updated');

		$info_vendas_itens = DBRead('vendasitens', "WHERE vendas_id = ".@$info_venda['0']['id']."", 'id, produtos_id, vendas_id, quantidade, valortotal');

		//CASO CARRINHO_EDIT NÃO EXISTA = Cliente acabou de clicar em editar vendas e carrinho está para ser criado com dados do banco.
		//CASO CARRINHO_EDIT EXISTA = Carrinho ja foi criado com dados do banco.
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
		}

?>

<div class="row">
  <h1 class="page-header">Editar - Venda</h1>
  <a href="javascript:history.back()">
	<button type="button" class="btn btn-info">Voltar</button>
</a>
  <hr>
</div>


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
            echo'<th>OPÇÃO</th>';
          echo'</tr>';
        echo'</thead>';
        echo'<tbody>';
          foreach($_SESSION['carrinho_edit'] as $key => $row){

            echo '<tr>';
              echo '
              <td>
                <input class="text-center" type="number" name="qtd_item[]"
                value="'.$_SESSION['carrinho_edit'][$key]['quantidade'].'" onkeyup=maskIt(this,event,"#####",true) min="1" required />
              </td>';
							echo '<td>'.$_SESSION['carrinho_edit'][$key]['id_produto'].'</td>';
              echo '<td>'.$_SESSION['carrinho_edit'][$key]['nome_produto'].'</td>';
              echo '
              <td>R$
              <input type="text" name="val_item[]" value="'.$_SESSION['carrinho_edit'][$key]['valorunit'].'"></td>';
              echo '<td>'.$_SESSION['carrinho_edit'][$key]['valortotal'].'</td>';

              echo '<input type="hidden" name="ide_item[]" value="'.$key.'">';
              echo '<input type="hidden" name="est_item[]" value="'.$_SESSION['carrinho_edit'][$key]['estoque'].'">';
              echo'<td>
                  <a href="remove_produto_carrinho_edit.php?id='.$_SESSION['carrinho_edit'][$key]['id_produto'].'" class="btn btn-danger btn-xs"">
                  remover
                  </a></td>';
            echo '<tr>';
          }
        echo'</tbody>';
      echo'</table>';
    echo '</div>';
		echo '<input type="hidden" name="carrinho_edit" value="carrinho_edit"/>';
		echo '<input type="hidden" name="id" value="'.@$id.'"/>';
    echo '<button type="submit" class="btn btn-primary" name="atualizar">Atualizar - carrinho</button>';
  echo'</form>';

echo "</div>";
echo "<br>";

?>



<?php include_once("editar_finalizar_venda.php");?>

<?php include_once("../elements/rodape.php");?>
