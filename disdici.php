<?php
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);

session_start();
require_once("lib_xmlaccess.php");
$doc = openXML("booking.xml");
$root = $doc->documentElement;	
$booking_list = $root->childNodes;
$mex="";

//verifica autenticazione utente
if (!isset($_SESSION['accesso_permesso'])) header('Location: login.php');

if(isset($_POST['disdici'])){

    for ($i=0; $i < $booking_list->length; $i++) {
        $booking = $booking_list->item($i);

        if( $booking->getAttribute('booking_id') == $_POST['id'] ){   

            $booking_list->item($i)->remove();
            printFileXML("booking.xml", $doc);
            $mex='Cancellazione effettuata';

        }
    }
    if(!$mex) $mex='La cancellazione non &egrave stata effettuata';
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
                for ($i=0; $i < $booking_list->length; $i++) {
                    $booking = $booking_list->item($i);

                    //visualizza solo le prenotazione effettuate dall'utente
                    if( $booking->getAttribute('visitor') == $_SESSION['username'] ){   

                        $id_value = $booking->getAttribute('booking_id');

                        $place = $booking->firstChild;
			            $place_value = $place->textContent;

			            $date = $booking->lastChild;
			            $date_value = $date->textContent;                    
 
                        echo '<input type="radio" name="id" value="'.$id_value.'"/> '.$date_value.' - '.$place_value.'<br />';
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