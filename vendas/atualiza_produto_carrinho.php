<?php
  session_start();

  //Recebe o ID passado pela form
  $id = $_POST['id'];

    //Vai contar quantos itens existem no carrinho
  	for ($a = 0; $a < count($_POST['ide_item']); $a++){

  		$ide_item = $_POST['ide_item'][$a]; //ID DO ITEM/PRODUTO
  		$qtd_item = $_POST['qtd_item'][$a]; //QUANTIDADE DO ITEM/PRODUTO INSERIDA NO CARRINHO
  		$est_item = $_POST['est_item'][$a]; //ESTOQUE DO ITEM/PRODUTO

      //Verifica se o estoque é válido
  		if ($est_item > '0'){
  			if ($est_item >= $qtd_item){
          //Se o carrinho_edit existir, ele irá alterar as informações da sessão de editar vendas, senão, vai ser para o carrinho normal.
          if (isset($_POST['carrinho_edit']) && $_POST['carrinho_edit'] == 'carrinho_edit'){
            $_SESSION['carrinho_edit'][$ide_item]['quantidade'] = $qtd_item;
          }else{
            $_SESSION['carrinho'][$ide_item]['quantidade'] = $qtd_item;
          }
  			}
  		}else{
        if (isset($_POST['carrinho_edit']) && $_POST['carrinho_edit'] == 'carrinho_edit'){
          $_SESSION['carrinho_edit'][$ide_item]['quantidade'] = $est_item;
        }else{
          $_SESSION['carrinho'][$ide_item]['quantidade'] = $est_item;
        }

  		}

      //Recebe valor unitario do item;
  		$val_item = $_POST['val_item'][$a];

      //Atualiza valor total do item (quantidade * valor unitario)
      if (isset($_POST['carrinho_edit']) && $_POST['carrinho_edit'] == 'carrinho_edit'){
          $_SESSION['carrinho_edit'][$ide_item]['valorunit'] = $val_item;
          $_SESSION['carrinho_edit'][$ide_item]['valortotal'] =  $_SESSION['carrinho_edit'][$ide_item]['quantidade'] * $val_item;
      }else{
          $_SESSION['carrinho'][$ide_item]['valorunit'] = $val_item;
      		$_SESSION['carrinho'][$ide_item]['valortotal'] =  $_SESSION['carrinho'][$ide_item]['quantidade'] * $val_item;
        }

  	}

    //Caso a sessão carrinho_edit exista, irá voltar para edit.php, senão, irá voltar para o carrinho.
    if (isset($_POST['carrinho_edit']) && $_POST['carrinho_edit'] == 'carrinho_edit'){
      header("location:edit.php?id=".$id."");
    }else{
      header("location:carrinho.php");
    }

?>
