<?php
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);
//accedo al database

require_once("connection.php");

$datimancanti=0;   //$datimancanti=1 Non sono stati inseriti tutti i dati necessari all'autentificazione dell'utente
$accessonegato=0;  //$accessonegato=1 I dati inseriti non sono validi per l'autentificazione dell'utente

//nel caso in cui si provenga dalla form
if(isset($_POST['invio'])){
	//nel caso siano stati inseriti sia la password che lo username
    if ($_POST['username'] && $_POST['password']) {
		//verifico, attraverso una query, se lo username e la password corrispondono a quelle di un utente nella tabella users
		$select_query = "SELECT *
                         FROM $user_table_name
                         WHERE userName = \"{$_POST['username']}\" AND password =\"{$_POST['password']}\" ";
        //se la query e' stata eseguita correttamente
		if ($res = mysqli_query($connection_mysqli, $select_query)) {
			
			$row = mysqli_fetch_array($res);
            //se $row e' diverso da null, ovvero la query precedentemente eseguita mi ha dato un risultato non nullo, allora
			//lo username e la password corrispondono effettivamente ad un utente della tabella users.
			if ($row) {  
			    //inizializzo la sessione e memorizzo una serie di informazioni nell'array $_SESSION[]
				session_start();
				$_SESSION['id_utente']=$row['user_id'];
				$_SESSION['username']=$row['username'];
				$_SESSION['data_login']=time();
				$_SESSION['accesso_permesso']=100;
				//indirizzo il client verso la pagina iniziale del sito
                header('Location: prenotazione.php');    
                exit();
            }
			else {$accessonegato=1;}
		}
		
	}
	else {$datimancanti=1;}
}
mysqli_close($connection_mysqli);

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
