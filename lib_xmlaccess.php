<?php

/* openXML (string $filename): DOMDocument 
   Genera un oggetto DOMDocument a partire da un file XML*/
function openXML ($fname) {

    /*Il file viene scaricato all'interno di un array attraverso la funzione file() e poi viene posto all'interno di uns stringa. 
      La funzione trim() permette di rimuovere i caratteri di whitespace di una data stringa.*/
    $stringXML="";
    foreach( file($fname) as $nodo ){
        $stringXML .= trim($nodo);
    }

   if( $stringXML == NULL)    return NULL;  //Nel caso in cui il file xml sia vuoto o non esista si ritorna NULL

    $doc = new DOMDocument();

    //A differenza di loadXML(), il seguente metodo consente il parsing di stringhe xml che contengono prefissi per il namespace (es xlmns:xsi)
    $doc->loadHTML($stringXML, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING );

    return $doc;
}

/*printFileXML (string $filename, DOMDocument $docXML): NULL
  permette di salvare il documento in un file xml, 
  L'elemento DOM non deve contenere la dichiarazione XML dato che verrà aggiunta dalla funzione */

function printFileXML ($fname, $docXML) {

    $stringXML = '<?xml version="1.0" encoding="UTF-8"?>' . $docXML->saveXML($docXML->documentElement);
    file_put_contents($fname, $stringXML);
}

?>