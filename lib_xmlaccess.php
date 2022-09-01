<?php

/* openXML(string $filename): DOMDocument 
   
   Genera un oggetto DOMDocument a partire da un file XML*/

function openXML ($fname) {

    /*Il file viene scaricato all'interno di un array attraverso la funzione file() e poi viene posto all'interno di uns stringa. 
      La funzione trim() permette di rimuovere i caratteri di whitespace di una data stringa.*/
    $stringaXML="";
    foreach( file($fname) as $nodo ){
        $stringaXML .= trim($nodo);
    }

    $doc = new DOMDocument();

    //A differenza di loadXML(), il seguente metodo consente il parsing di stringhe xml che contengono prefissi per il namespace (es xlmns:xsi)
    if( !$doc->loadHTML($stringaXML,
                   LIBXML_HTML_NOIMPLIED | 
                   LIBXML_HTML_NODEFDTD |  
                   LIBXML_NOERROR |        
                   LIBXML_NOWARNING       
    ) );
    
    return $doc;
}

?>