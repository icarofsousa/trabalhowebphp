<?php

if(isset($_POST['login']) && $_POST['login'] == 'acessar'){
	include_once "elements/conexao.php";
	include_once "elements/funcoes.php";
	
	$email = DBEscape($_POST['email']);
	$senha   = DBEscape($_POST['senha']);
	
	//debug($senha);
	
	$sql = "				
		WHERE
		  (email = '".$email."') AND 
		  (senha = '".$senha."') AND
		  (status = 1)
		LIMIT 1				
	";
	$resultado = DBRead('pessoas', "{$sql}", 'id, nome, email, senha, status');
	
    if ($resultado == false) { 	
	echo"
		<script>					
			alert(\"Login Invalido!\");
			window.location=\"index.php\";				
		</script>
	";
	exit;
	
    } else {		
		
         if (!isset($_SESSION)) {
			session_start();
			$_SESSION['UsuarioID'] = $resultado[0]['id'];
			$_SESSION['UsuarioNome'] = $resultado[0]['nome'];
			
			
			// debug($_SESSION);
		}		
			
		header("Location: pages/home.php"); 
		exit;
    }
}else{ 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Painel Administrativo do Segundao2017</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
    <link href="css/style.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	
		<form name="login" method="post" action="index.php" class="login">
		
			<h4 class="tituloLogin">Acesse o Painel Administrativo</h4>
			
		  <div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			
			<input type="email" name="email" class="form-control" autofocus id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
			
			<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			
			<input type="password" name="senha" class="form-control" id="exampleInputPassword1" placeholder="Password">
		  
		  </div>
		  
		  <input type="hidden" name="login" value="acessar" />
		  
		  <button type="submit" class="btn btn-primary" onclick="return validar()">ENTRAR</button>
		  	  <!-- <a href="pages/home.php">ENTRAR</a> -->
		</form>
		
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="js/jquery.min.js"></script>
	
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
		
<?php 
}
?>