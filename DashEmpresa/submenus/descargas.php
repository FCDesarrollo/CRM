<?php
    

    
   // Set the curl parameters.
   $ch = curl_init();
  // GET remote.php/dav/files/user/path/to/file
   curl_setopt($ch, CURLOPT_URL, "https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/FCC080410C38/Contabilidad/BDDADMW.pdf");

   curl_setopt($ch, CURLOPT_VERBOSE, 1);
   
   curl_setopt($ch, CURLOPT_USERPWD, "admindublock:4u1B6nyy3W");

   //curl_setopt($ch, CURLOPT_POSTFIELDS, "admindublock:4u1B6nyy3W");
   
   //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded; charset=UTF-8'));
   //curl_setopt($ch, CURLOPT_HEADER, false);
   // Max timeout in seconds to complete http request  
   //curl_setopt($ch, CURLOPT_TIMEOUT, 60);

   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
   //curl_setopt($ch, CURLOPT_POST, 1);

    //$COMANDO='admindublock:4u1B6nyy3W "remote.php/dav/files/admindublock/PruebaSincro/CarpetaCurl';

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

   // Set the request as a POST FIELD for curl.
   //curl_setopt($ch, CURLOPT_POSTFIELDS, $COMANDO);

   // Get response from the server.
   $httpResponse = curl_exec($ch);

   $fh = fopen('C:\Users\117875\Downloads\BDDADMW1.pdf', 'w');
   $string = $httpResponse;
   $write = fputs($fh, $string);
   //fwrite($fh, $httpResponse);
   fclose($fh);
   ?>
      

   <?php
   
   //var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE) );

   curl_close($ch);
   echo "Terminado";
  

?>
