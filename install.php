<?php
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Installazione database</title>
</head>

<body>
<h1>CREAZIONE DATABASE</h1>

<?php  // Script che crea e popola il database
 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++CREAZIONE DATABASE

$DB_host="localhost";
$DB_user="root";
$DB_pass="";
$DB_name="nasa";

/*In questo caso non è presente il nome del database in quanto il nostro scopo, adesso, è connetterci al mysql server per crearne uno.*/
$connection_mysqli = new mysqli($DB_host, $DB_user, $DB_pass);

if (mysqli_connect_errno()) {
    printf("***ATTENZIONE!***\n Non è stato possibile connettersi al database\n Errore: %s\n", mysqli_connect_error($connection_mysqli));
    exit();
}

$create_DB_query = "CREATE DATABASE if not exists $DB_name";

/*mysqli_query() è una funzione che invia una query che viene eseguita dal server mysql.
Devono essere passati come argomenti la connessione mysql da usare ($connection_mysqli) e la query in questione ($create_DB_query).
La funzione, in questo caso, restituisce TRUE se è stata eseguita correttamente e FALSE altrimenti.*/
$res=mysqli_query($connection_mysqli, $create_DB_query);
if ($res) {
    echo "+++CREAZIONE DATABASE EFFETTUATA+++\n";
}
else {
    echo "***ATTENZIONE!*** Il database non è stato creato\n";
    exit();
}

//Chiudo la connessione in modo tale da riaprire una connessione al database che ho appena creato per poter aggiungere le tabelle. 
mysqli_close($connection_mysqli);

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++CREAZIONE TABELLE

echo "<h1>CREAZIONE TABELLE</h1>\n";

/*Riapro la connessione (vedi file connection.php che ho incluso tramite la funzione require_once()).

La funzione require_once() permette di includere il codice di un file esterno (in questo caso connection.php).
Nel caso in cui il file sia stato gia' incluso, non verra' incluso di nuovo.
 */
require_once("connection.php");

//Creazione tabella utenti
$create_table_query = "CREATE TABLE if not exists $user_table_name (
            user_id int NOT NULL auto_increment, 
			primary key (user_id), 
            username varchar (40) NOT NULL, 
            password varchar (32) NOT NULL
            );";


//Controllo se la query e' stata eseguita correttamente o meno
if ($res = mysqli_query($connection_mysqli, $create_table_query))
    echo "+++CREAZIONE TABELLA UTENTI EFFETTUATA+++\n<br />";
else {
    echo "***ATTENZIONE!*** La tabella utenti non è stata creata\n<br />";
}
   
//Creazione tabella prenotazioni
$create_table_query = "CREATE TABLE if not exists $booking_table_name (
            booking_id int NOT NULL auto_increment, 
			primary key (booking_id), 
            place varchar (50) NOT NULL, 
            date_visit date NOT NULL ,
			visitor varchar (40) NOT NULL
            );";


if ($res = mysqli_query($connection_mysqli, $create_table_query))
    echo "+++CREAZIONE TABELLA PRENOTAZIONI EFFETTUATA+++\n<br />";
else {
    echo "***ATTENZIONE!*** La tabella prenotazioni non è stata creata\n<br />";
}

//La funzione mysqli_errno() restituisce un codice di errore per l'ultima funzione chiamata, se effettivamente c'è stato un errore.
//Altrimenti zero 
if(mysqli_errno($connection_mysqli)){
    printf ("+++ATTENZIONE+++ Si è verificato il seguente errore: %s\n", mysqli_errno($connection_mysqli));
	exit();
}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++POPOLAZIONE TABELLE


echo "<h1>POPOLAZIONE TABELLE</h1>\n";

//Inserisco gli utenti e le prenotazioni nelle rispettive tabelle 

//utenti

$insert_query = "INSERT INTO $user_table_name
	(username, password)
	VALUES
	(\"admin\", \"admin\")
	";

if ($res = mysqli_query($connection_mysqli, $insert_query))
    printf("+++1-L'utente 1 è stato inserito\n<br />");
else {
    printf("***1-L'utente 1 NON è stato inserito\n<br />");
    exit();
}

$insert_query = "INSERT INTO $user_table_name
	(username, password)
	VALUES
	(\"John\", \"1234\")
	";

if ($res = mysqli_query($connection_mysqli, $insert_query))
    printf("+++2-L'utente 2 è stato inserito\n<br />");
else {
    printf("***2-L'utente 2 NON è stato inserito\n<br />");
    exit();
}


//prenotazioni

$insert_query = "INSERT INTO $booking_table_name
	(place, date_visit, visitor)
	VALUES
	(\"Kennedy Space Center\", \"2022-8-29\", \"admin\")
	";

if ($res = mysqli_query($connection_mysqli, $insert_query))
    printf("+++1-La prenotazione 1 è stata inserita\n<br />");
else {
    printf("***1-La prenotazione 1 NON è stata inserita\n<br />");
    exit();
}

$insert_query = "INSERT INTO $booking_table_name
	(place, date_visit, visitor)
	VALUES
	(\"NASA Engineering and Safety Center\", \"2022-12-14\", \"John\")
	";
	
    if ($res = mysqli_query($connection_mysqli, $insert_query))
    printf("+++2-La prenotazione 2 è stata inserita\n<br />");
else {
    printf("***2-La prenotazione 2 NON è stata inserita\n<br />");
    exit();
}
  
$insert_query = "INSERT INTO $booking_table_name
	(place, date_visit, visitor)
	VALUES
	(\"Mars\", \"2042-12-14\", \"admin\")
	";
	
    if ($res = mysqli_query($connection_mysqli, $insert_query))
    printf("+++3-La prenotazione 2 è stata inserita\n<br />");
else {
    printf("***3-La prenotazione 2 NON è stata inserita\n<br />");
    exit();
}


mysqli_close($connection_mysqli);
?>
</body>

</html>