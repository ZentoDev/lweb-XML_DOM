<?php
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);

session_start();

//verifica autenticazione utente
if (!isset($_SESSION['accesso_permesso'])) header('Location: login.php');

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>


<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Visite Prenotate</title>
<link rel="shortcut icon" href="immagini/NASA_logo.svg.png"/>
<link rel="stylesheet" href="css_xhtml1.css" type="text/css" />
<style>
    table{
	text-align:center;
	border: 3px solid black;
	border-collapse: collapse;
    }
    th, td {
	border: 2px solid black;
	}
</style>
</head>

<body>
    
<div id="top">
    <a href="index.php" title="home page" style="float: left">
	    <img style="float: right;" src="immagini/R.b3423f74c717d44ce8e80d07dc75822a.png" alt="HOME" width="60"/>
	</a>
    <img src="immagini/NASA_logo.svg.png" width="120" alt="Logo" class="dx"/>    
    <h1 id="titolo">Visite Prenotate</h1>   
</div>

<div id="content">

    <div id="center" class="colonna">
        <h1><?php echo $_SESSION['username']?>, queste sono le sue visite prenotate</h1>
        
        <?php
            echo "<table div style=\"	
                        text-align:center;
                        border: 3px solid black;
                        border-collapse: collapse; \" >\n
                    ";
            echo "<tr>
                	<th>Luogo</th>
                    <th>Data</th>
                  </tr>";

                require_once("lib_xmlaccess.php");
                $doc = openXML("xml/booking.xml");

                $booking_list = $doc->getElementsByTagName( "booking" ); 
                for ($i=0; $i < $booking_list->length; $i++) {
                    $booking = $booking_list->item($i);

                    //visualizza solo le prenotazione effettuate dall'utente
                    if( $booking->getAttribute('visitor') == $_SESSION['username'] ){   
                        $place = $booking->firstChild;
			            $place_value = $place->textContent;

			            $date = $booking->lastChild;
			            $date_value = $date->textContent;                    

                        echo "<tr>
                              <td>$place_value</td>
                              <td>$date_value</td>
                              </tr>";
                    }
			
			        
                }
            echo "</table>\n";
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