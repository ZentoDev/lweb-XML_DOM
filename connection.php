<?php  

// Variabili con all'interno il nome del database e delle tabelle
$DB_host="localhost";
$DB_user="root";
$DB_pass="";
$DB_name="nasa";
$booking_table_name="booking";
$user_table_name="users";

/*Creo un oggetto che rappresenta la connessione al server mysql                      
La funzione mysqli ha per argomenti:
-il nome dell'host
-l'username dell'account mysql
-la rispettiva password
-il nome del database al quale dobbiamo connetterci*/ 

$connection_mysqli = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);


/* Verifico se la connessione al database è andata a buon termine attraverso la funzione mysqli_connect_errno().
Tale funzione restituisce il codice di errore dell'ultima connessione nel caso in cui questa connessione non sia
avvenuta, altrimenti restituisce un valore nullo. */
if (mysqli_connect_errno()) {
    printf("***ATTENZIONE!***\n Non è stato possibile connettersi al database\n Errore: %s\n", mysqli_connect_error());
    exit();
}
?>