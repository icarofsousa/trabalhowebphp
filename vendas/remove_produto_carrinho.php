<?php
  session_start();

	$id = (isset($_GET['id']) ? $_GET['id']  :  "");

	unset($_SESSION['carrinho'][$id]);

	header("location:add.php");

?>
