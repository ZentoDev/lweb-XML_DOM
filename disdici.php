<?php
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);

session_start();
require_once("connection.php");
$mex="";

//verifica autenticazione utente
if (!isset($_SESSION['accesso_permesso'])) header('Location: login.php');

if(isset($_POST['disdici'])){

    $sql_delete="DELETE FROM $booking_table_name
                WHERE booking_id='{$_POST['id']}'
                ";

    if($res = mysqli_query($connection_mysqli, $sql_delete))
        $mex='Cancellazione effettuata';
    else{
        $mex='La cancellazione non &egrave stata effettuata';
        exit();
    }
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>


<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Prenota visita</title>
<link rel="shortcut icon" href="immagini/NASA_logo.svg.png"/>
<link rel="stylesheet" href="css_xhtml1.css" type="text/css" />
</head>

<body>
    
<div id="top">
    <a href="index.php" title="home page" style="float: left">
	    <img style="float: right;" src="immagini/R.b3423f74c717d44ce8e80d07dc75822a.png" alt="HOME" width="60"/>
	</a>
    <img src="immagini/NASA_logo.svg.png" width="120" alt="Logo" class="dx"/>    
    <h1 id="titolo">Prenota visita</h1>   
</div>

<div id="content">

    <div id="center" class="colonna">
        <h1 style="clear: left">Benvenuto <?php echo "$_SESSION[username]"; ?>! </h1>
        <p>Seleziona una visita delle seguenti per disdirla </p>
        <hr />
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
            <?php 
                $select_query="SELECT place, date_visit, booking_id
                               FROM $booking_table_name
                               WHERE $booking_table_name.visitor='{$_SESSION['username']}'
                               ";
                if (!$res = mysqli_query($connection_mysqli, $select_query))
                    echo "Problemi nell'esecuzione della query";
                else{
                    //$prenotazioni = array();        
                    $row = mysqli_fetch_array($res);  
                    for($c = 0; $row != null; $c++){    
                        //$prenotazioni[$c] = $row;   //$prenotazioni è un vettore in cui ad ogni indice 
                                                    //è associato una coppia (place, date_visit)

                        echo '<input type="radio" name="id" value="'.$row[2].'"/> '.$row[1].' - '.$row[0].'<br />';

                        $row = mysqli_fetch_array($res);
                    }
                }
            ?>
            <br />
            <input type="submit" name="disdici" value="disdici"/>
        </form>
        <hr />
        <p><?php echo $mex; ?>

    </div>
    <div id="navbar" class="colonna">
        <ul class="nav">
            <li><a href="prenotazione.php">Prenota visita</a></li>
            <li><a href="disdici.php">Disdici visita</a></li>
            <li><a href="visualizzavisite.php">Visualizza visite prenotate</a></li>
        </ul>

        <ul class="nav" style="background: yellow;">
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>


</body>
</html>