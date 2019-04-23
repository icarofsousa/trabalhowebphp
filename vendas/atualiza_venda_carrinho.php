<?php
  session_start();

  //Recebe o ID passado pela form
  $id = $_POST['id'];

  //Caso a sessão carrinho_edit exista, ele irá calcular para edit.php, senão, ele irá calcular para o carrinho normal.
  if (isset($_POST['carrinho_edit']) && $_POST['carrinho_edit'] == 'carrinho_edit'){

    //Recebe Desconto
    $desconto = $_POST['desconto'];

    if ($desconto < 0 || $desconto > 100){
      // echo "<script>alert('Por favor insira um desconto de 0 a 100');</script>";
    }else {
      $total_venda = $_SESSION['venda_edit']['valor_total'];

      //Faz a conta do total da venda com desconto
      $total_a_pagar = $total_venda - ($total_venda*$desconto/100);
      $_SESSION['venda_edit']['desconto'] = $desconto;
      $_SESSION['venda_edit']['valor_a_pagar'] = $total_a_pagar;

    }
      echo $_SESSION['venda_edit']['desconto'];

      //Retorna
      header("location:edit.php?id=".$id."");

  }else{
    
    //Mesmos passos que a parte acima!
    $desconto = $_POST['desconto'];

    if ($desconto < 0 || $desconto > 100){
      // echo "<script>alert('Por favor insira um desconto de 0 a 100');</script>";
    }else {
      $total_venda = $_SESSION['venda']['valor_total'];
      $total_a_pagar = $total_venda - ($total_venda*$desconto/100);
      $_SESSION['venda']['desconto'] = $desconto;
      $_SESSION['venda']['valor_a_pagar'] = $total_a_pagar;
    }
      echo $_SESSION['venda']['desconto'];

     header("location:carrinho.php");
  }

?>
