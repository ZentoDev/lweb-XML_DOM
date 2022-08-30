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
                require_once("connection.php");

                $select_query="SELECT place, date_visit 
                               FROM $booking_table_name
                               WHERE $booking_table_name.visitor='{$_SESSION['username']}'
                                   ";
                if (!$res = mysqli_query($connection_mysqli, $select_query))
                    echo "Problemi nell'esecuzione della query";
                else{
                    $row = mysqli_fetch_array($res);
                    while($row != null){
                        echo "<tr>
                              <td>$row[place]</td>
			                  <td>$row[date_visit]</td>
			                  </tr>";
                        $row = mysqli_fetch_array($res);
                    }
                }
            echo "</table>\n";
            mysqli_close($connection_mysqli);
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