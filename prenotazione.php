<?php
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);

session_start();
$mex="";
$id="";

//verifica autenticazione utente
if (!isset($_SESSION['accesso_permesso'])) header('Location: login.php');

if(isset($_POST['prenota'])){

    if(isset($_POST['luogo']) && isset($_POST['date'])){
        
        if($_POST['date'] >= date("Y-m-d")){     //controllo validità della data

            require_once("lib_xmlaccess.php");
            $doc = openXML("xml/booking.xml");
		    $root = $doc->documentElement;
		
		    /*viene creato un elemento "booking" e viene aggiunto come figlio all'elemento "travel_reservations".
		    Cio' verra' fatto anche con gli altri elementi e sottoelementi di "booking".*/
		
		    $newBooking = $doc->createElement("booking");
		    $root->appendChild($newBooking);
		
		    $newPlace = $doc->createElement("place", "{$_POST['luogo']}");
		    $newBooking->appendChild($newPlace);
		
		    $newDate = $doc->createElement("date_visit", "{$_POST['date']}");
            $newBooking->appendChild($newDate);
		
            $id =  time() . $_POST['date'] . $_POST['luogo'] . $_SESSION['username'];  
		    $newBooking->setAttribute("booking_id", "$id");
            $newBooking->setAttribute("visitor","{$_SESSION['username']}");

		    //permette di salvare il documento in un file xml
            printFileXML("xml/booking.xml", $doc);
            
        }
        else $mex='Deve essere inserita una data nel futuro, 
                   non abbiamo ancora scoperto i viaggi nel tempo';
    }
    else $mex='selezione non completa';    
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
        <p>qui puoi prenotare una visita guidata in uno dei nostri posti speciali! </p>
        <hr />
        <p><strong>Seleziona il luogo da visitare</strong></p>
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
            <input type="radio" name="luogo" value="Armstrong Flight Research Center"/> Armstrong Flight Research Center<br />
            <input type="radio" name="luogo" value="Jet Propulsion Laboratory"/> Jet Propulsion Laboratory<br />
            <input type="radio" name="luogo" value="Kennedy Space Center"/> Kennedy Space Center<br />
            <input type="radio" name="luogo" value="NASA Engineering and Safety Center"/> NASA Engineering and Safety Center<br />
            <input type="radio" name="luogo" value="NASA Headquarters"/> NASA Headquarters<br />
            <input type="radio" name="luogo" value="Mars"/> Mars<br />

            <p><strong>Inserisci la data della visita</strong></p>
            <input type="date" name="date" />
            <br /><br />
            <input type="submit" name="prenota" value="prenota"/>
        </form>
        <?php 
        echo "<hr /> $mex <br />" ;

        if(isset($_POST['luogo']) && isset($_POST['date']) )
            echo $_POST['luogo']. " --- " .$_POST['date']. " --- " .$_SESSION['username'];
        ?>

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