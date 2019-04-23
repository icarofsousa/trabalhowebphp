<?php include_once("../elements/restrito.php");?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">

		<title>Painel Administrativo</title>

		<!-- Bootstrap core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<script type="text/javascript" src="../js/jquery-2.2.4.min.js"></script>
		<link href="../css/style.css" rel="stylesheet">

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../css/dashboard.css" rel="stylesheet">

		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<script src="../js/ie-emulation-modes-warning.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>

		<?php
			include_once "../elements/conexao.php";
			include_once "../elements/funcoes.php";
		?>

		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="../pages/home.php">Painel Administrativo</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<div class="navbar-brand msg-bem-vindo" style="color:#b37171; font-size: 14px;">
					<?php  echo " Olá, <b>" . $_SESSION['UsuarioNome'] . "</b> - Bem vindo ao Sistema! - Acesso em " . date('d/m/Y');?></div>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="../elements/deslogar.php">Deslogar</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 sidebar">

					<ul class="nav nav-sidebar" id="menu-principal">
						<p class="menu-categorias">PESSOAS</p>
						<li class="active"><a href="../funcionarios/index.php"> Funcionario <span class="sr-only">(current)</span></a></li>
						<li class="active"><a href="../clientes/index.php"> Cliente <span class="sr-only">(current)</span></a></li>
						<br><p class="menu-categorias">Mercadoria</p>
						<li class="active"><a href="../fabricantes/index.php"> Fabricantes <span class="sr-only">(current)</span></a></li>
						<li class="active"><a href="../produtos/index.php"> Produtos <span class="sr-only">(current)</span></a></li>
						<br><p class="menu-categorias">Financeiro</p>
						<li class="active"><a href="../vendas/carrinho.php"> Carrinho <span class="sr-only">(current)</span></a></li>
						<li class="active"><a href="../vendas/index.php"> Vendas <span class="sr-only">(current)</span></a></li>
						<li class="active"><a href="../contasareceber/index.php"> Contas a Receber <span class="sr-only">(current)</span></a></li>
						<li class="active"><a href="../movimentos/index.php"> Movimentos <span class="sr-only">(current)</span></a></li>
						<li class="active"><a href="../caixas/index.php"> Caixas  <span class="sr-only">(current)</span></a></li>
					</ul>

				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">