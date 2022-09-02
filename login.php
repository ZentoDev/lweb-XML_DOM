<?php
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);

require_once("lib_xmlaccess.php");

$datimancanti=0;   //$datimancanti=1 Non sono stati inseriti tutti i dati necessari all'autentificazione dell'utente
$accessonegato=0;  //$accessonegato=1 I dati inseriti non sono validi per l'autentificazione dell'utente

//nel caso in cui si provenga dalla form
if(isset($_POST['invio'])){
	//nel caso siano stati inseriti sia la password che lo username
    if ($_POST['username'] && $_POST['password']) {
		
		$doc = openXML("users.xml");
		$root = $doc->documentElement;
		
		$users_list = $root->childNodes;

		for ($i=0; $i<$users_list->length; $i++){
			$user = $users_list->item($i);
			
			$username_value = $user->getAttribute('username');
			
			$password_value = $user->getAttribute('password');
			

			if(($_POST['username']==$username_value) && ($_POST['password']==$password_value)){
				$permesso = $user->getAttribute('permesso');
				session_start();
				$_SESSION['username'] = $username_value;
				$_SESSION['accesso_permesso'] = $permesso;
				
				//indirizzo il client verso la pagina iniziale del sito
                header('Location: prenotazione.php');    
                exit();
			}else {$accessonegato=1;}
		}
	}else {$datimancanti=1;}
}

printf('<?xml version="1.0" encoding="UTF-8"?>');
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Login</title>
	<link rel="shortcut icon" href="immagini/NASA_logo.svg.png"/>
	<link rel="stylesheet" href="css_xhtml1.css" type="text/css" />
	
</head>

<body>
    <div id="top">
        <a href="index.php" title="home page" style="float: left">
	        <img style="float: right;" src="immagini/R.b3423f74c717d44ce8e80d07dc75822a.png" alt="HOME" width="60"/>
	    </a>
        <img src="immagini/NASA_logo.svg.png" width="120" alt="Logo" class="dx"/>    
        <h1 id="titolo">LOGIN</h1>   
    </div>

    <div id="content">
		<div class="log">
			<h1>Accedi al tuo account</h1>
			<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
			<p>Username: <input type="text" name="username" value="admin" size="40" /></p>
			<p>Password: <input type="password" name="password" value="admin" size="40" /></p>
			<p>
				<input type="reset" name="reset" value="Reset">
				<input type="submit" name="invio" value="Login">
			</p>
		    </form>
        </div>
	</div>
	
	<?php 
    if($datimancanti==1) echo "<p>MANCANO I DATI!!!</p> ";
    if($accessonegato==1) echo "<p>ACCESSO NEGATO. Non &egrave; possibile accedere con i dati inseriti!</p>";
    ?>

</body>
</html>
