<?php
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);

session_start();
//permette di cancellare le chiavi e i valori dell'array $_SESSION
unset($_SESSION);
//session_destroy() permette di distruggere i dati della sessione memorizzati nella memoria della sessione
session_destroy();
?>


<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Logout</title>
<link rel="stylesheet" href="css_xhtml1.css" type="text/css" />
</head>

<body>

<div id="content">
    
    <div id="center" class="colonna" style="margin-top: 5% ">
        <h1>Hai effettuato il logout!</h1>
        <h2><a href="index.php">Home</a></h2>
    </div>
    
</div>

</body>
</html>